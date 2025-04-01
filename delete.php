<?php
require_once "conn.php";

$id = $_GET['id'] ?? '';
if($id){
    $sql = "DELETE FROM auth_data WHERE id='$id'";
    $data = mysqli_query($con,$sql);
}
if($data){
    header("Location:list.php");
}
?>