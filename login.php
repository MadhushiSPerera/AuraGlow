<?php
include '../components/connect.php';

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $email=filter_var($email, FILTER_SANITIZE_STRING);

    $password = sha1($_POST['password']);
    $password=filter_var($password, FILTER_SANITIZE_STRING);
    

    //prepare and execute the SQL statement to prevent SQL injection
    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ? AND password = ?");
    $select_admin->execute([$email, $password]);

    //fetch the admin record
    $row = $select_admin->fetch(PDO::FETCH_ASSOC);

    if($select_admin->rowCount() > 0){
        setcookie('id', $row['id'], time() + 60*60*24*30, '/'); // Cookie valid for 30 days
        header('location:dashboard.php');
        exit();
    }else{
        //set warning message for incorrect login
        $warning_msg[] = 'Incorrect email or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auraglow - Admin Login Page</title>
    <link rel="stylesheet" href="/auraglow/css/style.css">
    <!--Font Awesome CDN link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1sr8O+NE5Yr+3LhUQKliwQQVdG0nLMwNLD69Npy4HI+N" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>Login Now</h3>
            <div class="input-field">
                <p>Your Email <span>*</span></p>
                <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box">
            </div>

            <div class="input-field">
                <p>Your Password <span>*</span></p>
                <input type="Password" name="password" required placeholder="Enter your Password" maxlength="50" class="box">

            </div>

            <input type="submit" value="Login Now" name="submit" class="btn">
        </form>

    </div>

    <!-- Sweet Alert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba4NHVW+zYkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--Alert .php to display messages-->
    <?php include '../components/alert.php'; ?>
    
</body>
</html>