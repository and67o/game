<?php

namespace Router\Abstractions\Social;

use Router\Controller\CommonController;
use Router\Exceptions\InstanceNotFound;
use Router\Models\social\OAuthHelperMailRu;
use Router\Models\Social\OAuthHelperVkontakte;

/**
 * Class OAuthHelper
 * @package Router\Abstractions\Social
 */
abstract class OAuthHelper extends CommonController
{
	/** @var Network */
	protected $_Network;
	
	public function __construct(Network $Network)
	{
		parent::__construct();
		$this->setNetwork($Network);
		
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
	 * @param string $state
	 * @return array
	 */
	abstract public function fetchAccessToken(string $code, string $state);
}