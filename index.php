<?php 
	// include 
	// =============================
	include "models/view_model.php";
	include "models/search_zip.php";
	include 'models/router.php';
	include 'models/MP.php';
	include 'models/fbHandler.php';
	require_once 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';

	// end includes 
	// =============================
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// pull in our config data
	$configs = include('config.php');

	// check if session exists 
	if(!session_id()) {
    	session_start();
	}


	// check for action in url
	// ===========================
	if (empty($_GET["action"])){
		$action = "home";
	}else{
		$action = $_GET["action"];
	}
	
	/*
	* Show the default home button
	*/	
	if( $action == "home"){
		$view_model = new View_Model();
		$view_model->get_view("views/index.php");
	}

	/*
	* Facebook Callback
	*/
	elseif($action == 'facebookCallback'){

		$FBHandler = new FBHandler();
		$data = $FBHandler->FBCallbackHandler($configs);

		$mp = new MP;
		$mp->MPCreateNewContact($configs, $data);

		header('Location:'.$configs['final_redirect-url']);
		die();
		
	}
?>
