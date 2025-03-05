<?php
include('include/header.php');
include('include/sidebar.php');
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                    <h4>Survey Form</h4>
                    </div>
                    <div class="card-body">
                        <div class="row" id="divFilter">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>School:</label>
                                    <select class="form-control select2" id="cmbSchool" name="cmbSchool"></select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6" style="padding-top:30px;">
                                <button type="button" class="btn btn-primary" id="btnProceed" name="btnProceed"><i class="fa fa-step-forward"></i>&nbsp;Proceed</button>
                            </div>
                        </div>
                        <div id="divInformation">
                            <fieldset style="border: 1px solid blue;padding: 15px;border-radius: 20px;width:100%;" id="showSurveyInformation">
                                <input type="hidden" id="hdnSurveyCode" name="hdnSurveyCode" value=""/>
                                <div style="padding:20px;">
                                    <div class="row"><b>School Name &nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-success" id="spanSchoolName">NA</span></b></div>
                                    <div class="row"><b>UDISE Code &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-success" id="spanSchoolCode">NA</span></b></div>
                                </div>
                            <fieldset>
                        </div><br>
                        <div class="" style="border-radius: 20px;">
                            <fieldset style="border: 1px solid blue;padding: 15px;border-radius: 20px;" id="showSurveyDeatils"><fieldset>
                        </div>
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
<script src="assets/bundles/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Libraies -->
<script src="assets/bundles/jquery-steps/jquery.steps.min.js"></script>
<script src="assets/bundles/select2/dist/js/select2.full.min.js"></script>
<!-- Page Specific JS File -->
<script src="assets/js/page/survey-form.js?ver=<?=rand();?>"></script>
<!-- Template JS File -->
<script src="assets/js/scripts.js"></script>
<!-- Custom JS File -->
<script src="assets/js/custom.js"></script>
</body>
</html>