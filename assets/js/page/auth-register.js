"use strict";
$(function () {
  $(".pwstrength").pwstrength();
  $("#divMessage").html();
  $("#name").val("");
  $("#username").val("");
  $("#hiddenUserId").val("");
  $("#is-active").prop("checked", false);
  $.ajax({
    url: "controllers/page/auth-register.php?type=fetchSurveyorDetails",
    type: "GET",
    data: { survey: "CRSS" },
    contentType: false,
    processData: false,
    cache: false,
    success: function (dataResult) {
      let res = jQuery.parseJSON(dataResult);
      if (res.response == "SUCCESS") {
        $("#divMessage").html(res.message);
        $("#divMessage").css("color", "green");
        $("#hiddenUserId").val(res.data.id);
        $("#name").val(res.data.admin_name);
        $("#username").val(res.data.username);
        let isActive = res.data.is_active == 1 ? true : false;
        $("#is-active").prop("checked", isActive);
        $("#btnChangePw").prop("disabled", false);
      } else if (res.response == "NA") {
        $("#divMessage").html(res.message);
        $("#divMessage").css("color", "red");
        $("#btnChangePw").prop("disabled", true);
      } else {
        $("#divMessage").html(res.message);
        $("#divMessage").css("color", "red");
        $("#btnChangePw").prop("disabled", false);
      }
    },
  });
  $("#btnChangePw").click(function (e) {
    if ($("#username").val() == "" && $("#username").val() == NULL) {
      $("#username").focus();
      $("#divMessage").html("Enter Username !");
      $("#divMessage").css("color", "red");
      return false;
    }
    if ($("#old-password").val() == "" && $("#old-password").val() == NULL) {
      $("#old-password").focus();
      $("#divMessage").html("Enter Old Password !");
      $("#divMessage").css("color", "red");
      return false;
    }
    if ($("#password").val() == "" && $("#password").val() == NULL) {
      $("#password").focus();
      $("#divMessage").html("Enter New Password !");
      $("#divMessage").css("color", "red");
      return false;
    }
    if (
      $("#password-confirm").val() == "" &&
      $("#password-confirm").val() == NULL
    ) {
      $("#password-confirm").focus();
      $("#divMessage").html("Confirm New Password !");
      $("#divMessage").css("color", "red");
      return false;
    }
    if (
      $("#password").val() != $("#password-confirm").val() ||
      $("#password").val() !== $("#password-confirm").val()
    ) {
      $("#password").val("");
      $("#password-confirm").val("");
      $("#password").focus();
      $("#divMessage").html("New Password & Confirm Password must be same !");
      $("#divMessage").css("color", "red");
      return false;
    }
    e.preventDefault();
    $("#btnChangePw").prop("disabled", true);
    $("#btnChangePw").html("Processing...");
    $.ajax({
      url: "controllers/page/auth-register.php?type=changePassword",
      type: "POST",
      data: new FormData(document.getElementById("change-pw-form")),
      contentType: false,
      processData: false,
      cache: false,
      success: function (dataResult) {
        let res = jQuery.parseJSON(dataResult);
        if (res.response == "SUCCESS") {
          $("#divMessage").html(res.message);
          $("#divMessage").css("color", "green");
        } else if (res.response == "INVALID") {
          $("#password").val("");
          $("#old-password").val("");
          $("#password-confirm").val("");
          $("#old-password").focus();
          $("#divMessage").html(res.message);
          $("#divMessage").css("color", "red");
        } else {
          $("#divMessage").html(res.message);
          $("#divMessage").css("color", "red");
        }
        $("#btnChangePw").prop("disabled", false);
        $("#btnChangePw").html("Change Password");
      },
    });
  });
});
