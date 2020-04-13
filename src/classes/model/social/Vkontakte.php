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
		$this->setId(self::ID_VKONTAKTE);
		$this->setClientId((int) getenv('VK_CLIEND_ID'));
		$this->setClientSecret(getenv('VK_CLIENT_SECRET'));
		$this->setRedirectUri(self::REDIRECT_URI);
	}
	
	public function getUserSocialAccountByToken($accessToken)
	{
		$this->setAccessToken($accessToken);
		$userId = $accessToken['user_id'];
		
		return $this->get('users.get', [
			'user_id' => $userId,
			'fields' => [
				'avatar',
				'email',
				'photo_100'
			],
		]);
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
		
		$res = Request::curl($url);
		return json_decode($res, true);
	}
	
}