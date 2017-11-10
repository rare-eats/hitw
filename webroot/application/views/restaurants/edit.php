<div class="container">
	<div class="card" style="padding: 1rem;">
		<h3><?php echo $title; ?></h3>
	<?php echo validation_errors(); ?>

	<?php echo form_open('restaurants/edit/'.$restaurant['id']); ?>
		<div class="form-group">
			<label for="name">Restaurant Name</label>
			<input type="text" id="name" name="name" class="form-control" value="<?php echo $restaurant['name']; ?>" required>			
		</div>
		<div class="form-group">
			<label for="restaurant_type">Restaurant Type</label>
			<input type="text" id="restaurant_type" name="restaurant_type" class="form-control" aria-describedby="type_help" value="<?php echo $restaurant['restaurant_type']; ?>">
			<small id="type_help" class="form-text text-muted">Additional tags can be added later.</small>
		</div>
		<div class="form-group">
			<label for="addr_1">Address 1</label>
			<input type="text" id="addr_1" name="addr_1" class="form-control" value="<?php echo $restaurant['addr_1']; ?>">
		</div>
		<div class="form-group">
			<label for="addr_2">Address 2</label>
			<input type="text" id="addr_2" name="addr_2" class="form-control" value="<?php echo $restaurant['addr_2']; ?>">
		</div>
		<div class="form-group">
			<label for="city">City</label>
			<input type="text" id="city" name="city" class="form-control" value="<?php echo $restaurant['city']; ?>" required>
		</div>
		<div class="form-group">
			<label for="state_prov_code">State/Province</label>
			<input type="text" id="state_prov_code" name="state_prov_code" class="form-control" value="<?php echo $restaurant['state_prov_code']; ?>">
		</div>
		<div class="form-group">
			<label for="country">Country</label>
			<input type="text" id="country" name="country" class="form-control" value="<?php echo $restaurant['country']; ?>" required>
		</div>
		<div class="row">
			<div class="col text-center">
				<button type="submit" class="btn btn-primary">Edit</button>
				<a class="btn btn-secondary" href="<?php echo site_url('restaurants/view/'.$restaurant['id']); ?>">Cancel</a>
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
      <div class="modal-body">
        Are you sure you want to delete <?php echo $restaurant['name'];?>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-danger" href="<?php echo site_url('restaurants/delete/'.$restaurant['id']); ?>">Delete</a>
      </div>
    </div>
  </div>
</div>

