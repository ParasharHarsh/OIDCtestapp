<html>
<head>
<title>OIDC Error Page</title>
<style>
/* ** --snipped-- ** */
</style>
</head>
<body>
<h2>Gigya OIDC OP Error Page</h2>
<div class="responseDiv" id="errorCode" style="width: 95%; overflow: auto; text-align: left; margin: 20px auto; font-weight: 700; font-size: 22px;">
</div>
<div class="responseDiv" id="errorMessage" style="width: 95%; overflow: auto; text-align: left; margin: 0px auto;">
</div>
<script>
let urlParams = new URLSearchParams(window.location.search);
let encodedErrMsg = urlParams.get('message');
encodedErrMsg = decodeURIComponent(encodedErrMsg);
let errMsg = encodedErrMsg.replaceAll('+',' ');
let errCode = urlParams.get('code');
document.getElementById('errorCode').innerHTML = errCode;
document.getElementById('errorMessage').innerHTML = errMsg;
</script>
</body>
</html>