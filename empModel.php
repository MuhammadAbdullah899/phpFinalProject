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


 
  //This method provides the values used for the options
  //in the select field and checks to be sure the value is an array. 
  public function setValue($value){
     if (!is_array($value)){
        die ("Error: value is not an array.");
     }
     $this->value = $value;
   }
 
  public function getValue(){
     return $this->value;
  }
 
  //This method creates the actual select options. It is private, 
  //since there is no need for it outside the operations of the class.
  private function makeOptions($value){
     foreach($value as $v){
        echo "<option value=\"$v\">" .ucfirst($v). "</option>\n";
      }
  }
 
  //This method puts it all together to create the select field.
  //This method puts it all together to create the select field.
  public function makeSelect(){
     echo "<select name=\"" .$this->getName(). "\">\n";
     //Create options.
     echo "<option value=\"No response\">--Select one--</option>\n";
     $this->makeOptions($this->getValue());
     echo "</select>" ;
  }
}//end class
 
?>