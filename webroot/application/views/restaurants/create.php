<div class="container">
	<div class="card">
		<div class="card-body">
		<h3 class="text-center"><?php echo $title; ?></h3>
	<div class="text-danger"><?php echo validation_errors(); ?></div>

	<?php echo form_open('restaurants/create'); ?>
		<div class="form-group">
			<label for="name">Restaurant Name*</label>
			<input type="text" id="name" name="name" class="form-control" placeholder="Sloppy Joe's" required>			
		</div>
		<div class="form-group">
			<label>Tags</label>
			<select multiple class="form-control form-control-chosen" name="tags[]" id="tag-select" multiple>
				<?php foreach($tags as $tag): ?>
					<option value="<?php echo $tag['id']; ?>"><?php echo $tag['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="addr_1">Address</label>
			<input type="text" id="addr_1" name="addr_1" class="form-control" placeholder="101 Grill St.">
		</div>
		<div class="form-group">
			<label for="city">City*</label>
			<input type="text" id="city" name="city" class="form-control" placeholder="Grillsville" required>
		</div>
		<div class="form-group">
			<label for="state_prov_code">State/Province*</label>
			<input type="text" id="state_prov_code" name="state_prov_code" class="form-control" placeholder="British Columbia">
		</div>
		<div class="form-group">
			<label for="country">Country*</label>
			<input type="text" id="country" name="country" class="form-control" placeholder="Canada" required>
		</div>
		<button type="submit" class="btn btn-primary">Create</button>
		<a class="btn btn-secondary" href="<?php echo site_url('/'); ?>">Cancel</a>
	</div>
	</div>
</div>