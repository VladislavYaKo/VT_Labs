<!DOCTYPE html>
<html>
<head>
	<title>Authorisation</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Styles/common_styles.css">
	<link rel="stylesheet" type="text/css" href="Styles/authorisation.css">
</head>
<body>

	{nav}

	<section>
		<div id="central_part_wrap">
			<div id="content_part">
				<span style="display: {display_style};">{error_text}</span>
				<h2>Вход</h2>
				<form method="POST" action="">
					<span>Введите логин</span><br>
					<input type="text" name="login" style="margin-bottom: 20px;" required><br>
					<span>Введите пароль</span><br>
					<input type="password" name="password" style="margin-bottom: 5px;" required><br>
					<a href="registration.php">Регистрация</a>
					<input type="submit" name="Done" value="Войти">					
				</form>
			</div>
		</div>
	</section>

	{footer}

</body>
</html>