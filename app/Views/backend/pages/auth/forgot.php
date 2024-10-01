<?= $this->extend('backend/layout/auth-layout') ?>
<?= $this->section('content') ?>

<section class="shop login section">
			<div class="container">
				<div class="row"> 
					<div class="col-lg-6 offset-lg-3 col-12">
						<div class="login-form">
							<h2>Reset Password</h2>
                            <p>Please enter the email used during registration.</p>
							<!-- Form -->
							<form class="form" method="post" action="<?= base_url('/forgot-password') ?>">
								<div class="row">
									<div class="col-12">
										<div class="form-group">
											<label>Your Email<span>*</span></label>
											<input type="email" name="email" placeholder="" required="required">
										</div>
									</div>
							
									<div class="col-12">
										<div class="form-group login-btn">
											<button class="btn" type="submit">Submit</button>
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






</div><?= $this->endSection() ?>