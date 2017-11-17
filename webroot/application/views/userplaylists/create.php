<div class="container">
	<div class="card" style="padding: 1rem;">
		<h3><?php echo $title; ?></h3>
	<?php echo validation_errors(); ?>

	<?php echo form_open('userplaylists/create'); ?>
		<div class="form-group">
			<label for="title">Playlist Title</label>
			<input type="text" id="title" name="title" class="form-control" placeholder="Worst Food Ever" required>			
		</div>
		<div class="form-group">
			<label for="playlist_description">Playlist Description</label>
			<input type="text" id="desc" name="desc" class="form-control"  placeholder="It sucks!!" required>
		</div>
		<div class="form-group">
			<label for="private_playlist">Is this playlist private?</label>
			<?php echo form_checkbox('private', 'accept', FALSE);?>
		</div>
		<div class="form-group">
			<select class="form-control" id="restaurant" name="restaurant">
			<?php foreach($restaurants as $row){ ?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
			<?php }?>
			</select>
		</div>
		<button type="submit" class="btn btn-primary">Create</button>
		<a class="btn btn-secondary" href="<?php echo site_url('/'); ?>">Cancel</a>
	</div>
</div>