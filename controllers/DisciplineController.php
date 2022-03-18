<?php
require_once(ROOT."/models/Discipline.php");

class DisciplineController {
	public function actionList() {
		$disciplineList = [];

		if (isset($_GET['department'])) {
			$disciplineList = Discipline::getDisciplineListByDepartmentId($_GET['department']);
		} else {
			$disciplineList = Discipline::getDisciplineList();
		}

		echo json_encode($disciplineList);

		return true;
	}

	public function actionAdd() {
		$data = json_decode(file_get_contents('php://input'), true);

		Discipline::addDiscipline($data['name'], $data['department']);

		return true;
	}

	public function actionEdit() {
		$data = json_decode(file_get_contents('php://input'), true);

		Discipline::editDiscipline($data['id'], $data['name'], $data['department']);

		return true;
	}

	public function actionDelete() {
		$data = json_decode(file_get_contents('php://input'), true);

		Discipline::deleteDiscipline($data['id']);

		return true;
	}
}