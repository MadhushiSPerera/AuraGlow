<?php
include 'connect.php';

if(isset($_COOKIE['admin_id'])){
    $admin_id=$_COOKIE['admin_id'];
}else{
    $admin_id='';   
    header('location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraGlow - Admin Login Page</title>
    <link rel="stylesheet" type="text/css" href="admin_style.css">
    <!--Font awesome CDN link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!--Boxicons CDN link-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <div class="main-container">
        <?php include 'admin_header.php';?>
       
        <section class="dashboard">
            <div class="heading">
                <h1>Admin Dashboard</h1>
                <img src="home_back.jpg" alt="searater" class="separator">
            </div>
            <div class="box-container">
                <div class="box">
                    <h3>Welcome Back!</h3>
                    <p><?=$fetch_profile['name'];?></p>
                    <a href="update.php" class="btn">Update Profile</a>
                </div>
                <div class="box">
                    <h3>Welcome Back!</h3>
                    <p><?=$fetch_profile['name'];?></p>
                    <a href="update.php" class="btn">Update Profile</a>
                </div>
                <div class="box">
                    <?php
                    $select_message=$conn->prepare("SELECT * FROM `messages`");
                    $select_message->execute();
                    $number_of_msg=$select_message->rowCount();
                    ?>
                    <h3><?= $number_of_msg; ?></h3>
                    <p>Messages</p>
                    <a href="admin_messages.php" class="btn">Save Messages</a>
                </div>
                <div class="box">
                    <?php
                    $select_products=$conn->prepare("SELECT * FROM `products` WHERE status=?");
                    $select_products->execute();
                    $number_of_products=$select_products->rowCount();
                    ?>
                    <h3><?= $number_of_products; ?></h3>
                    <p>products added</p>
                    <a href="add_products.php" class="btn">Add products</a>
                </div>
                <div class="box">
                    <?php
                    $select_active_products=$conn->prepare("SELECT * FROM `products` WHERE status=?");
                    $select_active_products->execute(['active']);
                    $number_of_active_products=$select_active_products->rowCount();
                    ?>
                    <h3><?= $number_of_active_products; ?></h3>
                    <p>total active products</p>
                    <a href="view_products.php" class="btn">Active products</a>
                </div>
                <div class="box">
                    <?php
                    $select_deactive_products=$conn->prepare("SELECT * FROM `products` WHERE status=?");
                    $select_deactive_products->execute(['deactive']);
                    $number_of_deactive_products=$select_deactive_products->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_products; ?></h3>
                    <p>total deactive products</p>
                    <a href="view_products.php" class="btn">Deactive products</a>
                </div>
                <div class="box">
                    <?php
                    $select_users=$conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();
                    $number_of_users=$select_users->rowCount();
                    ?>
                    <h3><?= $number_of_users; ?></h3>
                    <p>users account</p>
                    <a href="user_accounts.php" class="btn">see users</a>
                </div>
                <div class="box">
                    <?php
                    $select_admins=$conn->prepare("SELECT * FROM `users`");
                    $select_admins->execute();
                    $number_of_admins=$select_admins->rowCount();
                    ?>
                    <h3><?= $number_of_admins; ?></h3>
                    <p>admins account</p>
                    <a href="view_admins.php" class="btn">see admins</a>
                </div>
                <div class="box">
                    <?php
                    $select_orders=$conn->prepare("SELECT * FROM `orders`");
                    $select_orders->execute();
                    $number_of_orders=$select_orders->rowCount();
                    ?>
                    <h3><?= $number_of_orders; ?></h3>
                    <p>total orders placed</p>
                    <a href="admin_order.php" class="btn">total orders</a>
                </div>
                <div class="box">
                    <?php
                    $select_confirm_orders=$conn->prepare("SELECT * FROM `orders` WHERE status=?");
                    $select_orders->execute('ín progress');
                    $number_of_confirm_orders=$select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $number_of_confirm_orders; ?></h3>
                    <p>total confirmed orders</p>
                    <a href="admin_order.php" class="btn">confirm orders</a>
                </div>
                <div class="box">
                    <?php
                    $select_canceled_orders=$conn->prepare("SELECT * FROM `orders` WHERE status=?");
                    $select_orders->execute('canceled');
                    $number_of_canceled_orders=$select_canceled_orders->rowCount();
                    ?>
                    <h3><?= $number_of_canceled_orders; ?></h3>
                    <p>total canceled orders</p>
                    <a href="admin_order.php" class="btn">canceled orders</a>
                </div>
                <div class="box">
                    <?php
                    $select_delivered_orders=$conn->prepare("SELECT * FROM `orders` WHERE status=?");
                    $select_orders->execute('delivered');
                    $number_of_delivered_orders=$select_delivered_orders->rowCount();
                    ?>
                    <h3><?= $number_of_delivered_orders; ?></h3>
                    <p>total delivered orders</p>
                    <a href="admin_order.php" class="btn">delivered orders</a>
                </div>
            </div>
        </section>
    <div>
    <!-- Sweet Alert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba4NHVW+zYkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--Alert .php to display messages-->
    <?php include '../components/alert.php'; ?>

    <!--Cusom JS Link -->
    <script src="../js/admin_script.js"></script>
</body>
</html>