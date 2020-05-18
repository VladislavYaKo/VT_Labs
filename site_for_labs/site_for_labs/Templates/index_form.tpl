<div id="form_wrap">			
	<form id="form" method="{form_method}" action="{form_action}">	
		<div class="form_part">
			<input type="hidden" name="what_form" value="index_form">
			<span>Страна, город</span><br>
			<input type="text" name="location" style="{town_css_style}">
		</div>	
		<div class="form_part">
			<span>Заезд</span><br>
			<input type="date" name="date_from">
		</div>	
		<div class="form_part">
			<span>Отъезд</span><br>
			<input type="date" name="date_to">
		</div>	
		<div class="form_part">
			<span>Кол-во человек</span><br>
			<input type="number" min="1" value="1" name="persons_num">
			<div id="form_part_button_wrap">	
				<input type="submit" name="Done" value="Продолжить"><!-- onclick='location.href="hotels_found.php"'> -->
			</div>
		</div><br>
	</form>
</div>