<div class="container col-md-6">
    <div class="card">
    <h3 class="my-sm-3 mx-sm-3">User Login</h3>
    <div class="my-sm-3 mx-sm-3" >
    <?php
        if(!empty($success_msg)) {
            echo '<p class="text-success">'.$success_msg.'</p>';
        } elseif(!empty($error_msg)) {
            echo '<p class="text-danger">'.$error_msg.'</p>';
        }
    ?>
    <?php echo form_open('users/login/'.implode('/',$redirect_url));?>
        <div class="form-group has-feedback">
                <input type="email" class="form-control" name="email" placeholder="Email" required="" value="">
                <?php echo form_error('email','<span class="help-block">','</span>'); ?>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="password" placeholder="Password" required="">
              <?php echo form_error('password','<span class="help-block">','</span>'); ?>
            </div>
            <div class="form-group">
                <input type="submit" name="loginSubmit" class="btn btn-primary" value="Login"/>
            </div>
        </form>
        <p class="footInfo">Don't have an account? <a href="create/">Register here</a></p>
        </div>
    </div>
</div>
