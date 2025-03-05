<?php
include('include/header.php');
include('include/sidebar.php');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Change Password For Surveyor</h4>
            </div>
            <div class="card-body">
              <form class="needs-validation" id="change-pw-form" name="change-pw-form" novalidate="">
                <input type="hidden" id="hiddenUserId" name="hiddenUserId">
                <div class="row">
                  <div class="form-group col-6">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control" name="name" required readonly>
                    <div class="invalid-feedback">
                      Enter Name.
                    </div>
                  </div>
                  <div class="form-group col-6">
                    <label for="username">User Name</label>
                    <input id="username" type="text" class="form-control" name="username" required readonly>
                    <div class="invalid-feedback">
                      Enter User Name.
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="old-password">Old Password</label>
                  <input id="old-password" type="password" class="form-control" name="old-password" required="" autofocus>
                  <div class="invalid-feedback">
                    Enter Old Password.
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-6">
                    <label for="password" class="d-block">Password</label>
                    <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                    <div class="invalid-feedback">
                      Enter New Password.
                    </div>
                    <div id="pwindicator" class="pwindicator">
                      <div class="bar"></div>
                      <div class="label"></div>
                    </div>
                  </div>
                  <div class="form-group col-6">
                    <label for="password-confirm" class="d-block">Password Confirmation</label>
                    <input id="password-confirm" type="password" class="form-control" name="password-confirm" required>
                    <div class="invalid-feedback">
                      Confirm New Password.
                    </div>
                  </div>
                </div>
                <!--<div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="is-active" class="custom-control-input" id="is-active">
                    <label class="custom-control-label" for="is-active">Is Active</label>
                  </div>
                </div>-->
                <div class="text-center" id="divMessage"></div><br>
                <div class="form-group">
                  <button type="submit" id="btnChangePw" name="btnChangePw" class="btn btn-primary btn-lg btn-block">
                    Change Password
                  </button>
                </div>
              </form>
            </div>
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
<script src="assets/js/page/auth-register.js?ver=<?=rand();?>"></script>
<!-- Template JS File -->
<script src="assets/js/scripts.js"></script>
<!-- Custom JS File -->
<script src="assets/js/custom.js"></script>
</body>
</html>