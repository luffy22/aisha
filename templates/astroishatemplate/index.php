<?php 
//error_reporting(0);       // uncomment on server 
defined( '_JEXEC' ) or die( 'Restricted access' );
$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;
$title              = $doc->title;
/*$var             = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong><i class="fas fa-exclamation-circle"></i> Reports Closed.</strong> Due to office refurbishment work in progress all reports are closed. Only short and detailed answer are open. We regret for the inconvenience.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></button></div>';
if(!isset($_SESSION['var']))
{
    $_SESSION['var']    = $var;
    echo $_SESSION['var'];
}*/
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<title><?php echo $title; ?></title>
<meta name="robots" content="index, follow" />
<?php include_once (JPATH_ROOT.DS.'analyticstracking.php'); ?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/favicon.ico" type="image/x-icon" />
<link rel="icon" href="<?php echo $this->baseurl ?>/logo.png" type="image/x-icon">
<meta name="msvalidate.01" content="E689BB58897C0A89BDC88E5DF8800B2F" />
<meta property="fb:app_id" content="1092479767598458" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/all.min.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/popper.min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/common.js" type="text/javascript" language="javascript"></script>
<script
    src="https://www.paypal.com/sdk/js?client-id=AQTmuXv3b_AC_GBMrw7Mw53pWDUmpjbQI68g8ndsrxqXIFa4ORLQfj-5Pc0Vtko0tSBWUPpFuaG06m8J">
</script>
</head>
<body>
<div class="container-fluid">
	<p>
    <jdoc:include type="modules" name="top" />
    </p>
    <h1><a id="display-2" href="<?php echo JUri::base(); ?>" title="Navigate to Home Page"><img src="<?php echo JUri::base(); ?>/logo.png" title="Click to navigate to Home Page" class="img-fluid" />Astro Isha</a></h1>
    <div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12" id="main">
        <jdoc:include type="message" />
        <jdoc:include type="modules" name="sidemenu" />
        <jdoc:include type="modules" name="breadcrumb" />
        <jdoc:include type="component" />
        <jdoc:include type="modules" name="content1" />
        <jdoc:include type="modules" name="content2" />
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <jdoc:include type="modules" name="right" />
    </div>
</div>
</div>
<jdoc:include type="modules" name="footer" />
<?php
include_once (JPATH_ROOT.DS.'analyticstracking.php');
?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/cookieconsent.min.css" />
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#eaf7f7",
      "text": "#5c7291"
    },
    "button": {
      "background": "#56cbdb",
      "text": "#ffffff"
    }
  },
  "content": {
    "href": "https://www.astroisha.com/cookies-policy"
  }
})});
</script>
</body>
</html>
