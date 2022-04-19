<?php
require_once(ROOT."/components/Db.php");

class Department {
	public static function getDepartmentList() {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM department");

		$result->execute();
		$departmentList = [];

		while($row = $result->fetch()) {
			$departmentList[] = array(
				'id' => $row['id'], 
				'name' => $row['name'], 
			);
		}

		return $departmentList;
	}

	public static function getDepartmentById($id) {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM department WHERE id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
		$row = $result->fetch();

		return array(
			'id' => $row['id'], 
			'name' => $row['name'], 
		);
	}

	public static function addDepartment($departmentName) {
		$db = Db::getConnection();

		$result = $db->prepare("INSERT INTO department (name) VALUES (:name)");
		$result->bindParam(":name", $departmentName, PDO::PARAM_STR);
		$result->execute();
	}

	public static function editDepartment($id, $name) {
		$db = Db::getConnection();

		$result = $db->prepare("UPDATE department SET name = :name WHERE id = :id");
		$result->bindParam(":name", $name, PDO::PARAM_STR);
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}

	public static function deleteDepartment($id) {
		$db = Db::getConnection();

		$result = $db->prepare("DELETE FROM department WHERE id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}

	public static function getDepartmentIdByUserId($userId) {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM departmentmanager WHERE id = :id");
		$result->bindParam(":id", $userId, PDO::PARAM_INT);
		$result->execute();
		$row = $result->fetch();

		return $row['departmentId'];
	}
}
