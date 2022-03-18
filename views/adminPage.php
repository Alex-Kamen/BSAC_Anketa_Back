<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Анкетирование</title>
	<link rel="stylesheet" type="text/css" href="../../style/style.css?<?php echo time();?>">
	<link rel="stylesheet" type="text/css" href="../../style/admin.css?<?php echo time();?>">
</head>
<body>
	<div class="wrapper">
		<div class="content">
			<div class="header">
				<div class="container">
					<div class="header__inner">
						<h1 class="header__title">Панель Администратора</h1>
					</div>
				</div>
			</div>
			<div class="search">
				<div class="container">
					<form action="#" method="POST" class="search__inner">
						<div>
							<div class="search__item">
								<h3>Выбор анкеты</h3>
							
								<select name="formID">
									<?php for($i = 0; $i < count($formList); $i++): ?>
										<option value="<?php echo $formList[$i][0]; ?>"><?php echo $formList[$i][1]; ?></option>
									<?php endfor; ?>
								</select>
							</div>
							<div class="search__item">
								<h3>Фильтровать по</h3>
								<input type="text" name="chouse0" placeholder="Фильтр по">
								<select name="chouse1">
									<option value="all">Все группы</option>
									<?php for($i = 0; $i < count($groupList); $i++): ?>	
										<option value="<?php echo $groupList[$i]; ?>">
											<?php echo $groupList[$i]; ?>
										</option>
									<?php endfor; ?>
								</select>
								<select name="chouse2">
									<option value="all">Все дисциплины</option>
									<?php for($i = 0; $i < count($disciplineList); $i++): ?>
										<option value="<?php echo $disciplineList[$i]['name']; ?>">
											<?php echo $disciplineList[$i]['name']; ?>
										</option>
									<?php endfor; ?>
								</select>
								<select name="chouse3">
									<option value="all">Все специальности</option>
									<?php for($i = 0; $i < count($specialtyList); $i++): ?>
										<option value="<?php echo $specialtyList[$i]['name']; ?>">
											<?php echo $specialtyList[$i]['name']; ?>
										</option>
									<?php endfor; ?>
								</select>
								<select name="chouse4">
									<option value="all">Все формы получения образования</option>
									<option value="ДФПО">ДФПО</option>
									<option value="ЗФПО">ЗФПО</option>
								</select>
								<select name="chouse5">
									<option value="all">Все типы персонала</option>
									<?php for($k = 1; $k < count($personalTypeList[0]); $k++): ?>
									<option value="<?php echo $personalTypeList[0][$k]; ?>"><?php echo $personalTypeList[0][$k]; ?></option>
									<?php endfor; ?>
								</select>
								<select name="chouse6">
									<option value="all">Все возрастные категории</option>
									<?php for($k = 1; $k < count($personalTypeList[1]); $k++): ?>
									<option value="<?php echo $personalTypeList[1][$k]; ?>"><?php echo $personalTypeList[1][$k]; ?></option>
									<?php endfor; ?>
								</select>
							</div>
						</div>
						<input type="submit" name="search" value="Поиск">
					</form>
				</div>
			</div>
			<div>
				<div class="container">
					<?php 
					if($dataIsSearched != "") {
						echo '<h1 class="data__search">'.$dataIsSearched.'</h1>';
					}
					?>
				</div>
			</div>
			<?php if($dataIsSearched == ""): ?>
			<div class="diogram">
				<div class="container">
					<div class="diogram__title">
						<h1><?php echo $formList[$_SESSION['formID']-1][1].$_SESSION['searchBy']; ?></h1>
					</div>
					<div class="diogram__list">
						<div class="diogram__item">
							<div class="diogram__content">
								<table class="diogram__data">
								<?php for($i = 0; $i < $questionCount; $i++): ?>
									<tr>
										<td>
											<?php echo $i+1; ?>
										</td>
										<td>
											<?php echo $questionList[$i][1]; ?>
										</td>
										<td>
											<?php 
											if($flag) {
												echo "-";
											} else {
												echo round($OY[$i], 2)."±".round($sigmaList[$i], 2)."%";
											}
											?>
										</td>
									</tr>
								<?php endfor; ?>
									<tr>
										<td colspan="2">Итого</td>
										<td><b>
											<?php 
											if($flag) {
												echo "-";
											} else {
												echo round($mainOY, 2)."±".round($mainSigma, 2)."%";
											}
											?>
											<b>
										</td>
									</tr>
								</table>
								<canvas width="700" height="500"></canvas>
								<div class="data__list">
								<?php 
									if($flag) {
										for($i = 0; $i < $questionCount; $i++) {
											echo "0 0 ";
										}
									} else {
										for($i = 0; $i < $questionCount; $i++) {
											echo $OY[$i]." ".$sigmaList[$i]." ";
										}
									}
								?>
								</div>
							</div>
						</div>
					</div>
					<h3 class="answers__title passive">Ответы</h3>
					<form class="answers__list hidden" action="#" method="POST">
						<div class="answer__item">
							<table>
								<?php for($i = 0; $i < $m; $i++):?>
									<tr>
										<td><?php echo $data[$i][6]; ?></td>
										<?php for($j = 1; $j <= $questionCount; $j++): ?>
											<td>
												<b><?php echo $j; ?><b>
											</td>
										<?php endfor; ?>
										<td class="delete__btn"><input type="submit" name="<?php echo $answersId[$i]; ?>" value="Удалить" class="delete__btn"></td>
									</tr>
									<tr>
										<td>Важность</td>
										<?php for($j = 0; $j < $questionCount; $j++): ?>
											<td>
												<?php echo $weight[$i][$j]; ?>
											</td>
										<?php endfor; ?>

									</tr>
									<tr>
										<td>Оценка</td>
										<?php for($j = 0; $j < $questionCount; $j++): ?>
											<td>
												<?php echo $mark[$i][$j]; ?>
											</td>
										<?php endfor; ?>
									</tr>
                                    <?php for($j = 0; $j < count($data[$i][4]); $j++): ?>
                                        <tr>
                                            <td><?php echo $data[$i][4][$j][0]; ?></td>
                                            <td colspan="<?php echo $questionCount; ?>" class="recommends"><?php echo $data[$i][4][$j][1]; ?></td>
                                        </tr>
                                    <?php endfor; ?>
								<?php endfor; ?>
							</table>
						</div>
					</form>
				</div>
			</div>
			<div class="PDF">
				<div class="container">
					<a href="/download" class="buttonLink">Преобразовать в Word</a>
				</div>
			</div>
			<?php endif; ?>
			<div class="administrate__title">
				<div class="container">
					<h3>Администрирование</h3>
				</div>
			</div>
			<div class="administrate__panel">
				<div class="container">
					<div class="administrate__table">
						<div class="administrate__item">
							<h3>Добавить группу</h3>
							<form action="#" method="POST">
								<input type="text" name="login" placeholder="Логин">
								<input type="text" name="pass" placeholder="Пароль">
								<input type="submit" name="addGroup" value="Добавить">
							</form>
							<p><?php echo $adminErrors[4]; ?></p>
						</div>
						<div class="administrate__item">
							<h3>Удалить группу</h3>
							<form action="#" method="POST">
								<select name="whatGroup">
									<?php for($i = 0; $i < count($groupList); $i++): ?>
										<option value="<?php echo $groupList[$i]; ?>">
											<?php echo $groupList[$i]; ?>
										</option>
									<?php endfor; ?>
								</select>
								<input type="submit" name="delGroup" value="Удалить">
							</form>
						</div>
						<div class="administrate__item">
							<h3>Изменить группу</h3>
							<form action="#" method="POST">
								<select name="whatGroupChange">
									<?php for($i = 0; $i < count($groupList); $i++): ?>
										<option value="<?php echo $groupList[$i]; ?>">
											<?php echo $groupList[$i]; ?>
										</option>
									<?php endfor; ?>
								</select>
								<input type="text" name="newLogin" placeholder="Логин изменённой группы">
								<input type="text" name="newPass" placeholder="Пароль изменённой группы">
								<input type="submit" name="changeGroup" value="Изменить">
								<p><?php echo $adminErrors[3]; ?></p>
							</form>
						</div>
						<div class="administrate__item">
							<h3>Изменить данные для работодателей</h3>
							<form action="#" method="POST">
								<input type="text" name="newHirerLogin" placeholder="Логин">
								<input type="text" name="newHirerPass" placeholder="Пароль">
								<input type="submit" name="changeHirer" value="Изменить">
							</form>
							<p><?php echo $adminErrors[2]; ?></p>
						</div>
						<div class="administrate__item">
							<h3>Изменить данные для персонала</h3>
							<form action="#" method="POST">
								<input type="text" name="newStaffLogin" placeholder="Логин">
								<input type="text" name="newStaffPass" placeholder="Пароль">
								<input type="submit" name="changeStaff" value="Изменить">
							</form>
							<p><?php echo $adminErrors[1]; ?></p>
						</div>
						<div class="administrate__item">
							<h3>Изменить данные для администратора</h3>
							<form action="#" method="POST">
								<input type="text" name="newAdminLogin" placeholder="Логин">
								<input type="text" name="newAdminPass" placeholder="Пароль">
								<input type="submit" name="changeAdmin" value="Изменить">
							</form>
							<p><?php echo $adminErrors[0]; ?></p>
						</div>
						<div class="administrate__item">
							<h3>Добавить дисциплину</h3>
							<form action="#" method="POST">
								<input type="text" name="disciplineName" placeholder="Название дисциплины">
								<input type="submit" name="addDiscipline" value="Добавить">
							</form>
							<p><?php echo $adminErrors[5]; ?></p>
						</div>
						<div class="administrate__item">
							<h3>Удалить дисциплину</h3>
							<form action="#" method="POST">
								<select name="whatDiscipline">
									<?php for($i = 0; $i < count($disciplineList); $i++): ?>
										<option value="<?php echo $disciplineList[$i]['id']; ?>">
											<?php echo $disciplineList[$i]['name']; ?>
										</option>
									<?php endfor; ?>
								</select>
								<input type="submit" name="delDiscipline" value="Удалить">
							</form>
						</div>
						<div class="administrate__item">
							<h3>Добавить специальность</h3>
							<form action="#" method="POST">
								<input type="text" name="specialtyName" placeholder="Название специальности">
								<input type="submit" name="addSpecialty" value="Добавить">
							</form>
							<p><?php echo $adminErrors[6]; ?></p>
						</div>
						<div class="administrate__item">
							<h3>Удалить специальность</h3>
							<form action="#" method="POST">
								<select name="whatSpecialty">
									<?php for($i = 0; $i < count($specialtyList); $i++): ?>
										<option value="<?php echo $specialtyList[$i]['id']; ?>">
											<?php echo $specialtyList[$i]['name']; ?>
										</option>
									<?php endfor; ?>
								</select>
								<input type="submit" name="delSpecialty" value="Удалить">
							</form>
						</div>
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
	<script type="text/javascript" src="https://github.com/stackp/promisejs/blob/master/promise.js"></script>
    <script type="text/javascript" src="https://github.com/MrRio/jsPDF/blob/master/dist/jspdf.min.js"></script>
	<script type="text/javascript" src="../../script/admin.js?<?php echo time();?>"></script>
</body>
</html>