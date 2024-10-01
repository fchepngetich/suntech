<?= $this->extend('backend/layout/auth-layout') ?>
<?= $this->section('content') ?>

<section class="shop login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-12">
                <div class="login-form">
                    <h2>Register</h2>
                    <p>Please register in order to checkout more quickly</p>
                    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
<?php endif; ?>

                    <!-- Display Validation Errors -->
                    <?php if (isset($validation)): ?>
                        <div class="alert alert-danger">
                            <?= $validation->listErrors() ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form class="form" method="post" action="<?= base_url('/register') ?>">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Your Name<span>*</span></label>
                                    <input type="text" name="name" value="<?= set_value('name') ?>" required="required">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Your Email<span>*</span></label>
                                    <input type="text" name="email" value="<?= set_value('email') ?>" required="required">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Your Password<span>*</span></label>
                                    <input type="password" name="password" required="required">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Confirm Password<span>*</span></label>
                                    <input type="password" name="password_confirm" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button class="btn" type="submit">Register</button>
                                    <a href="<?= base_url('/login') ?>" class="btn">Login</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--/ End Form -->
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
