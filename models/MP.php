<?php 
	/*
	Found this at : 
	* https://github.com/infusedmj/maropost-php-sdk/blob/master/mp-class.php
	* this class handles requests to the hasofers api. 
	* sets up a curl request and sends it returning the response. 
	*/
	class MP{

		function MPCreateNewContact($configs, $contact){
			// EXAMPLE 1: Add new contact to Maropost:		
			$newcontact = self::request($configs, 'POST','lists/'.$configs['MP_listId'].'/contacts', array(
					'first_name'  => $contact['first_name'] ? : ' ',
					'last_name'   => $contact['last_name'] ?: ' ',
					'email' 	  => $contact['email'] ?: ' ',
					'phone'		  => $contact['phone'] ?: ' ',
			));
		}


		function request($configs, $action, $endpoint, $dataArray){

			$url = $configs['MP_url_api']. $endpoint.'.json';

		  	$ch = curl_init();
		  	$dataArray['auth_token'] = $configs['MP_auth_token'];
		  	$json = json_encode($dataArray);

		    curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		    curl_setopt($ch, CURLOPT_URL, $url);
		    switch($action){
		            case "POST":
		            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		            break;
		        case "GET":
		            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		            break;
		        case "PUT":
		            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		            break;
		        case "DELETE":
		            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		            break;
		        default:
		            break;
		    }
		    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json','Accept: application/json'));
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		    $output = curl_exec($ch);
		    curl_close($ch);
		    $decoded = json_decode($output);
		    return $decoded;
		}

	}
