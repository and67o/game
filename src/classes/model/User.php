<?php


namespace Router\Models;


use Router\src\classes\model\Model;

/**
 * Класс пользователя
 * Class User
 * @package Router\Models
 */
class User extends Model
{
	/** @var int уникальный идентификатор пользователя */
	public $userId;
	/** @var string email пользователя */
	public $email;
	/** @var string путь к аватару пользователя */
	public $profileAvatar;
	
	/**
	 * User constructor.
	 * @param int $userId
	 */
	public function __construct($userId = 0)
	{
		if ($userId) {
			$sql = sprintf('
				SELECT u.email, u.u_id, i.path
					FROM users u
					LEFT JOIN images i ON i.i_id = u.profile_avatar
				WHERE u.u_id = %s', $userId
			);
			$sqlResult = self::_db()->fetchAll($sql);
			$userData = array_shift($sqlResult);
			
			$this->email = !empty($userData['email']) ? $userData['email'] : '';
			$this->userId = $userData['u_id'];
			$this->profileAvatar = $userData['path'];
			
		}
	}

	/**
	 *  Проверка на существоание email
	 * @param string $email
	 * @return bool
	 */
	public static function isEmailExist(string $email) : bool
	{
		if (!$email) {
			return false;
		}
		$sql = sprintf('
			SELECT 1
			FROM users WHERE email = "%s"
		', $email);
		return self::_db()->fetchFirstField($sql);
		
	}

	/**
	 * Регистрация нового пользователя
	 * @param string $email
	 * @param string $password
	 * @return int
	 */
	public static function createNewUser(string $email, string $password) : int
	{
		if (!$email || !$password) {
			return false;
		}
		$sql = sprintf('
			INSERT INTO users (email, password) VALUES ("%s", "%s")
		', $email, $password);
		$result = self::_db()->query($sql);
		return $result ? mysqli_insert_id(self::_db()) : 0;
	}
}
