<?php

if (isset($_POST["submit"]))
{
    if (!isset($_SESSION)) {
        session_start();
    }
	if ($_POST["submit"] === "delete") {
		if (!delUser($_POST["user"])) {
			header("Location: index.php?page=profile&error-del=true");
		} else {
			header("Location: index.php?page=profile");
		}
	} else if ($_POST["submit"] === "admin") {
		if (!setAdmin($_POST["user"])) {
			header("Location: index.php?page=profile&error-admin=true");
		} else {
			header("Location: index.php?page=profile");
		}
	} else if ($_POST["submit"] === "change") {
		if (!changePass($_SESSION["logged_user"], $_POST["oldpass"], $_POST["newpass"])) {
			header("Location: index.php?page=profile&error-change=true");
		} else {
			header("Location: index.php?page=profile");
		}
	} else if ($_POST["submit"] === "delete user") {
		if (!delUser($_SESSION["logged_user"])) {
			header("Location: index.php?page=profile&error-del=true");
		} else {
			session_destroy();
			header("Location: index.php");
		}
	}
}

function changePass($name, $oldpass, $newpass) {
	if (!$oldpass || !$newpass) {
		return (false);
	}
	$users = unserialize(file_get_contents("db/users"));
	if ($users) {
		foreach ($users as &$user) {
			if ($user["login"] === $name && $user["passwd"] === hash("sha1", $oldpass)) {
				$user["passwd"] = hash("sha1", $newpass);
				file_put_contents("db/users", serialize($users));
				unset($user);
				return (true);
			}
		}
		unset($user);
	}
	return (false);
}

function setAdmin($name) {
	if ($_SESSION["logged_user"] !== "root") {
		return (false);
	}
	$users = unserialize(file_get_contents("db/users"));
	if ($users) {
		foreach($users as &$user) {
			if ($user["login"] === $name) {
				$user["access"] = $user["access"] === 1 ? 0 : 1;
				file_put_contents("db/users", serialize($users));
				unset($user);
				return (true);
			}
		}
		unset($user);
	}
	return (false);
}

function delUser($name) {
	$users = unserialize(file_get_contents("db/users"));
	if ($users) {
		foreach ($users as $key => $user) {
			if ($user["login"] === $name && ($_SESSION["logged_user"] === "root" || $_SESSION["logged_user"] === $name || $user["access"] != 1)) {
				unset($users[$key]);
				file_put_contents("db/users", serialize($users));
				return (true);
			}
		}
	}
	return (false);
}
?>
<div class="profile">
    <div class="wrapper">
    <?php
    if (isset($_GET["error-add"])) { ?>
    	<div class="error">Input all values</div>
    <?php }
    else if (isset($_GET["error-del"])) { ?>
    	<div class="error">Can't del user</div>
    <?php }
    else if (isset($_GET["error-admin"])) { ?>
    	<div class="error">Can't give admin</div>
    <?php }
    else if (isset($_GET["error-change"])) { ?>
    	<div class="error">Incorrect password</div>
    <?php } ?>

    <div class="header-form change-passwd">
    	<form action="profile.php" method="post">
            <div class="header-inputs">
                <h4>Change password</h4>
                <input required type="text" name="oldpass" placeholder="Old password">
        		<input required type="text" name="newpass" placeholder="New password">
    		    <input class="button" type="submit" name="submit" value="change">
            </div>
		</form>
		<?php if ($_SESSION["logged_user"] !== "root") { ?>
		<form action="profile.php" method="post">
            <div class="header-inputs">
    		    <input class="button" type="submit" name="submit" value="delete user">
            </div>
		</form>
		<?php } ?>
    </div>
    </div>
    <div class="header-form admin-user-manipul">
    <?php if (isset($_SESSION["access"])) {
    	$users = unserialize(file_get_contents("db/users"));
    	foreach ($users as $user) {
    		if ($user["login"] !== $_SESSION["logged_user"] && $user["login"] !== "root") { ?>
                <div class="user">
                    login: <span class="admin-user-login"><?= $user["login"] ?></span> access: <span class="admin-user-login"><?= ($user["access"]) ? "admin" : "user";?></span>
                    <form action="profile.php" method="post">
                        <input type="hidden" name="user" value="<?= $user["login"] ?>">
                        <input type="submit" name="submit" value="admin">
                        <input type="submit" name="submit" value="delete">
    			    </form>
    		    </div>
    		<?php }
    		} ?>
    <?php } ?>
    </div>
</div>
