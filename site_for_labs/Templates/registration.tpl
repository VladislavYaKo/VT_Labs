<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
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
				<form method="POST" action="registration.php">
					<span>Введите логин(латинские буквы, цифры или _)</span><br>
					<input type="text" name="login" style="margin-bottom: 20px;" required pattern="\w{3,44}"><br>
					<span>Введите пароль(без пробелов)</span><br>
					<input type="password" name="first_pass" style="margin-bottom: 20px;" required pattern="[^\s]+"><br>
					<span>Повторите пароль</span><br>
					<input type="password" name="second_pass" style="margin-bottom: 5px;" required><br>
					<input type="submit" name="Done" value="Зарегистрироваться">					
				</form>
			</div>
		</div>
	</section>

	{footer}

</body>
</html>