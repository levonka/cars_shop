<?php

include "utils.php";

if (isset($_POST["submit"]))
{
	if ($_POST["submit"] === "add") {
		if (!addCar([$_POST["maker"], $_POST["type"], $_POST["model"], $_POST["color"], $_POST["price"], $_POST["pop"], $_POST["img"]])) {
			header("Location: index.php?page=article&error-add=true");
		} else {
			header("Location: index.php?page=article");
		}
	} else if ($_POST["submit"] === "modify") {
		modifyCar([$_POST["maker"], $_POST["type"], $_POST["model"], $_POST["color"], $_POST["price"], $_POST["pop"], $_POST["img"]], $_POST["id"]);
		header("Location: index.php?page=article");
	}
	else if ($_POST["submit"] === "delete") {
		deleteCar($_POST["id"]);
		header("Location: index.php?page=article");
	}
}

$cars = getCars();

function deleteCar($id) {
	$cars = getCars();
	foreach ($cars as $key => $item) {
		if ($key == $id) {
			unset($cars[$key]);
			break ;
		}
	}
	$fp = fopen('db/cars', 'w');
	foreach ($cars as $item) {
		fputcsv($fp, $item);
	}
	fclose($fp);
}

function modifyCar($car, $id) {
	$cars = getCars();
	foreach ($cars as $key => $item) {
		if ($key == $id) {
			$cars[$key] = $car;
			break ;
		}
	}
	$fp = fopen('db/cars', 'w');
	foreach ($cars as $item) {
		fputcsv($fp, $item);
	}
	fclose($fp);
}

function addCar($car) {
	foreach ($car as $opt) {
		if (!$opt) {
			return (false);
		}
	}
	$fp = fopen('db/cars', 'a');
	fputcsv($fp, $car);
	fclose($fp);
	return (true);
}
?>
<div class="edit_article-section">
    <div class="wrapper">
    <?php
        if (isset($_GET["error-add"])) { ?>
            <div class="error">Input all values</div>
        <?php } ?>
        <div>
            <p class="edit_article-header">Edit articles</p>
            <?php foreach ($cars as $id => $car) { ?>
                <div class="edit-article">
                    <form action="edit_article.php" method="post">
                        <span>Maker: <input required type="text" value="<?= $car[0] ?>" name="maker"></span>
                        <span>Type: <input required type="text" value="<?= $car[1] ?>" name="type"></span>
                        <span>Model: <input required type="text" value="<?= $car[2] ?>" name="model"></span>
                        <span>Color: <input required type="text" value="<?= $car[3] ?>" name="color"></span>
                        <span>Price: <input required type="number" value="<?= $car[4] ?>" name="price"></span>
                        <span>Popular: <input required type="text" value="<?= $car[5] ?>" name="pop"></span>
                        <span>Img: <input required type="text" value="<?= $car[6] ?>" name="img"></span>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="submit" name="submit" value="modify">
                        <input type="submit" name="submit" value="delete">
                    </form>
                </div>
            <?php } ?>
        </div>
        <div class="add-article">
            <p class="edit_article-header">Add articles</p>
            <form action="edit_article.php" method="post">
                <p>Maker: <input required type="text" name="maker"></p>
                <p>Type: <input required type="text" name="type"></p>
                <p>Model: <input required type="text" name="model"></p>
                <p>Color: <input required type="text" name="color"></p>
				<p>Price: <input required type="number" name="price"></p>
				<p>Popular: <input required type="text" name="pop"></p>
				<p>Img: <input required type="text" name="img"></p>
                <input type="submit" name="submit" value="add">
            </form>
        </div>
    </div>
</div>
