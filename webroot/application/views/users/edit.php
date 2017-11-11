<div class="container col-md-6" >
    <h2>Edit User</h2>
    <?php echo form_open('users/edit/'.$id);?>
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
