<?php
include('include/header.php');
include('include/sidebar.php');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Export Table</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                  <thead>
                    <tr>
                      <th>District</th>
                      <th>Block</th>
                      <th>Gram Panchayat</th>
                      <th>Revenue Village</th>
                      <th>Name of the Surveyor</th>
                      <th>Contact No of the Surveyor</th>
                      <th>Name of the Head of the HH as per Aadhar</th>
                      <th>HH have PDS card ?</th>
                      <th>HH have BSKY card ?</th>
                      <th>HH have MGNREGS card ? </th>
                      <th>HH have benefited from KALIA Yojana ?</th>
                      <th>HH have any adult women member ?</th>
                      <th>Adult women of the HH are member of Mission Sakti ?</th>
                      <th>HH have any member 60 year or more than 60 year old / Widow / PWD person ?</th>
                      <th>Members of the HH are benefited from Social security pension schemes ?</th>
                      <th>HH have access to safe drinking water ?</th>
                      <th>HH have any children equal or less than 6 years old ?</th>
                      <th>Children of the HH are beneficiary of the AWC ?</th>
                      <th>Have any children more than 6 years old to 14 years old ?</th>
                      <th>Children of the house hold are going to school ?</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
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
<!-- Page Specific JS File -->
<script src="assets/bundles/datatables/datatables.min.js"></script>
<script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
<script src="assets/bundles/datatables/export-tables/buttons.flash.min.js"></script>
<script src="assets/bundles/datatables/export-tables/jszip.min.js"></script>
<script src="assets/bundles/datatables/export-tables/pdfmake.min.js"></script>
<script src="assets/bundles/datatables/export-tables/vfs_fonts.js"></script>
<script src="assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
<script src="assets/js/page/datatables.js?ver=<?= rand(); ?>"></script>
<!-- Template JS File -->
<script src="assets/js/scripts.js"></script>
<!-- Custom JS File -->
<script src="assets/js/custom.js"></script>
</body>

</html>