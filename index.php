<?php
include 'view/header.html';
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_erros',1);

//braziliex
$jsonbraziliex = file_get_contents("https://braziliex.com/api/v1/public/ticker/btc_brl"); //puxa os dados da api
$databrzx = json_decode($jsonbraziliex, true); //decodifica os dados da api
$braziliex_price = $databrzx['last']; //seleciona um valor especifico da api
$braziliex_volume = $databrzx['baseVolume'];
$braziliex_price = intval($braziliex_price); //transforma em numero
$braziliex_volume = intval($braziliex_volume);
$varbraziliex = $braziliex_price * $braziliex_volume;


//bitcointrade
$json_bitcointrade = file_get_contents("https://api.bitcointrade.com.br/v1/public/BTC/ticker");
$data_bitcoin_trade = json_decode($json_bitcointrade, true);
$bitcointrade_price = $data_bitcoin_trade['data']['last'];
$bitcointrade_volume = $data_bitcoin_trade['data']['volume'];
$bitcointrade_price = intval($bitcointrade_price);
$bitcointrade_volume = intval($bitcointrade_volume);
$varbitcointrade = $bitcointrade_price * $bitcointrade_volume;

//walltime
$json_walltime = file_get_contents("https://s3.amazonaws.com/data-production-walltime-info/production/dynamic/walltime-info.json");
$datawalltime = json_decode($json_walltime, true);
$walltime_price = $datawalltime['BRL_XBT']['last_inexact'];
$walltime_volume = $datawalltime['BRL_XBT']['quote_volume24h_inexact'];
$walltime_price = intval($walltime_price);
$walltime_volume = intval($walltime_volume);
$varwalltime = $walltime_price * $walltime_volume;

//bitcointoyou
$json_bitcointoyou = file_get_contents("https://www.bitcointoyou.com/api/ticker.aspx");
$databitcointoyou = json_decode($json_bitcointoyou, true);
$bitcointoyou_price = $databitcointoyou['ticker']['last'];
$bitcointoyou_volume = $databitcointoyou['ticker']['vol'];
$bitcointoyou_price = intval($bitcointoyou_price);
$bitcointoyou_volume = intval($bitcointoyou_volume);
$varbitcointoyou = $bitcointoyou_price * $bitcointoyou_volume;

//mercadobitcoin
$json_mercadobitcoin = file_get_contents("https://www.mercadobitcoin.net/api/btc/ticker/");
$datamercadobitcoin = json_decode($json_mercadobitcoin, true);
$mercadobitcoin_price = $datamercadobitcoin['ticker']['last'];
$mercadobitcoin_volume = $datamercadobitcoin['ticker']['vol'];
$mercadobitcoin_price = intval($mercadobitcoin_price);
$mercadobitcoin_volume = intval($mercadobitcoin_volume);
$varmercadobitcoin = $mercadobitcoin_price * $mercadobitcoin_volume;

//flowbtc
$json_flowbtc = file_get_contents("https://publicapi.flowbtc.com.br/v1/ticker/btcbrl");
$dataflowbtc = json_decode($json_flowbtc, true);
$flowbtc_price = $dataflowbtc['data']['LastTradedPx'];
$flowbtc_volume = $dataflowbtc['data']['Rolling24HrVolume'];
$flowbtc_price = intval($flowbtc_price);
$flowbtc_volume = intval($flowbtc_volume);
$varflowbtc = $flowbtc_price * $flowbtc_volume;


//Calcula o preco medio ponderado
$allvariables = $varbraziliex + $varbitcointrade + $varwalltime + $varbitcointoyou + $varmercadobitcoin + $varflowbtc; //soma todas as variaveis

$volumetotal = $braziliex_volume + $bitcointrade_volume + $walltime_volume + $bitcointoyou_volume + $mercadobitcoin_volume + $flowbtc_volume; //soma todos os volumes

$preco_ponderado = $allvariables / $volumetotal; //calcula o preco medio ponderado

$preco_ponderado = intval($preco_ponderado); //transforma em numero

//Calcula o MarketShare
$pbraziliex = round(($braziliex_volume/$volumetotal)*100, 2);
$pbitcointrade = round(($bitcointrade_volume/$volumetotal)*100, 2);
$pwalltime = round(($walltime_volume/$volumetotal)*100, 2);
$pbitcointoyou = round(($bitcointoyou_volume/$volumetotal)*100, 2);
$pmercadobitcoin = round(($mercadobitcoin_volume/$volumetotal)*100, 2);
$pflowbtc = round(($flowbtc_volume/$volumetotal)*100, 2);



//echo "o preço médio ponderado é R$:", number_format($preco_ponderado, 2, ',', '.');
include 'view/home.html';
?>