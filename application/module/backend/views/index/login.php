<?php $linkAction = URL::createLink( 'backend', 'index', 'login' ); ?>
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-info">
        <div class="card-header text-center">
            <h1 class="h1"><b>Admin</b></h1>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php echo @$this->errors ?>
            <form action="<?php echo $linkAction ?>" method="post" id="form-login">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="login-username" name="form[username]" placeholder="Username" />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="login-password" name="form[password]" placeholder="Password" />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <input name="form[token]" type="hidden" value="<?php echo time() ?>" />
                <button onclick="document.getElementById( 'form-login' ).submit() type="submit" class="btn btn-info btn-block">Sign In</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>