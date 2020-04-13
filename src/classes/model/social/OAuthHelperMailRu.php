<?php


namespace Router\Models\social;


use Router\Abstractions\Social\OAuthHelper;

class OAuthHelperMailRu extends OAuthHelper
{
	
	/**
	 * @inheritDoc
	 */
	public function getAuthUrl() : string
	{
		

//		$state = md5(uniqid(rand(), true));
//		$_SESSION['state'] = $state; // для защиты от CSRF
		$params = [
			'client_id'		=> $this->_Network->getClientId(),
			'response_type' => 'code',
			'redirect_uri'	=> $this->_Network->getRedirectUri(),
//			'scope'			=> implode(' ', $scope),
//			'state'			=> $state,
		];
		
		return 'https://connect.mail.ru/oauth/authorize' . '?' . http_build_query($params);
	}
	
	/**
	 * @inheritDoc
	 */
	public function fetchAccessToken(string $code, string $state)
	{
		// TODO: Implement fetchAccessToken() method.
	}
}