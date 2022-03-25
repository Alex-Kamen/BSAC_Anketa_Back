<?php
require_once(ROOT."/components/Db.php");

class Form {
	public static function getFormListByRole($role) {
		$db = Db::getConnection();

		if ($role != 'admin') {
			$result = $db->prepare("SELECT * FROM form WHERE status = :status");
			$result->bindParam(":status", $role, PDO::PARAM_STR);
		} else {
			$result = $db->prepare("SELECT * FROM form");
		}

	
		$result->execute();
		$formList = [];

		while($row = $result->fetch()) {
			$formList[] = array(
				'id' => $row['id'], 
				'name' => $row['formName'], 
				'tags' => json_decode($row['tags'], true)
			);
		}

		return $formList;
	}

	public static function getFormDataById($formId = false) {
		$db = Db::getConnection();

		if ($formId != false) {
			$result = $db->prepare("SELECT * FROM form WHERE id = :formId");
			$result->bindParam(":formId", $formId, PDO::PARAM_INT);
		} else {
			$result = $db->prepare("SELECT * FROM form");
		}
		
		$result->execute();
		$formList = [];

		while($row = $result->fetch()) {
			$formList[] = array(
				'id' => $row['id'], 
				'name' => $row['formName'], 
				'questionList' => json_decode($row['questions'], true),
				'tags' => json_decode($row['tags'], true)
			);
		}

		return $formList;
	}

	public static function saveForm($data) {
		$db = Db::getConnection();

		$weights = json_encode($data['weights']);
		$marks = json_encode($data['marks']);
		$tags = $data['tags'];
		$recommendation = json_encode($data['recommendation']);
		$time = date('Y-m-d');
		$fieldsList = '';
		$valueList = '';
		$searchInput = '';

		// 0 - name
		// 1 - value
		for ($i = 0; $i < count($tags); $i++) {
			$tag = $tags[$i];
			
			if (!stripos($fieldsList, $tag[0]) && $tag[0] != 'searchText') {
				$fieldsList .= $tag[0];
				$valueList .= "'".$tag[1]."'";
			}

			if ($i + 1 < count($tags) && $tag[0] != 'searchText') {
				$fieldsList .= ',';
				$valueList .= ',';
			}

			if ($tag[0] == 'searchText') $searchInput .= $tag[1] . " ";
		}

		if (strlen($fieldsList) > 0 && strlen($valueList) > 0 && strlen($searchInput) > 0) {
			$fieldsList .= ',';
			$valueList .= ',';
		}

		if (strlen($searchInput) > 0) {
			$fieldsList .= 'searchText';
			$valueList .= "'".$searchInput."'";
		}

		$result = $db->prepare("INSERT INTO answer(weights, marks, recommendation, time, ".$fieldsList.") VALUES (:weights, :marks, :recommendation, :time, ".$valueList.")");
		$result->bindParam(":weights", $weights, PDO::PARAM_STR);
		$result->bindParam(":marks", $marks, PDO::PARAM_STR);
		$result->bindParam(":recommendation", $recommendation, PDO::PARAM_STR);
		$result->bindParam(":time", $time, PDO::PARAM_STR);
		$result->execute();
	}

	public static function getQuestionLength($questionList) {
		$questionCount = 0;

		foreach ($questionList as $question) {
			if ($question[0] == 'input') {
				$questionCount++;
			}
		}

		return $questionCount;
	}
} 