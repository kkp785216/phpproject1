<?php
session_start();
if (!isset($_SESSION["logedin"]) || $_SESSION["logedin"] !== true) {
    $logedin = false;
    $user_name = "";
} else {
    $logedin = true;
    $user_name = $_SESSION["first_name"];
}

// By default configration
$showAlert = false;
$showWarning = false;
$showDanger = false;
$exists = false;

// Database attach
include "partials/_dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["loginemail"])) {
        $email = $_POST["loginemail"];
        $password = $_POST["loginpassword"];
        $sql = "SELECT * FROM `myusers` WHERE `email` LIKE '$email'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row["password"])) {
                    $_SESSION["logedin"] = true;
                    $logedin = true;
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["first_name"] = $row["first_name"];
                    $showAlert = "Login Successfully";
                    $user_name = $row["first_name"];
                    $serverUrl = $_SERVER['REQUEST_URI'];
                    header("location: $serverUrl");
                    exit;
                } else {
                    $showDanger = "Wrong Password";
                }
            } else {
                $showDanger = "Invalid Crediatials";
            }
        }
    } else if (isset($_POST["signupemail"])) {
        $first_name = $_POST["signupfirstname"];
        $last_name = $_POST["signuplastname"];
        $email = $_POST["signupemail"];
        $password = $_POST["signuppassword"];
        $cpassword = $_POST["csignuppassword"];

        // Check this user already exist or not
        $existSql = "SELECT * FROM `myusers` WHERE `email` LIKE '$email'";
        $existResult = mysqli_query($conn, $existSql);
        if ($existResult) {
            $num = mysqli_num_rows($existResult);
            if ($num >= 1) {
                $exists = true;
            } else {
                $exists = false;
            }
        }

        // Save sign up info into database
        if ($password === $cpassword && $exists !== true) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if ($conn) {
                $sql = "INSERT INTO `myusers` (`first_name`, `last_name`, `email`, `password`) VALUES ('$first_name', '$last_name', '$email', '$hash');";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    // if sinup done then auto login
                    $sql = "SELECT * FROM `myusers` WHERE `email` LIKE '$email'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if ($row = mysqli_fetch_assoc($result)) {
                            if (password_verify($password, $row["password"])) {
                                $_SESSION["logedin"] = true;
                                $logedin = true;
                                $_SESSION["email"] = $row["email"];
                                $_SESSION["first_name"] = $row["first_name"];
                                $showAlert = "Login Successfully";
                                $user_name = $row["first_name"];
                                $serverUrl = $_SERVER['REQUEST_URI'];
                                header("location: $serverUrl");
                                exit;
                            } else {
                                $showDanger = "Wrong Password";
                            }
                        } else {
                            $showDanger = "Invalid Crediatials";
                        }
                    }
                }
            }
        } else if ($password !== $cpassword) {
            $showWarning = "Both password must be same";
        } else if ($exists) {
            $showDanger = "Email already exist";
        }
    } else if (isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        $logedin = false;
        $serverUrl = $_SERVER['REQUEST_URI'];
        header("location: $serverUrl");
        exit;
    }
}

// for serach
if(isset($_GET["search"])){
    if(!isset($homeHeaderSearch)){
        $headerSearch = $_GET["search"];
        header("location: /?search=$headerSearch");
        exit;
    }
}
if(isset($_GET["threadsearch"])){
    if(!isset($searchHeaderSearch)){
        $headerSearch = $_GET["threadsearch"];
        header("location: /threadsearch.php?threadsearch=$headerSearch");
        exit;
    }
}

echo '
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">iForum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                            // fetch and show all categoris
                            if($conn){
                                $catSql = "SELECT category_id, category_name FROM `categories` LIMIT 5;";
                                $catResult = mysqli_query($conn, $catSql);
                                if($catResult){
                                    while($catRow = mysqli_fetch_assoc($catResult)){
                                        echo '<li><a class="dropdown-item" href="/threadlist.php?catid='.$catRow["category_id"].'">'.$catRow["category_name"].'</a></li>';
                                    }
                                }
                            }
                            echo'<!-- <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact.php">Contact</a>
                    </li>
                </ul>
                <form class="d-flex mb-4 mb-lg-0" method="GET">
                    <input class="form-control me-2" type="search" id="search" name="threadsearch" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success me-2" type="submit" id="searchBtn" disabled>Search</button>
                </form>
                <div class="d-flex">';
                if (!$logedin) {
                    include "partials/_loginModel.php";
                    include "partials/_signupModel.php";
                    echo '
                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#loginModel">
                        Login
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupModel">
                        Sign Up
                    </button>';
                } else {
                    echo '
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            ' . $user_name . '
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="/profile.php">Profile</a></li>
                            <li><form method="POST"><input type="hidden" name="logout"><button class="dropdown-item" type="submit">Log out</button></form></li>
                        </ul>
                    </div>';
                }
                echo '
                </div>
            </div>
        </div>
    </nav>
';

if ($showAlert !== false) {
    echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <strong>Sucess!</strong> ' . $showAlert . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
} else if ($showWarning !== false) {
    echo '<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
    <strong>Warning!</strong> ' . $showWarning . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
} else if ($showDanger !== false) {
    echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <strong>Error!</strong> ' . $showDanger . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}