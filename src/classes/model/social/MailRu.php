<?php


namespace Router\Models\social;


use Router\Abstractions\Social\Network;
use Router\Exceptions\BaseException;
use Router\Models\Services\Request;

/**
 * Class MailRu
 * @package Router\Models\social
 */
class MailRu extends Network
{
	const BASE_URL = 'https://www.appsmail.ru/platform/api';

	/**
	 * MailRu constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setId(self::ID_MAILRU);
		$this->setClientId((int)getenv('MAILRU_CLIEND_ID'));
		$this->setClientSecret(getenv('MAILRU_CLIENT_SECRET'));
		$this->setRedirectUri(self::REDIRECT_URI);
	}

	/**
	 * @param array $accessToken
	 * @return mixed
	 * @throws BaseException
	 */
	public function getUserSocialAccountByToken(array $accessToken)
	{
		if (isset($accessToken['error'])) {
			return [
				'errors' => [$accessToken['error']],
				'result' => false,
				'data' => []
			];
		}

		$response = $this->get(
			'users.getInfo',
			$accessToken['x_mailru_vid'],
			$accessToken['access_token']
		);

		$data = json_decode((string)$response, true);

		$data = array_shift($data);

		return [
			'errors' => [],
			'result' => true,
			'data' => [
				'name' => $data['nick'] ?? '',
				'avatar' => $data['pic_128'] ?? '',
				'email' => $data['email'] ?? ''
			]
		];
	}

	/**
	 * @param string $method
	 * @param string $uid
	 * @param string $token
	 * @return bool|string
	 * @throws BaseException
	 */
	public function get(string $method, string $uid, string $token)
	{
		$params = [
			'method' => $method,
			'app_id' => $this->getClientId(),
			'uid' => $uid,
			'session_key' => $token,
			'secure' => 1,
			'format' => Network::FORMAT_JSON,
		];

		ksort($params);
		$stringForSig = '';

		foreach ($params as $key => $value) {
			$stringForSig .= $key . '=' . $value;
		}

		$params['sig'] = md5($stringForSig . $this->getClientSecret());
		$url = self::BASE_URL . '?' . urldecode(http_build_query($params));

		return $this->getRequest()->curl($url, Request::METHOD_POST);
	}
}