<?php
/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/20/2017
 * Time: 4:34 PM
 */

require_once 'traits'.DIRECTORY_SEPARATOR.'vehicle.php';

class vehicle {

    use traits\vehicle;

    private $userid;

    public function __construct($userid)  { $this->userid=$userid; }

    private function checkForUpdate($post,$id)
    {
        $errorMsg='';

        $check= db::instance()->prepare('select status from vehicles WHERE vehicles.deletedat IS NULL and user_id = :userid and id = :id');
        $check->bindParam(':userid',$this->userid);
        $check->bindParam(':id',$id);
        $check->execute();

        $row=$check->fetch(PDO::FETCH_ASSOC);

        if ( $check->rowCount() > 0 ) {

            if ( $row['status'] != 1 && $row['status']!= 3  )
                $errorMsg = 'Dəyişiklik etməyə icazə verilmir';
            else
            {
                $checkNumber= db::instance()->prepare('select number from vehicles WHERE  vehicles.deletedat IS NULL and number = :number and id != :id');
                $checkNumber->bindParam(':number',$post['number']);
                $checkNumber->bindParam(':id',$id);
                $checkNumber->execute();

                if ( $checkNumber->rowCount() > 0 )
                    $errorMsg = 'Bu dövlət qeydiyyat nişanı ilə avtomobil artıq mövcuddur';

            }
        }
        else
            $errorMsg='Bu məlumatlara uyğun avtomobil tapılmadı';

        return $errorMsg;

    }

    private function checkForInsert($post)
    {
        $errorMsg='';

        $check= db::instance()->prepare('select id from vehicles WHERE vehicles.deletedat IS NULL and  user_id = :userid and number = :number ');
        $check->bindParam(':userid',$this->userid);
        $check->bindParam(':number',$post['number']);
        $check->execute();

        if ( $check->rowCount() > 0 ) {
                $errorMsg = 'Bu dövlət qeydiyyat nişanı ilə avtomobil artıq mövcuddur';
        }

        return $errorMsg;
    }

    private function checkForSave($post,$id)
    {
        if ($id>0)
            return $this->checkForUpdate($post,$id);
        else
            return $this->checkForInsert($post);
    }

    private function uplaodFiles($files)
    {
        $filesNames=array();

        try
        {
            foreach($files as $key=>$file) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newfilename = md5(time() . filter_var($file['name'], FILTER_SANITIZE_STRING) . '.') .'.'.$ext;
                move_uploaded_file($file['tmp_name'], 'upload/' . $newfilename);
                $filesNames[$key]=$newfilename;
            }
        }
        catch(Exception $e)
        {
            $filesNames='';
        }

        return $filesNames;

    }

    private function insertFiles($files,$id)
    {

        if (is_array($files) && count($files)==0)  return '';

        $errorMsg = '';

        try {

            if (!is_array($fileNames = $this->uplaodFiles($files)))
                throw new Exception('Fayllar yüklənən zaman xəta baş verdi');

            $db = db::instance();

           // print_r($fileNames); exit();

            $filesInsert=$db->prepare('INSERT into files (vehicle_id,doc1_1,doc1_2,doc2_1,doc2_2,doc3) VALUES (:id,:doc1_1,:doc1_2,:doc2_1,:doc2_2,:doc3)');
            $filesInsert->bindParam(':id',$id);
            $filesInsert->bindParam(':doc1_1',$fileNames['doc1_1']);
            $filesInsert->bindParam(':doc1_2',$fileNames['doc1_2']);
            $filesInsert->bindParam(':doc2_1',$fileNames['doc2_1']);
            $filesInsert->bindParam(':doc2_2',$fileNames['doc2_2']);
            $filesInsert->bindParam(':doc3',$fileNames['doc3']);
            $filesInsert->execute();

        }
        catch (Exception $e)
        {
            $errorMsg = $e->getMessage();
        }

        return $errorMsg;


    }


    private function updateFiles($files,$id)
    {

        if (is_array($files) && count($files)==0)  return '';

        $errorMsg = '';

        try {

            if (!is_array($fileNames = $this->uplaodFiles($files)))
                throw new Exception('Fayllar yüklənən zaman xəta baş verdi');

            $filesSql = '';
            foreach ($fileNames as $key=>$filename)
                $filesSql .= "{$key} = '{$filename}' ,";
            $filesSql = substr($filesSql, 0, -1);

            $db = db::instance()->prepare('UPDATE  files  SET '.$filesSql.' where vehicle_id = :id');
            $db->bindParam(':id',$id);
            $db->execute();
        }
        catch (Exception $e)
        {
            $errorMsg = $e->getMessage();
        }

        return $errorMsg;


    }


    private function updateVehicle($post,$files,$id)
    {
        $errorMsg = '';

        try
        {

            $db = db::instance();

            $db->beginTransaction();

            $update=$db->prepare('update vehicles set vehicle =:vehicle ,driver =:driver ,number =:number ,
                                                     type=:type , capacity=:capacity, regiontype=:regiontype,
                                                     region=:region, toregion=:toregion, months=:months , fromdate=:fromdate ,
                                                     time=:time, expire=:expire, status=1
                                                     where id=:id');
            $update->bindParam(':id',$id);
            $update->bindParam(':vehicle',$post['vehicle']);
            $update->bindParam(':number',$post['number']);
            $update->bindParam(':driver',$post['driver']);
            $update->bindParam(':type',$post['type']);
            $update->bindParam(':capacity',$post['capacity']);
            $update->bindParam(':regiontype',$post['regiontype']);
            $update->bindParam(':region',$post['region']);
            $update->bindParam(':toregion',$post['toregion']);
            $update->bindParam(':months',$post['months']);
            $update->bindParam(':fromdate',$post['fromdate']);
            $update->bindParam(':time',$post['time']);
            $update->bindParam(':expire',$post['expire']);
            $update->execute();

            if (strlen($errorMsg=$this->updateFiles($files,$id))>0)
                throw new Exception($errorMsg);

            $db->commit();


        }
        catch(Exception $e)
        {
            $db->rollBack();
            $errorMsg = $e->getMessage();
        }

        return $errorMsg;
    }

    private function insertVehicle($post,$files)
    {
        $errorMsg = '';

        try
        {

            $db = db::instance();

            $db->beginTransaction();

            $insert=$db->prepare('INSERT INTO vehicles (user_id,vehicle,driver,number,type,capacity,regiontype,region,toregion,months,fromdate,time,expire,status) VALUES
                                                      (:userid,:vehicle,:driver,:number,:type,:capacity, :regiontype,:region,:toregion,:months,:fromdate,:time,:expire,1)');
            $insert->bindParam(':userid',$this->userid);
            $insert->bindParam(':vehicle',$post['vehicle']);
            $insert->bindParam(':driver',$post['driver']);
            $insert->bindParam(':number',$post['number']);
            $insert->bindParam(':type',$post['type']);
            $insert->bindParam(':capacity',$post['capacity']);
            $insert->bindParam(':regiontype',$post['regiontype']);
            $insert->bindParam(':region',$post['region']);
            $insert->bindParam(':toregion',$post['toregion']);
            $insert->bindParam(':months',$post['months']);
            $insert->bindParam(':time',$post['time']);
            $insert->bindParam(':fromdate',$post['fromdate']);
            $insert->bindParam(':expire',$post['expire']);
            $insert->execute();

            if (strlen($errorMsg=$this->insertFiles($files,$db->lastInsertId()))>0)
                throw new Exception($errorMsg);

            $db->commit();


        }
        catch(Exception $e)
        {
            $db->rollBack();
            $errorMsg = $e->getMessage();
        }

        return $errorMsg;
    }

    public function Save($post,$files,$id)
    {
        $errorMsg='';

          if (strlen($errorMsg=$this->checkForSave($post,$id)) == 0 )
          {
              if ($id>0)
                  return $this->updateVehicle($post,$files,$id);
              else
                  return $this->insertVehicle($post,$files);

          }

        return $errorMsg;
    }

    public function getList()
    {
        $list= db::instance()->prepare('select vehicles.*,files.doc1_1,files.doc1_2,files.doc2_1,files.doc2_2,files.doc3 from vehicles
                                        left join files on vehicles.id = files.vehicle_id
                                        WHERE vehicles.deletedat IS NULL and  vehicles.user_id = :userid');
        $list->bindParam(':userid',$this->userid);
        $list->execute();

        $result = $list->fetchAll();

        $html='';

        if (is_array($result) && count($result)>0)
        {

            $i=0;

            foreach($result as $val)
            {
                $i++;

                $doc3 = ($val['doc3'] != null) ? '<a target="_blank" href="/upload/'.$val['doc3'].'">Etibarnamə</a>' : '';

                $html.= '
              <tr data-id="'.$val['id'].'">
                <td>'.$i.'</td>
                <td>'.$val['vehicle'].'</td>
                <td>'.$val['driver'].'</td>
                <td>'.$val['number'].'</td>
                <td>
                    <span class="vehicle-ico'.$val['type'].' active"></span>
                </td>
                <td>'.$val['capacity'].' '.self::getCapacityType($val['type']).'</td>
                <td class="docs-td"><span class="files">sənədlər... <img src="/images/clip.png"> </span>
                            <div class="vehicle-files">
                               <a target="_blank" href="/upload/'.$val['doc1_1'].'">Texpasport (ön)</a>
                               <a target="_blank" href="/upload/'.$val['doc1_2'].'">Texpasport (arxa)</a>
                               <a target="_blank" href="/upload/'.$val['doc2_1'].'">Sürücülük vəsiqəsi (ön)</a>
                               <a target="_blank" href="/upload/'.$val['doc2_2'].'">Sürücülük vəsiqəsi (arxa)</a>
                               '.$doc3.'
                            </div>
                        </td>
                <td>'.self::getRegionType($val['regiontype']).'</td>
                <td>'.self::getRegions($val['regiontype'],$val['region'],$val['toregion']).'</td>
                <td><span class="status-color'.$val['status'].'">'.self::getStatus($val['status'],$val['expire']).'</span>
                    '.self::getBtns($val['status'],$val['expire']).'
                </td>
            </tr>';
            }
        }
        else
          $html='<tr><td colspan="10" style="text-align: center">Heç bir məlumat mövcud deyil</td></tr>';

        return $html;



    }


    public function getVehicle($id)
    {
        $vehicle= db::instance()->prepare('select vehicles.*,files.doc1_1,files.doc1_2,files.doc2_1,files.doc2_2,files.doc3 from vehicles
                                                 left join files on vehicles.id = files.vehicle_id
                                           WHERE vehicles.deletedat IS NULL  and vehicles.id = :id and vehicles.user_id = :userid');
        $vehicle->bindParam(':id',$id);
        $vehicle->bindParam(':userid',$this->userid);
        $vehicle->execute();

        $row=$vehicle->fetch(PDO::FETCH_ASSOC);

        if ($vehicle->rowCount()>0)
            return $row;
        else
            return 'Məlumat tapılmadı';


    }



}