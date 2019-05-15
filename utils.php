<?php

function getCars() {
	$handle = fopen("db/cars", "r");
	$cars = [];
	while (($car = fgetcsv($handle)) !== false) {
		$cars[] = $car;
	}
	fclose($handle);
	return ($cars);
}

function addOrder($login, $price, $count, $cars) {
	$fp = fopen('db/orders', 'a');
	$order[] = $login;
	$order[] = $price;
	$order[] = $count;
	foreach ($cars as $key => $car) {
		$order[] = $key;
	}
	fputcsv($fp, $order);
	fclose($fp);
}

?>