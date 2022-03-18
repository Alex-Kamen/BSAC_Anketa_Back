<?php
require_once(ROOT."/components/Db.php");
require_once(ROOT."/models/Form.php");
require_once(ROOT."/models/Discipline.php");
require_once(ROOT."/models/Department.php");
require_once(ROOT."/models/Speciality.php");

class Answer {
	public static function getSortedAnswerList($params, $toDashboard = true) {
		$db = Db::getConnection();

		$formData = in_array('formId', $params) ? Form::getFormDataById($params['formId']) : Form::getFormDataById();

		$condition = Answer::collectParams($params);

		if ($condition != '') {
			$condition = "WHERE ".$condition;
		}

		$result = $db->prepare("SELECT * FROM answer ".$condition);
		$result->execute();
		$answerList = [];

		while ($row = $result->fetch()) {
			$answerList[] = Array(
					'id' => $row['id'],
					'formId' => $row['formId'],
					'marks' => json_decode($row['marks'], true),
					'weights' => json_decode($row['weights'], true),
					'recommendation' => json_decode($row['recommendation'], true),
					'time' => $row['time'],
					'login' => $row['login']
				);
		}

		return Array(
			'formData' => $toDashboard ? $formData[0] : $formData,
			'answerList' => $answerList
		);
	}

	public static function collectParams($params) {
		$paramsString = '';
		$paramCount = 0;

		foreach ($params as $param => $value) {
			if ($paramCount > 0) {
				if ($param == 'searchText') {
					$paramsString .= ' AND ' . $param . ' LIKE ' . "'%" . $value . "%'";
				} else {
					$paramsString .= ' AND ' . $param . "='" . $value . "'";
				}
			} else {
				$paramCount++;
				if ($param == 'searchText') {
					$paramsString .= ' ' . $param . ' LIKE ' . "'%" . $value . "%'";
				} else {
					$paramsString .= ' ' . $param . "='" . $value . "'";
				}
			}
			
		}

		return $paramsString;
		
	}

	public static function getAverageList($formData, $answerList) {
		$questionLength = Form::getQuestionLength($formData['questionList']);
		$averageList = [];

		for ($question = 0; $question < $questionLength; $question++) {
			$averageSum = 0;

			foreach ($answerList as $answer) {
				$averageSum += $answer['marks'][$question]; 
			}

			if ($averageSum != 0) {
				$averageList[] = $averageSum / count($answerList);
			} else {
				$averageList[] = 0;
			}
		}

		return $averageList;
	}

	public static function getResultList($formData, $answerList) {
		$questionLength = Form::getQuestionLength($formData['questionList']);
		$resultList = [];

		for ($question = 0; $question < $questionLength; $question++) {
			$sum = 0;

			foreach ($answerList as $answer) {
				$sum += $answer['marks'][$question] / $answer['weights'][$question]; 
			}

			if ($sum != 0) {
				$resultList[] = round($sum / count($answerList) * 100, 2);
			} else {
				$resultList[] = 0;
			}
		}

		return $resultList;
	}

	public static function getResultErrorList($formData, $answerList) {
		$questionLength = Form::getQuestionLength($formData['questionList']);
		$resultErrorList = [];
		$averageList = Answer::getAverageList($formData, $answerList);

		for ($question = 0; $question < $questionLength; $question++) {
			$sum = 0;

			foreach ($answerList as $answer) {
				$sum += pow($answer['marks'][$question] - $averageList[$question], 2); 
			}

			if ($sum != 0) {
				$resultErrorList[$question] = round(sqrt($sum / count($answerList)), 2);
			} else {
				$resultErrorList[$question] = 0;
			}
		}

		return $resultErrorList;
	}	

	public static function getMainResult($formData, $resultList) {
		$questionLength = Form::getQuestionLength($formData['questionList']);

		$mainResult = 0;

		foreach ($resultList as $result) {
			$mainResult += $result;
		}

		if ($mainResult != 0) {
			return round($mainResult / $questionLength, 2);
		}

		return 0;
	}

	public static function getMainErrorResult($formData, $resultErrorList) {
		$questionLength = Form::getQuestionLength($formData['questionList']);

		$mainResultError = 0;

		foreach ($resultErrorList as $resultError) {
			$mainResultError += $resultError;
		}

		if ($mainResultError != 0) {
			return round($mainResultError / $questionLength, 2);
		}

		return 0;
	}

	public static function collectFilterSettings($settingsList) {
		$settings = [];

		if (isset($settingsList['discipline'])) {
			$settings[] = array('name' => 'Дисциплина', 'value' => Discipline::getDisciplineById($settingsList['discipline'])['name']);
		}

		if (isset($settingsList['department'])) {
			$settings[] = array('name' => 'Кафедра', 'value' => Department::getDepartmentById($settingsList['department'])['name']);
		}

		if (isset($settingsList['speciality'])) {
			$settings[] = array('name' => 'Специальность', 'value' => Speciality::getSpecialityById($settingsList['speciality'])['name']);
		}

		if (isset($settingsList['educationType'])) {
			$settings[] = array('name' => 'Тип получения образования', 'value' => $settingsList['educationType']);
		}

		if (isset($settingsList['employeeType'])) {
			$settings[] = array('name' => 'Тип персонала', 'value' => $settingsList['employeeType']);
		}

		if (isset($settingsList['age'])) {
			$settings[] = array('name' => 'Возрастная категория персонала', 'value' => $settingsList['age']);
		}

		if (isset($settingsList['searchText'])) {
			$settings[] = array('name' => 'Другое', 'value' => $settingsList['searchText']);
		}

		return $settings;
	}

	public static function deleteAnswer($answerId) {
		$db = Db::getConnection();

		$result = $db->prepare("DELETE FROM answer WHERE id = :id");
		$result->bindParam(":id", $answerId, PDO::PARAM_INT);
		$result->execute();
	}
}


