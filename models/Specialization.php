<?php
require_once(ROOT."/components/Db.php");

class Specialization {
	public static function getSpecializationList() {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM specialization JOIN speciality ON (speciality.id = specialization.speciality)");

		$result->execute();
		$specializationList = [];

		while($row = $result->fetch()) {
			$specializationList[] = array(
				'id' => $row[0], // id специализации
				'name' => $row[1], // название специализации
				'specialityId' => $row['speciality'], // id специальности
				'specialityName' => $row[4] // название специальности
			);
		}

		return $specializationList;
	}

	public static function getSpecializationIdByUserId($id) {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM student JOIN specialization ON (student.specializationId = specialization.id) WHERE student.studentId = :studentId");
		$result->bindParam(":studentId", $id, PDO::PARAM_INT);
		$result->execute();
		$row = $result->fetch();

		return $row['id'];
	}

	public static function getSpecializationNameByUserId($id) {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM student JOIN specialization ON (student.specializationId = specialization.id) WHERE student.studentId = :studentId");
		$result->bindParam(":studentId", $id, PDO::PARAM_INT);
		$result->execute();
		$row = $result->fetch();

		return $row['name'];
	}

	public static function addSpecialization($specializationName, $specializationSpeciality) {
		$db = Db::getConnection();

		$result = $db->prepare("INSERT INTO specialization (name, speciality) VALUES (:name, :speciality)");
		$result->bindParam(":name", $specializationName, PDO::PARAM_STR);
		$result->bindParam(":speciality", $specializationSpeciality, PDO::PARAM_STR);
		$result->execute();
	}

	public static function editSpecialization($id, $specializationName, $specializationSpeciality) {
		$db = Db::getConnection();

		$result = $db->prepare("UPDATE specialization SET name = :name, speciality = :speciality  WHERE id = :id");
		$result->bindParam(":name", $specializationName, PDO::PARAM_STR);
		$result->bindParam(":speciality", $specializationSpeciality, PDO::PARAM_STR);
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}

	public static function deleteSpecialization($id) {
		$db = Db::getConnection();

		$result = $db->prepare("DELETE FROM specialization WHERE id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}
}
