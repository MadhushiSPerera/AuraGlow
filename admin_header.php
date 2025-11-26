<header>
    <div class="logo">
        <imag src="logo.png" alt="Auraglow Logo" width="200">


    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>
    <div class="profile-detail">
        <?php
            $select_profile=$conn->prepare("SELECT * FROM 'admins' WHERE id=?");
            $select_profile->execute([$admin_id]);
            if($select_profile->rowCount()>0){
                $fetch_profile=$select_profile->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        <div class="profile">
            <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="" class="logo-img" width="150">
            <p><?= $fetch_profile['name']; ?></p>
            <div class="flex-btn">
                <a href="profile.php" class="btn">Profile</a>
                <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="btn">logout</a>
            <div>
        </div>
        <?php } ?>

    </div>

</header>
<div class="sidebar-container">
    <div class="sidebar">
        <?php
        $select_profile=$conn->prepare("SELECT * FROM `admins` WHERE id=?");
        $select_profile->execute([$admin_id]);
        if($select_profile->rowCount()>0){
            $fetch_profile=$select_profile->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <div class="profile">
            <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="" class="logo-img" width="100">
            <p><?= $fetch_profile['name']; ?></p>
        </div>
        <?php } ?>

        <h5>Menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>dashboard</a></li>
                <li><a href="register.php"><i class="bx bxs-user-detail"></i>Add Admin</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i>Add Products</a></li>
                <li><a href="view_products.php"><i class="bx bxs-food-menu"></i>View Products</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>Accounts</a></li>
                <li><a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="btn"><i class="bx bx-log-out"></i>Add Products</a></li>


            </ul>
    </div>

    <h5>Contact us</h5>
    <div class="contact-info">
        <i class="bx bxl-facebook"></i>
        <i class="bx bxl-instagram"></i>
        <i class="bx bxl-linkdin"></i>
        <i class="bx bxl-twitter"></i>
</div>