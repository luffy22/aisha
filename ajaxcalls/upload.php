<?php
$ds          = DIRECTORY_SEPARATOR;  //1
$storeFolder = 'images/profiles';   //2
 
if (!empty($_FILES)) {
     
    $tempFile   = $_FILES['file']['tmp_name'];          //3             
    $filename   = $_FILES['file']['name'];
    $img_id     = $_POST['img_id'];
    $u_id         = substr($img_id, 7);
    $info       = new SplFileInfo($filename);
    $ext        = $info->getExtension();
    $new_name   = 'img_'.date('Y-m-d-H-i-s').'_'.uniqid().".".$ext;
    $file_new   = rename($filename, $new_name);
    $targetPath = dirname(dirname( __FILE__ )). $ds. $storeFolder . $ds;  //4
    $targetFile =  $targetPath. $new_name;  //5
    //print_r($targetFile);exit;
    $upload		= move_uploaded_file($tempFile,$targetFile); //6
    if($upload)
    {
        $host   = "localhost";$user = "astroxou_admin";
        $pwd    = "*Jrp;F.=OKzG";$db   = "astroxou_jvidya";
        $mysqli = new mysqli($host, $user, $pwd, $db);
        /* check connection */
        if (mysqli_connect_errno()) 
        {
            return "error: Contact admin@astroisha.com to notify image does not upload";
            exit();
        }
        else
        {

            $query      = "UPDATE jv_user_img SET img_name='".$filename."', img_new_name='".$new_name."' WHERE user_id='".$u_id."'";
            $result	= mysqli_query($mysqli, $query);
            if(!$result)
            {
                return "error: Failed To Upload File. Please contact admin@astroisha.com";
            }
        }
    }
    else
    {
        echo "Unable to move file. Please contact admin@astroisha.com for more details.";
    }
}
?>     
