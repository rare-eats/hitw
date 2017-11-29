<div class="container">
	<div class="card">
		<div class="card-body">
<?php if ($this->session->has_userdata('id')): ?>
			<h3><?php echo $title; ?></h3>
		<?php echo validation_errors(); ?>

		<?php echo form_open('userplaylists/create'); ?>
			<div class="form-group">
				<input type="text" id="title" name="title" class="form-control" placeholder="Playlist Title" required>
			</div>
			<div class="form-group">
				<input type="text" id="desc" name="desc" class="form-control" placeholder="Playlist Description" required>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="checkbox" value="true" name="private">
					Is this playlist private?
				</label>
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
		</form>
		</div>
<?php else: ?>
	<h4 class="text-danger">Please Log In to Create a List</h4>
<?php endif ?>
		</div>
	</div>
</div>