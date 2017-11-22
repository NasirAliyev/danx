<?php

session_start();

require_once 'classes/validation.php';
require_once 'classes/user.php';

$user = unserialize($_SESSION['userInfo']);

if (isset($_GET['action']) && ($user instanceof user))

     switch ($_GET['action'])
     {
          case 'vehicle':

               if (isset($_POST))
               {
                    $validation = new classes\validation();

                    if (isset($_POST['id'])) $id=$validation->getId($_POST['id']); else $id=0;

                    if ( !$postVars=$validation->getPostVars($_POST,array('vehicle','number','type','capacity','regiontype','region','toregion','months')))
                         $response = json_encode(array('code'=>0,'content'=>'Müraciət düzgün edilməyib'),JSON_UNESCAPED_UNICODE);
                    else if ( !$validation->checkForStrFill(array($postVars['vehicle'],$postVars['number'],$postVars['region'])) )
                         $response = json_encode(array('code'=>0,'content'=>'Bütün xanalarını doldurmaq vacibdir'),JSON_UNESCAPED_UNICODE);
                    else if ( !$validation->checkForIntFill (array($postVars['type'],$postVars['regiontype'],$postVars['months'])) )
                        $response = json_encode(array('code'=>0,'content'=>'Bütün xanaları doldurmaq vacibdir'),JSON_UNESCAPED_UNICODE);
                    else if ( !$validation->checkCapacity($postVars['type'],$postVars['capacity']))
                        $response = json_encode(array('code'=>0,'content'=>'Nəfər/ton xanası təyinatı üzrə düz yazılmaıb','param'=>'capacity'),JSON_UNESCAPED_UNICODE);
                    else if ( !$validation->checkRegions($postVars['regiontype'],$postVars['region'],$postVars['toregion']))
                        $response = json_encode(array('code'=>0,'content'=>'Şəhərlərarası tipi üçün 2 ci region düz seçilməyib','param'=>'toregion'),JSON_UNESCAPED_UNICODE);
                    else if ($id == 0 && !$validation->checkForSelect($_FILES,array('doc1-1','doc1-2','doc2-1','doc2-2','doc3')))
                        $response = json_encode(array('code'=>0,'content'=>'Fayllar seçilməyib'),JSON_UNESCAPED_UNICODE);
                    else if (!$validation->checkFileSizes($_FILES,1024))
                        $response = json_encode(array('code'=>0,'content'=>'Hər bir faylın həcmi 1 MB-dan artıq olmamalıdır'),JSON_UNESCAPED_UNICODE);
                    else if (!$validation->checkFileFormats($_FILES,array('jpg','png','bmp','gif')))
                        $response = json_encode(array('code'=>0,'content'=>'Fayllar yalnız şəkil formatında ola bilər (jpg,png,bmp,gif)'),JSON_UNESCAPED_UNICODE);
                    else {

                        $vehicle = new vehicle($user->userid);

                        if (strlen($errorMsg=$vehicle->save($postVars,$_FILES,$id))>0)
                            $response = json_encode(array('code'=>0,'content'=>$errorMsg),JSON_UNESCAPED_UNICODE);
                        else
                            $response = json_encode(array('code' => 0, 'content' => 'Əməliyyat uğurla icra olundu'), JSON_UNESCAPED_UNICODE);
                    }

               }
               else
                   $response = json_encode(array('code'=>0,'content'=>'Xəta baş verdi'),JSON_UNESCAPED_UNICODE);



               break;

          default : $response = json_encode(array('code'=>0,'content'=>'Heç bir müraciət icra olunmadı.'),JSON_UNESCAPED_UNICODE); break;
     }

echo $response;








