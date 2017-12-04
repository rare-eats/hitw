<div class="container">
	<div class="card">
		<div class="card-body">
<?php if ($this->session->has_userdata('id')): ?>
			<h3><?php echo $title; ?></h3>
		
		<p class="text-danger"><?php echo validation_errors(); ?></p>

		<?php echo form_open('userplaylists/create'); ?>
			<div class="form-group">
				<label for="title">Playlist Title</label>
				<input type="text" id="title" name="title" class="form-control" placeholder="Playlist Title" required>
			</div>
			<div class="form-group">
				<label for="playlist_description">Playlist Description</label>
				<input type="text" id="desc" name="desc" class="form-control" placeholder="Playlist Description" required>
			</div>
			<div class="form-group">
				<label for="private_playlist">Is this playlist private?
				<input type="checkbox" value="true" name="private">
				</label>
			</div>
			<div class="form-group">
				<div>
				<label>(Optionally) Choose one restaurant to get this playlist started:</label><br>
				<select data-placeholder="restaurant" class="form-control form-control-chosen" id="restaurant" name="restaurant">
				<option value="-1">None</option>
				<?php foreach($restaurants as $row){ ?>
					<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
				<?php }?>
				</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Create</button>
			<a class="btn btn-secondary" href="<?php echo site_url('/'); ?>">Cancel</a>
<?php else: ?>
	<h4 class="text-danger text-center">You're not currently logged in!</h4>
	<p class="card-text text-center">We won't be able to save your list if you don't log in.</p>
<?php endif ?>
		</div>
	</div>
</div>
