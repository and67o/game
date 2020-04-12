<?php


namespace Router\Models\Social;


use Exception;
use GuzzleHttp\Client;
use Router\Abstractions\Social\Network;
use Router\Abstractions\Social\OAuthHelper;
use Router\Exceptions\BaseException;
use Router\Models\Services\Request;

/**
 * Class OAuthHelperVkontakte
 * @package App\Social
 */
class OAuthHelperVkontakte extends OAuthHelper
{
	const AUTHORIZE_METHOD = 'authorize';
	const BASE_URL = 'https://oauth.vk.com/';
	const ACCESS_TOKEN_METHOD = 'access_token';
	
	/**
	 * @return string
	 */
	public function getAuthUrl() : string
	{
		$params = [
			'client_id' => $this->_Network->getClientId(),
			'redirect_uri' => $this->_Network->getRedirectUri(),
			'response_type' => Network::RESPONSE_TYPE,
		];
		
		return self::BASE_URL . self::AUTHORIZE_METHOD . '?' . urldecode(http_build_query($params));
	}
	
	/**
	 * @param string $code
	 * @param string $state
	 * @return array
	 * @throws Exception
	 */
	public function fetchAccessToken(string $code, string $state)
	{
		$url = $this->_getOauTokenThUrl($code);

		$token = Request::curl($url);
		$decodedToken = $this->fromJSon($token, true);
		$this->_Network->setAccessToken($decodedToken);
		return $this->_Network->getAccessToken();
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
				'code' => $code,
				'redirect_uri' => $this->_Network->getRedirectUri(),
			]);
	}
}