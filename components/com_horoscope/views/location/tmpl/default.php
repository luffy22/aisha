<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();
$redirect 		= $_GET['location'];
//echo $redirect;exit;
?>
<body>

<form class="form-inline" enctype="application/x-www-form-urlencoded" method="post" 
      action="<?php echo JRoute::_('index.php?option=com_horoscope&task=location.getLocation'); ?>">
  <label for="inlineFormInput">Location:&nbsp;</label>
    <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" name="muhurat_loc" id="muhurat_loc" placeholder="New Delhi, India" />
    <input type="hidden" id="muhurat_lat" name="muhurat_lat" />
    <input type="hidden" id="muhurat_lon" name="muhurat_lon" />
    <input type="hidden" id="muhurat_tmz" name="muhurat_tmz" />
    <input type="hidden" id="muhurat_redirect"  name="muhurat_redirect" value =<?php echo $redirect ?> />
    <div class="mb-3"></div>
    <button type="submit" class="btn btn-primary mr-sm-2" name="muhurat_submit">Save</button>
    <button type="button" class="btn btn-danger">Cancel</button>
</form>
<div class="mb-3"></div>
<link rel="stylesheet" href="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.css' ?>" type="text/css" />
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_astrologin/script/jquery-ui.min.js' ?>"></script>
<script type="text/javascript"  src="<?php echo JUri::base().'components/com_horoscope/script/muhurat.js' ?>">
</script>
<div class="mb-3"></div>
</body>
