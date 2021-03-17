<?php
//namespace AngelBroking; 
session_start();
require_once("includes/AngelConfigrationManage.php");	

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AngelBroking
{
	
	public static function GenerateSession()
	{
		//get url from config file
		$UrlData = AngelConfigrationManage::AngelConfigrationData();
		$url = $UrlData['root'].$UrlData['user_login'];


	  	//Generate session;
	  	
	  	$api_parameter = ['clientcode'=>'D883','password'=>'Abc#123'];


	  	// Common function to call smart api	
		$response_data	=	self::CurlOperation($url, $api_parameter,'','POST');

		//save $jwtToken and refreshToken in session
		$res = json_decode($response_data,true);		
		$jwtToken = $res['response_data']['data']['jwtToken'];
		$refreshToken = $res['response_data']['data']['refreshToken'];

		$_SESSION['jwtToken']		=	$jwtToken;
		$_SESSION['refreshToken']	=   $refreshToken;
		setcookie('jwtToken', $jwtToken);
		setcookie('refreshToken', $refreshToken);
		
		//echo $response_data;
		return $response_data;
	}

	public static function GenerateToken()
	{

		
		$token = self::getToken();
				
		 if ($token['status']) {
		 	$jwtToken = $token['jwtToken'];
		 	$refreshToken = $token['refreshToken'];
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['generate_token'];	  

			$api_parameter = 	['refreshToken'=> $refreshToken];
		
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,$api_parameter, $jwtToken,'POST');
		 }
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data = json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}

	public static function GetProfile()
	{	
		//getToken() check whether userlogged in or not and return jwtToken
		$token = self::getToken();
				
		 if ($token['status']) {
		 	//jwtToken not empty 
			$jwtToken = $token['jwtToken'];

			//get url from config file
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['get_profile'];	  	
		
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,'', $jwtToken,'GET');

		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}

	public static function LogOut($paramArray)
	{

		extract($paramArray);
		
		$token = self::getToken();
				
		 if ($token['status']) {
		 	$jwtToken = $token['jwtToken'];
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['logout'];	  

			$api_parameter = 	['clientcode'=> $clientcode];
		
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,$api_parameter, $jwtToken,'POST');
		 }
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		//echo $response_data;
		return $response_data;
	}

	public static function GetRMS()
	{
		$token  = self::getToken();	

		if ($token['status']) {
			$jwtToken 	=	$token['jwtToken'];
			$UrlData	=	AngelConfigrationManage::AngelConfigrationData();
			$url 		=	$UrlData['root'].$UrlData['get_rms'];

			// Common function to call smart api
			$response_data 	=	self::CurlOperation($url,'',$jwtToken,'GET');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		//echo $response_data;
		return $response_data;
	}
	

	public static function PlaceOrder($paramArray)
	{
		extract($paramArray);
		$token 	=	self::getToken();
		if ($token['status']) {
			$jwtToken	=	$token['jwtToken'];
			$UrlData 	=	AngelConfigrationManage::AngelConfigrationData();
			$url 		=	$UrlData['root'].$UrlData['order_place'];

			$api_parameter	=	array('variety'		=>	"$variety",
									'tradingsymbol'	=>	"$tradingsymbol",
									'symboltoken'	=>	"$symboltoken",
									'exchange'		=>	"$exchange",
									'transactiontype'=>	"$transactiontype",
									'ordertype'		=>	"$ordertype",
									'quantity'		=>	"$quantity",
									'producttype'	=>	"$producttype",
									'price'			=>	"$price",
									//'triggerprice'	=>	isset($triggerprice)?"$triggerprice":"",
									'squareoff'		=>	"$squareoff",
									'stoploss'		=>	"$stoploss",
									//'trailingStopLoss'	=>	isset($trailingStopLoss)?"$trailingStopLoss":"",
									//'disclosedquantity'	=>	isset($disclosedquantity)?"$disclosedquantity":"",
									'duration'		=>	"$duration",
								);

			//print_r(json_encode($api_parameter));

			//"orderid":"210309000000117
			
			// Common function to call smart api
			$response_data 	=	self::CurlOperation($url, $api_parameter, $jwtToken, 'POST');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//print_r($response_data);
		return $response_data;
	}



	public static function ModifyOrder($paramArray)
	{
		extract($paramArray);
		$token 	=	self::getToken();
		if ($token['status']) {
			$jwtToken	=	$token['jwtToken'];
			$UrlData 	=	AngelConfigrationManage::AngelConfigrationData();
			$url 		=	$UrlData['root'].$UrlData['order_modify'];
			
			$api_parameter	=	array(
									'orderid'		=>	"$orderid",
									'variety'		=>	"$variety",
									'tradingsymbol'	=>	"$tradingsymbol",
									'symboltoken'	=>	"$symboltoken",
									'exchange'		=>	"$exchange",
									'transactiontype'=>	"$transactiontype",
									'ordertype'		=>	"$ordertype",
									'quantity'		=>	"$quantity",
									'producttype'	=>	"$producttype",
									'price'			=>	"$price",
									//'triggerprice'	=>	isset($triggerprice)?"$triggerprice":"",
									'squareoff'		=>	"$squareoff",
									'stoploss'		=>	"$stoploss",
									//'trailingStopLoss'	=>	isset($trailingStopLoss)?"$trailingStopLoss":"",
									//'disclosedquantity'	=>	isset($disclosedquantity)?"$disclosedquantity":"",
									'duration'		=>	"$duration",
								);
			// Common function to call smart api
			$response_data 	=	self::CurlOperation($url, $api_parameter, $jwtToken, 'POST');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}

	public static function CancelOrder($paramArray)
	{
		extract($paramArray);
		$token 	=	self::getToken();
		if ($token['status']) {
			$jwtToken	=	$token['jwtToken'];
			$UrlData	=	AngelConfigrationManage::AngelConfigrationData();
			$url 		=	$UrlData['root'].$UrlData['order_cancel'];

			$api_parameter	=	array('variety' =>	$variety,
									'orderid'	=>	$orderid
								);
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url, $api_parameter, $jwtToken, 'POST');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}

	public static function GetOrderBook()
	{
		$token 	=	self::getToken();
		if ($token['status']) {
			$jwtToken	=	$token['jwtToken'];
			$UrlData	=	AngelConfigrationManage::AngelConfigrationData();
			$url 		=	$UrlData['root'].$UrlData['order_get_book'];

			// Common function to call smart api
			$response_data	=	self::CurlOperation($url, '', $jwtToken, 'GET');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data = json_encode($response_data);
		}
		//echo $response_data;
		return $response_data;
	}

	public static function GetTradeBook()
	{

		$token 	=	self::getToken();
		if ($token['status']) {
			$jwtToken	=	$token['jwtToken'];
			$UrlData	=	AngelConfigrationManage::AngelConfigrationData();
			$url 		=	$UrlData['root'].$UrlData['get_tradebook'];

			// Common function to call smart api
			$response_data	=	self::CurlOperation($url, '', $jwtToken, 'GET');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}	
		//echo $response_data;
		return $response_data;
	}

	

	public static function GetHoldings()
	{
		$token 	=	self::getToken();
		if ($token['status']) {
			$jwtToken	=	$token['jwtToken'];
			$UrlData	=	AngelConfigrationManage::AngelConfigrationData();
			$url 		=	$UrlData['root'].$UrlData['get_holding'];

			// Common function to call smart api
			$response_data	=	self::CurlOperation($url, '', $jwtToken, 'GET');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data = json_encode($response_data);
		}
		//echo $response_data;
		return $response_data;
	} 

	public static function GetPosition()
	{
		$token 	=	self::getToken();
		if ($token['status']) {
			$jwtToken 	=	$token['jwtToken'];
			$UrlData	=	AngelConfigrationManage::AngelConfigrationData();
			$url 		=	$UrlData['root'].$UrlData['get_position'];

			// Common function to call smart api
			$response_data = self::CurlOperation($url, '', $jwtToken, 'GET');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data = json_encode($response_data);
		}
		//echo $response_data;
		return $response_data;
	}

	public static function ConvertPosition($paramArray)
	{
		extract($paramArray);

		//getToken() check whether userlogged in or not and return jwtToken
		$token = self::getToken();
				
		 if ($token['status']) {
		 	//jwtToken not empty 
			$jwtToken = $token['jwtToken'];

			//get url from config file
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['convert_position'];	  	
			
			$api_parameter	=	array(
									"exchange"		=> "$exchange",
						            "oldproducttype"=> "$oldproducttype",
						            "newproducttype"=> "$newproducttype",
						            "tradingsymbol"	=> "$tradingsymbol",
						            "transactiontype"=> "$transactiontype",
						            "quantity"		=> "$quantity",
						            "type"			=> "$type"
								);
			print_r(json_encode($api_parameter));
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,$api_parameter, $jwtToken,'POST');

		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}

	/* Create GTT Rule*/
	public static function CreateRule($paramArray)
	{
		extract($paramArray);

		//getToken() check whether userlogged in or not and return jwtToken
		$token = self::getToken();
				
		 if ($token['status']) {
		 	//jwtToken not empty 
			$jwtToken = $token['jwtToken'];

			//get url from config file
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['create_rule'];	  	
			
			$api_parameter	=	array(
									"tradingsymbol"	=> 	"$tradingsymbol",
						            "symboltoken"		=> 	"$symboltoken",
						            "exchange"			=> 	"$exchange",
						            "transactiontype"	=> 	"$transactiontype",
						            "producttype"		=> 	"$producttype",
						            "price"				=> 	intval($price),
						            "qty"				=> 	intval($quantity),
						            "triggerprice"		=>	intval($triggerprice),
						            "disclosedqty"		=>	intval($disclosedqty),
						            "timeperiod"		=>	intval($timeperiod)
								);
			
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,$api_parameter, $jwtToken,'POST');

		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}


	/* Modify GTT Rule*/
	public static function ModifyRule($paramArray)
	{
		extract($paramArray);

		//getToken() check whether userlogged in or not and return jwtToken
		$token = self::getToken();
				
		 if ($token['status']) {
		 	//jwtToken not empty 
			$jwtToken = $token['jwtToken'];

			//get url from config file
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['modify_rule'];	  	
			
			$api_parameter	=	array(
									"id"				=>	"$id",
									"trading symbol"	=> 	"$tradingsymbol",
						            "symboltoken"		=> 	"$symboltoken",
						            "exchange"			=> 	"$exchange",
						            "transaction type"	=> 	"$transactiontype",
						            "producttype"		=> 	"$producttype",
						            "price"				=> 	"$price",
						            "quantity"			=> 	"$quantity",
						            "triggerprice"		=>	"$triggerprice",
						            "disclosedqty"		=>	"$disclosedqty",
						            "timeperiod"		=>	"$timeperiod"
								);
			
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,$api_parameter, $jwtToken,'POST');

		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}

	/* Cancel GTT Rule*/
	public static function CancelRule($paramArray)
	{
		extract($paramArray);

		//getToken() check whether userlogged in or not and return jwtToken
		$token = self::getToken();
				
		 if ($token['status']) {
		 	//jwtToken not empty 
			$jwtToken = $token['jwtToken'];

			//get url from config file
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['cancel_rule'];	  	
			
			$api_parameter	=	array(
									"id"				=>	"$id",
						            "symboltoken"		=> 	"$symboltoken",
						            "exchange"			=> 	"$exchange"
								);
						
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,$api_parameter, $jwtToken,'POST');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}

	/*  GTT Rule Details*/
	public static function RuleDetails($paramArray)
	{
		extract($paramArray);

		//getToken() check whether userlogged in or not and return jwtToken
		$token = self::getToken();
				
		 if ($token['status']) {
		 	//jwtToken not empty 
			$jwtToken = $token['jwtToken'];

			//get url from config file
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['rule_details'];	  	
			
			$api_parameter	=	array("id"	=>	"$id");
						
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,$api_parameter, $jwtToken,'POST');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}

	/*  GTT Rule list*/
	public static function RuleList($paramArray)
	{
		extract($paramArray);

		//getToken() check whether userlogged in or not and return jwtToken
		$token = self::getToken();
				
		 if ($token['status']) {
		 	//jwtToken not empty 
			$jwtToken = $token['jwtToken'];

			//get url from config file
			$UrlData = AngelConfigrationManage::AngelConfigrationData();
			$url = $UrlData['root'].$UrlData['rule_list'];	  	
			
			$api_parameter	=	array("status"=> $status,
							     "page"=> $page,
							     "count"=> $count
							 );			
			
			// Common function to call smart api
			$response_data	=	self::CurlOperation($url,$api_parameter, $jwtToken,'POST');
		}
		else{
			$response_data['status'] = 'fail';
			$response_data['error'] = 'The token is invalid';
			$response_data	=	json_encode($response_data);
		}
		
		//echo $response_data;
		return $response_data;
	}


	public static function getToken()
	{
		$jwtToken = '';
		$refreshToken = '';

		if (isset($_SESSION['jwtToken']) && !empty($_SESSION['jwtToken'])) {
			$jwtToken	=	$_SESSION['jwtToken'];
		}
		else if (isset($_COOKIE['jwtToken']) && !empty($_COOKIE['jwtToken'])) {
			$jwtToken	=	$_COOKIE['jwtToken'];
		}

		if (isset($_SESSION['refreshToken']) && !empty($_SESSION['refreshToken'])) {
			$refreshToken	=	$_SESSION['refreshToken'];
		}
		else if (isset($_COOKIE['refreshToken']) && !empty($_COOKIE['refreshToken'])) {
			$refreshToken	=	$_COOKIE['refreshToken'];
		}

		$output = array('jwtToken'=>$jwtToken,
						'refreshToken' => $refreshToken,
						'status'=>true);
		if ($jwtToken=='') {
			$output['status'] = false;
		}		

		return $output;
	}

	public static function CurlOperation($url, $api_parameter='', $jwtToken='', $method)
	{

		// Common function start

		$headers = [
                "Content-Type: application/json",
                "X-Content-Type-Options:nosniff",
                "Accept:application/json",
                "X-UserType: USER",
                "X-SourceID: WEB",
                "X-ClientLocalIP: 192.168.168.168",
                "X-ClientPublicIP: 106.193.147.98",
                "X-MACAddress: fe80::216e:6507:4b90:3719",
                "X-PrivateKey: smartapi_key",
                //"authorization: Bearer $jwtToken"
            ];
         if ($jwtToken!='') {
            	array_push($headers, "authorization: Bearer $jwtToken");
            }


      	$ch = curl_init();
		  
		// Receive server response ...
		curl_setopt($ch, CURLOPT_URL, $url); 
	
		// Return Page contents. 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		curl_setopt($ch,CURLOPT_ENCODING, "");
        curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch,CURLOPT_TIMEOUT, 0);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "$method");
        if ($api_parameter!='') {
        	curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($api_parameter)); 
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		

		$result = curl_exec($ch); 
		$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($result === false || $result==null)
		{
			$response_data['status'] = 'fail';
			$response_data['error'] = curl_error($ch);
		}
		else
		{
		    $response_data['status'] = 'success';
		}

		curl_close($ch); 

		$jsonArrayResponse = json_decode($result);

		$response_data['http_code'] = $response;
		$response_data['http_error']	=	self::getErrorMessage($response);
		$response_data['response_data'] = $jsonArrayResponse;

		

		return json_encode($response_data);

		// Common function end
	}

	public static function getErrorMessage($http_code)
	{
		
		switch ($http_code) {
			case '400':
				$message = "Invalid parameters";
				break;
			case '405':
				$message = "Method not allowed";
				break;
			case '500':
				$message = "Syntax error or empty or invalid parameter pass";
				break;
			default:
				$message = '';
				break;
		}
		return $message;
	}

	
}

?>