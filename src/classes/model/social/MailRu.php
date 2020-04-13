<?php


namespace Router\Models\social;


use Router\Abstractions\Social\Network;

class MailRu extends Network
{
	
	public function __construct()
	{
		$this->setId(self::ID_MAILRU);
		$this->setClientId((int) getenv('MAILRU_CLIEND_ID'));
		$this->setClientSecret(getenv('MAILRU_CLIENT_SECRET'));
		$this->setRedirectUri(self::REDIRECT_URI);
	}
	
	public function getUserSocialAccountByToken($accessToken)
	{
		// TODO: Implement getUserSocialAccountByToken() method.
	}
}