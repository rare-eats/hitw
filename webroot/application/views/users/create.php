<div class="container col-md-6 mx-auto" >
    <h2>New User</h2>
    <?php echo form_open('users/create'); ?>
        <div class="form-group">
            <label>First Name</label>
                <?php echo form_input($first_name); ?>
        </div>
        <div class="form-group">
            <label>Last Name</label>
                <?php echo form_input($last_name); ?>
        </div>
        <div class="form-group">
            <label>Email</label>
                <?php echo form_input($email); ?>
        </div>
        <div class="form-group">
            <label>Password</label>
                <?php echo form_password($password); ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/" class="btn btn-link">Cancel</a>
    </form>
</div>



