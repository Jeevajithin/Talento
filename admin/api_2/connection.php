<?php
$con=new mysqli("localhost","root","Neontetra@2021#","srishtis_campusonline");
if(!$con)
{
  die("sql connection error");
}
$server_path=$_SERVER['DOCUMENT_ROOT']."/Project/talento/";
$base_path="http://campus.sicsglobal.co.in/Project/talento/admin/";
?>