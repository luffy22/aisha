<body onload="hidefields()">
<script>
function showfields()
{
    $('#profile_hidden').show();
    document.getElementById("profile_hidden").style.visibility = 'visible';
}
function hidefields()
{
    $('#profile_hidden').hide();
    document.getElementById("profile_hidden").style.visibility = 'hidden';
    //alert("calls");
}
</script>
<?php
//print_r($this->msg);exit;
//$time   = new DateTime();
//$time   ->setTimeStamp($this->msg['tob']);
//$time   = $time->format('Y-m-d H:i:s');
//echo $time;exit;
$array  = explode(":",$time);
//defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
if($user->guest)
 {
    $location   = JURi::base()."login";
    echo header('Location: '.$location);
 }
else
{
    if(isset($_GET['terms'])&&($_GET['terms']=='no'))
    {
?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Kindly accept the Terms and Conditions if you wish to join as an Astrologer.</div>
<?php
    }

?>
<h1 class="display-3">Extended Profile</h1>
<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Fields marked with asterix(*) are compulsory</div>
<form enctype="application/x-www-form-urlencoded" method="post" action="<?php echo JRoute::_('index.php?option=com_extendedprofile&task=extendedprofile.updateUser'); ?>">
    <input type="hidden" value="<?php echo $this->msg['UserId'] ?>" name="profile_id" />
<div class="form-group">
        <label for="astro_name">Name:</label>
    <?php
        if(!empty($this->msg['name']))
        {
    ?>
        <input type="text" value="<?php echo $this->msg['name']; ?>" id="astro_name" class="form-control" />
    <?php
        }
        else
        {
    ?>
        <input type="text" id="astro_name" class="form-control" placeholder="Enter your Name" />
    <?php
        }
    ?>
</div>
<div class="form-group">
         <label for="inputGender" class="control-label">Gender:</label>
<?php 
        if($this->msg['gender'] == "female")
        { 
?>
         <input type="radio" name="gender_profile" value="male" id="lagna_gender1"  /> Male
        <input type="radio" name="gender_profile" value="female" id="lagna_gender2" checked="checked" /> Female
<?php
        }
        else if($this->msg['gender'] == "male")
        {
?>
        <input type="radio" name="gender_profile" value="male" id="lagna_gender1" checked="checked" /> Male
        <input type="radio" name="gender_profile" value="female" id="lagna_gender2"  /> Female
<?php
        }
        else
        {
?>
         <input type="radio" name="gender_profile" value="male" id="lagna_gender1"  /> Male
        <input type="radio" name="gender_profile" value="female" id="lagna_gender2" checked="checked" /> Female
<?php
        }
?>
    </div>
<div class="form-group">
    <label for="dob_profile">Date Of Birth*: </label>
    <?php
        if(!empty($this->msg['dob']))
        {
    ?>
    <input type="date" class="form-control" name="dob_profile" id="dob_profile" placeholder="Enter your date of birth" min="1910-01-01" max="2050-12-31" required 
           value="<?php echo $this->msg['dob'] ?>" />
    <?php
        }
        else
        {
    ?>
    <input type="date" class="form-control" name="dob_profile" id="dob_profile" placeholder="Enter your date of birth" min="1910-01-01" max="2050-12-31" required 
            />
    <?php
        }
    ?>
</div>   
<div class="form-group">
    <label for="tob_profile">Time Of Birth(24 Hour Format)*: </label>
    <select class="select2" name="tob_profile_hr">
    <?php
    for($i=0;$i<23;$i++)
    {
        if($i < 10)
        {
            if($i==$array[0])
            {
?>
                <option value="<?php echo "0".$i ?>" selected><?php echo "0".$i ?></option>
<?php
            }
            else
            {
    ?>
        <option value="<?php echo "0".$i ?>"><?php echo "0".$i ?></option>
    <?php
            }
        }
        else
        {
            if($i==$array[0])
            {
?>
                <option value="<?php echo $i ?>" selected><?php echo $i ?></option>
<?php
            }
            else
            {
    ?>
    ?>
        <option value="<?php echo $i ?>"><?php echo $i; ?></option>
    <?php
            }
        }
    }
    ?>
    </select>
    <select class="select2" name="tob_profile_min">
    <?php
    for($i=0;$i<60;$i++)
    {
        if($i < 10)
        {
            if($i==$array[1])
            {
?>
                <option value="<?php echo "0".$i ?>" selected><?php echo "0".$i ?></option>
<?php
            }
            else
            {
    ?>
        <option value="<?php echo "0".$i ?>"><?php echo "0".$i ?></option>
    <?php
            }
        }
        else
        {
            if($i==$array[1])
            {
?>
                <option value="<?php echo $i ?>" selected><?php echo $i ?></option>
<?php
            }
            else
            {
    ?>
                <option value="<?php echo $i ?>"><?php echo $i; ?></option>
    <?php
            }
        }
    }
    ?>
    </select>
    <select class="select2" name="tob_profile_sec">
    <?php
    for($i=0;$i<60;$i++)
    {
        if($i < 10)
        {
            if($i==$array[2])
            {
?>
                <option value="<?php echo "0".$i ?>" selected><?php echo "0".$i ?></option>
<?php
            }
            else
            {
    ?>
                <option value="<?php echo "0".$i ?>"><?php echo "0".$i ?></option>
    <?php
            }
        }
        else
        {
            if($i==$array[2])
            {
?>
                <option value="<?php echo $i ?>" selected><?php echo $i ?></option>
<?php
            }
            else
            {
    ?>
                <option value="<?php echo $i ?>"><?php echo $i; ?></option>
    <?php
            }
        }
    }
    ?>
    </select>
</div>
<div class="form-group">
    <label for="pob_profile">Place Of Birth*: </label>
    <?php
        if(!empty($this->msg['pob']))
        {
    ?>
    <input type="text" name="pob_profile" id="pob_profile" value="<?php echo $this->msg['pob'] ?>"
           placeholder="Enter Your Place Of Birth" class="form-control" required />
    <?php
        }
        else
        {
    ?>
    <input type="text" name="pob_profile" id="pob_profile" 
           placeholder="Enter Your Place Of Birth" class="form-control" required />
    <?php
        }
    ?>
</div>
<div class="form-group">
        <label for="longitude" class="control-label">Longitude</label><br>
        <input type="text" id="lagna_long_1" class="form-text" name="lon_deg">
        <input type="text" id="lagna_long_2" class="form-text" name="lon_min">
        <select class="select2" id="lagna_long_direction" name="lon_dir">
            <option>E</option>
            <option>W</option>
        </select>

    </div>
    <div class="form-group">
        <label for="latitude" class="control-label">Latitude</label><br>
        <input type="text" id="lagna_lat_1" class="form-text" name="lat_deg">
        <input type="text" id="lagna_lat_2" class="form-text" name="lat_min">
        <select class="select2" id="lagna_lat_direction" name="lat_dir">
            <option>N</option>
            <option>S</option>
        </select>
    </div>
    <div class="form-group">
        <label for="latitude" class="control-label">Timezone: <strong>GMT</strong></label>
        <input type="text" id="lagna_timezone" class="form-text" name="lagna_timezone">
    </div>
    <div class="form-group">
        <label for="lagna_dst" class="control-label">DST/Summer War:</label>
        <select class="select2" name="lagna_dst" id="lagna_dst">
            <option value="00:00:00">None</option>
            <option value="01:00:00">One Hour</option>
            <option value="02:00:00">Two Hour</option>
            <option value="03:00:00">Three Hour</option>
        </select>
        <a href="http://www.timeanddate.com/time/dst/" title="Click on link to understand about Daylight Saving Timings" target="_blank">What is DST?</a>
    </div>
<div class="form-group">
    <?php
        if($this->msg['data'] == "nodata")
        {
    ?>
        <button type="submit" name="save_profile" class="btn btn-primary" >Save</button>
    <?php
        }
        else
        {
    ?>
        <button type="submit" name="update_profile" class="btn btn-primary" >Update</button>
    <?php
        }
    ?>
        <button type="reset" name="cancel" class="btn btn-navbar">Cancel</button>
    </div>
</form>
<?php
}
?>
</body>