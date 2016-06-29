<?php
	require_once 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php'; 

	/*
	* Once we figure out exactly what we need to do with this script. Clean up this garbage. 
	* Remove the php embed and extract everything into models. 
	*/
	$configs = include('config.php');

	$app_id = $configs['fb_app_id'];
	$app_secret = $configs['fb_app_secret'];
	$default_graph_version = $configs['fb_default_graph_version'];
	$redirectUrl = $configs['fb_redirect_url'];
	// Init facebook stuff
	$fb = new Facebook\Facebook([
		'app_id' => $app_id,
		'app_secret' => $app_secret,
		'default_graph_version' => $default_graph_version,
		//'default_access_token' => '{access-token}', // optional
	]);

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email']; // Optional permissions
	$loginUrl = $helper->getLoginUrl($redirectUrl, $permissions);	
?>


<style>
.buttonHolder{
	margin-top: 20px;
}
.btn {

	background: #3498db;
	background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
	background-image: -moz-linear-gradient(top, #3498db, #2980b9);
	background-image: -ms-linear-gradient(top, #3498db, #2980b9);
	background-image: -o-linear-gradient(top, #3498db, #2980b9);
	background-image: linear-gradient(to bottom, #3498db, #2980b9);
	-webkit-border-radius: 28;
	-moz-border-radius: 28;
	border-radius: 28px;
	font-family: Arial;
	color: #ffffff;
	font-size: 20px;
	padding: 10px 20px 10px 20px;
	text-decoration: none;
}

.btn:hover {
	background: #3cb0fd;
	background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
	background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
	background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
	background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
	background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
	text-decoration: none;
}
</style>
<div class="buttonHolder">
	<?php echo '<a class="btn" href="' . htmlspecialchars($loginUrl) . '">Facebook utton</a>'; ?>
</div>
