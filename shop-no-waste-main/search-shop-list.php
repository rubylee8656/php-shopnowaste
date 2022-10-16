<?php
require __DIR__ . '/parts/connect_db.php';

    $perPage = 5; // 一頁有幾筆
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    // 算總筆數
    $t_sql = "SELECT COUNT(1) FROM shop_list ";
    $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
    $totalPages = ceil($totalRows / $perPage);
    $rows = [];
    // 如果有資料
    if ($totalRows) {
        if ($page < 1) {
            header('Location: ?page=1');
            exit;
        }
        if ($page > $totalPages) {
            header('Location: ?page=' . $totalPages);
            exit;
        }

        $sql = sprintf(
            "SELECT * FROM shop_list ORDER BY sid DESC LIMIT %s, %s",
            ($page - 1) * $perPage,
            $perPage
        );
        $rows = $pdo->query($sql)->fetchAll();
    }
    $output = [
        'totalRows' => $totalRows,
        'totalPages' => $totalPages,
        'page' => $page,
        'rows' => $rows,
        'perPage' => $perPage,
    ];

// echo json_encode($output); exit;
?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/nav-bar-admin.php'; ?>
<div class="container-fluid">

    <div class="row">
        <div class="col">
            <form action="03-shop-search.php" method="">
                <input type="text" id="keywords" name="keywords">
                <button type="submit">搜尋</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                        </a>
                    </li>

                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php
                        endif;
                    endfor; ?>

                    <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-circle-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">店家封面</th>
                        <th scope="col">店家帳號</th>
                        <th scope="col">店家密碼</th>
                        <th scope="col">店家名稱</th>
                        <th scope="col">店家電話</th>
                        <th scope="col">縣市地址</th>
                        <th scope="col">區域地址</th>
                        <th scope="col">詳細地址</th>
                        <th scope="col">開店時間</th>
                        <th scope="col">關店時間</th>
                        <th scope="col">取餐時間</th>
                        <th scope="col">店家審查</th>
                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <td><?= $r['sid'] ?></td>
                            <td>
                                <img src="./uploads/<?= $r['shop_cover'] ?>" alt="" style="width: 100px;">
                            </td>
                            <td><?= $r['shop_email'] ?></td>
                            <td><?= $r['shop_password'] ?></td>
                            <td><?= htmlentities($r['shop_name']) ?></td>
                            <td><?= $r['shop_phone'] ?></td>
                            <td><?= $r['shop_address_city'] ?></td>
                            <td><?= $r['shop_address_area'] ?></td>
                            <td><?= $r['shop_address_detail'] ?></td>
                            <td><?= $r['shop_opentime'] ?></td>
                            <td><?= $r['shop_closetime'] ?></td>
                            <td><?= $r['shop_deadline'] ?></td>
                            <td><?= $r['shop_approved'] == 1 ? "可上架" : "審核中" ?></td>
                            <td>
                                <a href="03-shop-edit-form.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    include __DIR__ . '/parts/scripts.php'; ?>
    <script>
        function delete_it(sid) {
            if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
                location.href = `03-shop-delete.php?sid=${sid}`;
            }
        }
    </script>
    <?php
    include __DIR__ . '/parts/html-foot.php'; ?>

//台北市 大安區 店家 的所有商品
SELECT `shop_list`.*,`shop_address_city`.`shop_city`,`shop_address_area`.`shop_area`,`food_product`.`product_name` 
FROM `shop_list` 
JOIN `shop_address_city` ON `shop_list`.`shop_address_city_sid` = `shop_address_city`.`sid` 
JOIN `shop_address_area` ON `shop_list`.`shop_address_area_sid` = `shop_address_area`.`sid` 
JOIN `food_product` ON `shop_list`.`sid` = `food_product`.`shop_list_sid` 
WHERE `shop_address_city`.`sid`= 2 
AND `shop_address_area`.`sid` = 14;

//台北市 大安區 店家 的所有商品 的所有種類

SELECT `shop_list`.*,`shop_address_city`.`shop_city`,`shop_address_area`.`shop_area`,`food_product`.`product_name`,`food_category`.`product_categories` FROM `shop_list` JOIN `shop_address_city` ON `shop_list`.`shop_address_city_sid` = `shop_address_city`.`sid` JOIN `shop_address_area` ON `shop_list`.`shop_address_area_sid` = `shop_address_area`.`sid` JOIN `food_product` ON `shop_list`.`sid` = `food_product`.`shop_list_sid` JOIN `food_category` ON `food_product`.`product_categories_sid` = `food_category`.`sid` WHERE `shop_address_city`.`sid`= 2 AND `shop_address_area`.`sid` = 14 AND `food_category`.`product_categories` = '麵包';

//台北市 大安區 店家 的所有商品 的所有種類 同店家只顯示一筆
SELECT `shop_list`.*,`shop_address_city`.`shop_city`,`shop_address_area`.`shop_area`,`food_product`.`product_name`,`food_category`.`product_categories` FROM `shop_list` JOIN `shop_address_city` ON `shop_list`.`shop_address_city_sid` = `shop_address_city`.`sid` JOIN `shop_address_area` ON `shop_list`.`shop_address_area_sid` = `shop_address_area`.`sid` JOIN `food_product` ON `shop_list`.`sid` = `food_product`.`shop_list_sid` JOIN `food_category` ON `food_product`.`product_categories_sid` = `food_category`.`sid` WHERE `shop_address_city`.`sid`= 2 AND `shop_address_area`.`sid` = 14 AND `food_category`.`product_categories` = '麵包' GROUP BY `shop_list`.`shop_name`;


SELECT * FROM `food_product` JOIN `food_category` ON `food_product`.`product_categories_sid` = `food_category`.`sid` WHERE `food_category`.`product_categories` IN ('甜點','中式');