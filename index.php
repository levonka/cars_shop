<?php

session_start();

include "auth.php";

if (!isset($_GET['page']) || $_GET['page'] === 'home') {
    $page = "home.php";
} else if ($_GET["page"] === "profile") {
	$page = "profile.php";
} else if ($_GET["page"] === "catalog") {
	$page = "catalog.php";
} else if ($_GET["page"] === "article") {
	$page = "edit_article.php";
} else if ($_GET["page"] === "basket") {
	$page = "basket.php";
} else if ($_GET["page"] === "orders") {
	$page = "edit_orders.php";
}

if (isset($_POST["login"]))
    $login = $_POST["login"];
if (isset($_POST["passwd"]))
    $passwd = $_POST["passwd"];


if (isset($_POST["submit"]))
{
    if ($_POST["submit"] == "Register" && addUser($login, $passwd))
    {
        $_SESSION["logged_user"] = $login;
        if ($login === "root") {
            $_SESSION["access"] = 1;
        }
        header("Location: index.php");
    }
    else if ($_POST["submit"] == "Log in")
    {
        if (!auth($login, $passwd))
        {
            header("Location: index.php?error-auth=true");
        }
        else
        {
            $_SESSION["logged_user"] = $login;
            if ($login === "root" || checkAccess($login))
            {
                $_SESSION["access"] = 1;
            }
            header("Location: index.php");
        }
    }
}
else if (isset($_POST["submit"]) || isset($_GET["logout"])) {
    $_SESSION["logged_user"] = "";
	$_SESSION["access"] = 0;
	session_destroy();
    header("Location: index.php");
}

function checkAccess($login) {
	$users = unserialize(file_get_contents("db/users"));
	if ($users) {
		foreach ($users as $user) {
			if ($user["login"] === $login && $user["access"] == 1) {
				return (true);
			}
		}
	}
	return (false);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>rush00</title>
	<link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/catalog.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/edit_article.css">
    <link rel="stylesheet" href="css/basket.css">
    <link rel="stylesheet" href="css/edit_orders.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
	<script src="scripts/script.js" defer></script>
</head>
<body>
	<div id="header_overlay" class="header-overlay">
		<div id="header-form--log_in" class="header-form">
			<div id="popup_close" class="popup__close">X</div>
			<form action="index.php" method="post">
				<div class="header-inputs">
					<h4>Your account for everything</h4>
					<input required type="text" name="login" placeholder="Login">
					<input required type="password" name="passwd" placeholder="Password">
					<input class="button" type="submit" name="submit" value="Log in">
					<p>Not a member? <span id="join_btn" class="member-btn">Join now.</span></p>
				</div>
			</form>
		</div>
		<div id="header-form--join" class="header-form">
			<div id="popup_close2" class="popup__close">X</div>
			<form action="index.php" method="post">
				<div class="header-inputs">
					<h4>Registration<br>form</h4>
					<input required type="text" placeholder="Login (length lower 18 characters)" name="login">
					<input required type="password" placeholder="Password" name="passwd">
					<input class="button" type="submit" name="submit" value="Register">
					<p>Already a member? <span id="sign_btn" class="member-btn">Sign in.</span></p>
				</div>
			</form>
		</div>
	</div>
	<header>
        <div id="errorAlert" class="wrapper-auth-error">
            <div class="wrapper">
            <?php
            if (isset($_GET["error-auth"])) {
                ?>
                <div class="error-auth" style="">Invalid login or password</div>
                <div id="errorAuthBtn" class="error-auth" style="">X</div>
                <?php
            }
            ?>
            </div>
        </div>
		<div class="wrapper">
			<div class="header-top">
				<div class="menu">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="?page=catalog">Catalog</a></li>
						<?php
						if (isset($_SESSION["logged_user"])) {
						?>
							<li class="dropdown">
								<div class="dropdown-button sign_up--btn"><?= $_SESSION["logged_user"] ?></div>
								<div class="dropdown-content">
									<?php if (isset($_SESSION["access"]) && $_SESSION["access"] == 1) {?>
									<a href="?page=article">Edit articles</a>
									<a href="?page=orders">Edit orders</a>
									<?php } ?>
									<a href="?page=profile">Profile</a>
									<a href="?logout=true">Logout</a>
								</div>
							</li>
						<?php
						} else {
						?>
							<li><span id="sign_up--btn" class="sign_up--btn" href="#">Join/ Log in to Account</span></li>
						<?php
						}
						?>
                        <a class="basket-icon-a" href="?page=basket">
                            <li class="basket-icon-li">
                                <img class="basket-icon" src="images/shopping-cart.svg" alt="">
                                <div class="basket-icon-div">
                                    <span class="basket-amount"><?php if (isset($_SESSION["count_basket"])) { echo $_SESSION["count_basket"]; }?></span>
                                    <span class="basket-price"><?php if (isset($_SESSION["price_basket"])) { echo $_SESSION["price_basket"]; }?>$</span>
                                </div>
                            </li>
                        </a>
                    </ul>
				</div>
			</div>
		</div>
	</header>
    <?php include $page; ?>
    <footer>
        <div class="wrapper">
            <div class="footer-section">
                <p>All Rights Reserved |  2019  |  <a href="#">agottlie</a> and <a href="#">afalmer-</a></p>
            </div>
        </div>
    </footer>

	</body>
	</html>