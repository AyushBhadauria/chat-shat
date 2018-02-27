<?php
session_start();
DEFINE ('DB_PASSWORD','webonise123#');
DEFINE ('DB_HOST','localhost');
DEFINE ('DB_NAME','blog');
DEFINE ('DB_USER','root');
class DB_con
{
 function __construct()
 {
$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$this->dbh=$dbc;
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 }
 public function fetchdata()
 {
 $email=$_SESSION['email'];
 $result=mysqli_query($this->dbh,"select * from users where email='".$email."'");
 return $result;
 }
 public function fetchusersdata()
 {
 $email=$_SESSION['email'];
 $result=mysqli_query($this->dbh,"select * from users where email !='".$email."'");
 return $result;
 }
 public function fetchChatData($user)
 {

 $result=mysqli_query($this->dbh,"select * from users where email ='".$user."'");
 return $result;
 }
 public function insertData($name,$email,$password,$contact)
 {
 $result=mysqli_query($this->dbh,"insert into users(name,email,password,contact) values('".$name."','".$email."','".$password."','".$contact."')");
 return $result;
 }
 public function updateImage($destFile,$email)
 {
 $result=mysqli_query($this->dbh,"UPDATE users SET image = ' $destFile' WHERE email ='$email'");
 return $result;
 }
 public function updateUser($name,$contact,$gender,$hobbies, $interests,$email)
 {
 $result=mysqli_query($this->dbh,"UPDATE users SET 
 name = '  $name',
 contact = '  $contact',
 gender = '  $gender',
 about = '  $about',
 hobbies = '  $hobbies',
 interests = '  $interests'
 WHERE email ='$email'");
 return $result;
 }
 public function updatePassword($newpass,$email)
 {
 $result=mysqli_query($this->dbh,"UPDATE users SET password = ' $newpass' WHERE email ='$email'");
 return $result;
 }
 public function seenMsg($seen,$main, $id)
 {
 $result=mysqli_query($this->dbh,"UPDATE chat SET seen = '$seen' WHERE user2_id ='$main' AND user_id ='$id'");
 return $result;
 }
}
?>
