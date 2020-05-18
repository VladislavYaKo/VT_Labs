<!DOCTYPE html>
<html>
<head>
	<title>Personal page</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Styles/common_styles.css">
	<link rel="stylesheet" type="text/css" href="Styles/user_personal_page.css">
</head>
<body>

	{nav}

	<section>
		<div id="central_part_wrap">
			<h2>Информация о вас, {login}</h2>
			<form id="personal_info" method="post" action="user_personal_page.php">
				<div class="form_part">
					<span>Фамилия:</span>
					<input type="text" name="second_name" required value="{sec_name}">
				</div>	
				<div class="form_part">
					<span>Имя:</span>
					<input type="text" name="first_name" required value="{first_name}">
				</div>
				<div class="form_part">
					<span>Отчество:</span>
					<input type="text" name="patronymic" required value="{patronymic}">
				</div>
				<div class="form_part">
					<span>Контактный e-mail:</span>
					<input type="e-mail" name="cont_email" required value="{contact_email}">
				</div>
				<div class="form_part">
					<span>Контактный телефон:</span>
					<input type="tel" name="cont_phone" required value="{contact_phone}">
					<div id="form_part_button_wrap">	
						<input type="submit" name="save" value="Сохранить">	
						<span style="display: {display_style}">{hidden_text}</span>
					</div>
				</div>
			</form>
			<hr noshade size="6">


			<form method="post" action="authorisation.php">

				<input type="submit" name="exit" value="Выйти">
			</form>
		</div>
	</section>

	{footer}

</body>
</html>