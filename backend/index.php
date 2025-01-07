<?php
require_once '../includes/functions.php'; // Pastikan fungsi seperti sanitizeInput dan fetchAll tersedia
$page = "dashboard";
$page_name = "Dashboard";
?>
<?php 
// PARTIAL HEAD & NAVIGATION
include 'partial/head.php'; 
include 'partial/sidebar.php'; 
include 'partial/navbar.php'; 

// KONTEN
include 'cards/_stats.php'; 
include 'tables/_sekolah.php'; 


// PARTIAL FOOTER
include 'partial/credit.php'; 
include 'partial/footer.php'; 
?>