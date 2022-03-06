<?php
include('dbcon.php');
if(isset($_SESSION['token'])){
    try{
        $verifiedToken = $auth->verifyIdToken($_SESSION['token']);
        $uid = $_SESSION['uid'];
        $user = $auth->getUser($uid);
    }catch(Exception $e){
        header('location: login.php');
    }
}else{
    header('location: login.php');
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $database->getReference("contacts/$id")->set(null);
    header('location: index.php');
}else{
    header('location: index.php');
}
?>