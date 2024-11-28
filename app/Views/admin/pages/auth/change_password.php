<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>
    <div class="container ">
          <div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Change Password</h4>
                </div>
                 <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Change Password
                        </li>
                    </ol>
                </nav>
            </div>
           
        </div>
    </div>

<div class="bg-white box-shadow border-radius-10">
  
       <div class="row ">
         <div class="col-md-6 login-box">
         <?php if (session()->get('success')) : ?>
    <div class="toast toast-success">
        <?= esc(session()->get('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->get('fail')) : ?>
    <div class="toast toast-error">
        <?= esc(session()->get('fail')) ?>
    </div>
<?php endif; ?>

<script>
    setTimeout(() => {
        document.querySelectorAll('.toast').forEach(toast => toast.remove());
    }, 5000); // Remove after 5 seconds
</script>

         <form action="<?= base_url('admin/change-password') ?>" method="POST" id="passwordForm">
    <?= csrf_field() ?>

    <div id="global-error" class="alert alert-danger" style="display: none;"></div>

    <div class="input-group custom">
        <input type="password" class="form-control form-control-lg" id="current_password" name="current_password" placeholder="Current Password" required>
        <div class="input-group-append custom">
            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
        </div>
        <div id="current_password_error" class="text-danger small"></div>
    </div>

    <div class="input-group custom">
        <input type="password" class="form-control form-control-lg" id="new_password" name="new_password" placeholder="New Password" required>
        <div class="input-group-append custom">
            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
        </div>
        <div id="new_password_error" class="text-danger small"></div>
    </div>

    <div class="input-group custom">
        <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required>
        <div class="input-group-append custom">
            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
        </div>
        <div id="confirm_password_error" class="text-danger small"></div>
    </div>

    <div class="form-group mt-2">
        <input type="checkbox" id="show_passwords" onclick="togglePasswordVisibility()"> 
        <label for="show_passwords">Show Passwords</label>
    </div>

    <div class="row align-items-center">
        <div class="col-12">
            <div class="input-group mb-0">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Change Password</button>
            </div>
        </div>
    </div>
</form>


    </div>
         <div class="col-md-6 login-box">
            <h4>Password Requirements</h4>
            <ul>
                <li>At least 8 characters long</li>
                <li>At least one uppercase letter</li>
                <li>At least one lowercase letter</li>
                <li>At least one number</li>
                <li>At least one special character</li>
            </ul>
        </div>

    </div>  
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var currentPassword = document.getElementById('current_password');
        var newPassword = document.getElementById('new_password');
        var confirmPassword = document.getElementById('confirm_password');
        var showPasswords = document.getElementById('show_passwords');

        if (showPasswords.checked) {
            currentPassword.type = 'text';
            newPassword.type = 'text';
            confirmPassword.type = 'text';
        } else {
            currentPassword.type = 'password';
            newPassword.type = 'password';
            confirmPassword.type = 'password';
        }
    }
</script>

<?= $this->endSection() ?>
