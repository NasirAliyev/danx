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
            default  : return true; break;
            case 2 :   return $this->busCapacity($capacity); break;
            case 3 :   return $this->truckCapacity($capacity); break;
        }
    }

    private function checkToRegion($region,$toregion)
    {
        if ( $region != $toregion && strlen($toregion) > 2 ) return true; else return false;
    }

    function checkRegions($regiontype,$region,$toregion)
    {
        if ($regiontype == 1)
            return true ;
        else
            return $this->checkToRegion($region,$toregion);

    }





}