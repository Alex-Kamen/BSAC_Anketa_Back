<?php
require_once(ROOT."/components/Db.php");

class Speciality {
	public static function getSpecialityList() {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM speciality");

		$result->execute();
		$specialityList = [];

		while($row = $result->fetch()) {
			$specialityList[] = array(
				'id' => $row['id'], 
				'name' => $row['name'], 
			);
		}

		return $specialityList;
	}

	public static function getSpecialityById($id) {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM speciality WHERE id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();

		return array(
			'id' => $result['id'], 
			'name' => $result['name'], 
		);
	}

	public static function addSpeciality($specialityName) {
		$db = Db::getConnection();

		$result = $db->prepare("INSERT INTO speciality (name) VALUES (:name)");
		$result->bindParam(":name", $specialityName, PDO::PARAM_STR);
		$result->execute();
	}

	public static function editSpeciality($id, $name) {
		$db = Db::getConnection();

		$result = $db->prepare("UPDATE speciality SET name = :name WHERE id = :id");
		$result->bindParam(":name", $name, PDO::PARAM_STR);
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}

	public static function deleteSpeciality($id) {
		$db = Db::getConnection();

		$result = $db->prepare("DELETE FROM speciality WHERE id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}
}
