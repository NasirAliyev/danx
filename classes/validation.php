<?php

namespace classes;

require_once 'core/validation.php';

class validation extends core\validation {


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





}