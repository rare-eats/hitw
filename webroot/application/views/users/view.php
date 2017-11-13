<div class="container col-md-6">
    <table class="table">
        <tr>
            <td>First Name</td>
            <td><?php echo $first_name;?></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><?php echo $last_name;?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $email;?></td>
        </tr>
    </table>
    <?php if ($this->session->userdata('id') === $id): ?>
        <a href="../edit/<?php echo $id;?>" type="button" class="btn btn-primary" >Edit</a>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_modal">Delete Account</button>
    <?php endif ?>
</div>

<div class="modal fade text-center" id="delete_modal">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="delete_modal">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Your account will be deleted. Are you sure you want to continue?</p>
          <p>This process is not reversible and no user data is retained once deleted</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <a href="../delete/<?php echo $id;?>" type="button" class="btn btn-danger">Yes</a>
        </div>
    </div>
  </div>
</div>
