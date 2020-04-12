<?php


namespace Router\Controller;


use Router\Abstractions\Social\Network;
use Router\Exceptions\BaseException;
use Router\Exceptions\InstanceNotFound;
use Router\Models\Services\Input;

/**
 * Class SocialAuth
 * @package Router\Controller
 */
class SocialAuth extends CommonController
{
	/**
	 *
	 */
	public function authorisation() : void
	{
		$this->setRequest(Input::METHOD_REQUEST_POST);
		
		$returnURL = $this->Input->get('returnUrl', 'string');
		$socialNetwork = $this->Input->get('returnUrl', 'int');
		
		try {
			$Network = Network::getById($socialNetwork);
			$redirectURL = $Network->getURLForAuth();
			
			if (!$redirectURL) {
				$this->toJSON([
					'urlTo' => $returnURL
				], true);
			}
			
			$this->Session->start();
			$this->Session->set('sn', $socialNetwork);
			$this->Session->set('return', $returnURL);
			
		} catch (InstanceNotFound $exception) {
			$redirectURL = $returnURL;
		}
		$this->toJSON([
			'linkContinue' => $redirectURL
		], true);
	}
	
	/**
	 *
	 */
	public function oauthCallback() : void
	{
		$this->setRequest(Input::METHOD_REQUEST_GET);
		
		$this->Session->start();
		$redirectURL = $this->Session->get('return');
		$socialNetwork = $this->Session->get('sn');
		
		$code = $this->Input->get('code', 'string');
		$state = $this->Input->get('state', 'string');
		
		try {
			if (
				!$socialNetwork &&
				$socialNetwork !== Network::ID_VKONTAKTE
			) {
				throw new BaseException(BaseException::UNKNOWN_SOCIAL_NETWORK);
			}
			$Network = Network::getById($socialNetwork);
			$accessToken = $Network->fetchAccessTokenForAuth($code, $state);
			$UserSocialAccount = $Network->getUserSocialAccountByToken($accessToken);
			
		} catch (BaseException $exception) {
			var_dump($exception->getMessage());
		}
		$this->locationRedirect($redirectURL);
	}
}