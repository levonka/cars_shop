<?php

function addUser($login, $passwd) {
	if (!$login || !$passwd) {
		return (false);
	}

	$users = unserialize(file_get_contents("db/users"));
	if ($users !== false) {
		foreach ($users as $user) {
			if ($user["login"] === $login) {
				return (false);
			}
		}
	}

	$users[] = [
		"login" => $login,
		"passwd" => hash("sha1", $passwd),
		"access" => 0
	];
	file_put_contents("db/users", serialize($users));
	$_SESSION["logged_user"] = $login;
	return (true);
}

function auth($login, $passwd) {
	if (!$login || !$passwd) {
		return (false);
	}

	$users = unserialize(file_get_contents("db/users"));
	if ($users) {
		foreach($users as $user) {
			if ($user["login"] === $login) {
				if ($user["passwd"] === hash("sha1", $passwd)) {
					return (true);
				} else {
					return (false);
				}
			}
		}
	}
	return (false);
}

?>