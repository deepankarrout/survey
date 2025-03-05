"use strict";
$(function () {
  $("#tableExport").DataTable({
    ajax: {
      url: "controllers/page/export-table.php?type=fetchSurveyDetails",
    },
    pageLength: 100,
    dom:
      "<'row'<'col-sm-6'B><'col-sm-4'l><'col-sm-2'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-6'i><'col-sm-6 float-end'p>>",
    //sDom: "<'row'<'col-md-4'i><'col-md-4'l><'col-md-4'f>r>t<'row'<'col-md-6' <'row' <'col-md-6' >>><'col-md-6'p>>",
    aoColumns: [
      { data: "1", className: "text-center" },
      { data: "2", sWidth: "6%" },
      { data: "3", sWidth: "8%", className: "text-center" },
      { data: "4", className: "text-center" },
      { data: "5", className: "text-center" },
      { data: "6", className: "text-center" },
      { data: "7", className: "text-center" },
      { data: "8", className: "text-center" },
      { data: "9", className: "text-center" },
      { data: "10", className: "text-center" },
      { data: "11", className: "text-center" },
      { data: "12", className: "text-center" },
      { data: "13", className: "text-center" },
      { data: "14", className: "text-center" },
      { data: "15", className: "text-center" },
      { data: "16", className: "text-center" },
      { data: "17", className: "text-center" },
      { data: "18", className: "text-center" },
      { data: "19", className: "text-center" },
      { data: "20", className: "text-center" },
    ],
    buttons: [
      {
        extend: "csv",
        title: "Survey Report CSV",
        exportOptions: {
          columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ]
        },
      },
      {
        extend: "excel",
        title: "Data export Excel",
        exportOptions: {
          columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ]
        },
      },
      // {
      //   extend: "pdf",
      //   title: "Data export Pdf",
      //   exportOptions: {
      //     columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ]
      //   },
      // },
      {
        extend: "print",
        title: "Data export Print",
        exportOptions: {
          columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ]
        },
      },
    ],
  });
});
