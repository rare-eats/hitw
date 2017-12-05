<div class="container">
	<div class="card">
		<div class="card-body">
		<?php if($this->session->id !== $playlist['author_id'] && (!$this->users_model->is_admin())): ?>
			<h3 class="text-danger text-center">You do not have permission to edit this playlist!</h3>
		<?php else: ?>
			<h3 class="text-center"><?php echo $title; ?></h3>
			
			<div class="text-danger">
				<?php echo validation_errors(); ?>
			</div>

			<?php echo form_open('userplaylists/edit/'.$playlist['id']); ?>
			<div class="form-group">
				<label for="title">Playlist Title</label>
				<input type="text" id="title" name="title" class="form-control" value="<?php echo html_escape($playlist['title']); ?>" required>
			</div>
			<div class="form-group">
				<label for="playlist_description">Playlist Description</label>
				<input type="text" id="desc" name="desc" class="form-control" value="<?php echo html_escape($playlist['desc']); ?>">
			</div>
			<div class="form-group">
				<label for="private_playlist">Is this playlist private?</label>
				<?php if ($playlist['private'] == '1'): ?>
					<input type="checkbox" value="true" name="private" checked>
				<?php else: ?>
					<input type="checkbox" value="true" name="private">
				<?php endif; ?>
			</div>
			<?php if (empty($restaurants)): ?>
				<p class="card-text text-muted">This playlist is currently empty.</p>
			<?php else: ?>
				<table class="table">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Restaurant Name</th>
							<th scope="col">Remove</th>
						</tr>
					</thead>
					<tbody class="table-striped">
				<?php foreach ($restaurants as $key => $restaurant): ?>
					<tr>
						<th scope="row"><?php echo $key+1; ?></th>
						<td><?php echo $restaurant['name']; ?></td>
						<td><a class="btn btn-secondary" href="<?php echo site_url('userplaylists/').$playlist['id'].'/content/'.$restaurant['content_id'].'/delete'; ?>">&times;</a></td>
					</tr>
				<?php endforeach; ?>
					</tbody>
				</table>
				<?php endif; ?>			
			<button type="submit" class="btn btn-primary">Save Changes</button>
			<a class="btn btn-secondary" href="<?php echo site_url('userplaylists/view/'.$playlist['id']); ?>">Cancel</a>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePlaylistModal">Delete</button>
		<?php endif; ?>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal" id="deletePlaylistModal" tabindex="-1" role="dialog" aria-labelledby="deletePlaylistModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="deletePlaylistModalLabel">Delete this playlist?</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		Are you sure you want to delete your playlist '<?php echo $playlist['title']; ?>'?
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<a class="btn btn-danger" href="<?php echo site_url('userplaylists/delete/'.$playlist['id']); ?>">Delete</a>
	  </div>
	</div>
  </div>
</div>

