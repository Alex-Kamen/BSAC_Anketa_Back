<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Анкетирование</title>
	<link rel="stylesheet" type="text/css" href="../static/style/style.css?<?php echo time();?>">
	<link rel="stylesheet" type="text/css" href="../static/style/formList.css?<?php echo time();?>">
</head>
<body>
	<div class="wrapper">
		<div class="content">
			<div class="header">
				<div class="container">
					<div class="header__inner">
						<h1 class="header__title">Анкетирование</h1>
					</div>
				</div>
			</div>
			<div class="form">
				<div class="container">
					<div class="form__list">
						<?php foreach ($formList as $form): ?>
							<div class="form__item">
								<h3 class="form__title visible"><?php echo $formList[$i][1]; ?></h3>
								<form class="form__login hidden" method="POST" action="#">
									<?php for($j = 0; $j < count($formList[$i][2]); $j++): ?>
										<?php if($formList[$i][2][$j][0] == "input"): ?>
											<input type="text" name="input_<?php echo $j; ?>" placeholder="<?php echo $formList[$i][2][$j][1]; ?>">
										<?php elseif ($formList[$i][2][$j][0] == "table"): ?>
											<?php 
												$query = "SELECT * FROM ".$formList[$i][2][$j][1];
												$result = mysqli_query($conn, $query);
												$optionCount = mysqli_num_rows($result);
												$optionList = array();
												for($k = 0; $k < $optionCount; $k++) {
													$row = mysqli_fetch_row($result);
													$optionList[$k] = $row[1];
												}
											?>
											<select name="input_<?php echo $j; ?>">
												<?php for($k = 0; $k < count($optionList); $k++): ?>
													<option value="<?php echo $optionList[$k]; ?>"><?php echo $optionList[$k]; ?></option>
												<?php endfor; ?>
											</select>
										<?php else: ?>
											<select name="input_<?php echo $j; ?>">
												<?php for($k = 1; $k < count($formList[$i][2][$j]); $k++): ?>
													<option value="<?php echo $formList[$i][2][$j][$k]; ?>"><?php echo $formList[$i][2][$j][$k]; ?></option>
												<?php endfor; ?>
											</select>
										<?php endif; ?>
									<?php endfor; ?>
									<input type="submit" name="<?php echo $formList[$i][0]; ?>" value="Заполнить анкету">
									<p class="error__message">
										<?php
											for($j = 1; $j <= $allForms; $j++) {
												if(isset($error[$j])) {
													echo $error[$j];
												}
											}
										?>
									</p>
								</form>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="container">
				<div class="footer__inner">
					<p class="footer__text">ВФ БГАС</p>
					<a class="footer__text" href="/">Выйти</a>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../static/script/formList.js?<?php echo time();?>"></script>
</body>
</html>