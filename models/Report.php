<?php
require_once(ROOT."/components/Db.php");
use PhpOffice\PhpWord\Shared\Converter;
require_once('vendor/autoload.php');

class Report {
	public static function toWord($formData, $answerList, $resultList, $resultErrorList, $mainResult, $mainResultError, $filterSettings) {
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=result.docx");
		header("Content-Type: application/zip");
		header("Content-Transfer-Encoding: binary");

		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->addSection();

		Report::printHeader($section, $formData, $filterSettings);

		Report::printFormTable($section, $formData, $answerList, $resultList, $resultErrorList, $mainResult, $mainResultError);

		Report::printChart($section, $formData, $resultList);

		$section = $phpWord->addSection();

		Report::printAnswerTable($section, $formData, $answerList);

		$phpWord->save(ROOT.'/static/report/result.doc', 'Word2007');
		readfile(ROOT.'/static/report/result.doc');
	}

	private static function printFormTable($section, $formData, $answerList, $resultList, $resultErrorList, $mainResult, $mainResultError) {
		$tableStyle = array(
		    'borderColor' => '000000',
		    'borderSize'  => 6,
		);

		$table = $section->addTable($tableStyle);

		foreach ($formData['questionList'] as $questionIndex => $question) {
			if ($question[0] == 'input') {
		        $table->addRow();
		        $cell = $table->addCell();

		        $fontStyle = array('name'=>'Times New Roman', 'size'=> 12, 'color'=>'000000', 'bold'=>FALSE, 'italic'=>FALSE);

		        $cell->addText($questionIndex+1, $fontStyle);
		        $cell = $table->addCell();
		        $cell->addText($question[1], $fontStyle);
		        $cell = $table->addCell();

		        $cell->addText(round($resultList[$questionIndex], 2).'±'.round($resultErrorList[$questionIndex], 2).'%', $fontStyle);
		    }
		}

		$table->addRow();
		$cell = $table->addCell();

		$fontStyle = array('name'=>'Times New Roman', 'size'=> 12, 'color'=>'000000', 'bold'=>FALSE, 'italic'=>FALSE);

		$cell->addText(count($formData['questionList'])+1, $fontStyle);
		$cell = $table->addCell();
		$cell->addText('Итого:', $fontStyle);
		$cell = $table->addCell();
		$cell->addText(round($mainResult, 2).'±'.round($mainResultError, 2).'%', $fontStyle);
	}

	private static function printAnswerTable($section, $formData, $answerList) {
		$fontStyle = array('name'=>'Times New Roman', 'size'=>14, 'color'=>'000000', 'bold'=>TRUE, 'italic'=>FALSE);
		$section->addText('Ответы:', $fontStyle);

		$tableStyle = array(
		    'borderColor' => '000000',
		    'borderSize'  => 6,
		);

		$table = $section->addTable($tableStyle);
		$fontStyle = array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000', 'bold'=>FALSE, 'italic'=>FALSE);

		foreach ($answerList as $answerIndex => $answer) {
			$table->addRow();
		    $cell = $table->addCell();
		    $cell->addText($answer['time'], $fontStyle);

		    for($number = 0; $number < count($formData['questionList']); $number++) {
		    	if ($formData['questionList'][$number][0] == 'input') {
		    		$cell = $table->addCell();
		        	$cell->addText($number + 1, $fontStyle);
		    	}
		    }

		    $table->addRow();
		    $cell = $table->addCell();
		    $cell->addText('Важность', $fontStyle);

		    foreach ($answer['weights'] as $weight) {
		    	$cell = $table->addCell();
		        $cell->addText($weight, $fontStyle);
		    }

		    $table->addRow();
		    $cell = $table->addCell();
		    $cell->addText('Оценка', $fontStyle);

		    foreach ($answer['marks'] as $mark) {
		    	$cell = $table->addCell();
		        $cell->addText($mark, $fontStyle);
		    }

		    foreach ($answer['recommendation'] as $recommendation) {
		    	$table->addRow();
		        $cell = $table->addCell();
		        $cell->addText($recommendation[0], $fontStyle);
		        $cell = $table->addCell();
		        $cell->getStyle()->setGridSpan(count($formData['questionList']));
		        $cell->addText($recommendation[1], $fontStyle);
		    }
		}
	}

	private static function printChart($section, $formData, $resultList) {
		$qustionNumberList = array();

		for ($i = 1; $i <= count($formData['questionList'])+1; $i++) {
		    array_push($qustionNumberList, $i);
		}

		foreach ($resultList as $resultIndex => $result) {
			$resultList[$resultIndex] = round($result, 2);
		}

		$chart = $section->addChart('column', $qustionNumberList, $resultList);
		$chart->getStyle()->setWidth(Converter::inchToEmu(5))->setHeight(Converter::inchToEmu(2));
		$chart->getStyle()->setShowAxisLabels(true);
	}

	private static function printHeader($section, $formData, $filterSettings) {
		$fontStyle = array('name'=>'Times New Roman', 'size'=>14, 'color'=>'000000', 'bold'=>TRUE, 'italic'=>FALSE);
		$section->addText($formData['name'], $fontStyle);

		$section->addText('Фильтрация по:', $fontStyle);

		foreach ($filterSettings as $setting) {
			$fontStyle = array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000', 'bold'=>FALSE, 'italic'=>FALSE);

			$section->addText('1) ' . $setting['name'] . ': ' . $setting['value'], $fontStyle);
		}
	}
}
