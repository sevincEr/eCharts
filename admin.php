<?php
include 'config.php';
session_start();
error_reporting(0);

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password =hash("sha512", ($_POST['password']));
    $sql ="SELECT * FROM users WHERE email ='$email' AND password ='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows>0){
        $row = mysqli_fetch_assoc($result);
		$_SESSION['username'] = $row['username'];
        if($row["user_type"]=="admin")
        {	
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
        }
        else{
            header("Location: userhome.php");
        }
	} 
    else {
		echo "<script>alert('Oops! Email or Password is Wrong.')</script>";
	}
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="style_admin.css">

    <title>Veteriner Kliniği Admin Girişi</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST" class="login-email">
            <p class="login-text">KULLANICI GIRISI</p>
            <div class="input-group">
                <input type="email" placeholder="Email" name='email' required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name='password' required>
            </div>
            <div class="input-group">
                <button name='submit' class="btn">Giriş</button>
            </div>
        </form>
    </div>
</body>
</html>