<?php
include 'connect.php';

if(isset($_POST['submit'])){
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $password_input = isset($_POST['password']) ? $_POST['password'] : '';

    // We'll fetch by email only and support several stored password formats so existing admins can still log in:
    // 1) password_hash() (recommended) -> verify with password_verify()
    // 2) SHA1 stored previously -> compare with sha1(input)
    // 3) plaintext stored (legacy) -> compare directly (insecure)
    // On successful login, we'll upgrade plaintext/SHA1 passwords to a secure password_hash().

    try {
        $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ? LIMIT 1");
        $select_admin->execute([$email]);
        $row = $select_admin->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $stored = isset($row['password']) ? $row['password'] : '';
            $authenticated = false;

            // 1) password_hash() (bcrypt/argon), length varies, password_verify handles it
            if (!empty($stored) && password_verify($password_input, $stored)) {
                $authenticated = true;
            }

            // 2) SHA1 legacy
            if (!$authenticated && !empty($stored) && $stored === sha1($password_input)) {
                $authenticated = true;
                // upgrade the hash to password_hash()
                $newHash = password_hash($password_input, PASSWORD_DEFAULT);
                $upd = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
                $upd->execute([$newHash, $row['id']]);
            }

            // 3) plaintext legacy (very insecure)
            if (!$authenticated && !empty($stored) && $stored === $password_input) {
                $authenticated = true;
                // upgrade the hash to password_hash()
                $newHash = password_hash($password_input, PASSWORD_DEFAULT);
                $upd = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
                $upd->execute([$newHash, $row['id']]);
            }

            if ($authenticated) {
                setcookie('admin_id', $row['id'], time() + 60*60*24*30, '/'); // Cookie valid for 30 days
                header('location:dashboard.php');
                exit();
            } else {
                $warning_msg[] = 'Incorrect email or password!';
            }
        } else {
            $warning_msg[] = 'Incorrect email or password!';
        }
    } catch (PDOException $e) {
        error_log('Database error during admin login: ' . $e->getMessage());
        $warning_msg[] = 'An internal error occurred. Please contact the site administrator.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auraglow - Admin Login Page</title>
    <link rel="stylesheet" href="admin_style.css">
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
    <?php include 'alert.php'; ?>
    
    <!--custom js file link-->
    <script src="admin_script.js"></script>
</body>
</html>