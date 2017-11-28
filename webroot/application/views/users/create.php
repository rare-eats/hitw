<div class="container col-md-6 mx-auto" >
    <div class="card">
    <h3 class="my-sm-3 mx-sm-3">Create your Rare Eats Account</h3>
    <div class="my-sm-3 mx-sm-3" >
    <?php if (isset($error_msg)): ?>
        <p class="text-danger"><?php echo $error_msg;?></p>
    <?php endif ?>
        <?php echo form_open('users/create'); ?>
            <div class="form-group">
                <?php echo form_input($first_name); ?>
            </div>
            <div class="form-group">
                <?php echo form_input($last_name); ?>
            </div>
            <div class="form-group">
                <?php echo form_input($email); ?>
            </div>
            <div class="form-group">
                <?php echo form_password($password); ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </div>
</div>



