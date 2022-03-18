<?php
require_once(ROOT."/models/Department.php");

class DepartmentController {
	public function actionList() {
		$departmentList = Department::getDepartmentList();

		echo json_encode($departmentList);

		return true;
	}

	public function actionAdd() {
		$data = json_decode(file_get_contents('php://input'), true);

		Department::addDepartment($data['name']);

		return true;
	}

	public function actionEdit() {
		$data = json_decode(file_get_contents('php://input'), true);

		Department::editDepartment($data['id'], $data['name']);

		return true;
	}

	public function actionDelete() {
		$data = json_decode(file_get_contents('php://input'), true);

		Department::deleteDepartment($data['id']);

		return true;
	}
}