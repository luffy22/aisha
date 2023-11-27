<?php
error_reporting(0);       // uncomment on server 
defined( '_JEXEC' ) or die( 'Restricted access' );
$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;
$title              = $doc->title;
/*$var             = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<strong><i class="bi bi-exclamation-triangle-fill fs-1"></i> Orders Closed.</strong> Orders are temporarily closed until 18th September 2023. We apologize for any inconvenience caused.
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
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
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/favicon.ico" type="image/x-icon" />
<link rel="icon" href="<?php echo $this->baseurl ?>/logo.png" type="image/x-icon">
<meta name="msvalidate.01" content="E689BB58897C0A89BDC88E5DF8800B2F" />
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"><link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/common.js" type="text/javascript" language="javascript"></script>
</head>
<body>
<div class="container-fluid">
<div class="alert alert-warning alert-dismissible fade show" role="alert">
<strong><i class="bi bi-exclamation-triangle-fill fs-1"></i> Orders Closed.</strong> Orders are temporarily closed until 5th December 2023. We apologize for any inconvenience caused. In case of emergency please get in touch via <a href="https://wa.me/9870036765">whatsapp <i class="bi bi-whatsapp"></i></a>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<div class="d-flex flex-row mb-3">
	<div class="p-2"><a href="<?php echo JUri::base(); ?>"><img src="<?php echo JUri::base(); ?>/logo.png" title="Click to navigate to Home Page" class="img-fluid" /></a></div>
	<div class="pt-2">
		<h1 class="display-3"><a id="display-2" href="<?php echo JUri::base(); ?>" title="Navigate to Home Page">Astro Isha</a></h1>
		<p class="lead">Site on Vedic Astrology</p>
	</div>
</div>

<div class="row">   
    <div class="col-2">
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <i class="bi bi-list"></i>
    </button>
    </div><div class="mb-3"></div>
	<jdoc:include type="modules" name="top" /> 
</div>	
<div class="row">
    	<div class="col-lg-8" id="main">
                <jdoc:include type="message" />
                <jdoc:include type="modules" name="left" /> 
		<jdoc:include type="modules" name="breadcrumb" /> 
		<jdoc:include type="component" />
		<jdoc:include type="modules" name="menu_1" />
                <jdoc:include type="modules" name="menu_2" />
	</div>
	<div class="col-lg-4">
		<jdoc:include type="modules" name="right" /> 
	</div>
</div>
</div>
<jdoc:include type="modules" name="footer" /> 
<script async src="https://cse.google.com/cse.js?cx=006812877761787834600:wz19pryi_e0"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JRYDTR6DD6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JRYDTR6DD6');
</script>
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
<script
    src="https://www.paypal.com/sdk/js?client-id=AQTmuXv3b_AC_GBMrw7Mw53pWDUmpjbQI68g8ndsrxqXIFa4ORLQfj-5Pc0Vtko0tSBWUPpFuaG06m8J">
</script>
</body>
</html>
