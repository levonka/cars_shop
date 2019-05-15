<?php

include "utils.php";

if (isset($_SESSION) && isset($_SESSION['basket'])) {
	$cars = $_SESSION["basket"];
}

if (isset($_POST["submit"])) {
	if (!isset($_SESSION)) {
		session_start();
	}
	if ($_POST["submit"] === "Delete") {
		delCarBasket($_POST["id"]);
		header("Location: index.php?page=basket");
	} else if ($_POST["submit"] === "Confirm order") {
		addOrder($_SESSION["logged_user"], $_SESSION["price_basket"], $_SESSION["count_basket"], $_SESSION["basket"]);
		unset($_SESSION["basket"]);
		unset($_SESSION["count_basket"]);
		unset($_SESSION["price_basket"]);
		header("Location: index.php?page=basket");
	}
}

function delCarBasket($id) {
	$cars = $_SESSION["basket"];
	foreach ($cars as $key => $value) {
		if ($key == $id) {
			$price = $cars[$key][4];
			unset($_SESSION["basket"][$key]);
			break ;
		}
	}
	$_SESSION["count_basket"] -= 1;
	$_SESSION["price_basket"] -= $price;
}

?>

<div class="pricing basket">
    <div class="wrapper">
        <div class="price-cards">
            <?php
			if (isset($cars)) {
				foreach ($cars as $id => $car) { ?>
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
					<form action="basket.php" method="post">
						<input type="hidden" name="id" value="<?= $id ?>">
						<input class="button" type="submit" name="submit" value="Delete">
					</form>
                </div>
            </div>
			<?php } 
			} ?>
        </div>
    </div>
</div>
<div class="basket-stat">
    <div class="wrapper">
        <div class="basket-stat-wrapper">
        <?php if (isset($_SESSION["basket"]) && isset($_SESSION["logged_user"])) { ?>
            <div class="basket-stat-count">Count: <?= $_SESSION["count_basket"] ?></div>
            <div class="basket-stat-price">Total Price: <?= $_SESSION["price_basket"] ?></div>
            <form class="" action="basket.php" method="post">
                <input type="submit" name="submit" value="Confirm order">
            </form>
        <?php } ?>
        </div>
    </div>
</div>
