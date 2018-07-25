<?php
header('Content-type: application/json');
$host   = "localhost";$user = "root";
$pwd    = "Desai_1985";$db   = "astroisha";
$mysqli = new mysqli($host, $user, $pwd, $db);

/* check connection */
if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
}
else
{
    $search     = ucfirst($_GET['term']);
    $query	= "SELECT jv_location.country,jv_location.state,jv_location.city, jv_location.latitude, jv_location.longitude, jv_timezone.tmz_words FROM jv_location, jv_timezone WHERE jv_location.timezone = jv_timezone.tmz_id AND city ='Bhavnagar'";
    $result	= mysqli_query($mysqli, $query);
    
    while($row  = mysqli_fetch_array($result))
    {
        if($row['state'] == 'none' || $row['state']=='')
        {
            $city       = $row['city'].", ".$row['country'];
        }
        else
        {
            $city       = $row['city'].", ".$row['state'].", ".$row['country'];
        }
        $lat        = $row['latitude'];
        $lon        = $row['longitude']; 
        $tmz        = $row['tmz_words'];
        $json[]     = array('label'=>$city, 'lat'=>$lat, 'lon'=>$lon, 'tmz'=>$tmz);
 
   }
    $data       = json_encode($json);
    print_r($data);
    
    
    
}
?>
