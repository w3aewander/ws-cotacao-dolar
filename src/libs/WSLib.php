<?php
/**
 * Consumir API taxa de cambio do dia.
 * diretamente do banco central do Brasil
 */

/**
 */


 namespace App\libs;

 use GuzzleHttp\Client;

 class WSLib {

    private $url;
    private $retorno;
    
    
public function __construct(){
    $json = json_decode(file_get_contents(__DIR__ . '/../config/wslib.json'));
    //'https://economia.awesomeapi.com.br/json/last/USD-BRL,EUR-BRL,BTC-BRL';
    $this->url = $json->url;
}    

/**
 * Função para obter o conteúdo a partir da URL informada.
 * @param $url String  URL que se deseja obter o conteúdo.
 * @return   $content String O conteúdo desejado. 
 */
private function getURLBodyContent()
{ 

        $client = new \GuzzleHttp\Client();

        $resp = $client->request('GET', $this->url);

        return $resp->getBody()->getContents();

 }

 public function getDolarValue(){
    $resp = $this->getURLBodyContent();
    return json_decode($resp)->USDBRL->ask;
 }

 public function getEuroValue(){
    $resp = $this->getURLBodyContent();
    return json_decode($resp)->EURBRL->ask;
 }


 public function getBTCValue(){
    $resp = $this->getURLBodyContent();
    return json_decode($resp)->BTCBRL->ask;
 }


}