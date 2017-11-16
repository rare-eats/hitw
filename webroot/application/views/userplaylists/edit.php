<div class="container">
	<div class="card" style="padding: 1rem;">
		<h3><?php echo $title; ?></h3>
	<?php echo validation_errors(); ?>

	<?php echo form_open('userplaylists/edit/'.$playlist['id']); ?>
		<div class="form-group">
			<label for="title">Playlist Title</label>
			<input type="text" id="title" name="title" class="form-control" value="<?php echo $playlist['title']; ?>" required>			
		</div>
		<div class="form-group">
			<label for="playlist_description">Playlist Description</label>
			<input type="text" id="desc" name="desc" class="form-control" value="<?php echo $playlist['desc']; ?>">
		</div>
		<div class="row">
			<div class="col text-center">
				<button type="submit" class="btn btn-primary">Edit</button>
				<a class="btn btn-secondary" href="<?php echo site_url('userplaylists/view/'.$playlist['id']); ?>">Cancel</a>
				<!-- Button trigger modal -->
				<!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteRestaurantModal">Delete</button>-->
			</div>
		</div>
	</div>
</div>


<!-- Modal
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
</div> -->

