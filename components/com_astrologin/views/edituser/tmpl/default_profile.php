
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$details                    = $this->data;
//print_r($details);exit;

?>
<div class="lead alert alert-dark">Edit Details</div>
<form name="edit_details" method="post" enctype="application/x-www-form-urlencoded" action="<?php echo JRoute::_('?option=com_astrologin&task=edituser.editdetails') ?>">
    <input type="hidden" name="edit_uid" value="<?php echo $this->data['id'] ?>" />
    <div class="form-group">
        <label for="fname">Name: </label>
        <input type="text" name="edit_fname" class="form-control" id="edit_fname"  placeholder="Enter name" value="<?php echo $this->data['name'] ?>" required />
    </div>
     <div class="form-group">
        <label for="uname">Username: </label>
        <input type="text" name="edit_uname" class="form-control" id="edit_uname"  placeholder="Enter username" value="<?php echo $this->data['username'] ?>" required />
    </div>
    <div class="form-group">
        <label for="email">Email: </label>
        <input type="email" name="edit_email" class="form-control" id="edit_email"  placeholder="Enter email" value="<?php echo $this->data['email'] ?>" required />
    </div>
    <P id="pwd_msg">Leave password empty if no desire to change</P>
    <div class="form-group">
        <label for="pwd1">Password(optional): </label>
        <input type="password" name="edit_pwd1" class="form-control" id="edit_pwd1"  placeholder="Enter password"  />
    </div>
    <div class="form-group">
        <label for="pwd2">Confirm Password(optional): </label>
        <input type="password" name="edit_pwd2" class="form-control" id="edit_pwd2"  placeholder="Re-enter password"  />
    </div>
     <div class="btn-group btn-group-lg">
            <button type="submit" class="btn btn-primary btn-lg" name="edit_submit" id="edit_submit">Submit</button>
            <button type="reset" class="btn btn-danger btn-lg">Reset</button>
    </div>
</form>
