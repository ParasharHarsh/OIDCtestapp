<!DOCTYPE html>
<html>
<head>
<title>demo.gigya.com | OIDC RP Site</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<style type='text/css'>
/* ** --snipped-- ** */
</style>
</head>
<body>
<div class="" id="main_wrapper">
<h2>Gigya OIDC Demo RP Site</h2>
<p></p>
<div class="" id="loginOptions">
<h3>Select which flow you would like to use</h3>
<button class="rpBtn" id="idTokenBtn" />ID Token</button>
<button class="rpBtn" id="codeBtn" />Auth Code</button>
</div>
<script>
$(document).ready(function() {
//document.getElementById('codeBtn').disabled=true;
$(document).on("click", "#idTokenBtn", function() {
window.location="index_idToken.php";
});
//$(document).on("click", "#codeBtn", function() {
// window.location="index_code.php";
//});
$(document).on("click", "#codeBtn", function() {
window.location="auth.php";
});
})
</script>
</div><!-- /main_wrapper -->
</body>
</html>