<?php

namespace Router\Abstractions\Social;

use Router\Exceptions\InstanceNotFound;
use Router\Models\social\MailRu;
use Router\Models\Social\Vkontakte;

/**
 * Class Network
 * @package Router\Abstractions\Social
 */
abstract class Network
{
	const RESPONSE_TYPE = 'code';
	const REDIRECT_URI = 'http://test.site/socialAuth/oauthCallback';
	
	/** ID СОЦИАЛЬНОЙ СЕТИ: ВКонтакте */
	const ID_VKONTAKTE = 0;
	/** ID СОЦИАЛЬНОЙ СЕТИ: MAIL.RU */
	const ID_MAILRU = 1;
	
	/** @var string */
	protected $redirectUri;
	/** @var string */
	protected $clientSecret;
	/** @var integer */
	protected $clientId;
	/** @var integer */
	protected $id;
	/** @var array */
	protected $accessToken;
	
	/**
	 * @param int $clientId
	 */
	public function setClientId(int $clientId) : void
	{
		$this->clientId = $clientId;
	}
	
	/**
	 * @return string
	 */
	public function getClientId() : string
	{
		return $this->clientId;
	}
	
	/**
	 * @param string $clientSecret
	 */
	public function setClientSecret(string $clientSecret) : void
	{
		$this->clientSecret = $clientSecret;
	}
	
	/**
	 * @return string
	 */
	public function getClientSecret() : string
	{
		return $this->clientSecret;
	}
	
	/**
	 * @param string $redirectUri
	 */
	public function setRedirectUri(string $redirectUri) : void
	{
		$this->redirectUri = $redirectUri;
	}
	
	/**
	 * @return string
	 */
	public function getRedirectUri() : string
	{
		return $this->redirectUri;
	}
	
	/**
	 * @return array
	 */
	public function getAccessToken() : array
	{
		return $this->accessToken;
	}
	
	/**
	 * @param string $field
	 * @return string
	 */
	public function getFieldAccessToken(string $field)
	{
		return $this->getAccessToken()[$field] ?? '';
	}
	
	/**
	 * @param array $accessToken
	 */
	public function setAccessToken(array $accessToken) : void
	{
		$this->accessToken = $accessToken;
	}
	
	/**
	 * @param int $id
	 */
	public function setId(int $id) : void
	{
		$this->id = $id;
	}
	
	/**
	 * @return int
	 */
	public function getId() : int
	{
		return $this->id;
	}
	
	/**
	 * @param int $id
	 * @return static
	 * @throws InstanceNotFound
	 */
	public static function getById(int $id) : self
	{
		switch ($id) {
			case self::ID_VKONTAKTE:
				return new Vkontakte();
			case self::ID_MAILRU:
				return new MailRu();
			default :
				throw new InstanceNotFound();
		}
	}
	
	/**
	 * @return string
	 * @throws InstanceNotFound
	 */
	public function getUrlForAuth() : string
	{
		return $this->_getOAuthHelper()
			->getAuthUrl();
	}
	
	/**
	 * @return OAuthHelper
	 * @throws InstanceNotFound
	 */
	private function _getOAuthHelper() : OAuthHelper
	{
		return OAuthHelper::getByNetwork($this);
	}
	
	/**
	 * @param string $code
	 * @param string $state
	 * @return array
	 * @throws InstanceNotFound
	 */
	public function fetchAccessTokenForAuth(string $code, string $state) : array
	{
		return $this->_getOAuthHelper()
			->fetchAccessToken($code, $state);
	}
	
	abstract public function getUserSocialAccountByToken($accessToken);
}