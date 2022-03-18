<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Анкетирование</title>
	<link rel="stylesheet" type="text/css" href="../../style/style.css?<?php echo time();?>">
	<link rel="stylesheet" type="text/css" href="../../style/form.css?<?php echo time();?>">
</head>
<body>
	<div class="what__role" style="display: none;"><?php echo $_SESSION['status'] ?></div>
	<div class="wrapper">
		<div class="content">
			<div class="header">
				<div class="container">
					<div class="header__inner">
						<h1 class="header__title">
						<?php 
							echo $formName; 
						?>
						</h1>
					</div>
				</div>
			</div>
			<div class="form">
				<div class="container">
					<form class="qustionsList" action="#" method="POST">
						<?php for($i = 0; $i < count($questionList); $i++): ?>
                        <?php if ($questionList[$i][0] == 'input'): ?>
						<div class="input question">
							<p><?php echo $questionList[$i][1]; ?></p>
							<div class="question__form">
								<div class="question__item">
									<p>Важность критерия (1-10)</p> 
									<input type="text" name="<?php echo 'importance_'.($i+1); ?>" value="<?php echo $_POST['importance_'.($i+1)]; ?>">
								</div>
								<div class="question__item">
									<p>Оценка удовлетворённости (1-10)</p>
									<input type="text" name="<?php echo 'mark_'.($i+1); ?>" value="<?php echo $_POST['mark_'.($i+1)]; ?>">
								</div>
								<div class="question__error">
									<p><?php echo $errors[$i][0]; ?></p>
									<p><?php echo $errors[$i][1]; ?></p>
								</div>
							</div>
						</div>

                        <?php elseif ($questionList[$i][0] == 'checkbox'): ?>
                        <div class="question checkbox">
                            <p><?php echo $questionList[$i][1]; ?></p>
                            <div class="question__form">
                                <div class="question__item">
                                    <div>
                                        <?php for($j = 0; $j < count($questionList[$i][2]); $j++): ?>
                                            <div>
                                                <input type="checkbox" name="<?php echo $i+1; ?>_<?php echo $j; ?>">
                                                <?php echo $questionList[$i][2][$j]; ?>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="question__item">
                                <p>Другое</p>
                                <input type="text" style="width: 100%; text-align: left" name="<?php echo $i+1; ?>_<?php echo count($questionList[$i][2]); ?>">
                            </div>
                        </div>
                        <?php else: ?>
                        <textarea placeholder="<?php echo $questionList[$i][1]; ?>" name="textArea_<?php echo $i+1; ?>"></textarea>
                        <?php endif; ?>
                        <?php endfor; ?>
                        <div class="button">
							<input type="submit" name="submit">
						</div>
					</form>
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
	<script type="text/javascript" src="../../script/form.js?<?php echo time();?>"></script>
</body>
</html>