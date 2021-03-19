# SmartAPI - PHP Client SDK

## Installation
```bash
composer require smartapi-php/angelbroking
```

## Import package to controller
```
use AngelBroking\AngelBroking;
```

## Getting started with API
```php
  //in your function of controller create instance of AngelBroking class

    $ab = new AngelBroking();
    
    //Login
    $ab->GenerateSession("Client-code","password");
    
    //methods
    $token = $ab->GenerateToken();  
    
    $profile = $ab->GetProfile();
    
    $ab->LogOut(array('clientcode'=>'your client-code'));
    
    $rms = $ab->GetRMS();
    
    $order = $ab->PlaceOrder(array('variety' => 'NORMAL',
                                    'tradingsymbol'  =>  'JINDALSTEL-EQ',
                                    'symboltoken' => '6733',
                                    'exchange' => 'NSE',
                                    'transactiontype' => 'SELL',
                                    'ordertype' => 'LIMIT',
                                    'quantity' => '1',
                                    'producttype' => 'INTRADAY',
                                    'price' => 312.65,
                                    'squareoff' => 0
                                    'stoploss' => 0
                                    'duration' => 'DAY'));
                                    
     $modifyOrder = $ab->ModifyOrder(array('variety' => 'NORMAL',
                                    'tradingsymbol'  =>  'JINDALSTEL-EQ',
                                    'symboltoken' => '6733',
                                    'exchange' => 'NSE',
                                    'transactiontype' => 'BUY',
                                    'ordertype' => 'LIMIT',
                                    'quantity' => '1',
                                    'producttype' => 'INTRADAY',
                                    'price' => 200,
                                    'squareoff' => 0
                                    'stoploss' => 0
                                    'duration' => 'DAY',
                                    'orderid' =>210312000000394));
    
    $cancelOrder = $ab->CancelOrder(array('variety' => 'NORMAL',
                                      'orderid' => '210312000000394'));
                                      
    $GetOrderBook = $ab->GetOrderBook();
    
    $GetTradeBook = $ab->GetTradeBook();
    
    $GetHoldings =  $ab->GetHoldings();
    
    $GetPosition  = $ab->GetPosition();
    
    $ConvertPosition  = $ab->ConvertPosition(array("exchange"=>"NSE",
                                                "oldproducttype"=>"INTRADAY",
                                                "newproducttype"=>"MARGIN",
                                                "tradingsymbol"=>"JINDALSTEL-EQ",
                                                "transactiontype"=>"SELL",
                                                "quantity"=>"1",
                                                "type"=>"DAY"));
                                                
   $CreateRule  = $ab->CreateRule(array("tradingsymbol" => "SBIN-EQ", 
                                      "symboltoken" => "3045", 
                                      "exchange" => "NSE", 
                                      "producttype" => "MARGIN", 
                                      "transactiontype" => "BUY",
                                      "price" => 100000, 
                                      "qty" => 10, 
                                      "disclosedqty"=> 10, 
                                      "triggerprice" => 200000,
                                      "timeperiod" => 365));
                                       
   $ModifyRule  = $ab->ModifyRule(array('id' => '1000059',
                                       "tradingsymbol" => "SBIN-EQ", 
                                      "symboltoken" => "3045", 
                                      "exchange" => "NSE", 
                                      "producttype" => "MARGIN", 
                                      "transactiontype" => "BUY",
                                      "price" => 100000, 
                                      "qty" => 20, 
                                      "disclosedqty"=> 10, 
                                      "triggerprice" => 200000,
                                      "timeperiod" => 365));
                                      
    $CancelRule = $ab->CancelRule(array('symboltoken'  => '3045'
                                       'exchange'   =>   'NSE' ,
                                      'id'  => '1000059'));
                                      
    $RuleDetails = $ab->RuleDetails(array('id'=>'1000059'));
    
    $RuleList = $ab->RuleList(array( "status"=> [
                                      "NEW",
                                      "CANCELLED",
                                      "ACTIVE",
                                      "SENTTOEXCHANGE",
                                      "FORALL"
                                 ],
                                 "page"=> 1,
                                 "count"=> 10));
                                 
    $GetCandleData = $ab->GetCandleData(array("exchange"=> "NSE",
                                             "symboltoken"=> "3045",
                                             "interval"=> "MINUTE",
                                             "fromdate"=> "2021-02-08 09:00",
                                             "todate"=> "2021-02-08 09:16"));
    
```

## Getting started with SmartAPI Websocket's
```
 print_r($ab->SocketConnet($client-code, $feed-token, $task, $script));   
```
