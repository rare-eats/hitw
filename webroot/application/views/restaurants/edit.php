<div class="container">
	<div class="card">
		<h3>Edit</h3>
	<?php echo validation_errors(); ?>

	<?php echo form_open('restaurants/edit'.$restaurant['id']); ?>
		<div class="form-group">
			<label for="name">Restaurant Name</label>
			<input type="text" id="name" name="name" class="form-control" placeholder="Sloppy Joe's" value="<?php echo $restaurant['name']; ?>" required>			
		</div>
		<div class="form-group">
			<label for="restaurant_type">Restaurant Type</label>
			<input type="text" id="restaurant_type" name="restaurant_type" class="form-control" aria-describedby="type_help" placeholder="BBQ" value="<?php echo $restaurant['restaurant_type']; ?>">
			<small id="type_help" class="form-text text-muted">Doesn't have to be super specific, you can add additional tags later.</small>
		</div>
		<div class="form-group">
			<label for="addr_1">Address 1</label>
			<input type="text" id="addr1" name="addr1" class="form-control" placeholder="101 Grill St." value="<?php echo $restaurant['addr1']; ?>">
		</div>
		<div class="form-group">
			<label for="addr_2">Address 2</label>
			<input type="text" id="addr2" name="addr2" class="form-control" placeholder="Suite 42" value="<?php echo $restaurant['addr2']; ?>">
		</div>
		<div class="form-group">
			<label for="city">City</label>
			<input type="text" id="city" name="city" class="form-control" placeholder="Grillsville" value="<?php echo $restaurant['city']; ?>" required>
		</div>
		<div class="form-group">
			<label for="state-prov-code">State/Province Code</label>
			<input type="text" id="state-prov-code" name="state-prov-code" class="form-control" placeholder="BC" value="<?php echo $restaurant['state-prov-code']; ?>">
		</div>
		<button type="submit" class="btn btn-primary">Edit</button>

		<a class="btn btn-secondary" href="<?php echo site_url('restaurants/view/'.$restaurant['id'])); ?>">Cancel</a>
	</div>
</div>