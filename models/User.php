<?php
require_once(ROOT."/components/Db.php");

class User {
	public static function checkAuthData($login, $password) {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM user WHERE login = :login AND password = :password");
		$result->bindParam(":login", $login, PDO::PARAM_STR);
		$result->bindParam(":password", $password, PDO::PARAM_STR);
		$result->execute();
		$user = $result->fetch();

		if($user) {
			return array(
				'id' => $user['id'], 
				'status' => $user['status'], 
				'login' => $user['login']
			);
		}

		return false;
	}

	public static function getUserList() {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM user");

		$result->execute();
		$userList = [];

		while($row = $result->fetch()) {
			$userList[] = array(
				'id' => $row['id'], 
				'login' => $row['login'],
				'status' => $row['status'], 
			);
		}

		return $userList;
	}

	public static function addUser($userLogin, $userPassword, $userStatus) {
		$db = Db::getConnection();

		$result = $db->prepare("INSERT INTO user (login, password, status) VALUES (:login, :password, :status)");
		$result->bindParam(":login", $userLogin, PDO::PARAM_STR);
		$result->bindParam(":password", $userPassword, PDO::PARAM_STR);
		$result->bindParam(":status", $userStatus, PDO::PARAM_STR);
		$result->execute();
	}

	public static function editUser($id, $userLogin, $userPassword, $userStatus) {
		$db = Db::getConnection();

		if ($userPassword != '') {
			$result = $db->prepare("UPDATE user SET login = :login, password = :password, status = :status WHERE id = :id");
			$result->bindParam(":login", $userLogin, PDO::PARAM_STR);
			$result->bindParam(":password", $userPassword, PDO::PARAM_STR);
			$result->bindParam(":status", $userStatus, PDO::PARAM_STR);
			$result->bindParam(":id", $id, PDO::PARAM_INT);
			$result->execute();
		} else {
			$result = $db->prepare("UPDATE user SET login = :login, status = :status WHERE id = :id");
			$result->bindParam(":login", $userLogin, PDO::PARAM_STR);
			$result->bindParam(":status", $userStatus, PDO::PARAM_STR);
			$result->bindParam(":id", $id, PDO::PARAM_INT);
			$result->execute();
		}

		
	}

	public static function deleteUser($id) {
		$db = Db::getConnection();

		$result = $db->prepare("DELETE FROM user WHERE id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}
}