
<div class="container">
	<div class="card" style="padding: 1rem;">
		<h3><?php echo $title; ?></h3>
	<?php echo validation_errors(); ?>

	<?php echo form_open('restaurants/reviews/'.$restaurant['id']); ?>
		<div class="form-group">
			<label for="name"> Review </label>
			<input type="text" name="review" class="form-control" value="<?php echo $restaurant['name']; ?>" required>
		</div>
  </div>
</div>
