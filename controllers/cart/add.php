<?php
// Include configuration
require_once '../../config/config.php';
require_once '../../config/Database.php';
require_once '../../controllers/CartController.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('/views/auth/unified_login.php');
}

// Check if user is admin or delivery personnel
if (isAdmin() || isDelivery()) {
    // Redirect to appropriate dashboard
    if (isAdmin()) {
        redirect('/admin/dashboard.php');
    } else {
        redirect('/delivery/dashboard.php');
    }
}

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Create cart controller
$cartController = new CartController($db);

// Save scroll position to session if provided
if (isset($_POST['scroll_position'])) {
    $_SESSION['scroll_position'] = (int)$_POST['scroll_position'];
}

// Handle add to cart
$cartController->addToCart();

// Redirect back to previous page (this should not be reached as addToCart redirects)
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('/index.php');
header('Location: ' . $referer);
exit;
?>
