<?php
require_once(ROOT."/components/Db.php");

class Discipline {
	public static function getDisciplineList() {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM discipline JOIN department ON (discipline.departmentId = department.id)");

		$result->execute();
		$disciplineList = [];

		while($row = $result->fetch()) {
			$disciplineList[] = array(
				'id' => $row[0],  // id дисциплины
				'name' => $row[1], // Название дисциплины
				'department' => $row['name'], // Название кафедры
			);
		}

		return $disciplineList;
	}

	public static function getDisciplineListByDepartmentId($id) {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM discipline JOIN department ON (discipline.departmentId = department.id) WHERE department.id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
		$disciplineList = [];

		while($row = $result->fetch()) {
			$disciplineList[] = array(
				'id' => $row[0],  // id дисциплины
				'name' => $row[1], // Название дисциплины
				'department' => $row['name'], // Название кафедры
			);
		}

		return $disciplineList;
	}

	public static function getDisciplineById($id) {
		$db = Db::getConnection();

		$result = $db->prepare("SELECT * FROM discipline JOIN department ON (discipline.departmentId = department.id) WHERE discipline.id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
		$row = $result->fetch();

		return array(
			'id' => $row[0],  // id дисциплины
			'name' => $row[1], // Название дисциплины
			'department' => $row['name'], // Название кафедры
		);
	}

	public static function addDiscipline($disciplineName, $disciplineDepartment) {
		$db = Db::getConnection();

		$result = $db->prepare("INSERT INTO discipline (name, departmentId) VALUES (:name, :department)");
		$result->bindParam(":name", $disciplineName, PDO::PARAM_STR);
		$result->bindParam(":department", $disciplineDepartment, PDO::PARAM_STR);
		$result->execute();
	}

	public static function editDiscipline($id, $disciplineName, $disciplineDepartment) {
		$db = Db::getConnection();

		$result = $db->prepare("UPDATE discipline SET name = :name, departmentId = :department WHERE id = :id");
		$result->bindParam(":name", $disciplineName, PDO::PARAM_STR);
		$result->bindParam(":department", $disciplineDepartment, PDO::PARAM_STR);
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}

	public static function deleteDiscipline($id) {
		$db = Db::getConnection();

		$result = $db->prepare("DELETE FROM discipline WHERE id = :id");
		$result->bindParam(":id", $id, PDO::PARAM_INT);
		$result->execute();
	}
}
