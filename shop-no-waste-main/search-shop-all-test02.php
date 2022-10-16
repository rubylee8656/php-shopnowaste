<?php require __DIR__ . '/parts/connect_db.php';

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'getData' => $_GET // 除錯用的
];

// $shop_sql = "SELECT `shop_list`.*,`shop_address_city`.`shop_city`,`shop_address_area`.`shop_area` 
// FROM `shop_list` 
// JOIN `shop_address_city` ON `shop_list`.`shop_address_city_sid` = `shop_address_city`.`sid` 
// JOIN `shop_address_area` ON `shop_list`.`shop_address_area_sid` = `shop_address_area`.`sid` 
// WHERE `shop_address_city`.`sid`= ? 
// AND `shop_address_area`.`sid` = ?";

// $shop_sql = "SELECT `shop_list`.*,`shop_address_city`.`shop_city`,`shop_address_area`.`shop_area`,`food_product`.`product_name`,`food_category`.`product_categories` 
// FROM `shop_list` 
// JOIN `shop_address_city` ON `shop_list`.`shop_address_city_sid` = `shop_address_city`.`sid` 
// JOIN `shop_address_area` ON `shop_list`.`shop_address_area_sid` = `shop_address_area`.`sid` 
// JOIN `food_product` ON `shop_list`.`sid` = `food_product`.`shop_list_sid` 
// JOIN `food_category` ON `food_product`.`product_categories_sid` = `food_category`.`sid` 
// WHERE `shop_address_city`.`sid`= ? 
// AND `shop_address_area`.`sid` = ? 
// AND `food_category`.`product_categories` = ?";

$city_sql = "SELECT `shop_list`.*,`shop_address_city`.`shop_city` 
FROM `shop_list` 
JOIN `shop_address_city` ON `shop_list`.`shop_address_city_sid` = `shop_address_city`.`sid` 
WHERE `shop_address_city`.`sid`= 2";

$cityRows = $pdo->query($city_sql)->fetchAll();


$cityRows = "SELECT *,`shop_address_area`.`shop_area` 
FROM `shop_list` 
JOIN `shop_address_area` ON `shop_list`.`shop_address_area_sid` = `shop_address_area`.`sid` 
WHERE `shop_address_area`.`sid` = 14";

$areaRows = $pdo->query($cityRows)->fetchAll();

// $stmt->execute([
//     $_GET['shop_area']
// ]);

// $output = ['$shopRows' => $shopRows];

echo json_encode($areaRows, JSON_UNESCAPED_UNICODE);

?>

<!-- <?php require __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/nav-bar-admin.php'; ?>
<div class="container">
    <div class="row">
        <?php foreach ($shopRows as $r) : ?>
            <div class="col-3">
                <div class="card">
                    <div class="img-wrap overflow-hidden" style="height: 200px;">
                        <img src="./uploads/<?= $r['shop_cover'] ?>" class="card-img-top w-100">
                    </div>
                    <div class="card-body">
                        <h3 class="shop_name"><?= htmlentities($r['shop_name']) ?></h3>
                        <!-- <p class="shop_cat"><?= $r['food_category'] ?></p> -->
                        <p class="shop_address">
                            <?= $r['shop_city'] ?><?= $r['shop_area'] ?><?= $r['shop_address_detail'] ?>
                        </p>
                        <p class="shop_phone"><?= $r['shop_phone'] ?></p>
                        <p>營業時間: <?= $r['shop_opentime'] ?> - <?= $r['shop_closetime'] ?></p>
                        <p>最後取餐時間: <?= $r['shop_deadline'] ?></p>
                        <a href="#" class="btn btn-primary">Go shopping</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include __DIR__ . '/parts/html-foot.php'; ?>
</div>
</div> -->