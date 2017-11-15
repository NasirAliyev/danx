<?php
/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/15/2017
 * Time: 4:41 PM
 */

require_once 'DB.php';

class User {

    public $voen;
    public $name;
    public $type;
    public $company;
    public $phone;
    public $email;

    public function __construct($voen,$name,$type,$company)
    {
          $this->voen=$voen;
          $this->name=$name;
          $this->type=$type;
          $this->company=$company;
          $this->checkUser();
    }

    private function checkUser()
    {

        $db= DB::instance()->prepare('select * from users where voen = :voen');
        $db->bindParam(':voen',$this->voen);
        $db->execute();

        $row=$db->fetch(PDO::FETCH_ASSOC);

        if ( $db->rowCount() > 0 ) {
            $this->updateInfo();
            $this->setProperties($row['email'],$row['phone']);
        }
        else
            $this->addInfo();

    }

    public function updateInfo()
    {

        $response = 'Success';

        try
        {
            $update = DB::instance()->prepare('update users set name =:name , type=:type , company=:company where voen=:voen');
            $update->bindParam(':name',$this->name);
            $update->bindParam(':type',$this->type);
            $update->bindParam(':company',$this->company);
            $update->bindParam(':voen',$this->voen);
            $update->execute();
        }
        catch(PDOException $e)
        {
            $response = $e->getMessage();
        }

        return $response;
    }

    public function addInfo()
    {

        $response = 'Success';

        try
        {
            $insert = DB::instance()->prepare('insert into users VALUES ("",:voen,:type,:company,:name,"","")');
            $insert->bindParam(':name',$this->name);
            $insert->bindParam(':type',$this->type);
            $insert->bindParam(':company',$this->company);
            $insert->bindParam(':voen',$this->voen);
            $insert->execute();
        }
        catch(PDOException $e)
        {
            $response = $e->getMessage() ;
        }

        return $response;
    }

    private function setProperties($email,$phone)
    {
        $this->email=$email;
        $this->phone=$phone;
    }


    public static function setInfo($voen,$email,$phone)
    {

        $response = 'Success';

        try
        {
            $update = DB::instance()->prepare('update users set email=:email , phone=:phone where voen=:voen');
            $update->bindParam(':email',$email);
            $update->bindParam(':phone',$phone);
            $update->bindParam(':voen',$voen);
            $update->execute();

            self::setProperties($email,$phone);
        }
        catch(PDOException $e)
        {
            $response = $e->getMessage();
        }

        return $response;

    }





}