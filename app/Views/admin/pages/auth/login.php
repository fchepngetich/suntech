<?= $this->extend('backend/layout/auth-layout') ?>
<?= $this->section('content') ?>

<section class="shop login section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-12">

    <?php $validations = Config\Services::validation(); ?>

    <form class="form" method="post" action="<?= base_url('admin/login') ?>">
    <?= csrf_field() ?>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Admin Email<span>*</span></label>
                <input type="email" name="email" placeholder="Enter your admin email" required="required">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label>Password<span>*</span></label>
                <input type="password" name="password" placeholder="Enter your password" required="required">
            </div>
        </div>

        <!-- Hidden input to specify login type -->
        <input type="hidden" name="login_type" value="admin"> <!-- 'admin' for admin users -->

        <div class="col-12">
            <div class="form-group login-btn">
                <button class="btn" type="submit">Login</button>
            </div>
            <a href="<?= base_url('/forgot') ?>" class="lost-pass">Forgot your password?</a>
        </div>
    </div>
</form>

</div></div></div></section>

<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById('password');
        var showPassword = document.getElementById('show_password');

        if (showPassword.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    }
</script>

<?= $this->endSection() ?>
