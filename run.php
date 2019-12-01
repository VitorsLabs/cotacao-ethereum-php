<?php

$cache = 500; //diferença entre o tempo atual e o tempo de ultima modificação dos arquivos de Cache (em segundos)
//puxa as exchanges

//braziliex
$cache_braziliex = 'braziliex.cache';
if(file_exists($cache_braziliex)) {
  if(time() - filemtime($cache_braziliex) > $cachetime) {
     // too old , re-fetch
     $cache = file_get_contents("https://braziliex.com/api/v1/public/ticker/eth_brl"); //Atualiza o Cache
     file_put_contents($cache_braziliex, $cache);
     $jsonbraziliex = file_get_contents($cache_braziliex);
  } else {
     $jsonbraziliex = file_get_contents($cache_braziliex);
  }
} else {
  // no cache, create one
  $cache = file_get_contents("https://braziliex.com/api/v1/public/ticker/eth_brl"); //Cria o Cache
  file_put_contents($cache_braziliex, $cache);
  $jsonbraziliex = file_get_contents($cache_braziliex);
}


$databrzx = json_decode($jsonbraziliex, true); //decodifica os dados da api
$braziliex_price = $databrzx['last']; //seleciona um valor especifico da api
$braziliex_volume = $databrzx['baseVolume'];
//$braziliex_price = intval($braziliex_price); //transforma em numero
//$braziliex_volume = intval($braziliex_volume);
$varbraziliex = $braziliex_price * $braziliex_volume;


//bitcointrade

//cache da API
$cache_bitcointrade = 'bitcoinreade.cache';
if(file_exists($cache_bitcointrade)) {
  if(time() - filemtime($cache_bitcointrade) > $cachetime) {
     // too old , re-fetch
     $cache = file_get_contents("https://api.bitcointrade.com.br/v2/public/BRLETH/ticker"); //Atualiza o Cache
     file_put_contents($cache_bitcointrade, $cache);
     $json_bitcointrade = file_get_contents($cache_bitcointrade);
  } else {
     $json_bitcointrade = file_get_contents($cache_bitcointrade);
  }
} else {
  // no cache, create one
  $cache = file_get_contents("https://api.bitcointrade.com.br/v2/public/BRLETH/ticker"); //Cria o Cache
  file_put_contents($cache_bitcointrade, $cache);
  $json_bitcointrade = file_get_contents($cache_bitcointrade);
}


$data_bitcoin_trade = json_decode($json_bitcointrade, true);
$bitcointrade_price = $data_bitcoin_trade['data']['last'];
$bitcointrade_volume = $data_bitcoin_trade['data']['volume'];
//$bitcointrade_price = intval($bitcointrade_price);
//$bitcointrade_volume = intval($bitcointrade_volume);
$varbitcointrade = $bitcointrade_price * $bitcointrade_volume;



//mercadobitcoin

//cache da API
$cache_mercadobitcoin = 'mercadobitcoin.cache';
if(file_exists($cache_mercadobitcoin)) {
  if(time() - filemtime($cache_mercadobitcoin) > $cachetime) {
     // too old , re-fetch
     $cache = file_get_contents("https://www.mercadobitcoin.net/api/eth/ticker/"); //Atualiza o Cache
     file_put_contents($cache_mercadobitcoin, $cache);
     $json_mercadobitcoin = file_get_contents($cache_mercadobitcoin);
  } else {
     $json_mercadobitcoin = file_get_contents($cache_mercadobitcoin);
  }
} else {
  // no cache, create one
  $cache = file_get_contents("https://www.mercadobitcoin.net/api/eth/ticker/"); //Cria o Cache
  file_put_contents($cache_mercadobitcoin, $cache);
  $json_mercadobitcoin = file_get_contents($cache_mercadobitcoin);
}


$datamercadobitcoin = json_decode($json_mercadobitcoin, true);
$mercadobitcoin_price = $datamercadobitcoin['ticker']['last'];
$mercadobitcoin_volume = $datamercadobitcoin['ticker']['vol'];
//$mercadobitcoin_price = intval($mercadobitcoin_price);
//$mercadobitcoin_volume = intval($mercadobitcoin_volume);
$varmercadobitcoin = $mercadobitcoin_price * $mercadobitcoin_volume;


//Calcula o preco medio ponderado
$allvariables = $varbraziliex + $varbitcointrade + $varmercadobitcoin + $varflowbtc; //soma todas as variaveis

$volumetotal = $braziliex_volume + $bitcointrade_volume + $mercadobitcoin_volume + $flowbtc_volume; //soma todos os volumes
$volumetotal = round($volumetotal, 8); //Bitcoin tem 8 casas decimais

$preco_ponderado = $allvariables / $volumetotal; //calcula o preco medio ponderado


//Calcula o MarketShare
$pbraziliex = round(($braziliex_volume/$volumetotal)*100, 2);
$pbitcointrade = round(($bitcointrade_volume/$volumetotal)*100, 2);
$pmercadobitcoin = round(($mercadobitcoin_volume/$volumetotal)*100, 2);



//cache da API
$cache_data = 'data.cache';
if(file_exists($cache_data)) {
  if(time() - filemtime($cache_data) > $cachetime) {
     // too old , re-fetch
     $cache = date('Y-m-d H:i'); //Atualiza o Cache
     file_put_contents($cache_data, $cache);
     $date = file_get_contents($cache_data);
  } else {
     $date = file_get_contents($cache_data);
  }
} else {
  // no cache, create one
  $cache = date('Y-m-d H:i'); //Cria o Cache
  file_put_contents($cache_data, $cache);
  $date = file_get_contents($cache_data);
}


?>