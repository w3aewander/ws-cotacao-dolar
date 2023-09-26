<?php
/**
 *  Ponto de entrada da aplicação
 *  @author Wanderlei Silva do Carmo <wander.silva@gmail.com>
 *  @version 20230925.01
 */

 ini_set('display_errors', 1);
 ini_set('error_reporting', E_ALL|E_WARNING);

 
 require __DIR__ . '/../vendor/autoload.php';

 $jsonConfig = json_decode(file_get_contents( __DIR__ . '/../src/config/wslib.json') );

 $url = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);


 $request = new App\libs\WSLib;

 $moeda = html_entity_decode(explode('/',$url)[1]);

 switch( $moeda){
    case "dolar":
        echo $request->getDolarValue();        
    break;
    case "euro":
        echo $request->getEuroValue();        
    break;
    case "btc":
        echo $request->getBTCValue();        
    break;
    default:
       require_once(__DIR__ . '/../templates/index.tpl.php');
    
 }



// echo "Dolar americano: " . $request->getDolarValue() . "<br>";
// echo "Euro: " .   $request->getEuroValue() . "<br>";
// echo "BitCoin: "    . $request->getBTCValue()  . "<br>" ;
