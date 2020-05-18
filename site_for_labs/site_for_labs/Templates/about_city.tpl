<!DOCTYPE html>
<html>
<head>
	<title>About city</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Styles/common_styles.css">
	<link rel="stylesheet" type="text/css" href="Styles/about_city.css">
</head>
<body>

	{nav}

	<section>
		<div id="about_city_wrap">
			<h2 style="text-align: center; margin-top: 0px;">{city_name}</h2>
			<div id="about_city_img_wrap">
				<img src="{city_image_path}">
			</div>
			<div id="about_city_text_wrap">
				{city_info}
			</div>
			<div id="about_city_form_wrap">
				<form method="post" action="hotels_found.php" id="about_city_form">
					<input type="submit" name="town_name" value="Выбрать этот город" onclick='location.href="booking_2.php"'>
				</form>
			</div>
		</div>
	</section>

	{footer}

</body>
</html>