<? session_start();

spl_autoload_register(function($class){
    $class_path='classes'.DIRECTORY_SEPARATOR.$class.'.php';
    if (file_exists($class_path)) require_once $class_path;
});


$userInfo = array('"WhiteRoof " MMC','9900038501','NOVRUZOV EMIN BƏLAHƏR OĞLU',2,'08.09.1986',
                  '"WhiteRoof" MƏHDUD MƏSULİYYƏTLİ CƏMİYYƏTİ','Dilarə küç, 185','images/pasp.png');

$userInfo='';

if (is_array($userInfo)) unset($_SESSION['userInfo']);

if ( !isset($_SESSION['userInfo']) ) {
    $user = new User($userInfo[1], $userInfo[2], $userInfo[3], $userInfo[0]);
    $_SESSION['userInfo'] = serialize($user);
}


require_once 'view/template.php';