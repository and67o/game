<?php


namespace Router\Models;


use PDOException;
use Router\Models\Services\Session;

/**
 * Класс пользователя
 * Class User
 * @package Router\Models
 */
class User extends Model
{
	const TABLE_NAME= 'users';

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
	public function __construct(int $userId = 0)
	{
		if ($userId) {
			$userData = self::_db()
				->queryPrepare([
					'u_id' => $userId
				],
			'SELECT u.email, u.u_id, i.path
					FROM users u
					LEFT JOIN images i ON i.i_id = u.profile_avatar
				WHERE u.u_id = ?'
			)
			->first();
			if (is_array($userData) && count($userData)) {
				$this->setUser($userData);
			}
		}
	}
    
    /**
     * @param $userData
     */
	public function setUser($userData) {
        $this->email = $userData['email'];
        $this->userId = $userData['u_id'];
        $this->profileAvatar = $userData['path'];
    }
	
	/**
	 * Проверка на существоание email
	 * @param string $email
	 * @return string
	 */
	public static function isEmailExist(string $email)
	{
		return self::_db()
			->select([1])
			->table(self::TABLE_NAME, 'u')
			->where('email = ?')
			->get((array) $email)
			->single();
	}
	
	/**
	 * Создание пользователя
	 * @param array $param
	 * @return int
	 */
	public function create(array $param = []) :int 
	{
		$userId = (int) self::_db()
			->table(self::TABLE_NAME)
			->add($param);
		if (!$userId) {
			throw new PDOException('There was a problem creating this account.');
		}
		return $userId;
	}
}
