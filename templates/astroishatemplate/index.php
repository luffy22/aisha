<?php 
//error_reporting(0);       // uncomment on server 
defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<meta name="robots" content="index, follow" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/favicon.ico" type="image/x-icon" />
<link rel="icon" href="<?php echo $this->baseurl ?>/logo.png" type="image/x-icon">
<meta name="msvalidate.01" content="E689BB58897C0A89BDC88E5DF8800B2F" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/jquery-ui.structure.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/jquery-ui.theme.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/all.min.css" type="text/css" />
<link href="/aisha/index.php?format=feed&amp;type=rss" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
<link href="/aisha/index.php?format=feed&amp;type=atom" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
<link href="/aisha/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.min.js" language="javascript"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery-migrate.min.js" language="javascript"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery-ui.min.js" language="javascript"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap.min.js" language="javascript"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/common.js" language="javascript"></script>
</head>
<body>
<div class="container-fluid">
    <h1 class="display-4"><a id="display-4" href="<?php echo JUri::base(); ?>"><img src="<?php echo JUri::base(); ?>/logo.png" title="Click to navigate to Home Page" />Astro Isha</a></h1>
<div class="row">
    <div class="col-md-9 col-sm-9 col-xs-8" id="main">
        <jdoc:include type="modules" name="sidemenu" />
        <jdoc:include type="component" />
        <jdoc:include type="modules" name="content1" />
        ​<picture>
  
  <img src="images/astrologer.png" class="img-fluid img-thumbnail" alt="astrologer">
</picture>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4">
        <jdoc:include type="modules" name="right" />
    </div>
</div>
</div>
<jdoc:include type="modules" name="footer" />
</body>
</html>
