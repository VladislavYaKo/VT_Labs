<!DOCTYPE html>
<html>
<head>
	<title>Booking. Step 3</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Styles/common_styles.css">
	<link rel="stylesheet" type="text/css" href="Styles/booking_2.css">
</head>
<body>

	{nav}

	<section>
		<div id="booking_2_center_part">
			<div id="booking_2_wrap">
				<h2>Шаг 3. Информация о клиенте</h2>
				<div id="form_wrap">
					<form id="booking_form">	
						<div class="booking_form_part">
							<span>Фамилия</span><br>
							<input type="text" name="second_name" required value="{sec_name}">
						</div>	
						<div class="booking_form_part">
							<span>Имя</span><br>
							<input type="text" name="first_name" required value="{first_name}">
						</div>
						<div class="booking_form_part">
							<span>Отчество</span><br>
							<input type="text" name="patronymic" required value="{patronymic}">
						</div>
						<br>
						<br>
						<div class="booking_form_part">
							<span>Контактный e-mail</span><br>
							<input type="e-mail" name="cont_email" required value="{contact_email}">
						</div>
						<div class="booking_form_part">
							<span>Контактный телефон</span><br>
							<input type="tel" name="cont_phone" required value="{contact_phone}">
							<div id="booking_form_part_button_wrap">	
								<input type="button" name="town_name" value="Продолжить">	
							</div>
						</div>
						
					</form>
				</div>	
			</div>		
		</div>
	</section>

	{footer}

</body>
</html>