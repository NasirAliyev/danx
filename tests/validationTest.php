<?php
/**
 * Created by PhpStorm.
 * User: Nasir
 * Date: 11/15/2017
 * Time: 7:51 PM
 */

require_once './classes/validation.php';

class validationtest extends PHPUnit_Framework_TestCase
{
    /*
    public function testFill()
    {
        $validation = new classes\validation();
        $this->assertEquals(true,$validation->checkForIntFill(array(1,2,3,5)));
        $this->assertEquals(false,$validation->checkForIntFill(array(0.2,0)));
        $this->assertEquals(false,$validation->checkForStrFill(array('','test')));
        $this->assertEquals(true,$validation->checkForStrFill(array('test','test2')));
    }*/

    public function testCapacity()
    {
        $validation = new classes\validation();
        $this->assertEquals(true,$validation->checkCapacity(1,0));
        $this->assertEquals(false,$validation->checkCapacity(2,0));
        $this->assertEquals(false,$validation->checkCapacity(2,0.1));
        $this->assertEquals(false,$validation->checkCapacity(3,0));
        $this->assertEquals(true,$validation->checkCapacity(3,0.2));
    }


}