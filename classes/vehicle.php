<?php
/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/20/2017
 * Time: 4:34 PM
 */

require_once 'traits/vehicle.php';

class vehicle {

    use traits\vehicle;

    private $userid;

    public function __construct($userid)  { $this->userid=$userid; }

    private function checkForUpdate($id)
    {
        $errorMsg='';

        $check= db::instance()->prepare('select status,expire from vehicles WHERE user_id = :userid and id = :id ');
        $check->bindParam(':userid',$this->userid);
        $check->bindParam(':id',$id);
        $check->execute();

        $row=$check->fetch(PDO::FETCH_ASSOC);

        if ( $check->rowCount() > 0 ) {
            if ( $row['status'] != 1 && $row['status']!= 3 && $row['expire'] > date('Y.m.d') )
                $errorMsg = 'Dəyişiklik etməyə icazə verilmir';
        }
        else
            $errorMsg='Bu məlumatlara uyğun avtomobil tapılmadı';

        return $errorMsg;

    }

    private function checkForInsert($post)
    {
        $errorMsg='';

        $number = strtoupper($post['number']);

        $check= db::instance()->prepare('select id from vehicles WHERE user_id = :userid and number = :number ');
        $check->bindParam(':userid',$this->userid);
        $check->bindParam(':number',$number);
        $check->execute();

        if ( $check->rowCount() > 0 ) {
                $errorMsg = 'Bu dövlət qeydiyyat nişanı ilə avtomobil artıq mövcuddur';
        }

        return $errorMsg;
    }

    private function checkForSave($post,$id)
    {
        if ($id>0)
            return $this->checkForUpdate($id);
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
            $time = time();
            $expire = date('Y.m.d', strtotime("+{$post['months']} months"));

            $db = db::instance();

            $db->beginTransaction();

            $update=$db->prepare('update vehicles set vehicle =:vehicle ,driver =:driver ,
                                                     type=:type , capacity=:capacity, regiontype=:regiontype,
                                                     region=:region, toregion=:toregion, months=:months ,
                                                     time=:time, expire=:expire, status=1
                                                     where id=:id');
            $update->bindParam(':id',$id);
            $update->bindParam(':vehicle',$post['vehicle']);
            $update->bindParam(':driver',$post['driver']);
            $update->bindParam(':type',$post['type']);
            $update->bindParam(':capacity',$post['capacity']);
            $update->bindParam(':regiontype',$post['regiontype']);
            $update->bindParam(':region',$post['region']);
            $update->bindParam(':toregion',$post['toregion']);
            $update->bindParam(':months',$post['months']);
            $update->bindParam(':time',$time);
            $update->bindParam(':expire',$expire);
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

            $time = time();
            $expire = date('Y.m.d', strtotime("+{$post['months']} months"));
            $number = strtoupper($post['number']);


            $db = db::instance();

            $db->beginTransaction();

            $insert=$db->prepare('INSERT INTO vehicles (user_id,vehicle,driver,number,type,capacity,regiontype,region,toregion,months,time,expire,status) VALUES
                                                      (:userid,:vehicle,:driver,:number,:type,:capacity, :regiontype,:region,:toregion,:months,:time,:expire,1)');
            $insert->bindParam(':userid',$this->userid);
            $insert->bindParam(':vehicle',$post['vehicle']);
            $insert->bindParam(':drver',$post['driver']);
            $insert->bindParam(':number',$number);
            $insert->bindParam(':type',$post['type']);
            $insert->bindParam(':capacity',$post['capacity']);
            $insert->bindParam(':regiontype',$post['regiontype']);
            $insert->bindParam(':region',$post['region']);
            $insert->bindParam(':toregion',$post['toregion']);
            $insert->bindParam(':months',$post['months']);
            $insert->bindParam(':time',$time);
            $insert->bindParam(':expire',$expire);
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
                                        WHERE user_id = :userid');
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
                <td><span class="files">sənədlər... <img src="/images/clip.png"> </span></td>
                <td>'.self::getRegionType($val['regiontype']).'</td>
                <td>'.self::getRegions($val['regiontype'],$val['region'],$val['toregion']).'</td>
                <td><span class="status-color'.$val['status'].'">'.self::getStatus($val['status']).'</span>
                    '.self::getBtns($val['status']).'
                </td>
            </tr>';
            }
        }


        return $html;



    }



}