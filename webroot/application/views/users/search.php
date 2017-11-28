<div class="container">
    <div class="card">
<?php if(empty($users)):?>
    <h2>No users found :(</h2>
<?php else: ?>
    <table class="table">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>email</th>
        </tr>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?php echo $user['first_name']; ?></td>
            <td><?php echo $user['last_name']; ?></td>
            <td><?php echo $user['email']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif ?>
    </div>
</div>