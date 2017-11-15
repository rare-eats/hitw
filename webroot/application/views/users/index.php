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