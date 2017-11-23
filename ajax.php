<?php

session_start();

require_once __DIR__.DIRECTORY_SEPARATOR.'autoload.php';

$user = unserialize($_SESSION['userInfo']);

if (isset($_GET['action']) && ($user instanceof user))

     switch ($_GET['action'])
     {
         case 'vehicle':

               if (isset($_POST))
               {
                    $validation = new classes\validation();

                    if (isset($_POST['id'])) $id=$validation->getId($_POST['id']); else $id=0;

                    if ( !$postVars=$validation->getPostVars($_POST,array('vehicle','driver','number','type','capacity','regiontype','region','toregion','months')))
                         $response = json_encode(array('code'=>0,'content'=>'Müraciət düzgün edilməyib'),JSON_UNESCAPED_UNICODE);
                    else if ( !$validation->checkForStrFill(array($postVars['vehicle'],$postVars['driver'],$postVars['number'],$postVars['region'])) )
                         $response = json_encode(array('code'=>0,'content'=>'Bütün xanalarını doldurmaq vacibdir'),JSON_UNESCAPED_UNICODE);
                    else if ( !$validation->checkForIntFill (array($postVars['type'],$postVars['regiontype'],$postVars['months'])) )
                        $response = json_encode(array('code'=>0,'content'=>'Bütün xanaları doldurmaq vacibdir'),JSON_UNESCAPED_UNICODE);
                    else if ( !$validation->checkCapacity($postVars['type'],$postVars['capacity']) && !is_null($postVars['capacity']))
                        $response = json_encode(array('code'=>0,'content'=>$postVars['capacity'].'Nəfər/ton xanası təyinatı üzrə düz yazılmaıb','param'=>'capacity'),JSON_UNESCAPED_UNICODE);
                    else if ( !$validation->checkRegions($postVars['regiontype'],$postVars['region'],$postVars['toregion'])&& !is_null($postVars['toregion']))
                        $response = json_encode(array('code'=>0,'content'=>'Şəhərlərarası tipi üçün 2 ci region düz seçilməyib','param'=>'toregion'),JSON_UNESCAPED_UNICODE);
                    else if ($id == 0 && !$validation->checkForSelect($_FILES,array('doc1_1','doc1_2','doc2_1','doc2_2')))
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
                            $response = json_encode(array('code' => 1, 'content' => 'Əməliyyat uğurla icra olundu'), JSON_UNESCAPED_UNICODE);
                    }

               }
               else
                   $response = json_encode(array('code'=>0,'content'=>'Xəta baş verdi'),JSON_UNESCAPED_UNICODE);



               break;

         case 'getList' :

             $vehicle = new vehicle($user->userid);

             $response = json_encode(array('code'=>0,'content'=>$vehicle->getList()),JSON_UNESCAPED_UNICODE); break;

             break;

         case 'getVehicle' :

             $vehicle = new vehicle($user->userid);
             $validation=new classes\validation();

             if (isset($_POST['id'])) $id=$validation->getId($_POST['id']); else $id=0;
             $response = json_encode(array('code'=>0,'content'=>$vehicle->getVehicle($id)),JSON_UNESCAPED_UNICODE); break;

             break;

         case 'userInfo' :

             $validation = new classes\validation();
             $user = unserialize($_SESSION['userInfo']);

             if ( strlen($errorMsg=$validation->checkAdUserInfo($_POST))>0)
                 $response = json_encode(array('code'=>0,'content'=>$errorMsg),JSON_UNESCAPED_UNICODE);
             else  if ( strlen($errorMsg=$user->setInfo($_POST['email'], $_POST['phone']))>0)
                 $response = json_encode(array('code'=>0,'content'=>$errorMsg),JSON_UNESCAPED_UNICODE);
             else {
                 $_SESSION['userInfo'] = serialize($user);
                 $response = json_encode(array('code' => 1, 'content' => 'Məlumatlar yadda saxlanıldı'), JSON_UNESCAPED_UNICODE);
             }


             break;

         default : $response = json_encode(array('code'=>0,'content'=>'Heç bir müraciət icra olunmadı.'),JSON_UNESCAPED_UNICODE); break;
     }

echo $response;








