<?php
require_once(ROOT."/models/User.php");

class SiteController {
	public function actionIndex() {
		$data = json_decode(file_get_contents('php://input'), true);

		$userData = User::checkAuthData($data['login'], $data['password']);
			
		if ($userData) {
			echo json_encode($userData);
		} else {
			echo json_encode(Array('status' => false));
		}

		return true;
	}
}