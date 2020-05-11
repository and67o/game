<?php

namespace Router\Abstractions\Social;

use Router\Exceptions\InstanceNotFound;
use Router\Models\Services\Request;
use Router\Models\social\OAuthHelperMailRu;
use Router\Models\Social\OAuthHelperVkontakte;
use Router\Traits\Json;

/**
 * Class OAuthHelper
 * @package Router\Abstractions\Social
 */
abstract class OAuthHelper
{
	use Json;

	/** @var Network */
	protected $_Network;
	/** @var Request */
	protected $_Request;
	
	public function __construct(Network $Network)
	{
		$Request = new Request();
		$this->setRequest($Request);
		$this->setNetwork($Network);
	}

	/**
	 * @param Request $Request
	 */
	public function setRequest(Request $Request): void
	{
		$this->_Request = $Request;
	}

	/**
	 * @return Request
	 */
	public function getRequest(): Request
	{
		return $this->_Request;
	}
	/**
	 * @param Network $Network
	 */
	public function setNetwork(Network $Network) : void
	{
		$this->_Network = $Network;
	}
	
	/**
	 * @return Network
	 */
	public function getNetwork() : Network
	{
		return $this->_Network;
	}
	
	/**
	 * @return string
	 */
	abstract public function getAuthUrl() : string;
	
	/**
	 * @return string
	 */
	public function getNetworkUrl() : string
	{
		return $this->_Network->getRedirectUri();
	}
	
	
	public static function getByNetwork(Network $Network) : self
	{
		switch ($Network->getId()) {
			case Network::ID_VKONTAKTE:
				return new OAuthHelperVkontakte($Network);
			case Network::ID_MAILRU:
				return new OAuthHelperMailRu($Network);
			default :
				throw new InstanceNotFound();
		}
	}

	/**
	 * @param string $code
	 * @return array
	 */
	abstract public function fetchAccessToken(string $code);
}