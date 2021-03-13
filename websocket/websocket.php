<?php
		$host = "wss://omnefeeds.angelbroking.com/NestHtml5Mobile/socket/stream";
		$port = 80;

		
			$msg = '{"task":"cn","channel":"","token":"09668232","user": "D883","acctid":"D883"}';
			$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die(socket_last_error().'-'.socket_strerror(socket_last_error())."Could not create socket\n");

			socket_connect($sock, $host, $port) or die(socket_last_error().'-'.socket_strerror(socket_last_error())." Could not connect socket\n");

			socket_write($sock, $msg, strlen($msg)) or die(socket_last_error().'-'.socket_strerror(socket_last_error())." Could not write output\n");

			$reply= socket_read($sock, 1924);
			$reply = trim($reply);
			$reply = "server Says :\t".$reply;

		print_r($reply);
?>