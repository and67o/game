<?php


namespace Router\Models;


use Router\Db;

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
	 * @return Db
	 */
	public static function isEmailExist(string $email)
	{
		return self::_db()
			->select([1])
			->table('users', 'u')
			->where('email = ?')
			->get((array) $email);
	}
	
	/**
	 * Создание пользователя
	 * @param array $param
	 * @return string
	 */
	public function create(array $param = [])
	{
		$userId = self::_db()
			->table('users')
			->add($param);
		if (!$userId) {
			throw new \PDOException('There was a problem creating this account.');
		}
		return $userId;
	}
}
