<?php

include("Process.class.php");

$class = new Process();

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action != ""){
	switch($action){
		case 'getUrlResponse':
			$result = array();
			$url = $_POST['url'];

			if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
				$ch = curl_init();
				curl_setopt_array($ch, [
			        CURLOPT_URL => $url,
			        CURLOPT_HTTPHEADER => [
			            "Accept: application/vnd.github.v3+json",
			            "Content-Type: text/plain",
			            "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
			        ],
			        CURLOPT_RETURNTRANSFER => true,
			        CURLOPT_FOLLOWLOCATION => true,
			    ]);
			    $response = curl_exec($ch);
			    curl_close($ch);

				$result['response'] = $response;
				$result['processedResponse'] = [];

				//process response
				$processedResponse = [];
				if($response != ""){
					$result['processedResponse'] = $class->processsJson($response);
				}
			}else{
				$result['response'] = $url;
			}


			echo json_encode($result);
			break;
	}
}



