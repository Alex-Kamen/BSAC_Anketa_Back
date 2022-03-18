<?php
require_once(ROOT."/models/Form.php");
require_once(ROOT."/models/Answer.php");

class AdminController {
	public function actionData() {
		$answerData = Array('formData' => [], 'answerList' => []);
		$resultList = [];
		$resultErrorList = [];
		$mainResult = 0;
		$mainResultError = 0;

		if (count($_GET)) {
			$answerData = Answer::getSortedAnswerList($_GET);
			$resultList = Answer::getResultList($answerData['formData'], $answerData['answerList']);
			$resultErrorList = Answer::getResultErrorList($answerData['formData'], $answerData['answerList']);
			$mainResult = Answer::getMainResult($answerData['formData'], $resultList);
			$mainResultError = Answer::getMainErrorResult($answerData['formData'], $resultErrorList);
		}
		

		echo json_encode(Array(
			'formData' => $answerData['formData'],
			'answerList' => $answerData['answerList'],
			'resultErrorList' => $resultErrorList,
			'resultList' => $resultList,
			'mainResult' => $mainResult,
			'mainResultError' => $mainResultError,
		));

		return true;
	}

	public function actionList() {
		$answerData = Array('formData' => [], 'answerList' => []);

		$answerData = Answer::getSortedAnswerList($_GET, false);
		

		echo json_encode(Array(
			'formData' => $answerData['formData'],
			'answerList' => $answerData['answerList'],
		));

		return true;
	}
}