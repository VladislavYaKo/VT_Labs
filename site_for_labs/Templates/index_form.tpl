<div id="form_wrap">			
	<form id="form" method="{form_method}" action="{form_action}">	
		<div class="form_part">
			<span>Название города</span><br>
			<input type="text" name="town" style="{town_css_style}">
		</div>	
		<div class="form_part">
			<span>Заезд</span><br>
			<input type="date" name="date_from">
		</div>	
		<div class="form_part">
			<span>Отъезд</span><br>
			<input type="date" name="date_upto">
		</div>	
		<div class="form_part">
			<span>Кол-во человек</span><br>
			<input type="number" min="1" value="1" name="perons_num">
			<div id="form_part_button_wrap">	
				<input type="submit" name="Done" value="Продолжить"><!-- onclick='location.href="hotels_found.php"'> -->
			</div>
		</div><br>
	</form>
</div>