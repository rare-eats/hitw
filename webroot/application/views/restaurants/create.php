<div class="container">
	<div class="card" style="padding: 1rem;">
		<h3><?php echo $title; ?></h3>
	<?php echo validation_errors(); ?>

	<?php echo form_open('restaurants/create'); ?>
		<div class="form-group">
			<label for="name">Restaurant Name</label>
			<input type="text" id="name" name="name" class="form-control" placeholder="Sloppy Joe's" required>			
		</div>
		<div class="form-group">
			<label for="restaurant_type">Restaurant Type</label>
			<input type="text" id="restaurant_type" name="restaurant_type" class="form-control" aria-describedby="type_help" placeholder="BBQ">
			<small id="type_help" class="form-text text-muted">Doesn't have to be super specific, you can add additional tags later.</small>
		</div>
		<div class="form-group">
			<label for="addr_1">Address 1</label>
			<input type="text" id="addr_1" name="addr_1" class="form-control" placeholder="101 Grill St.">
		</div>
		<div class="form-group">
			<label for="addr_2">Address 2</label>
			<input type="text" id="addr_2" name="addr_2" class="form-control" placeholder="Suite 42">
		</div>
		<div class="form-group">
			<label for="city">City</label>
			<input type="text" id="city" name="city" class="form-control" placeholder="Grillsville" required>
		</div>
		<div class="form-group">
			<label for="state_prov_code">State/Province</label>
			<input type="text" id="state_prov_code" name="state_prov_code" class="form-control" placeholder="British Columbia">
		</div>
		<div class="form-group">
			<label for="country">Country</label>
			<input type="text" id="country" name="country" class="form-control" placeholder="Canada" required>
		</div>
		<button type="submit" class="btn btn-primary">Create</button>
		<a class="btn btn-secondary" href="<?php echo site_url('/'); ?>">Cancel</a>
	</div>
</div>