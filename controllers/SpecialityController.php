<?php
require_once(ROOT."/models/Speciality.php");

class SpecialityController {
	public function actionList() {
		$specialityList = Speciality::getSpecialityList();

		echo json_encode($specialityList);

		return true;
	}

	public function actionAdd() {
		$data = json_decode(file_get_contents('php://input'), true);

		Speciality::addSpeciality($data['name']);

		return true;
	}

	public function actionEdit() {
		$data = json_decode(file_get_contents('php://input'), true);

		Speciality::editSpeciality($data['id'], $data['name']);

		return true;
	}

	public function actionDelete() {
		$data = json_decode(file_get_contents('php://input'), true);

		Speciality::deleteSpeciality($data['id']);

		return true;
	}
}