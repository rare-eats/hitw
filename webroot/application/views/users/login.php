<!-- <div class="container col-md-6" >
    <h2>Login</h2>
    <?php echo form_open('users/login'); ?>
        <div class="form-group">
            <label>Email</label>
                <?php echo form_input($email); ?>
        </div>
        <div class="form-group">
            <label>Password</label>
                <?php echo form_password($password); ?>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <button class="btn btn-danger">Cancel</button>
</div> -->

<div class="container col-md-6">
    <h2>User Login</h2>
    <?php
    if(!empty($success_msg)){
        echo '<p class="statusMsg">'.$success_msg.'</p>';
    }elseif(!empty($error_msg)){
        echo '<p class="statusMsg">'.$error_msg.'</p>';
    }
    ?>
    <?php echo form_open('users/login'); ?>
        <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="Email" required="" value="">
            <?php echo form_error('email','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Password" required="">
          <?php echo form_error('password','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="submit" name="loginSubmit" class="btn-primary" value="Submit"/>
        </div>
    </form>
    <p class="footInfo">Don't have an account? <a href="create/">Register here</a></p>
</div>