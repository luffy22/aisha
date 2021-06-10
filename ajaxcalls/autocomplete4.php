<?php
header('Content-Type: text/html;charset=utf-8');
$host   = "localhost";$user = "astroxou_admin";
$pwd    = "*Jrp;F.=OKzG";$db   = "astroxou_jvidya";
$mysqli = new mysqli($host, $user, $pwd, $db);
$mysqli->set_charset("utf8");
/* check connection */
if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
}
else
{
    $search     = ucfirst($_GET['term']);
    ///$query	= "SELECT jv_location.country,jv_location.state, jv_location.city, jv_location.latitude, jv_location.longitude, jv_timezone.tmz_words FROM jv_location, jv_timezone WHERE "
            // "     city LIKE '$search%' OR state LIKE '$search%' AND jv_location.timezone = jv_timezone.tmz_id LIMIT 1";
    $query	= "SELECT * FROM jv_location WHERE city='$search' OR country='$search' OR city LIKE '$search%' OR country LIKE '$search%' LIMIT 25";
    $result	= mysqli_query($mysqli, $query);
    $json 	= array();
    while($row  = mysqli_fetch_array($result))
    {
        $pl_id          = $row['id'];
        if($row['state'] == 'none' || $row['state']=='')
        {
            $city       = $row['city'].", ".$row['country'];
        }
        else
        {
            $city       = $row['city'].", ".$row['state'].", ".$row['country'];
        }
        $lat            = $row['latitude'];
        $lon            = $row['longitude']; 
        
        $json[]             = array('label'=>$city, 'lat'=>$lat, 'lon'=>$lon, 'pl_id'=>$pl_id);
 
   }
    $data       = json_encode($json);
    echo $data; 
}
?>
