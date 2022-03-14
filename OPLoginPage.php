<html>
<head>
<title>OIDC Login Page | demo.gigya.com</title>
<script type="text/javascript" src="https://cdns.gigya.com/js/gigya.js?apiKey=3_cQkWA59GszKEVKtE0704hqQMGhjNH99ZgJKSpVxonDSA5IE4mVsiPO32QQKPStMo"></script>
<style>
/* ** --snipped-- ** */
</style>
</head>
<body>
<h2>Gigya OIDC OP Login Page</h2>
<div id="container"></div>
<script>
function redirectToProxy() {
var url = gigya.utils.URL.addParamsToURL("OIDCProxyPage.php",{
mode: 'afterLogin'
});
window.location.href = url;
}
gigya.socialize.addEventHandlers({
onLogin: function() {
redirectToProxy();
}
});
locale = (window.navigator.language || window.navigator.userLanguage) == "fr-CA"? "fr": (window.navigator.language || window.navigator.userLanguage);
customButtons= [{
	"type": "oidc",
	"providerName":"Azure OIDC",
	"opName":"testwebapp",
	"iconURL": "https://drive.google.com/uc?id=1pvAjtf0NqeiBJWDwZC0A4fRVwPIvx8d5",
	"lastLoginIconURL":"https://drive.google.com/uc?id=1pvAjtf0NqeiBJWDwZC0A4fRVwPIvx8d5"
	}]
gigya.accounts.showScreenSet({
screenSet: 'Default-RegistrationLogin',
startScreen: 'gigya-login-screen',
sessionExpiration: '14400',
lang: locale,
customButtons
});
</script>
</body>
</html>