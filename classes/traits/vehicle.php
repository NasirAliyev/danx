<?php
/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/23/2017
 * Time: 3:27 PM
 */

namespace traits;

trait vehicle {


    public static function getCapacityType($type)
    {
        if ($type == 1) return '';
        return ( $type == 2 ) ? 'Nəf' : 'Ton';
    }

    public static function getRegionType($type)
    {
        return ( $type == 1 ) ? 'Şəhərdaxili' : 'Şəhərlərarası';
    }

    public static function getRegions($type,$region,$toregion)
    {
        return ( $type == 2 ) ? $region .' - '.$toregion : $region;
    }

    public static function getStatus($status)
    {
        switch ($status)
        {
            default : return 'Gözləmədə...'; break;
            case '2' : return 'Baxılır...'; break;
            case '3' : return 'Dəyişiklik tələb olunur'; break;
            case '4' : return 'Qəbul olundu'; break;
            case '5' : return 'İmtina olundu'; break;
        }
    }

    public static function getBtns($status)
    {
        return ( $status == 1 || $status == 3 ) ?  '<a href="javascript:void(0)" class="btn btn-info edit edit-vehicle hidden"><img src="/images/edit.png"> </a>' : '';
    }



}