	<!-- Load in jQuery (full) and chosen plugin -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	<!-- Load in Popper.js, then Bootstrap JS before </body> tag -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	
	<!-- Load additional JavaScript files passed in $data, should they exist -->
	<?php if(isset($javascript)): ?>
		<?php foreach($javascript as $js): ?>
			<script src="<?php echo $js.".js"; ?>"></script>
		<?php endforeach; ?>
	<?php endif; ?>
  </body>
</html>