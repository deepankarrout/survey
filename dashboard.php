<?php
include('include/header.php');
include('include/sidebar.php');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">No Of Survey's</h5>
                    <h2 class="mb-3 font-18 card-1">0</h2>
                    <p class="mb-0 p-1"><span class="col-green span-1"></span></p>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                  <div class="banner-img">
                    <img src="assets/img/banner/1.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">No Of School's</h5>
                    <h2 class="mb-3 font-18 card-2">0</h2>
                    <p class="mb-0"><span class="col-green"></span></p>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                  <div class="banner-img">
                    <img src="assets/img/banner/3.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">Total Fund Amount</h5>
                    <h2 class="mb-3 font-18 card-3">0</h2>
                    <p class="mb-0"><span class="col-green"></span></p>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                  <div class="banner-img">
                    <img src="assets/img/banner/4.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-lg-12">
        <div class="card ">
          <div class="card-header">
            <h4>Fund chart ( School Wise )</h4>
            <div class="card-header-action">
              <!-- <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Options</a>
                <div class="dropdown-menu">
                  <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                  <a href="#" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>
                    Delete</a>
                </div>
              </div> -->
              <a href="survey-report.php" class="btn btn-primary">View All</a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div id="barChart"></div>
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
<!-- JS Libraies -->
<script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
<!-- JS Libraies -->
<script src="assets/bundles/amcharts4/core.js"></script>
<script src="assets/bundles/amcharts4/charts.js"></script>
<script src="assets/bundles/amcharts4/animated.js"></script>
<script src="assets/bundles/amcharts4/worldLow.js"></script>
<script src="assets/bundles/amcharts4/maps.js"></script>
<!-- Page Specific JS File -->
<script src="assets/js/page/index.js?ver=<?=rand()?>"></script>
<!-- Template JS File -->
<script src="assets/js/scripts.js"></script>
<!-- Custom JS File -->
<script src="assets/js/custom.js"></script>
</body>
</html>