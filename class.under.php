<?php

/**davichoso@gmail.com*/


class UnderArmour {

		public $client_id;
		public $client_secret;
		public $api_url;
		public $redirect_url;
		public $oauth_url;
		public $refresh_url;
		public $access_token;

		public function __construct
		(
			$client_id, #Client ID, get this by creating an app  https://developer.underarmour.com/docs
			$client_secret, #Client Secret, get this by creating an app   https://developer.underarmour.com/docs
			$redirect_url, #Callback URL for getting an access token
			$oauth_url = 'https://www.mapmyfitness.com/v7.1/oauth2/uacf/authorize/', 
			$refresh_url = 'https://api.ua.com/v7.1/oauth2/uacf/access_token/', 
			$api_url = 'https://api.ua.com/v7.1/'
		)
		{
			$this->api_url = $api_url;
			$this->oauth_url = $oauth_url;
			$this->client_id = $client_id;
			$this->client_secret = $client_secret;
			$this->refresh_url = $refresh_url;
			$this->redirect_url = $redirect_url;
		}

		#Generate an request URL

		public function requestAuthorizationURL() {
		// https://dev.fitbit.com/docs/oauth2/#authorization-code-grant-flow			
		// your OAuth 2.0 Application Type must be server 
			$u = $this->oauth_url;
			$t = '?response_type=' . urlencode('code'); //code for Authorization Code Grant flow, token for Implicit Grant flow
			$c = '&client_id=' . urlencode($this->client_id);
			$r = '&redirect_uri=' . urlencode($this->redirect_url);			
			$url = $u . $t . $c . $r;
			return $url;
		}

		#Validate access token
		public function validate_token($token) {
			$u = $this->oauth_url . 'tokeninfo?access_token=' . $token;
			$r = $this->get_http_response_code($u);
			if ($r === "200") {
				return json_decode($this->geturl($u), true);
			} else {
				return false;
			}
		}

		#Get access_token
        public function exchangeCodeforToken($code) {
                return $this->make_request($code,"authorization_code");
        }

                #Refresh access_token

        public function refresh($refresh_token) {
                return $this->make_request($refresh_token, "refresh_token");
        }

        private function make_request($token, $type)
        {
                $u = $this->refresh_url;
                $d = array('grant_type' => $type);                
                if ($type === "authorization_code") {
                		$d['client_id'] = $this->client_id;
                		$d['client_secret'] = $this->client_secret;                        
                        $d['code'] = $token;

                } elseif ($type === "refresh_token") 
                {
                        $d['refresh_token'] = $token;
                        $d['client_id'] = $this->client_id;
                		$d['client_secret'] = $this->client_secret;         
                }

                $ch = curl_init();
				curl_setopt($ch, CURLOPT_HTTPHEADER,['Api-Key: '.$this->client_id,'Content-Type: application/x-www-form-urlencoded']); // https://developer.underarmour.com/docs/v71_OAuth_2_Intro for more info
                curl_setopt($ch, CURLOPT_URL, $u); // url send the post
                curl_setopt($ch, CURLOPT_POST, 1); // make post
                
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($d));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $result = curl_exec($ch);
                curl_close($ch);
                $token = json_decode($result, True);
                if(isset($token['access_token']))
                return array('access_token' => $token['access_token'], 'refresh_token' => $token['refresh_token']);
                else
                return false;
                
        }
         
		public function setAccessToken($access_token)
		{
			$this->access_token=$access_token;
		}

		public function geturl($url) {

			if(!$this->access_token) //set the access_token first
				return false; 	

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER,['Authorization: Bearer '.$this->access_token,'Api-Key: '.$this->client_id]); // changes in the header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


			$data = curl_exec($ch);
			curl_close($ch);
				return json_decode($data,1);
		}

	}

	?>