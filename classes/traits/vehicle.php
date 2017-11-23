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
        if ($type == 1) return '-';
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

    public static function getStatus($status,$expire)
    {
        switch ($status)
        {
            default  : return 'Gözləmədə...'; break;
            case '2' : return 'Baxılır...'; break;
            case '3' : return 'Xətalı ! '; break;
            case '4' : return  $expire; break;
            case '5' : return 'İmtina olundu'; break;
        }
    }

    public static function getBtns($status,$expire)
    {

        return ( $status == 1 || $status == 3 || ( $expire <= date('Y.m.d') && $status==4 )) ?  '<a href="javascript:void(0)" class="btn btn-info edit edit-vehicle"><img src="/images/edit.png"> </a>' : '';
    }



}