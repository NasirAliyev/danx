<?php

namespace classes;

use classes\core\validation as validationAbstract ;

require_once 'core'.DIRECTORY_SEPARATOR.'validation.php';

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

    function checkRegionType($type,$regiontype)
    {
        $response = true;
        $allowedRTypes = array(1=>array(1,2),2=>array(1,2,3,4),3=>array(0,3,4));

         if ( $type >= 1 && $type <= 3 )
            if ( !in_array($regiontype,$allowedRTypes[$type]) )
                $response = false;

        return $response;
    }

    function getPostVars($post,$array)
    {
        $post=parent::getPostVars($post,$array);
        if (is_array($post))
        {
            if ($post['type']==1) $post['capacity']=null;
            if ($post['regiontype']==1) $post['toregion']=null;
            $post['number'] = $this->getVehicleNumber($post['number']);
            $post['time'] = time();
            if ($this->checkDate($post['fromdate'],'Y.m.d'))
            $post['expire']=date('Y.m.d', strtotime("+{$post['months']} months",strtotime(str_replace('.','-',$post['fromdate']))));
        }
        return  $post;
    }


    function checkAdUserInfo($post)
    {
        $errorMsg='';

        if (strlen($post['phone'])>0 ) $post['phone']=$this->getPhoneNumber($post['phone']);

        if (strlen($post['email'])==0 && strlen($post['phone'])==0)
            $errorMsg='Heç bir məlumat daxil edilməyib';
        if (strlen($post['email'])>0 && !$this->checkemail($post['email']))
            $errorMsg='E-mail düzgün qeyd olunmayıb';
        else if ( strlen($post['phone'])>0 && ( strlen($post['phone'])<9 || strlen($post['phone'])>12) )
            $errorMsg='Telefon rəqəm sayı düzgün deyil';

        return $errorMsg;


    }

    public function checkDate($date,$format)
    {
        $response = true;

        if ( $response = parent::checkDate($date,$format))
            if ( $date < date('Y.m.d'))
                $response= false;

        return $response;

    }







}