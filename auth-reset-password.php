<?php
include('include/header.php');
include('include/sidebar.php');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card card-primary">
            <form class="needs-validation" id="reset-pw-form" name="reset-pw-form" novalidate="">
              <input type="hidden" id="hiddenUserId" name="hiddenUserId" value="<?=$_SESSION['adminid']?>">
              <div class="card-header">
                <h4>Change Login Password</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" id="username" name="username" class="form-control" value="" required="" readonly>
                  <div class="invalid-feedback">
                    What's your username?
                  </div>
                </div>
                <div class="form-group">
                  <label>Old Password</label>
                  <input type="password" id="old-password" name="old-password" class="form-control" required="" autofocus>
                  <div class="invalid-feedback">
                    Enter your old password.
                  </div>
                </div>
                <div class="form-group">
                  <label for="password" class="d-block">New Password</label>
                  <input type="password" id="password" name="password"  class="form-control pwstrength" data-indicator="pwindicator" tabindex="2" required="">
                  <div class="invalid-feedback">
                    Enter New Password.
                  </div>
                  <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                  </div>
                </div>
                <div class="form-group mb-0">
                  <label class="d-block">Confirm Password</label>
                  <input type="password" id="password-confirm" name="password-confirm" class="form-control" tabindex="2" required=""></input>
                  <div class="invalid-feedback">
                    Confirm your new password.
                  </div>
                </div>
              </div>
              <div class="text-center" id="divMessage"></div><br>
              <div class="card-footer text-right">
                <button type="submit" id="btnChangePw" name="btnChangePw" class="btn btn-primary btn-lg btn-block" tabindex="4">Change Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
  include('include/settings.php');
  ?>
</div>
<!-- Footer -->
<?php
include('include/footer.php');
?>
<!-- General JS Scripts -->
<script src="assets/js/app.min.js"></script>
<!-- JS Libraies -->
<script src="assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
<script src="assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
<!-- Page Specific JS File -->
<script src="assets/js/page/auth-reset-password.js"></script>
<!-- Template JS File -->
<script src="assets/js/scripts.js"></script>
<!-- Custom JS File -->
<script src="assets/js/custom.js"></script>
</body>

</html>