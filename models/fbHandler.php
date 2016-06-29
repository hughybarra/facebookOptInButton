<?php 
	class FBHandler{


		public function FBCallbackHandler($configs){
			$fb = new Facebook\Facebook([
				'app_id' => $configs['fb_app_id'],
				'app_secret' => $configs['fb_app_secret'],
				'default_graph_version' => $configs['fb_default_graph_version'],
			]);

			$helper = $fb->getRedirectLoginHelper();

			try {
			  	$accessToken = $helper->getAccessToken();
			  	$_SESSION['accessToken'] = $accessToken;
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
				// echo 'Graph returned an error: ' . $e->getMessage();
				// echo "<br>";
				// exit;

				header('Location:'.$configs['final_redirect-url']);
				die();
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				// When validation fails or other local issues
				// echo 'Facebook SDK returned an error: ' . $e->getMessage();
				// echo "<br>";
				// exit;


				header('Location:'.$configs['final_redirect-url']);
				die();
			}

			// 
			if (! isset($accessToken)) {
				if ($helper->getError()) {
					// header('HTTP/1.0 401 Unauthorized');
					// echo "Error: " . $helper->getError() . "\n";
					// echo "Error Code: " . $helper->getErrorCode() . "\n";
					// echo "Error Reason: " . $helper->getErrorReason() . "\n";
					// echo "Error Description: " . $helper->getErrorDescription() . "\n";
					header('Location:'.$configs['final_redirect-url']);
					die();
				} else {
					// header('HTTP/1.0 400 Bad Request');
					// echo 'Bad request';

					header('Location:'.$configs['final_redirect-url']);
					die();
				}
				// exit;
				header('Location:'.$configs['final_redirect-url']);
				die();
			}


			// Logged in
			// echo '<h3>Access Token</h3>';
			// var_dump($accessToken->getValue());


			// The OAuth 2.0 client handler helps us manage access tokens
			$oAuth2Client = $fb->getOAuth2Client();


			// Get the access token metadata from /debug_token
			$tokenMetadata = $oAuth2Client->debugToken($accessToken);
			// echo '<h3>Metadata</h3>';
			// echo '<pre>';

			// print_r($tokenMetadata);


			// Validation (these will throw FacebookSDKException's when they fail)
			$tokenMetadata->validateAppId($configs['fb_app_id']); // Replace {app-id} with your app id
			// If you know the user ID this access token belongs to, you can validate it here
			//$tokenMetadata->validateUserId('123');
			$tokenMetadata->validateExpiration();


			// Exchanges a short-lived access token for a long-lived one
			try {

				$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
			} catch (Facebook\Exceptions\FacebookSDKException $e) {
				// echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
				// exit;

				header('Location:'.$configs['final_redirect-url']);
				die();
			}

			// echo '<h3>Long-lived</h3>';
			// var_dump($accessToken->getValue());

			$_SESSION['fb_access_token'] = (string) $accessToken;

			// Get email not working 
			try {
				// echo '<h3>user Data</h3>';
				// Returns a `Facebook\FacebookResponse` object
				$response = $fb->get('/me?fields=email,first_name,last_name', $accessToken);
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				// echo 'Graph returned an error: ' . $e->getMessage();
				// exit;

				header('Location:'.$configs['final_redirect-url']);
				die();
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				// echo 'Facebook SDK returned an error: ' . $e->getMessage();
				// exit;
				header('Location:'.$configs['final_redirect-url']);
				die();
			} finally {
				$graphNode = $response->getGraphNode();
				$userNode = $response->getGraphUser();

		


				$data = array(
					'email'				=> $userNode->getField('email'), 
					'first_name'		=> $userNode->getField('first_name'),
					'last_name'			=> $userNode->getField('last_name'),
					'phone'				=> $graphNode->getField('phone'),
				);

				return $data;

			}
		}
	}