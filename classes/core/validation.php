<?php

namespace classes\core;

abstract class validation {

    public function checkemail($input)
    {
        return filter_var(filter_var($input, FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);
    }

    public  function checkForStrFill($array)
    {
        if (!is_array($array)) return false;

        $errCount=0;

        foreach ($array as $key => $val)
            if (strlen($val) == 0 ) { $errCount++; break; }

        return ( $errCount > 0 ) ? false : true;

    }

    public  function checkForIntFill($array)
    {
        if (!$this->checkForStrFill($array)) return false;

        $errCount=0;

        foreach ($array as $key => $val)
            if ( !filter_var(filter_var($val,FILTER_SANITIZE_NUMBER_INT),FILTER_VALIDATE_INT) ) { $errCount++; break; }

        return ( $errCount > 0 ) ? false : true;

    }

    function getPostVars($post,$array)
    {
        if (!is_array($array)) return false;

        $errCount=0;
        $postVars=array();

        foreach($array as $key=>$val)
        {
            if (!isset($post[$val]))
            { $errCount++; break; }
            else
                $postVars[$val]=filter_var($post[$val],FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return ( $errCount > 0 ) ? false : $postVars;
    }

    protected function hasFileError($file)
    {
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                return false;
            break;
            case UPLOAD_ERR_NO_FILE:
                return 'No file sent.';
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'Exceeded filesize limit';
            default:
                return 'Unknown errors.';
        }
    }

    public function checkForSelect($files,$array){

        if (!is_array($array)) return false;

        $errCount=0;

        foreach ($array as $key => $val) {
            if (!isset ($files[$val])) {
                $errCount++;
                break;
            }
        }

        return ( $errCount > 0 ) ? false : true;

    }

    public function checkFileSizes($files,$size){

        $errCount=0;

        foreach ($files as $val) {
            if ( $val['size'] > $size * 1024 ) {
                $errCount++;
                break;
            }
        }

        return ( $errCount > 0 ) ? false : true;

    }

    public function checkFileFormats($files,$allowed){

        $errCount=0;

        foreach ($files as $val) {
            $filename = $val['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) ) {
                $errCount++;
                break;
            }
        }

        return ( $errCount > 0 ) ? false : true;

    }



    public function getId($id)
    {
        $id = filter_var(filter_var($id, FILTER_SANITIZE_NUMBER_INT),FILTER_VALIDATE_INT);
        return ( is_integer($id) ) ? $id : 0 ;
    }


}