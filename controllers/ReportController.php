<?php
require_once(ROOT."/models/Report.php");
require_once(ROOT."/models/Answer.php");
require_once(ROOT."/models/Discipline.php");

class ReportController {
	public function actionWord() {
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
			$filterList = Answer::collectFilterSettings($_GET);
		}

		Report::toWord($answerData['formData'], $answerData['answerList'], $resultList, $resultErrorList, $mainResult, $mainResultError, $filterList);

		return true;
	}
}