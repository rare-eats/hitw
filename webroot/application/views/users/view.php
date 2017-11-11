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
    <?php var_dump($this->session->has_userdata('id')); ?>
    <?php if ($this->session->userdata('id') === $id): ?>
        <a href="../edit/<?php echo $id;?>" type="button" class="btn btn-primary" >Edit</a>
        <a href="" type="button" class="btn btn-danger">Delete</a>
        <a href="../index/" type="button" class="btn btn-primary">List Users</a>
    <?php endif ?>
</div>
