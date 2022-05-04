<?php
//error_reporting(0);       // uncomment on server 
defined( '_JEXEC' ) or die( 'Restricted access' );
$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;
$title              = $doc->title;
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
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/common.js" type="text/javascript" language="javascript"></script>
</head>
<body>
	<div class="mb-3"></div>
<div class="container-fluid">
<div class="row">
	<jdoc:include type="modules" name="top" /> 
</div>	
<div class="row">
	<div class="col-lg-8" id="main">
                <jdoc:include type="message" />
		<jdoc:include type="modules" name="breadcrumb" /> 
		<jdoc:include type="component" />
		<jdoc:include type="modules" name="menu_1" />
                <jdoc:include type="modules" name="menu_2" />
		<jdoc:include type="modules" name="footer" />
	</div>
	<div class="col-lg-4">
		<jdoc:include type="modules" name="right" /> 
	</div>
</div>	
<?php include_once (JPATH_ROOT.DS.'analyticstracking.php'); ?>
</body>
</html>
