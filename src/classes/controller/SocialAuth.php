<?php


namespace Router\Controller;


use Router\Abstractions\Social\Network;
use Router\Exceptions\BaseException;
use Router\Exceptions\InstanceNotFound;
use Router\Facades\UserFacade;
use Router\Models\Auth;
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
	public function authorisation(): void
	{
		$this->setResponse(Input::METHOD_REQUEST_POST);

		$returnURL = $this->Input->get('returnUrl', 'string');
		$socialNetwork = $this->Input->get('socialNetwork', 'int');

		try {
			$Network = Network::getById($socialNetwork);
			$redirectURL = $Network->getURLForAuth();

			if (!$redirectURL) {
				$this->toJSON([
					'urlTo' => $returnURL
				], true);
			}

			$this->_setSocialParams($socialNetwork, $returnURL);

		} catch (InstanceNotFound $exception) {
			$redirectURL = $returnURL;
		}
		$this->toJSON([
			'linkContinue' => $redirectURL
		], true);
	}

	/**
	 * @param int $socialNetwork
	 * @param string $returnURL
	 */
	private function _setSocialParams(int $socialNetwork, string $returnURL): void
	{
		$this->Session->start();
		$this->Session->set('sn', $socialNetwork);
		$this->Session->set('return', $returnURL);
	}

	/**
	 *
	 */
	public function oauthCallback(): void
	{
		$this->setResponse(Input::METHOD_REQUEST_GET);

		$this->Session->start();
		$redirectURL = (string)$this->Session->get('return');
		$socialNetwork = (int)$this->Session->get('sn');

		$code = $this->Input->get('code', 'string');
		try {
			if (!in_array($socialNetwork, Network::getAllNetworkId())) {
				throw new BaseException(BaseException::UNKNOWN_SOCIAL_NETWORK);
			}
			$Network = Network::getById($socialNetwork);
			$accessToken = $Network->fetchAccessTokenForAuth($code);
			$UserSocialAccount = $Network->getUserSocialAccountByToken($accessToken);
			if (!$UserSocialAccount['result']) {
				$this->toJSON($this->response(
					[],
					false
				), true);
			}

			//TODO пароли в отдельную таблицу и связка пароль к users
			$userId = UserFacade::add(
				$UserSocialAccount['data']['email'],
				'',
				$UserSocialAccount['data']['email'],
				$UserSocialAccount['data']['avatar']
			);

			if (!$userId) {
				throw new BaseException(BaseException::USER_NOT_CREATED);
			}

			Auth::setAuthCookie('userId', $userId);
			$this->Session->start();
			$this->Session->set('userId', $userId);

			$this->toMain();

		} catch (BaseException $exception) {
			var_dump($exception->getMessage());
		}
		$this->locationRedirect($redirectURL);
	}
}