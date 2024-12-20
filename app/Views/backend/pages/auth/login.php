<?= $this->extend('backend/layout/auth-layout') ?>
<?= $this->section('content') ?>

<section class="shop login section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-12">


				<div class="login-form">
					<h2>Login</h2>
					<p>Please register or login in order to checkout more quickly</p>
					<!-- Display Errors -->
					<?php if (session()->getFlashdata('fail')): ?>
						<div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
					<?php endif; ?>
					<?php if (isset($validation)): ?>
						<div class="alert alert-danger"><?= $validation->listErrors(); ?></div>
					<?php endif; ?>
					<!-- Form -->
					<form class="form" method="post" action="<?= base_url('/login') ?>">
    <?= csrf_field() ?>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Your Email<span>*</span></label>
                <input type="email" name="email" placeholder="Enter your email" required="required">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label>Your Password<span>*</span></label>
                <input type="password" name="password" placeholder="Enter your password" required="required">
            </div>
        </div>

        <!-- Hidden input to specify login type -->
        <input type="hidden" name="login_type" value="user"> <!-- 'user' for default users -->

        <div class="col-12">
            <div class="form-group login-btn">
                <button class="btn" type="submit">Login</button>
                <a href="<?= base_url('/register') ?>" class="btn">Register</a>
            </div>
            <div class="checkbox">
                <label class="checkbox-inline" for="remember_me">
                    <input name="remember_me" id="remember_me" type="checkbox">Remember me
                </label>
            </div>
            <a href="<?= base_url('/forgot') ?>" class="lost-pass">Forgot your password?</a>
        </div>
    </div>
</form>


					<!--/ End Form -->
				</div>
			</div>
		</div>
	</div>
</section>

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