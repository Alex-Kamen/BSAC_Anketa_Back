<?php
require_once(ROOT."/models/User.php");

class UserController {
	public function actionList() {
		$userList = User::getUserList();

		echo json_encode($userList);

		return true;
	}

	public function actionAdd() {
		$data = json_decode(file_get_contents('php://input'), true);

		User::addUser($data['login'], $data['password'], $data['status']);

		return true;
	}

	public function actionEdit() {
		$data = json_decode(file_get_contents('php://input'), true);

		User::editUser($data['id'], $data['login'], $data['password'], $data['status']);

		return true;
	}

	public function actionDelete() {
		$data = json_decode(file_get_contents('php://input'), true);

		User::deleteUser($data['id']);

		return true;
	}
}