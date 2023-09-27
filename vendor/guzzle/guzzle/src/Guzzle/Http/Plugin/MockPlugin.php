<?php

namespace Guzzle\Http\Plugin;

use Guzzle\Common\Event;
use Guzzle\Common\Exception\InvalidArgumentException;
use Guzzle\Common\AbstractHasDispatcher;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Queues mock responses and delivers mock responses in a fifo order.
 */
class MockPlugin extends AbstractHasDispatcher implements EventSubscriberInterface, \Countable
{
    /**
     * @var array Array of mock responses
     */
    protected $queue = array();

    /**
     * @var bool Whether or not to remove the plugin when the queue is empty
     */
    protected $temporary = false;

    /**
     * @var array Array of requests that were mocked
     */
    protected $received = array();

    /**
     * Constructor
     *
     * @param array $responses Array of responses to queue
     * @param bool  $temporary Set to TRUE to remove the plugin when
     *      the queue is empty
     */
    public function __construct(array $responses = null, $temporary = false)
    {
        $this->temporary = $temporary;
        if ($responses) {
            foreach ($responses as $response) {
                $this->addResponse($response);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array('client.create_request' => 'onRequestCreate');
    }

    /**
     * {@inheritdoc}
     */
    public static function getAllEvents()
    {
        return array('mock.request');
    }

    /**
     * Get a mock response from a file
     *
     * @param string $file File to retrieve a mock response from
     *
     * @return Response
     * @throws InvalidArgumentException if the file is not found
     */
    public static function getMockFile($path)
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException('Unable to open mock file: ' . $path);
        }

        $parts = explode("\n\n", file_get_contents($path), 2);
        // Convert \n to \r\n in headers
        $data = isset($parts[1])
            ? str_replace("\n", "\r\n", $parts[0]) . "\r\n\r\n" . $parts[1]
            : $parts[0];

        return Response::fromMessage($data);
    }

    /**
     * Returns the number of remaining mock responses
     *
     * @return int
     */
    public function count()
    {
        return count($this->queue);
    }

    /**
     * Add a response to the end of the queue
     *
     * @param string|Response $response Response object or path to response file
     *
     * @return MockPlugin
     * @throws InvalidArgumentException if a string or Response is not passed
     */
    public function addResponse($response)
    {
        if (!($response instanceof Response)) {
            if (!is_string($response)) {
                throw new InvalidArgumentException('Invalid response');
            }
            $response = self::getMockFile($response);
        }

        $this->queue[] = $response;

        return $this;
    }

    /**
     * Clear the queue
     *
     * @return MockPlugin
     */
    public function clearQueue()
    {
        $this->queue = array();

        return $this;
    }

    /**
     * Returns an array of mock responses remaining in the queue
     *
     * @return array
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Check if this is a temporary plugin
     *
     * @return bool
     */
    public function isTemporary()
    {
        return $this->temporary;
    }

    /**
     * Get a response from the front of the list and add it to a request
     *
     * @param RequestInterface $request Request to mock
     *
     * @return MockPlugin
     */
    public function dequeue(RequestInterface $request)
    {
        $this->dispatch('mock.request', array(
            'plugin'  => $this,
            'request' => $request
        ));
        $request->setResponse(array_shift($this->queue), true);

        return $this;
    }

    /**
     * Clear the array of received requests
     */
    public function flush()
    {
        $this->received = array();
    }

    /**
     * Get an array of requests that were mocked by this plugin
     *
     * @return array
     */
    public function getReceivedRequests()
    {
        return $this->received;
    }

    /**
     * Called when a request completes
     *
     * @param Event $event
     */
    public function onRequestCreate(Event $event)
    {
        if (!empty($this->queue)) {
            $request = $event['request'];
            $this->dequeue($request);
            $this->received[] = $request;
            // Detach the filter from the client so it's a one-time use
            if ($this->temporary && empty($this->queue) && $request->getClient()) {
                $request->getClient()->getEventDispatcher()->removeSubscriber($this);
            }
        }
    }
}
