<?php


namespace Router\Models\social;


use Router\Abstractions\Social\OAuthHelper;
use Router\Exceptions\BaseException;
use Router\Models\Services\Request;

/**
 * Class OAuthHelperMailRu
 * @package Router\Models\social
 */
class OAuthHelperMailRu extends OAuthHelper
{
	const AUTHORIZE_METHOD = 'authorize';
	const BASE_URL = 'https://connect.mail.ru/oauth/';
	const ACCESS_TOKEN_METHOD = 'token';
	
	/**
	 * @inheritDoc
	 */
	public function getAuthUrl() : string
	{
		$params = [
			'client_id' => $this->_Network->getClientId(),
			'response_type' => 'code',
			'redirect_uri' => $this->_Network->getRedirectUri(),
		];
		
		return self::BASE_URL . self::AUTHORIZE_METHOD . '?' . urldecode(http_build_query($params));
	}
	
	/**
	 * @param string $code
	 * @return array
	 * @throws BaseException
	 */
	public function fetchAccessToken(string $code) : array
	{
		$url = $this->_getOauTokenThUrl($code);
		$token = $this->getRequest()->curl($url, Request::METHOD_POST);
		$decodedToken = $this->fromJSon($token, true);
		$this->_Network->setAccessToken($decodedToken);
		return $this->_Network->getAccessToken() ?? [];
	}
	
	/**
	 * @param string $code
	 * @return string
	 */
	private function _getOauTokenThUrl(string $code) : string
	{
		return self::BASE_URL . self::ACCESS_TOKEN_METHOD . '?' . http_build_query([
				'client_id' => $this->_Network->getClientId(),
				'client_secret' => $this->_Network->getClientSecret(),
				'grant_type' => 'authorization_code',
				'code' => $code,
				'redirect_uri' => $this->_Network->getRedirectUri(),
			]);
	}
}