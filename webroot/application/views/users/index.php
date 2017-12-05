<?php if($this->users_model->is_admin()): ?>
    <div class="container">
        <div class="card">
            <div class="card-body">
        <h3><?php echo $title; ?></h3>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>email</th>
        </tr>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['first_name']; ?></td>
            <td><?php echo $user['last_name']; ?></td>
            <td><?php echo $user['email']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1>You do not have permissions to view this page</h1>
<?php endif ?>