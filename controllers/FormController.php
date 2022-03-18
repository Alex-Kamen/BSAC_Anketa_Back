<?php
require_once(ROOT."/models/Form.php");
require_once(ROOT."/models/Discipline.php");
require_once(ROOT."/models/Department.php");
require_once(ROOT."/models/Speciality.php");
require_once(ROOT."/models/Answer.php");

class FormController {
	public function actionList() {
		$data = json_decode(file_get_contents('php://input'), true);

		$result = Array();

		$formList = Form::getFormListByRole($data['status']);

		$result['data'] = $formList;

		if ($data['status'] == 'student') {
			$result['discipline'] = Discipline::getDisciplineList();
			$result['department'] = Department::getDepartmentList();
			$result['speciality'] = Speciality::getSpecialityList();
			$result['educationType'] = ['ДФПО', 'ЗФПО'];
		} else if ($data['status'] == 'staff') {
			$result['employeeType'] = ["АУП","ППС","УВП","ПОП"];
			$result['age'] = ["до 35 лет","от 35 до 55 лет","старше 55 лет"];
		}

		echo json_encode($result);

		return true;
	}

	public function actionForm($formId) {
		$form = Form::getFormDataById($formId);

		echo json_encode($form);

		return true;
	}

	public function actionSave() {
		$data = json_decode(file_get_contents('php://input'), true);
	
		Form::saveForm($data);

		return true;
	}

	public function actionDelete() {
		$data = json_decode(file_get_contents('php://input'), true);

		Answer::deleteAnswer($data['id']);

		return true;
	}
}