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
    <?php if ($this->session->userdata('id') === $id || $this->users_model->is_admin()): ?>
        <a href="../edit/<?php echo $id;?>" type="button" class="btn btn-primary" >Edit</a>
        <a href="" type="button" class="btn btn-danger">Delete</a>
    <?php endif ?>
</div>
