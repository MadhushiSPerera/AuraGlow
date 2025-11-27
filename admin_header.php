<?php
// admin_header.php - simplified and corrected
// Expects $admin_id to be available (set from cookie in pages like dashboard.php)
if (!isset($admin_id) || empty($admin_id)) {
    // nothing to show if no admin id
    return;
}

// fetch profile safely
$fetch_profile = null;
try {
    $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ? LIMIT 1");
    $select_profile->execute([$admin_id]);
    if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    error_log('Header profile fetch error: ' . $e->getMessage());
}
?>

<header>
    <div class="logo">
        <img src="logo.png" alt="Auraglow Logo" width="200">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>
    <div class="profile-detail">
        <?php if ($fetch_profile): ?>
        <div class="profile">
            <img src="uploaded_files/<?= htmlspecialchars($fetch_profile['image'] ?? '') ?>" alt="" class="logo-img" width="150">
            <p><?= htmlspecialchars($fetch_profile['name'] ?? '') ?></p>
            <div class="flex-btn">
                <a href="profile.php" class="btn">Profile</a>
                <a href="admin_logout.php" onclick="return confirm('logout from this website?');" class="btn">Logout</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</header>

<div class="sidebar-container">
    <div class="sidebar">
        <?php if ($fetch_profile): ?>
        <div class="profile">
            <img src="uploaded_files/<?= htmlspecialchars($fetch_profile['image'] ?? '') ?>" alt="" class="logo-img" width="100">
            <p><?= htmlspecialchars($fetch_profile['name'] ?? '') ?></p>
        </div>
        <?php endif; ?>

        <h5>Menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>dashboard</a></li>
                <li><a href="register.php"><i class="bx bxs-user-detail"></i>Add Admin</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i>Add Products</a></li>
                <li><a href="view_products.php"><i class="bx bxs-food-menu"></i>View Products</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>Accounts</a></li>
                <li><a href="admin_logout.php" onclick="return confirm('logout from this website?');" class="btn"><i class="bx bx-log-out"></i>Logout</a></li>
            </ul>
        </div>

        <h5>Contact us</h5>
        <div class="contact-info">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-twitter"></i>
        </div>
    </div>
</div>