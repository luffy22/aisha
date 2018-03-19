<?php
if(isset($_POST['expert']))
{
    $country        = $_POST['locate'];

    //$country        = "IN";
    $host   = "localhost";$user = "astroxou_admin";
    $pwd    = "*Jrp;F.=OKzG";$db   = "astroxou_jvidya";
    $conn   = new mysqli($host, $user, $pwd, $db);
    /* check connection */
    if (mysqli_connect_errno()) 
    {
        echo "error";
        exit();
    }
    else
    {
        $expert         =       trim(substr($_POST['expert'],9));
        $service        =       'expert_fees';
        $query          =       "SELECT jv_users.name as name,jv_users.username as uname, jv_user_img.img_new_name as img_new_name,
                                    jv_user_img.img_name as img_name, jv_user_astrologer.city as city, jv_user_astrologer.country as country,
                                    jv_user_astrologer.info as info, jv_user_astrologer.max_no_ques as max_no_ques
                                    ,jv_user_astrologer.phone_or_report as phone_or_report FROM jv_users RIGHT JOIN jv_user_astrologer ON jv_user_astrologer.UserId = jv_users.id 
                                    RIGHT JOIN jv_user_img ON jv_user_img.user_id = jv_users.id WHERE jv_users.id = '".$expert."'";
        
        $query          =       mysqli_query($conn, $query);
        $result         = mysqli_fetch_array($query);
        $query1         =       "SELECT jv_expert_charges.country as country, jv_expert_charges.amount as amount, 
                                 jv_user_currency.currency as currency, jv_user_currency.curr_code as curr_code, 
                                 jv_user_currency.curr_full as curr_full FROM jv_expert_charges RIGHT JOIN 
                                 jv_user_currency ON jv_expert_charges.currency_ref = jv_user_currency.Curr_ID WHERE
                                 jv_expert_charges.user_id = '".$expert."' AND jv_expert_charges.service_for_charge='".$service."' AND 
                                 jv_expert_charges.country = '".$country."'";
        $query1         =       mysqli_query($conn, $query1);
        $row            = mysqli_num_rows($query1);
        if($row > 0)
        {
            $result1        =       mysqli_fetch_array($query1);
            $array          = array_merge($result, $result1);
        }
        else
        {
            flush($query1);
            $query1         =       "SELECT jv_expert_charges.country as country, jv_expert_charges.amount as amount, 
                                    jv_user_currency.currency as currency, jv_user_currency.curr_code as curr_code, 
                                    jv_user_currency.curr_full as curr_full FROM jv_expert_charges RIGHT JOIN 
                                    jv_user_currency ON jv_expert_charges.currency_ref = jv_user_currency.Curr_ID WHERE
                                    jv_expert_charges.user_id = '".$expert."' AND jv_expert_charges.service_for_charge='".$service."' AND 
                                    jv_expert_charges.country = 'ROW'";
            $query1         =       mysqli_query($conn, $query1);
            $result1        =       mysqli_fetch_array($query1);
            $array          = array_merge($result, $result1);
        }
        
        $json           = json_encode($array);
        echo $json;
    }
}
else
{
    echo "error";
    exit;
}
 /* 
 * $query          = "SELECT jv_users.id as user_id, jv_users.name as name,jv_users.username as uname, jv_user_img.img_new_name as img_new_name,
                            jv_user_img.img_name as img_name, jv_user_astrologer.city as city, jv_user_astrologer.country as country,
                            jv_user_astrologer.info as info, jv_user_astrologer.max_no_ques as max_no_ques
                            ,jv_user_astrologer.phone_or_report as phone_or_report FROM jv_users RIGHT JOIN jv_user_astrologer ON jv_user_astrologer.UserId = jv_users.id 
                            RIGHT JOIN jv_user_img ON jv_user_img.user_id = jv_users.id WHERE jv_users.id = '".$expert."'";
  * 
  * $query1          ->select($db->quoteName(array('a.country','a.amount','b.currency','b.curr_code','b.curr_full')))
                                    ->from($db->quoteName('#__expert_charges','a'))
                                    ->join('INNER', $db->quoteName('#__user_currency', 'b') . ' ON (' . $db->quoteName('a.currency_ref') . ' = ' . $db->quoteName('b.Curr_ID') . ')')
                                    ->where($db->quoteName('user_id').' = '.$db->quote($u_id).' AND '.
                                            $db->quoteName('service_for_charge').' = '.$db->quote($service).' AND '.
                                            $db->quoteName('country').' = '.$db->quote('RU'));
  * 
  * $query1         =       "SELECT jv_expert_charges.country as country, jv_expert_charges.amount as amount, 
                                 jv_user_currency.currency as currency, jv_user_currency.curr_code as curr_code, 
                                 jv_user_currency.curr_full as curr_full FROM jv_expert_charges INNER JOIN 
                                 jv_user_currency WHERE jv_expert_charges.currency_ref = jv_user_currency.Curr_ID WHERE
                                 jv_expert_charges.user_id = '".$expert."' AND jv_
 */
    
?>
