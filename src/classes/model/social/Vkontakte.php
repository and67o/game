<?php


namespace Router\Models\Social;


use Exception;
use Router\Abstractions\Social\Network;
use Router\Models\Services\Request;

/**
 * Class Vkontakte
 * @package Router\Models\Social
 */
class Vkontakte extends Network
{
	const API_VKONTAKTE_V = '5.80';
	const BASE_URL = 'https://api.vk.com/method/';

	/**
	 * Vkontakte constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setId(self::ID_VKONTAKTE);
		$this->setClientId((int)getenv('VK_CLIEND_ID'));
		$this->setClientSecret(getenv('VK_CLIENT_SECRET'));
		$this->setRedirectUri(self::REDIRECT_URI);
	}

	/**
	 * @param array $accessToken
	 * @return array
	 * @throws Exception
	 */
	public function getUserSocialAccountByToken(array $accessToken) :array
	{
		$this->setAccessToken($accessToken);
		$userId = $accessToken['user_id'];

		$data = $this->get('users.get', [
			'user_id' => $userId,
			'fields' => [
				'avatar',
				'email',
				'photo_100'
			],
		])['response'];

		$data = array_shift($data);
		return [
			'socialNetwork' => self::ID_MAILRU,
			'socialId' => $data['id'],
			'name' => $data['first_name'] . ' ' .  $data['last_name'],
			'avatar' => $data['photo_100']
		];
	}

	/**
	 * @param string $method
	 * @param array $query
	 * @return mixed
	 * @throws Exception
	 */
	public function get(string $method, array $query = [])
	{
		foreach ($query as $param => $value) {
			if (is_array($value) && count($value)) {
				$query[$param] = implode(',', $value);
			}
		}

		$query['access_token'] = $this->getFieldAccessToken('access_token') ?? '';

		if (empty($query['v'])) {
			$query['v'] = self::API_VKONTAKTE_V;
		}

		$url = self::BASE_URL . $method . '?' . http_build_query($query);

		$res = $this->getRequest()->curl($url);
		return json_decode($res, true);
	}

}