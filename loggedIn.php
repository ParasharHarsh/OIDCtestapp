
<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
global $curlResult;
global $curlResult2;
global $json;
global $json0;
global $json1;
global $json2;
global $json3;
global $userInfoResult;
global $userInfojson;
global $reqResStatus;
global $fullUIInfo;
?>
<!DOCTYPE html>
<html>
<script>
//Convert hashed fragment to PHP GETable query string in return URI from Gigya
// id_token flow would normally be used with mobile devices, and would require the fragment
// for security reasons
if(window.location.hash !=="") {
torip=window.location.href;
torip=torip.replace('#', '?');
window.location.href=torip;
}
var curlResult = {};
</script>
<head>
<title>Gigya RP Demo Site</title>
<link rel="shortcut icon" href="favicon.ico?v=2" type="image/x-icon"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.0/beautify.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-base64@3.7.2/base64.min.js"></script>
<style type='text/css'>
/* ** --snipped-- ** */
</style>
</head>
<?php
$errors='';
global $validUser;
if (isset($_GET['id_token']) && $_GET['id_token'] !== "") {
$id_token = $_GET['id_token'];
} else {
$id_token = 'undefined';
$errors .='id_token was undefined.<br />';
}
if (isset($_GET['code']) && $_GET['code'] !== "") {
$code = $_GET['code'];
} else {
$code = 'undefined';
$errors .='code was undefined.<br />';
}
// Do a simple check to determine if the user arrived directly to the page (via copy/paste)
// Does not actually determine if user is authorized
// A production environment would require additonal logic after validating the code/token is authentic
if (($id_token !== 'undefined') && ($code ==='undefined')) {
$oidcResponseType = "id_token";
$validUser="true";
} else if (($id_token === 'undefined') && ($code !=='undefined')) {
$oidcResponseType = "code";
$validUser="true";
} else {
$oidcResponseType = "<span style=\"color: #e76468;\">No authorized user detected.</span>";
$validUser="false";
}
?>
<body>
<div class="" id="main_wrapper">
<div class="" id="logoDiv">
<a href="https://rp.demo.gigya.com/">
</a>
</div>
<input type="hidden" id="validUser" value='<?php echo $validUser; ?>' />
<h2>Gigya OIDC Demo RP Site</h2>
<h3 id="loginSuccessful">Login Successful</h3><h3 id="invalidLogin">Error</h3>
<script>
// This section has the same caveat as the validUser param above
validUser=document.getElementById('validUser').value;
if ((validUser == "true")) {
 document.getElementById('loginSuccessful').style.display='block';
 document.getElementById('invalidLogin').style.display='none';
} else {
 document.getElementById('loginSuccessful').style.display='none';
 document.getElementById('invalidLogin').style.display='block';
}
</script>
<!-- When the flow is detected as being id_token -->
<h4>Response Type: <?php echo $oidcResponseType ?></h4>
<div class="" id="idTokenDiv">
Complete JWT:<br />
<textarea id="successJWT" rows="8" style="width: 100%" readonly></textarea><br />
Part One:<br />
<textarea id="qrystrJWT1" rows="2" style="width: 100%" readonly></textarea><br />
Part One Decoded:<br />
<textarea id="qrystrJWT1b" rows="2" style="width: 100%" readonly></textarea><br />
Part Two:<br />
<textarea id="qrystrJWT2" rows="5" style="width: 100%" readonly></textarea><br />
Part Two Decoded:<br />
<textarea id="qrystrJWT2b" rows="6" style="width: 100%" readonly></textarea><br />
Part Three (signature):<br />
<textarea id="qrystrJWT3" rows="3" style="width: 100%" readonly></textarea><br />
</div>
<!-- When the flow is detected as being code -->
<div class="" id="codeFlowDiv">
This flow would normally be handled entirely on the server. These values are only echoed here for reference.<br /><br />
Code received from authorize endpoint (send this to the token endpoint):<br />
<textarea id="codeFlowCode" rows="2" style="width: 100%" readonly></textarea><br />
Access token (received from token endpoint; response[0]):<br />
<textarea id="qrystrJWT4" rows="2" style="width: 100%" readonly></textarea><br />
Decoded userinfo response (returned from userinfo endpoint in exchange for access_token (above)):<br />
<textarea class="" id="userInfoResponse" rows="12" style="width: 100%" readonly></textarea><br />
</div>
<div class="" id="serverRequestResponseDiv">
</div>
<script>
var oidcResponseType = '<?php echo $oidcResponseType ?>';
var clientSecret="h0zeiKcgv6Uxv3UeMPCXGlFNup6W1YJmIqpX9OPSLCPAfJWe-5PQTr-es-9P7hK_b72o-XbIiNTXknEKDIH6-A";
var qrystrJWT;
var splitJWT = {};
var qrystrJWT1;
var qrystrJWT2;
var qrystrJWT3;
var qrystrJWT1b;
var qrystrJWT2b;
var qrystrJWT5;
// If id_token flow
if (oidcResponseType === "id_token") {
document.getElementById('idTokenDiv').style.display='block';
document.getElementById('codeFlowDiv').style.display='none';
$(document).ready(function() {
qrystrJWT = '<?php echo $id_token ?>';
splitJWT = qrystrJWT.split('.');
document.getElementById('successJWT').value = qrystrJWT;
if (splitJWT.length === 3) {
qrystrJWT1 = splitJWT[0];
qrystrJWT2 = splitJWT[1];
qrystrJWT3 = splitJWT[2];
document.getElementById('qrystrJWT1').value=qrystrJWT1;
document.getElementById('qrystrJWT2').value=qrystrJWT2;
document.getElementById('qrystrJWT3').value=qrystrJWT3;
 document.getElementById('qrystrJWT1b').value=atob(qrystrJWT1);
 document.getElementById('qrystrJWT2b').value=atob(qrystrJWT2);
} else {
console.warn('The query string does not contain a valid JWT.');
}
});
// Else if code flow
} else if (oidcResponseType === "code") {
document.getElementById('idTokenDiv').style.display='none';
 document.getElementById('codeFlowDiv').style.display='block';
$(document).ready(function() {
qrystrAuthCode = '<?php echo $code ?>';
document.getElementById('codeFlowCode').value = qrystrAuthCode;
//console.log(qrystrAuthCode);
splitJWT = qrystrAuthCode.split('.');
request();
});
}

// The rest of the code below pertains almost entirely to the code flow
/* startCodeFlow CODE from the query string and sends it back to the token endpoint
in order to receive an access_token
 *********************************************************************************** */

	const request = async () => {
	var clientID = "gbU8B24ZCDK1orqCL0CB99DY";
	var clientSecret="h0zeiKcgv6Uxv3UeMPCXGlFNup6W1YJmIqpX9OPSLCPAfJWe-5PQTr-es-9P7hK_b72o-XbIiNTXknEKDIH6-A";
	var code = '<?php echo $code ?>';
	var url = "https://fidm.us1.gigya.com/oidc/op/v1.0/3_cQkWA59GszKEVKtE0704hqQMGhjNH99ZgJKSpVxonDSA5IE4mVsiPO32QQKPStMo/token?grant_type=authorization_code&code="+encodeURIComponent(code)+"&redirect_uri="+encodeURIComponent('http://localhost:8080/OIDC/loggedIn.php');
	
	console.log("URL",url);
				const response = await fetch(url, {
					method: 'POST',
					mode: 'cors',
					headers: new Headers({'Authorization': 'Basic '+btoa(clientID+":"+clientSecret)})
				  });
				  const json = await response.json();
    console.log(json);
	document.getElementById('qrystrJWT4').value = json.access_token;
	var nextUrl = "https://fidm.us1.gigya.com/oidc/op/v1.0/3_cQkWA59GszKEVKtE0704hqQMGhjNH99ZgJKSpVxonDSA5IE4mVsiPO32QQKPStMo/userinfo";
	var bearAccessToken="Bearer " + json.access_token;
				const accessResponse = await fetch(nextUrl, {
					method: 'POST',
					mode: 'cors',
					headers: new Headers({'Authorization': bearAccessToken})
				  });
				  const json2 = await accessResponse.json();
	document.getElementById('userInfoResponse').value = JSON.stringify(json2);
    console.log(json2);
	}
	
				  
	/*Call to token endpoint and userinfo endpoint needs to be server side. Client Secret cannot be exposed on client side. Only for the purpose of this demo we are making a fetch request.*/

/* THIS NOW RETURNS THE ACCESS TOKEN TO THE USER_INFO ENDPOINT TO GET THE USER'S INFO
 *********************************************************************************** */
</script>
<br /><br /><a href="http://localhost:8080/OIDC/myprofile.html" target="_blank" class="gigyaLink">CDC Portal</a><br /><br />
</div><!-- /main_wrapper -->
</body>
</html>