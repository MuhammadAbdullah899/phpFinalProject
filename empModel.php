<?php
class employee{
  //Property
  private $emp_id;
  private $name;   
  private $login;
  private $password;
  private $dept;
  private $salary;
  private $picture;
  private $boss;
  private $designation;

 
  function __construct() {
    $this->emp_id = "";
    $this->name = "";
    $this->login = "";
    $this->password = "";
    $this->dept = "";
    $this->salary = "";
    $this->picture = "";
    $this->boss = "";
    $this->designation = "";
  }

  //Methods
  //Set Functions
  public function setID($emp_id){
     $this->emp_id = $emp_id;
  }
  public function setName($name){
     $this->name = $name;
  }
  public function setLogin($login){
     $this->login = $login;
  }
  public function setPassword($password){
     $this->password = $password;
  }
  public function setDepartment($dept){
     $this->dept = $dept;
  }
  public function setSalary($salary){
     $this->salary = $salary;
  }
  public function setPicture($picture){
     $this->picture = $picture;
  }
  public function setBoss($boss){
     $this->boss =   $boss;
  }
  public function setDesignation($designation){
     $this->designation = $designation;
  }
 

 //get functions
  public function getID(){
     return $this->emp_id;
  }
  public function getName(){
     return $this->name;
  }
  public function getLogin(){
     return $this->login;
  }
  public function getPassword(){
     return $this->password;
  }
  public function getDepartment(){
     return $this->dept;
  }
  public function getSalary(){
     return $this->salary;
  }
  public function getPicture(){
     return $this->picture;
  }
  public function getBoss(){
     return $this->boss;
  }
  public function getDesignation(){
     return $this->designation;
  }


  
}//end class
 
?>