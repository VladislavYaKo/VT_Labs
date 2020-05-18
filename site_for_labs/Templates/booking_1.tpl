<!DOCTYPE html>
<html>
<head>
	<title>Booking. Step 1</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Styles/common_styles.css">
	<link rel="stylesheet" type="text/css" href="Styles/booking_1.css">
</head>
<body>

	{nav}
	<!--<nav>		
		<div id="nav_menu_wrap">
			<a class="nav_menu" href="index.html" style="margin-left: 0px;"><span>Главная</span></a>      
			<a class="nav_menu" href="booking_1.html"><span>Бронирование</span></a> 
			<a class="nav_menu" href="for_clients.html"><span>Клиентам</span></a> 
			<a class="nav_menu" href="for_partners.html"><span>Партнёрам</span></a>
		</div>
	</nav> -->

	<section>
		<div id="booking_center_part">
			<div id="booking_wrap">
				<h2>Шаг 1. Поиск отеля</h2>
				{index_form}
				<!--<div id="form_wrap">
					<form id="booking_form">	
						<div class="booking_form_part">
							<span>Название города</span><br>
							<input type="text" name="town" required>
						</div>	
						<div class="booking_form_part">
							<span>Заезд</span><br>
							<input type="date" name="date_from" required>
						</div>	
						<div class="booking_form_part">
							<span>Отъезд</span><br>
							<input type="date" name="date_upto" required>
						</div>	
						<div class="booking_form_part">
							<span>Кол-во человек</span><br>
							<input type="number" min="1" value="1" name="perons_num" required>
							<div id="booking_form_part_button_wrap">	
								<input type="button" name="town_name" value="Продолжить" onclick='location.href="hotels_found.html"'>	
							</div>
						</div><br>
					</form>
				</div> -->	
			</div>		
		</div>
	</section>

	{footer}
	<!-- <footer>
		<div id="footer_blocks_wrap">
			<div class="footer_block">
				<ul class="footer_list">
					<li class="footer_list_li"><a href="cities_and_countries.html" class="footer">Города и страны</a></li>
					<li class="footer_list_li"><a href="for_clients.html#reference" class="footer">Справка (Как забронировать номер?)</a></li>
				</ul>
			</div>
			<div class="footer_block">
				<ul class="footer_list">
					<li class="footer_list_li"><a href="about_site.html" class="footer">О сайте</a></li>
					<li class="footer_list_li"><a href="service_conditions.html" class="footer">Условия предоставления услуг</a></li>
					<li class="footer_list_li"><a href="reviews.html" class="footer">Отзывы</a></li>
				</ul>
			</div>			
		</div>
	</footer> -->

</body>
</html>