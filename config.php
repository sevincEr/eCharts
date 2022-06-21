<?php

#$conn = mysqli_connect('localhost','root','','cart_db');
#$db = new PDO("mysql:host=localhost; dbname=kisisel_kutuphane",'root','');
$server = "localhost";
$password = "";
$user = "root";
$databaseName = "2020800277";
#$db = new PDO('mysql:host=localhost;dbname=' . $databaseName, $user, $password);
$conn = mysqli_connect($server, $user, $password, $databaseName);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
/*
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $username=$_POST["username"];
    $password=hash("sha512", ($_POST["password"]));


    $sql="select * from users where username='".$username."' AND password='".$password."' ";

    $result=mysqli_query($conn,$sql);

    $row=mysqli_fetch_array($result);

    if($row["user_type"]=="user")
    {	

        $_SESSION["username"]=$username;

        header("location:userhome.php");
    }

    elseif($row["user_type"]=="admin")
    {

        $_SESSION["username"]=$username;
        
        header("location:dashboard.php");
    }

    else
    {
        echo "username or password incorrect";
    }


}
*/



?>