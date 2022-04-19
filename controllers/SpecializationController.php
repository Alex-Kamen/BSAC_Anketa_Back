<?php
require_once(ROOT."/models/Specialization.php");

class SpecializationController {
	public function actionList() {
		$specializationList = Specialization::getSpecializationList();

		echo json_encode($specializationList);

		return true;
	}

	public function actionAdd() {
		$data = json_decode(file_get_contents('php://input'), true);

		Specialization::addSpecialization($data['name'], $data['specialityId']);

		return true;
	}

	public function actionEdit() {
		$data = json_decode(file_get_contents('php://input'), true);

		Specialization::editSpecialization($data['id'], $data['name'], $data['specialityId']);

		return true;
	}

	public function actionDelete() {
		$data = json_decode(file_get_contents('php://input'), true);

		Specialization::deleteSpecialization($data['id']);

		return true;
	}
}