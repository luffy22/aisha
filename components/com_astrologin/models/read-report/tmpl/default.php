
<?php
defined('_JEXEC') or die('Restricted access');
if(isset($_GET['order']))
{
    $order      = $_GET['order'];
}
if(isset($_GET['ref']))
{
    $refemail   = $_GET['ref'];
}
  
$jinput             = JFactory::getApplication()->input;
$jinput->set('order',  $order, 'string');
?>
<h3>Get Answer</h3>

