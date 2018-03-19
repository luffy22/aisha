<?php
class modTopContentHelper
{
    /**
     * Retrieves the hello message
     *
     * @param array $params An object containing the module parameters
     * @access public
     */    
    public function gettopview()
    {
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        /*$query 		->select($db->quoteName(array('id','alias','asset_id','title','introtext','catid', 'hits')))
                                ->from($db->quoteName('#__content'))
                                 ->order('hits DESC'.' LIMIT 5');*/
        $query          = "SELECT jv_content.id AS article_id, jv_content.alias as article_alias,
                            jv_content.asset_id AS article_assetid,jv_content.title, jv_content.images as images, LEFT(jv_content.introtext,500) AS article_text,
                            jv_content.hits, jv_categories.alias AS cat_alias, jv_content.catid as cat_id, jv_categories.title as cat_title FROM jv_content INNER JOIN jv_categories
                            ON jv_content.catid = jv_categories.id WHERE state=1 ORDER BY hits DESC LIMIT 5";     
        $db->setQuery($query);
      
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();
        
        return $results;
    }
    
    public function getRecentTop()
    {
        $today         = new DateTime('NOW');
        $todate        = $today->format('Y-m-d H:i:s');
        $today    ->sub(new DateInterval('P0Y3M0DT0H0M0S'));
        $month_6        = $today->format('Y-m-d H:i:s');
        
        $db             = JFactory::getDbo();  // Get db connection
        $query          = $db->getQuery(true);
        
        $query          = "SELECT jv_content.id AS article_id, jv_content.alias as article_alias, jv_content.created as article_create,
                            jv_content.asset_id AS article_assetid,jv_content.title,jv_content.images as images, LEFT(jv_content.introtext,500) AS article_text,
                            jv_content.hits, jv_categories.alias AS cat_alias, jv_content.catid as cat_id, jv_categories.title as cat_title FROM jv_content INNER JOIN jv_categories
                            ON jv_content.catid = jv_categories.id AND created between '$month_6' AND '$todate' where state=1 
                            ORDER BY hits DESC LIMIT 5";
        
        $db->setQuery($query);
      
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();
        
        return $results;
    }
    // Below function checks if browser is of mobile or pc
    // Function does not work
   /* public function checkmobile_pc()
    {
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
        {
            return true;
        }
        else
        {
            return false;
        }	
    }*/
}
?>

