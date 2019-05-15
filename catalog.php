<?php

include "utils.php";

$handle = fopen("db/cars", "r");

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["sort"])) {
    $_SESSION["sort"] = [
        "maker" => "all", 
        "type" => "all",
        "color" => "all"
    ];
}

if (isset($_POST["submit"])) {
	if (!isset($_SESSION)) {
		session_start();
	}
	if ($_POST["submit"] === "add to cart") {
		addToBasket($_POST["car"], $_POST["id"]);
		header("Location: index.php?page=catalog");
    } else if ($_POST["submit"] === "Accept") {
        $_SESSION["sort"] = [
            "maker" => $_POST["maker"], 
            "type" => $_POST["type"],
            "color" => $_POST["color"]
        ];
        header("Location: index.php?page=catalog");
    }
}

function addToBasket($car, $id) {
    $car = explode(";", $car);
    if (!isset($_SESSION["basket"][$id])) {
    $_SESSION["basket"][$id] = $car;
    $_SESSION["count_basket"] = isset($_SESSION["count_basket"]) ? $_SESSION["count_basket"] + 1 : 1;
    $_SESSION["price_basket"] = isset($_SESSION["price_basket"]) ? $_SESSION["price_basket"] + $car[4] : $car[4];
    }
}

function sortCar($car, $sort) {
    if (($car[0] === $sort["maker"] || $sort["maker"] === "all") &&
        ($car[1] === $sort["type"] || $sort["type"] === "all") &&
        ($car[3] === $sort["color"] || $sort["color"] === "all")) {
            return (true);
        }
    return (false);
}

$cars = getCars();

?>
<div class="catalog-wrapper">
<div class="filter">
    <div class="wrapper">
        <div class="filter-wrapper">
            <form action="catalog.php" method="post">
                <p>Show only:</p>
                <div class="filter-div"><p>MAKER</p>
                    <select name="maker" class="filter-select">
                        <option selected value="all">all</option>
                        <option value="bmw">BMW</option>
                        <option value="audi">AUDI</option>
                        <option value="vw">VW</option>
                        <option value="mers">MERCEDES</option>
                    </select>
                </div>
                <div class="filter-div"><p>TYPE</p>
                    <select name="type" class="filter-select">
                        <option selected value="all">all</option>
                        <option value="sedan">sedan</option>
                        <option value="offroad">offroad</option>
                        <option value="coupe">coupe</option>
                    </select>
                </div>
                <div class="filter-div"><p>COLOR</p>
                    <select name="color" class="filter-select">
                        <option selected value="all">all</option>
                        <option value="black">black</option>
                        <option value="white">white</option>
                        <option value="red">red</option>
                    </select>
                </div>
                <input type="submit" name="submit" value="Accept">
            </form>
        </div>
    </div>
</div>
<div class="pricing">
    <div class="wrapper">
        <div class="price-cards">
            <?php
				foreach ($cars as $id => $car) {
                    if (sortCar($car, $_SESSION["sort"])) {?>
            <div class="price-card <?php if (isset($car[5]) && $car[5] == "true") {?>popular-item<?php } ?>">
                <div class="price-img" style="background-image: url(<?= $car[6] ?>);"></div>
                <div class="price-text">
                    <p class="mark"><?= $car[0] . " " . $car[2] ?></p>
                    <span class="price"><?= $car[4] . ".00$"?></span>
                    <table class="car">
                        <tr>
                            <th>Type:</th>
                            <td><?= $car[1] ?></td>
                        </tr>
                        <tr>
                            <th>Color:</th>
                            <td><?= $car[3] ?></td>
                        </tr>
                    </table>
					<form action="catalog.php" method="post">
						<input type="hidden" name="car" value="<?= implode(";", $car) ?>">
						<input type="hidden" name="id" value="<?= $id ?>">
						<input class="button" type="submit" name="submit" value="add to cart">
					</form>
                </div>
            </div>
            <?php } 
            } ?>
        </div>
    </div>
</div>
</div>