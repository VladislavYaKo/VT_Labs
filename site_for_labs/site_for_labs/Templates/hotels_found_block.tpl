<div class="brief_hotel_info_wrap">
	<h2>{*hotel_name*}</h2>
	<div class="img">
		<img src="{*image_path*}">
	</div>
	<div class="text">
		{*info_about*}
	</div>
	<div class="form_wrap">
		<form class="form" method="POST" action="booking_2.php">
			<input type="hidden" name="hotel_id" value="{hotel_id}">
			<input type="button" name="hotel_name" value="Выбрать этот отель">
		</form>

	<hr noshade size="3">
</div>