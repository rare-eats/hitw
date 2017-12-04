<div class="container-fluid">
<div class="card">
	<div class="card-body">
<?php if (!($this->session->has_userdata('id') || $this->users_model->is_admin())): ?>
	<h4 class="text-danger">Please login or register to view your profile.</h4>
<?php else: ?>
	<div>
		<?php echo form_open('users/search', ['class' => 'form-inline']); ?>
		<div class="form-group my-sm-3 mx-sm-3">
			<input class="form-control" type="text" name="search" placeholder="Find Friends by Email"/>
		</div>
			<button type="submit" class="btn btn-primary">Search</button>
		</form>
	</div>

	<div class="card">
		<div class="card-header" role="tab" id="headingOne">
			<a style="text-decoration: none;" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				<div class="clearfix">
					<span class="float-right text-muted">&#9660;</span>
					<h4 class="mb-0 text-center">Account Details</h4>
				</div>
			</a>
		</div>

		<div id="collapseOne" class="collapse hide" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
			<div class="card-body">
				<table class="table">
					<tr>
						<th scope="row">First Name</th>
						<td><?php echo $user['first_name'];?></td>
					</tr>
					<tr>
						<th scope="row">Last Name</th>
						<td><?php echo $user['last_name'];?></td>
					</tr>
					<tr>
						<th scope="row">Email</th>
						<td><?php echo $user['email'];?></td>
					</tr>
				</table>
			<a href="edit/<?php echo $user['id'];?>" class="btn btn-primary">Edit</a>
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_modal">Delete Account</button>
			</div>
		</div>
	</div>
	<div class="my-sm-3 mx-sm-3">
		<div class="col">
			<h2 class="text-center">My Subscribed Lists</h2>
		</div>
<?php if(!empty($playlists_subscribed)):?>
	<?php foreach ($playlists_subscribed as $key => $playlist): ?>
		<a href="/userplaylists/view/<?php echo $playlist['id']; ?>" style="text-decoration: none;">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title"><?php echo $playlist['title']; ?></h3>
					<p class="card-text text-dark"><?php echo $playlist['desc']; ?></p>
				</div>
			</div>
		</a>
	<?php endforeach; ?>
<?php else: ?>
	<p class="text-muted">You are currently not subscribed to any lists.</p>
<?php endif; ?>
	</div>
	<div class="my-sm-3 mx-sm-3">
		<div class="row">
			<div class="col">
				<h2 class="text-center">Lists By Me
					<small><a href="/userplaylists/create" aria-label="Create a playlist">&plus;</a></small>
				</h2>
			</div>
		</div>
<?php if(!empty($playlists_by)):?>
	<?php foreach ($playlists_by as $key => $playlist): ?>
		<a href="/userplaylists/view/<?php echo $playlist['id']; ?>" style="text-decoration: none;">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title"><?php echo $playlist['title']; ?></h3>
					<p class="card-text text-dark"><?php echo $playlist['desc']; ?></p>
				</div>
			</div>
		</a>
	<?php endforeach; ?>
<?php else: ?>
	<p class="text-muted">You currently have no lists.</p>
<?php endif; ?>
	</div>
</div>



<div class="modal fade text-center" id="delete_modal">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="delete_modal">Delete Account</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<p>Your account will be deleted. Are you sure you want to continue?</p>
			<p class="text-danger">This process is not reversible and no user data is retained once deleted.</p>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			<a href="/users/delete/<?php echo $user['id'];?>" class="btn btn-danger">Delete</a>
		</div>
	</div>
  </div>
<?php endif ?>
</div>
</div>
</div>