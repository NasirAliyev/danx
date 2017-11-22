<?php
/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/20/2017
 * Time: 4:34 PM
 */

class vehicle {

    private $userid;

    public function __construct($userid)  { $this->userid=$userid; }

    private function checkForUpdate($id)
    {
        $errorMsg='';

        $check= db::instance()->prepare('select status,expire from vehicle WHERE user_id = :userid and id = :id ');
        $check->bindParam(':userid',$this->userid);
        $check->bindParam(':id',$id);
        $check->exec();

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

        $check= db::instance()->prepare('select id from vehicle WHERE user_id = :userid and number = :number ');
        $check->bindParam(':userid',$this->userid);
        $check->bindParam(':number',strtolower($post['number']));
        $check->exec();

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
            return $this->checkForInsert($post,$id);
    }

    private function uplaodFiles($files)
    {
        $filesNames=array();

        try
        {
            foreach($files as $file) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newfilename = md5(time() . filter_var($file['name'], FILTER_SANITIZE_STRING) . '.' . $ext);
                move_uploaded_file($file['tmp_name'], 'upload/' . $newfilename);
                array_push($newfilename,$filesNames);
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

        $errorMsg = '';

        try {

            if (!is_array($fileNames = $this->uplaodFiles($files)))
                throw new Exception('Fayllar yüklənən zaman xəta baş verdi');

            $filesSql = '';
            foreach ($fileNames as $filename)
                $filesSql .= "({$id},{$filename}),";
            $filesSql = substr($filesSql, 0, -1);

            db::instance()->prepare('INSERT into files (vehicle_id,filename) VALUES ' . $filesSql)->exec();
        }
        catch (Exception $e)
        {
            $errorMsg = $e->getMessage();
        }


    }


    private function updateVehicle($post,$files,$id)
    {
        $errorMsg = '';

        try
        {
            $db = db::instance();

            $db->beginTransaction();

            $update=$db->prepare('update vehicle set vehicle =:vehicle ,
                                                     type=:type , capacity=:capacity, regiontype=:regiontype,
                                                     region=:region, toregion=:toregion, months=:months ,
                                                     time=:time, expire=:expire, status=1
                                                     where id=:id');
            $update->bindParam(':vehicle',$post['vehicle']);
            $update->bindParam(':type',$post['type']);
            $update->bindParam(':capacity',$post['capacity']);
            $update->bindParam(':regiontype',$post['regiontype']);
            $update->bindParam(':region',$post['region']);
            $update->bindParam(':toregion',$post['toregion']);
            $update->bindParam(':months',$post['months']);
            $update->bindParam(':time',time());
            $update->bindParam(':expire',date('Y.m.d', strtotime("+{$post['months']} months")));
            $update->execute();

            if (strlen($errorMsg=$this->insertFiles($files,$id))>0)
                throw new Exception($errorMsg);

            $db->commit();


        }
        catch(PDOException $e)
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

}