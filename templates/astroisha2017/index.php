<?php
error_reporting(0);       // uncomment on server
defined('_JEXEC') or die;
$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;
// Output as HTML5
$doc->setHtml5(true);
// Add Stylesheets
$sitename = $app->get('sitename');
$doc->setGenerator("Astro Isha Inc.");
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<meta name="robots" content="index, follow" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/favicon.ico" type="image/x-icon" />
<link rel="icon" href="<?php echo $this->baseurl ?>/logo.png" type="image/x-icon">
<meta name="msvalidate.01" content="E689BB58897C0A89BDC88E5DF8800B2F" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap-flex.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/jquery-ui.structure.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/jquery-ui.theme.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/font-awesome.min.css" type="text/css" />
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/tether.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery-ui.min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/common.js" type="text/javascript" language="javascript"></script>
<jdoc:include type="head" />
</head>
<body>
    <?php
 // Get option and view
$option = JRequest::getVar('option');
$view = JRequest::getVar('view');
// Make sure it is a single article
if ($option == 'com_content' && $view == 'article'):
  $id = JRequest::getInt('id');
?>
<div id="<?php echo $id; ?>" class="accordion-id"></div>
<?php
endif;
?>
<div id="fb-root"></div>
<jdoc:include type="modules" name="topmenu" style="none" />
<div class="mb-1"></div>
<jdoc:include type="modules" name="jbanner" style="none" />
<div class="mb-1"></div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
<script>
  (function() {
    var cx = '006812877761787834600:wz19pryi_e0';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>
<div class="mb-1"></div>
<?php
    if ($option == 'com_content' && $view == 'article'):
    $id = JRequest::getInt('id');
endif;
?>
    <jdoc:include type="modules" name="breadcrumb" style="none" />
    <div class="mb-1"></div>
    <jdoc:include type="message" />
    <div class="mb-1"></div>
     <jdoc:include type="modules" name="articleslider" style="none" />
     <div class="mb-1"></div>
    <jdoc:include type="component" />   
    <div class="mb-1"></div>
    <jdoc:include type="modules" name="relatedarticles" style="none" />
    <div class="mb-1"></div>
    </div>
    <div class="col-md-4">
        <div class="mt-1"></div>
        <jdoc:include type="modules" name="sidebar" style="none" />    
    </div>
    </div>
</div>
<div class="mb-2"></div>
<jdoc:include type="modules" name="footer2" style="none" />
<jdoc:include type="modules" name="footer" style="none" />
<script>
  window.fbAsyncInit = function() {FB.init({appId      : '220390744824296',xfbml      : true,version    : 'v2.4'});};
  (function(d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));
</script>
<?php
include_once (JPATH_ROOT.DS.'analyticstracking.php');
?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>
