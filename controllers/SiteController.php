<?php
require_once(ROOT."/models/User.php");
require_once(ROOT."/models/Department.php");
require_once(ROOT."/models/Specialization.php");

class SiteController {
	public function actionIndex() {
		$data = json_decode(file_get_contents('php://input'), true);

		$userData = User::checkAuthData($data['login'], $data['password']);

		if ($userData['status'] == 'departmentManager') {
			$userData['departmentId'] = Department::getDepartmentIdByUserId($userData['id']);
		}

		if ($userData['status'] == 'student') {
			$userData['specialization'] = Specialization::getSpecializationIdByUserId($userData['id']);
		}
			
		if ($userData) {
			echo json_encode($userData);
		} else {
			echo json_encode(Array('status' => false));
		}

		return true;
	}
}