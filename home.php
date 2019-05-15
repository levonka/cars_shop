<?php

include "utils.php";

$cars = getCars();

?>

<html>
    <main>
        <div class="header-main">
            <div class="wrapper">
                <div class="header-text">
                    <h1><span>RUSH00</span> <br> School21<br>project</h1>
                    <p>car shop</p>
                </div>
            </div>
        </div>
        <div class="pricing">
            <div class="wrapper">
                <h2>Shop Best Sellers</h2>
                <div class="price-cards">
                <?php for ($i = 0; $i < count($cars); $i++) {
                    if (isset($cars[$i][5]) && $cars[$i][5] == "true") {?>
                    <div class="price-card <?php if (isset($cars[$i][5]) && $cars[$i][5] == "true") {?>popular-item<?php } ?>">
                       <div class="price-img" style="background-image: url(<?= $cars[$i][6] ?>);"></div>
                       <div class="price-text">
                           <p class="mark"><?= $cars[$i][0]." ".$cars[$i][2] ?></p>
                           <span class="price"><?= $cars[$i][4]."00$" ?></span>
                           <table class="car">
                               <tr>
                                   <th>Type:</th>
                                   <td><?= $cars[$i][1] ?></td>
                               </tr>
                               <tr>
                                   <th>Color:</th>
                                   <td><?= $cars[$i][3] ?></td>
                               </tr>
                           </table>
                           <form action="catalog.php" method="post">
                               <input type="hidden" name="car" value="<?php $cars[$i] ?>">
                               <input type="hidden" name="id" value="<?= $i ?>">
                           </form>
                       </div>
                   </div>
                <?php } 
                } ?>
                </div>
            </div>
        </div>
        <div class="our-story">
            <div class="wrapper-story">
                <p>We are in business for over 6 years providing amazing services to client and people love them to the core. View our story to know more.</p>
            </div>
        </div>
    </main>
</html>