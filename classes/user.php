<?php
/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/15/2017
 * Time: 4:41 PM
 */

require_once './autoload.php';

class user {

    public $voen;
    public $name;
    public $type;
    public $date;
    public $company;
    public $company_long;
    public $address;
    public $img;
    public $phone;
    public $email;
    public $userid;


    public function __construct($userInfo)
    {
          $this->voen=$userInfo['voen'];
          $this->name=$userInfo['name'];
          $this->type=$userInfo['type'];
          $this->date=$userInfo['date'];
          $this->company=$userInfo['company'];
          $this->company_long=$userInfo['company_long'];
          $this->address=$userInfo['address'];
          $this->img=$userInfo['img'];
          $this->checkUser();
    }

    private function checkUser()
    {

        $db= db::instance()->prepare('select * from users where voen = :voen');
        $db->bindParam(':voen',$this->voen);
        $db->execute();

        $row=$db->fetch(PDO::FETCH_ASSOC);

        if ( $db->rowCount() > 0 ) {

            $this->updateInfo();
            $this->setProperties($row['email'],$row['phone'],$row['id']);
        }
        else
            $this->addInfo();

    }

    public function updateInfo()
    {

        $response = 'Success';

        try
        {
            $db = db::instance();
            $update=$db->prepare('update users set name =:name , type=:type , date=:date, company=:company, company_long=:company_long, address=:address, img=:img where voen=:voen');
            $update->bindParam(':name',$this->name);
            $update->bindParam(':type',$this->type);
            $update->bindParam(':company',$this->company);
            $update->bindParam(':voen',$this->voen);
            $update->bindParam(':date',$this->date);
            $update->bindParam(':company_long',$this->voen);
            $update->bindParam(':address',$this->address);
            $update->bindParam(':img',$this->img);
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
            $db = db::instance();
            $insert=$db->prepare('insert into users VALUES ("",:voen,:type,:company,:name,"","",:date,:company_long,:address,:img)');
            $insert->bindParam(':name',$this->name);
            $insert->bindParam(':type',$this->type);
            $insert->bindParam(':company',$this->company);
            $insert->bindParam(':voen',$this->voen);
            $insert->bindParam(':date',$this->date);
            $insert->bindParam(':company_long',$this->voen);
            $insert->bindParam(':address',$this->address);
            $insert->bindParam(':img',$this->img);
            $insert->execute();

            $this->userid=$db->lastInsertId();
        }
        catch(PDOException $e)
        {
            $response = $e->getMessage() ;
        }

        return $response;
    }

    private function setProperties($email,$phone,$userid=0)
    {
        $this->email=$email;
        $this->phone=$phone;
        if ($userid>0)
            $this->userid=$userid;

    }


    public static function setInfo($voen,$email,$phone)
    {

        $response = 'Success';

        try
        {
            $update = db::instance()->prepare('update users set email=:email , phone=:phone where voen=:voen');
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