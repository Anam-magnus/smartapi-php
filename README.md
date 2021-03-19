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
    
    print_r($ab->SocketConnet("S212741", "0985676059", "mw", "nse_cm|2885&nse_cm|1594&nse_cm|11536"));        
    
```
