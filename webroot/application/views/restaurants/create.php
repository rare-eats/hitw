<div class="container">
	<div class="card">
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
			<input type="text" id="addr1" name="addr1" class="form-control" placeholder="101 Grill St.">
		</div>
		<div class="form-group">
			<label for="addr_2">Address 2</label>
			<input type="text" id="addr2" name="addr2" class="form-control" placeholder="Suite 42">
		</div>
		<div class="form-group">
			<label for="city">City</label>
			<input type="text" id="city" name="city" class="form-control" placeholder="Grillsville" required>
		</div>
		<div class="form-group">
			<label for="state-prov-code">State/Province Code</label>
			<input type="text" id="state-prov-code" name="state-prov-code" class="form-control" placeholder="BC">
		</div>
		<button type="submit" class="btn btn-primary">Create</button>
	</div>
</div>