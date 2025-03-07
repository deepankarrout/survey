<?php
include('include/header.php');
include('include/sidebar.php');
?>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Survey Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="divReportShow"></div>
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
<!-- <script src="assets/bundles/select2/dist/js/select2.full.min.js"></script> -->
<!-- Page Specific JS File -->
<script src="assets/js/page/survey-report.js?ver=<?=rand();?>"></script>
<!-- Template JS File -->
<script src="assets/js/scripts.js"></script>
<!-- Custom JS File -->
<script src="assets/js/custom.js"></script>
</body>
</html>