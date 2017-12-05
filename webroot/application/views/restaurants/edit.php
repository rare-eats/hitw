<div class="container">
	<div class="card" style="padding: 1rem;">
		<h3 class="text-center"><?php echo $title; ?></h3>
	<?php echo validation_errors(); ?>

	<?php echo form_open('restaurants/edit/'.$restaurant['id']); ?>
		<p class="text-center">Fields marked with an asterisk (*) are mandatory.</p>
		<div class="form-group">
			<label for="name">Restaurant Name*</label>
			<input type="text" id="name" name="name" class="form-control" value="<?php echo $restaurant['name']; ?>" required>
		</div>
		<div class="form-group">
			<label>Tags</label>
			<select multiple class="form-control form-control-chosen" name="tags[]" id="tag-select">
				<?php foreach($tags as $tag): ?>
					<option value="<?php echo $tag['id']; ?>"><?php echo $tag['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="addr_1">Address</label>
			<input type="text" id="addr_1" name="addr_1" class="form-control" value="<?php echo $restaurant['addr_1']; ?>">
		</div>
		<div class="form-group">
			<label for="city">City*</label>
			<input type="text" id="city" name="city" class="form-control" value="<?php echo $restaurant['city']; ?>" required>
		</div>
		<div class="form-group">
			<label for="state_prov_code">State/Province*</label>
			<input type="text" id="state_prov_code" name="state_prov_code" class="form-control" value="<?php echo $restaurant['state_prov_code']; ?>">
		</div>
		<div class="form-group">
			<label for="country">Country*</label>
			<input type="text" id="country" name="country" class="form-control" value="<?php echo $restaurant['country']; ?>" required>
		</div>
		<div class="row">
			<div class="col text-center">
				<button type="submit" class="btn btn-primary">Save</button>
				<a class="btn btn-secondary" href="/restaurants/view/<?php echo $restaurant['id']; ?>">Cancel</a>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteRestaurantModal">Delete</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal" id="deleteRestaurantModal" tabindex="-1" role="dialog" aria-labelledby="deleteRestaurantModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteRestaurantModalLabel">Delete this restaurant?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        Are you sure you want to delete <?php echo $restaurant['name'];?>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-danger" href="<?php echo site_url('restaurants/delete/'.$restaurant['id']); ?>">Delete</a>
      </div>
    </div>
  </div>
</div>
