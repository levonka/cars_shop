<?php

include "utils.php";



if (isset($_POST["submit"])) {
	if ($_POST["submit"] === "delete") {
		deleteOrder($_POST["id"]);
		header("Location: index.php?page=orders");
	}
}

$orders = getAllOrders();

function deleteOrder($id) {
	$orders = getAllOrders();

	foreach ($orders as $key => $order) {
		if ($key == $id) {
			unset($orders[$key]);
			break ;
		}
	}
	$fp = fopen("db/orders", "w");
	fclose($fp);
	foreach ($orders as $order) {
		addOrder($order[0], $order[1], $order[2], $order[3]);
	}
}

function getAllOrders() {
	$handle = fopen("db/orders", "r");
	$orders = [];
	$cars = getCars();
	while (($order = fgetcsv($handle)) !== false) {
		$data = [];
		for ($i = 0; $i < count($order); $i++) {
			if ($i > 2) {
				$data[3][] = $cars[$order[$i]];
			} else {
				$data[$i] = $order[$i];
			}
		}
		$orders[] = $data;
		
	}
	fclose($handle);
	return ($orders);
}


if (isset($orders)) { ?>
    <div class="edit-orders-wrapper">
        <div class="wrapper">
            <div class="edit-orders">
            <?php foreach ($orders as $id => $order) { ?>
                <div class="order">
                    <fieldset>
                        <legend>Personal information:</legend>
                        <span>Login: <b><?= $order[0] ?></b></span>
                        <span>Price: <b><?= $order[1] ?></b></span>
                        <span>Count: <b><?= $order[2] ?></b></span>
                        <div class="order-block-info">
                            <?php for ($i = 3; $i < count($order); $i++) { ?>
                                    <?php foreach ($order[$i] as $data) { ?>
                                    <div class="order-block-car">Car:
                                        <div>Maker: <?= $data[0] ?></div>
                                        <div>Type: <?= $data[1] ?></div>
                                        <div>Model: <?= $data[2] ?></div>
                                        <div>Color: <?= $data[3] ?></div>
                                        <div>Price: <?= $data[4] ?></div>
                                    </div>
                                    <?php } ?>
                            <?php } ?>
                        </div>
                        <form action="edit_orders.php" method="post">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input class="delete_btn" type="submit" name="submit" value="delete">
                        </form>
                    </fieldset>
                </div>
            <?php } ?>
        <?php } ?>
            </div>
        </div>
    </div>

