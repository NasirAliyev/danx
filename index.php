<?php session_start();

require_once 'autoload.php';

$userInfo = array('company'=>'"WhiteRoof " MMC',
                  'voen'=>'9900038502',
                  'name'=>'NOVRUZOV EMIN BƏLAHƏR OĞLU',
                  'type'=>2,
                  'date'=>'08.09.1986',
                  'company_long'=>'"WhiteRoof" MƏHDUD MƏSULİYYƏTLİ CƏMİYYƏTİ',
                  'address'=>'Dilarə küç, 186',
                  'img'=>'/images/pasp.png');


//if (is_array($userInfo)) unset($_SESSION['userInfo']);

if ( !isset($_SESSION['userInfo']) ) {
    $user = new user($userInfo);
    $_SESSION['userInfo'] = serialize($user);
}

$user = unserialize($_SESSION['userInfo']);

//print_r($user); exit();

echo date('Y-m-d H:i:s', strtotime("+3 months")); exit();

require_once 'view/template.php';