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
<!-- includes profile scope -->
<p></p>
<div class="" id="loginBtnDiv">
<button class="rpBtn" id="loginBtn" />Login via ID Token</button>
</div>
<br />
<script>
var newNonce=Date.now();
var authorizeEndpointLink="https://fidm.us1.gigya.com/oidc/op/v1.0/3_cQkWA59GszKEVKtE0704hqQMGhjNH99ZgJKSpVxonDSA5IE4mVsiPO32QQKPStMo/authorize?client_id=gbU8B24ZCDK1orqCL0CB99DY&response_type=id_token&redirect_uri=http://localhost:8080/OIDC/loggedIn.php&scope=openid%20profile%20data&nonce=" + newNonce;
$(document).on("click", "#loginBtn", function() {
window.location=authorizeEndpointLink;
});
</script>
</div><!-- /main_wrapper -->
</body>
</html>