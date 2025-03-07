'use strict';
$(function () {
    $.ajax({
        url: "controllers/page/survey-report.php?type=getReport",
        type: "GET",
        data: { survey: "CRSS" },
        contentType: false,
        processData: true,
        cache: false,
        success: function (dataResult) {
            let res = jQuery.parseJSON(dataResult);
            if (res.response == "SUCCESS") {
                $('#divReportShow').html(res.html);
            } else {
                iziToast.info({
                    title: 'Error !',
                    message: 'Data Not Availble !',
                    position: 'topRight'
                });
            }
        },
    });
    $("#btnDownloadReport").click(function () {
        DowloadExcel();
    });
});

function DowloadExcel(fn, dl) {
    console.log('jhjkhjk');
    let fileName = "Survey_Report";
    let htmlContent = $("#divReportShow").html();
    let blob = new Blob([htmlContent], { type: "application/vnd.ms-excel" });
    saveAs(blob, fileName + ".xls");
}