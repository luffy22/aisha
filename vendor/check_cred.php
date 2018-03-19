<?php
include_once('bootstrap.php');
use PayPal\Api\RedirectUrls;
$baseUrl = getBaseUrl();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../templates/astroisha2.0/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="../templates/astroisha2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../templates/astroisha2.0/css/style.css" />
    <link rel="stylesheet" type="text/css" href="../templates/astroisha2.0/css/template.css" />
</head>
<body>
<div class="container">
    <h3>Login Form</h3>
   <form action="<?php echo $baseUrl; ?>/show_order.php" method="post" enctype="">
  <div class="form-group">
    <label for="exampleInputUname">Username</label>
    <input type="text" class="form-control" id="exampleInputUname" name="user" placeholder="Username" />
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="pwd" placeholder="Password" />
  </div>
  <button type="submit" class="btn btn-primary" name="submit" value="yes">Submit</button>
</form>
</div>
</body>
</html>