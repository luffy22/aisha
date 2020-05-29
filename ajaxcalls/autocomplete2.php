<?php
header('Content-type: application/json');
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
    $query	= "SELECT DISTINCT country FROM jv_location WHERE country='$search' OR country LIKE '$search%' LIMIT 5";
    $result	= mysqli_query($mysqli, $query);
    $json 	= array();
    while($row  = mysqli_fetch_array($result))
    {
        $country          = $row['country'];
        $json[]             = array('label'=>$country);
 
   }
    $data       = json_encode($json);
    echo $data; 
}
?>
