<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('GSSDK.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Open ID Connect Consent Page</title>
    <script type="text/javascript" src="https://cdns.gigya.com/js/gigya.js?apiKey=4_pt4PEpU8zX3VqxJrc0C0IA"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    
</head>
<body>
<h2>Gigya OIDC OP Consent Page</h2>
<div class="standardDiv" id="errorsDiv">
    <?php
    $secret="MjCMcS9DCY5x3uf56fwpro6tIlxIloR4";
	$key="AA0hvmjp7QCz";
    $errors="";
    $errorsExist = 'false';
    if (isset($_GET['context']) && $_GET['context'] !== "") {
        $context = $_GET['context'];
    } else {
        $context = 'undefined';
        $errors .='context was undefined.<br />';
    }
    if (isset($_GET['clientID']) && $_GET['clientID'] !== "") {
        $clientID = $_GET['clientID'];
    } else {
        $clientID = 'undefined';
        $errors .='clientID was undefined.<br />';
    }
    if (isset($_GET['scope']) && $_GET['scope'] !== "") {
        $scope = $_GET['scope'];
        $scope = preg_replace('/[+]/', ' ', $scope);
    } else {
        $scope = 'undefined';
        $errors .= 'scope was undefined.<br />';
    }
    if (isset($_GET['UID']) && $_GET['UID'] !== "") {
        $UID = $_GET['UID'];
    } else {
        $UID = 'undefined';
        $errors .= 'UID was undefined.<br />';
    }
    if (isset($_GET['UIDSignature']) && $_GET['UIDSignature'] !== "") {
        $UIDSignature = $_GET['UIDSignature'];
    } else {
        $UIDSignature = 'undefined';
        $errors .= 'UIDSignature was undefined.<br />';
    }
    if (isset($_GET['signatureTimestamp']) && $_GET['signatureTimestamp'] !== "") {
        $signatureTimestamp = $_GET['signatureTimestamp'];
    } else {
        $signatureTimestamp = 'undefined';
        $errors .= 'signatureTimestamp was undefined.<br />';
    }
    if ($errors !== "") {
        $errors = "<br />There may be errors processing your request due to missing or incorrect values: <br /><br />".errors."<br /><br />";
        echo $errors;
    }
    if (($scope ==="undefined") || ($clientID === "undefined") || ($context === "undefined") || ($UID === "undefined")) {
        echo "<br /><br /><span style='font-weight: bold; color: red;'>Too many errors occurred; please try again.</span>";
        $errorsExist = 'true';
    } else {
    //construct signature
    $consentObject = json_encode(array(
        "scope" => $scope,
        "clientID" => $clientID,
        "context" => $context,
        "UID" => $UID,
        "consent" => true
    ));
    $consentO2 = utf8_encode($consentObject);
    $rawHmac = hash_hmac("sha1", utf8_encode($consentO2), base64_decode($secret), true);
    $consentSignature= base64_encode($rawHmac);
    $consentSignature= preg_replace("/=$/", "", $consentSignature);
    $consentSignature= preg_replace("/=$/", "", $consentSignature);
    $consentSignature= preg_replace("/[+]/", "-", $consentSignature); // -
    $consentSignature= preg_replace("/\//", "_", $consentSignature); // _
    }
    ?>
</div><!-- /errorsDiv -->

<div class="wrapper" id="main_wrapper">
    <div id="errorsSwitch">
        <br /><br />There were errors detected. Check this box to view: <input type="checkbox" value='' id="errorsSwitchCheck" /><br /><br />
        <!--script>
            var rpBackLink=function() {
                window.history.back;
            };
        </script>
        <a href="https://rp.demo.gigya.com/">Return to the Main page</a-->.
    </div>
    <script>
        var consentSignature = '<?php echo $consentSignature ?>';
        var consentObject = '<?php echo $consentObject ?>';
        var userKey = '<?php echo $key ?>';
    </script>
    
    <div class="content" id="consent_content">
        By clicking the button below you agree to share your data from the Gigya <a href="https://demo.gigya.com" target="_blank">Demo Site</a> with the Gigya <a href="https://rp.demo.gigya.com/" target="_blank">RP Site</a>.
        <!--<br />
        <input type="checkbox" id="consentYes" value="true" />&nbsp;&nbsp;&nbsp;<input type="checkbox" value="false" id="consentNo" /> -->
        <br />
        <br />
        In a production environment you would now give the user a chance to approve/disapprove the requested scopes and/or perform logic to determine if the user has previously consented and skip redundant consent. 
        <br />
        <br />
        For the purposes of this demo, you are agreeing to share your email address and basic profile claims as defined in the <a href="http://developers.gigya.com/display/GD/fidm.oidc.op.createRP+REST#fidm.oidc.op.createRPREST-Parameters" target="_blank">allowedScopes</a> parameter.
        <br />
        <br />
        <button class="rpBtn" id="submitConsent">Grant Consent</button><br /><br />
    </div><!-- /consent_content -->
</div><!-- /main_wrapper -->
<script>
$(document).ready(function () {
    var errorsExist = '<?php echo $errorsExist ?>';
    if (errorsExist === 'true') {
        document.getElementById('errorsSwitch').style.display='block';
		document.getElementById('errorsDiv').style.display='none';
        document.getElementById('submitConsent').disabled=true;
        //document.getElementById('submitConsent').className='rpBtn_disabled';
    }
	else{
		document.getElementById('errorsSwitch').style.display='none';
	}
    //errorsSwitchCheck
    $("#errorsSwitchCheck").click(function(){
        if (document.getElementById('errorsSwitchCheck').checked === true) {
            document.getElementById('errorsDiv').style.display='block';
        } else {
            document.getElementById('errorsDiv').style.display='none';
        }    
    });
    $("#submitConsent").click(function(){
        var proxyURL="OIDCProxyPage.php?mode=afterConsent&consent=" + consentObject + "&sig=" + consentSignature + "&userKey=" + userKey;
        window.location.href=proxyURL;
    });
});
</script>
</body>
</html>