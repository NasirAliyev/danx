<?php
/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/28/2017
 * Time: 6:17 PM
 */

require_once '.'.DIRECTORY_SEPARATOR.'autoload.php';

class regions {

    private $regions = array();

    public function __construct(){

        $db = db::instance()->prepare('select * from regions ');
        $db->execute();

        $rows=$db->fetchAll();

        if ( $db->rowCount() > 0 ) {
            foreach($rows as $row)
               $this->regions[$row['id']]=$row['name'];
        }

    }

    public function getRegionList($default){

        $html = '';

        foreach($this->regions as $region) {
            $selected = (strtolower($default) == strtolower($region)) ? 'selected="selected"' : '';
            $html .= '<option ' . $selected . ' value="' . $region . '">' . $region . '</option>';
        }

        return $html;
    }





}