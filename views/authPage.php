<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Анкетирование</title>
	<link rel="stylesheet" type="text/css" href="../static/style/style.css?<?php echo time();?>">
	<link rel="stylesheet" type="text/css" href="../static/style/startPage.css?<?php echo time();?>">
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
			<div class="login">
				<div class="container">
					<div class="login__inner">
						<form action="#" method="POST" class="login__form">
							<h1 class="form__title">Авторизация</h1>
							<input type="text" name="login" placeholder="Введите логин">
							<input type="password" name="password" placeholder="Введите пароль">
							<input type="submit" name="submit" value="Войти">
							<p class="error"><?php echo $errorMessage; ?></p>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="container">
				<div class="footer__inner">
					<p class="footer__text">ВФ БГАС</p>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../static/script/startPage.js?<?php echo time();?>"></script>
</body>
</html>