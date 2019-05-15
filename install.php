#!/usr/bin/php
<?php

createUsers();
createCars();
createOrder();

function createOrder() {
	$path = "db";
	$file = "db/orders";
	if (!file_exists($path)) {
		mkdir($path);
	}
	file_put_contents($file, "");
}

function createCars() {
	$path = "db";
	if (!file_exists($path)) {
		mkdir($path);
	}
	addCar(["audi", "sedan" ,"a4", "black" , "14000", "true", "https://avatars.mds.yandex.net/get-autoru-all/1633415/80866d3ffe417fc92fc6798e1be98e7e/1200x900"]);
	addCar(['audi','sedan','tt','red','40760','true','https://avatars.mds.yandex.net/get-autoru-all/1712138/1c163426f5a8d70d8c4cb8a681765c9e/1200x900']);
	addCar(["audi",'offroad','Q7','black','13830','false','https://avatars.mds.yandex.net/get-autoru-all/1879106/fe292e0fcd26ef142bbce35508d4523a/1200x900']);
	addCar(['audi','sedan','S5','red','13830','false','https://avatars.mds.yandex.net/get-autoru-all/1853361/98367c5feac3684a8bac8c46d341154c/1200x900']);
	addCar(['audi','offroad','Q7','white','13215','false','https://avatars.mds.yandex.net/get-autoru-all/1667349/d4efffe120ebcb9673c8d74e894b8507/1200x900']);
	addCar(['bmw','offroad','x6','white','30000','false','https://avatars.mds.yandex.net/get-autoru-all/1882904/51e72721c64af5680c7346d0b6d40526/1200x900']);
	addCar(['bmw','coupe',"6 series",'white','65384','false','https://avatars.mds.yandex.net/get-autoru-all/1879091/9742d08b08c1415a73aff348409876f7/1200x900']);
	addCar(['bmw','coupe',"3 series",'white','5384','false','https://avatars.mds.yandex.net/get-autoru-all/1885557/5a538227dafe1c3e1ca0f32f2dbb4fc3/1200x900']);
	addCar(['bmw','offroad','x1','black','32292','false','https://avatars.mds.yandex.net/get-autoru-all/1877442/e92603cafffc38f642c180d78ea79829/1200x900']);
	addCar(['mers','offroad','glc','black','34000','true','https://avatars.mds.yandex.net/get-autoru-all/1712138/4b4fe7b76056e3f9656c626411264e14/1200x900']);
	addCar(['mers','offroad',"G-klasse AMG I",'white','89230','true','https://avatars.mds.yandex.net/get-autoru-all/1893093/ea802a53886400ca713dca50c3b2dbd5/1200x900']);
	addCar(['mers','sedan','E-klasse','black','26000','true','https://avatars.mds.yandex.net/get-autoru-all/1886836/b0eac98322cc0311d37698abda637253/1200x900']);
	addCar(['mers','coupe','gt','black','103000','false','https://avatars.mds.yandex.net/get-autoru-all/1534759/a122fa2f8322cb77a7e275aacd8e3966/1200x900']);
	addCar(['mers','coupe',"CL-klasse III",'black','26150','false','https://avatars.mds.yandex.net/get-autoru-all/1604871/bf651ae8cedfa8aaa6cef96a4eb26b26/1200x900']);
	addCar(['vw','offroad',"Tiguan I",'black','17000','false','https://avatars.mds.yandex.net/get-autoru-all/1896796/822f821c3fe079442d2d40e019b43815/1200x900']);
	addCar(['vw','sedan',"Passat B3",'white','1380','false','https://avatars.mds.yandex.net/get-autoru-all/1525732/0dbcbb0998f5b163dfbfd4ecba79a944/1200x900']);
	addCar(['vw','coupe',"Type 1",'white','23076','true','https://avatars.mds.yandex.net/get-autoru-all/1336605/01dc5718e783147f07064d052fa980d5/1200x900']);
	addCar(['mers','coupe',"S-klasse VI",'black','80000','false','https://avatars.mds.yandex.net/get-autoru-all/1878758/140cf7aaa681da788d1c469590fe0447/1200x900']);
}

function addCar($car) {
	$fp = fopen('db/cars', 'a');
	fputcsv($fp, $car);
	fclose($fp);
	return (true);
}

function createUsers() {
	$path = "db";
	$file = "db/users";
	if (!file_exists($path)) {
		mkdir($path);
	}
	$arr[] = [
		"login" => "root",
		"passwd" => hash("sha1", "root"),
		"access" => 1
	];
	file_put_contents($file, serialize($arr));
}
?>