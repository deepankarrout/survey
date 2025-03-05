$(document).ready(function () {
  $("#btnLogin").click(function (e) {
    if ($("#username").val() != "" && $("#password").val() != "") {
      e.preventDefault();
      $.ajax({
        url: "controllers/authentication/authLogin.php?type=Login",
        type: "POST",
        data: new FormData(document.getElementById("formLogin")),
        contentType: false,
        processData: false,
        cache: false,
        success: function (dataResult) {
          let res = jQuery.parseJSON(dataResult);
          if (res.response == "SUCCESS") {
            document.location.href = "dashboard.php";
            $("#divMessage").html(res.message);
            $("#divMessage").css("color", "green");
          } else {
            $("#divMessage").html(res.message);
            $("#divMessage").css("color", "red");
          }
        },
      });
    }
  });
});
