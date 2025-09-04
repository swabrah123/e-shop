<?php
session_start();
require_once('files/header.php');
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger text-center" role="alert">'
         . $_SESSION['error_message'] .
         '</div>';
    unset($_SESSION['error_message']); 
}
?>



<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>


<div class="container py-4 py-lg-5 my-4">
  <div class="row">
    <!-- Sign In -->
    <div class="col-md-6">
      <div class="card border-0 shadow">
        <div class="card-body">
          <h2 class="h4 mb-1">Sign in</h2>
          <div class="py-3">
            <h3 class="d-inline-block align-middle fs-base fw-medium mb-2 me-2">With social account:</h3>
            <div class="d-inline-block align-middle">
              <a class="btn-social bs-google me-2 mb-2" href="#"><i class="ci-google"></i></a>
              <a class="btn-social bs-facebook me-2 mb-2" href="#"><i class="ci-facebook"></i></a>
              <a class="btn-social bs-twitter me-2 mb-2" href="#"><i class="ci-twitter"></i></a>
            </div>
          </div>
          <hr>
          <h3 class="fs-base pt-4 pb-2">Or using form below</h3>

          <!-- Alert messages (Login) -->
          <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?= $_SESSION['success']; unset($_SESSION['success']); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= $_SESSION['error']; unset($_SESSION['error']); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Login Form -->
          <form class="needs-validation" novalidate method="POST" action="loginlogic.php">
            <input type="hidden" name="action" value="login">

            <div class="input-group mb-3">
              <i class="ci-mail position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
              <input class="form-control rounded-start" type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group mb-3">
              <i class="ci-locked position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
              <div class="password-toggle w-100">
                <input class="form-control" type="password" name="password" placeholder="Password" required>
                <label class="password-toggle-btn" aria-label="Show/hide password">
                  <input class="password-toggle-check" type="checkbox">
                  <span class="password-toggle-indicator"></span>
                </label>
              </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me" checked>
                <label class="form-check-label" for="remember_me">Remember me</label>
              </div>
              <a class="nav-link-inline fs-sm" href="account-password-recovery.html">Forgot password?</a>
            </div>

            <hr class="mt-4">
            <div class="text-end pt-4">
              <button class="btn btn-primary" type="submit"><i class="ci-sign-in me-2 ms-n1"></i>Sign In</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Sign Up -->
    <div class="col-md-6 pt-4 mt-3 mt-md-0">
      <h2 class="h4 mb-3">No account? Sign up</h2>
      <p class="fs-sm text-muted mb-4">Registration takes less than a minute but gives you full control over your orders.</p>

      <!-- Alert messages (Register) -->
      <?php if (isset($_SESSION['reg_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= $_SESSION['reg_success']; unset($_SESSION['reg_success']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['reg_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= $_SESSION['reg_error']; unset($_SESSION['reg_error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <!-- Registration Form -->
      <form class="needs-validation" novalidate method="POST" action="Registerlogic.php">
        <div class="row gx-4 gy-3">
          <div class="col-sm-6">
            <label class="form-label" for="reg-fn">First Name</label>
            <input class="form-control" type="text" name="first_name" required id="reg-fn">
            <div class="invalid-feedback">Please enter your first name!</div>
          </div>

          <div class="col-sm-6">
            <label class="form-label" for="reg-ln">Last Name</label>
            <input class="form-control" type="text" name="last_name" required id="reg-ln">
            <div class="invalid-feedback">Please enter your last name!</div>
          </div>

          <div class="col-sm-6">
            <label class="form-label" for="reg-email">E-mail Address</label>
            <input class="form-control" type="email" name="email" required id="reg-email">
            <div class="invalid-feedback">Please enter valid email address!</div>
          </div>

          <div class="col-sm-6">
            <label class="form-label" for="reg-phone">Phone Number</label>
            <input class="form-control" type="text" name="phone" required id="reg-phone">
            <div class="invalid-feedback">Please enter your phone number!</div>
          </div>

          <div class="col-sm-6">
            <label class="form-label" for="reg-password">Password</label>
            <input class="form-control" type="password" name="password" required id="reg-password">
            <div class="invalid-feedback">Please enter password!</div>
          </div>

          <div class="col-sm-6">
            <label class="form-label" for="reg-password-confirm">Confirm Password</label>
            <input class="form-control" type="password" name="password_confirmation" required id="reg-password-confirm">
            <div class="invalid-feedback">Passwords do not match!</div>
          </div>

          <input type="hidden" name="action" value="register">

          <div class="col-12 text-end">
            <button class="btn btn-primary" type="submit"><i class="ci-user me-2 ms-n1"></i>Sign Up</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once('files/footer.php'); ?>
