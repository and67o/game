<?php


namespace Router\Facades;


use Exception;
use Router\Models\Images;
use Router\Models\Model;
use Router\Models\Role;
use Router\Models\Services\Hash;
use Router\Models\User;

/**
 * Class UserFacade
 * @package Router\Facades
 */
class UserFacade extends Model
{
	/**
	 * @param string $email
	 * @param string $pass
	 * @param string $name
	 * @param string $imgPath
	 * @return int
	 * @throws Exception
	 */
	public static function add(
		string $email,
		string $pass,
		string $name,
		string $imgPath = ''
	): int
	{
		//TODO Добавить транзакцию
		$User = new User();
		$hashes = Hash::passwordHash($pass);
		$userParams = [
			'email' => $email,
			'password' => $hashes['hash'],
			'salt' => $hashes['salt'],
			'name' => $name,
			'reg_dt' => Model::now(),
			'role_id' => Role::USER_ROLE,
		];

		if ($imgPath) {
			$imgId = Images::saveImg(['path' => $imgPath]);
			if ($imgId > 0) {
				$userParams['profile_avatar'] = $imgId;
			}
		}

		return $User->create($userParams);
	}

}