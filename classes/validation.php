<?php

namespace classes;

use classes\core\validation as validationAbstract ;

require_once 'core/validation.php';

class validation extends validationAbstract {

    private function busCapacity($capacity)
    {
        if ($capacity == 0 ) return false;
        return filter_var($capacity, FILTER_VALIDATE_INT);
    }

    private function truckCapacity($capacity)
    {
        if ($capacity == 0 ) return false;
        return filter_var($capacity, FILTER_VALIDATE_FLOAT);
    }

    function checkCapacity($type,$capacity)
    {
        switch ($type)
        {
            default  : return false; break;
            case 2 :   return $this->busCapacity($capacity); break;
            case 3 :   return $this->truckCapacity($capacity); break;
        }
    }

    private function checkToRegion($region,$toregion)
    {
       return ( $region != $toregion && strlen($toregion) > 2 ) ;
    }

    function checkRegions($regiontype,$region,$toregion)
    {
        if ($regiontype == 1)
            return false ;
        else
            return $this->checkToRegion($region,$toregion);

    }

    function getPostVars($post,$array)
    {
        $post=parent::getPostVars($post,$array);
        if (is_array($post))
        {
            if ($post['type']==1) $post['capacity']=null;
            if ($post['regiontype']==1) $post['toregion']=null;
        }
        return  $post;
    }


    function checkAdUserInfo($post)
    {
        $errorMsg='';

        if (strlen($post['phone'])>0 ) $post['phone']=preg_replace('/[^0-9]/', '', $post['phone']);

        if (strlen($post['email'])==0 && strlen($post['phone'])==0)
            $errorMsg='Heç bir məlumat daxil edilməyib';
        if (strlen($post['email'])>0 && !$this->checkemail($post['email']))
            $errorMsg='E-mail düzgün qeyd olunmayıb';
        else if ( strlen($post['phone'])>0 && ( strlen($post['phone'])<9 || strlen($post['phone'])>12) )
            $errorMsg='Telefon rəqəm sayı düzgün deyil';

        return $errorMsg;


    }





}