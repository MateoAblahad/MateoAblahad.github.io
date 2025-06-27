<?php
session_start();
// Set the current page variable for active state
include "../php/db-accounts.php";
global $pdo;
?>
<link rel="stylesheet" href="../css/header.css">

<!--nav-->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid justify-content-center">
<div class="navbar-nav gap-2">
            <li>
                <a href="\sd24-project-p03-review-your-experience-masuka\php\home.php"><button class="nav-btn <?= ($page == "home") ? "active" : ""; ?>">Home</button></a>
            </li>
            <li>
                <a href="\sd24-project-p03-review-your-experience-masuka\php\profile.php"><button class="nav-btn <?= ($page == "profile") ? "active" : ""; ?>">Profile</button></a>
            </li>
            <li>
                <a href="\sd24-project-p03-review-your-experience-masuka\php\category.php"><button class="nav-btn <?= ($page == "category") ? "active" : ""; ?>">Categories</button></a>
            </li>
            <li>
                <a href="\sd24-project-p03-review-your-experience-masuka\php\about-us.php"><button class="nav-btn <?= ($page == "about-us") ? "active" : ""; ?>">About Us</button></a>
            </li>
            <li>
                <a href="\sd24-project-p03-review-your-experience-masuka\php\contact.php"><button class="nav-btn <?= ($page == "contact") ? "active" : ""; ?>">Contact</button></a>
            </li>
            <li>
                <a href="\sd24-project-p03-review-your-experience-masuka\views\logout.php"><button class="nav-btn <?= ($page == "logout") ? "active" : ""; ?>">Logout</button></a>
            </li>
        </div>
    </div>
</nav>