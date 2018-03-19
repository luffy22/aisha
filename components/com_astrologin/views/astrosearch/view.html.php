<?php
defined('_JEXEC') or die('Restricted access');

class AstroLoginViewAstroSearch extends JViewLegacy
{
    /*
    * Display the extended profile view
    */
    var $astro;
    var $pagination;
    var $expert;
    function display($tpl = null)
    {
        $user   = $this->get('Astro');
        //print_r($user);exit;
        if(empty($user))
        {
            $this->astro = $this->get('Data');
            $this->pagination = $this->get('Pagination'); 
            parent::display($tpl);
        }
        else
        {
            $this->astro    = $user;
            $this->expert    = $this->get('Expert');
            parent::display("user");
        }
       // print_r($this->pagination);exit;
       
    }
    function showDetails($data)
    {
       $this->astro     = $data;
       parent::display('info');
    }
    
}
