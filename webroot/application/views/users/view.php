<div class="container-fluid">
<div class="card">
    <div class="card-body">
<?php if (!($this->session->has_userdata('id') || $this->users_model->is_admin())): ?>
    <h4 class="text-danger">Please login or register to view your profile</h4>
<?php else: ?>
    <div>
        <?php echo form_open('users/search', ['class' => 'form-inline']); ?>
        <div class="form-group my-sm-3 mx-sm-3">
            <input class="form-control" type="text" name="search" placeholder="Find Friends"/>
        </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
    <div class="my-sm-3 mx-sm-3">
        <h3>User Profile</h3>
        <table class="table">
            <tr>
                <td>First Name</td>
                <td><?php echo $user['first_name'];?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo $user['last_name'];?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $user['email'];?></td>
            </tr>
        </table>
        <a href="edit/<?php echo $user['id'];?>" class="btn btn-primary">Edit</a>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_modal">Delete Account</button>
    </div>
    <div class="my-sm-3 mx-sm-3">
        <div class="row">
            <div class="col">
                <span>
                    <h2>My Lists <small>
                    <a href="/userplaylists/create">&plus;</a></small></h2>
                </span>
            </div>
        </div>
        <?php if(!empty($playlists)):?>
        <div class="row">
            <div class="col d-lg-flex">
            <?php foreach ($playlists as $playlist): ?>
                <div class="card">
                    <img class="card-img-top" src="http://via.placeholder.com/350x150" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $playlist['title']; ?></h4>
                        <p class="card-text"><?php echo $playlist['desc']; ?></p>
                        <a href="/userplaylists/view/<?php echo $playlist['id']; ?>" class="btn btn-primary">View List</a>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
            <p class="text-muted">You currently have no lists</p>
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