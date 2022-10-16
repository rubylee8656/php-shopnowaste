<?php require __DIR__ . '/parts/connect_db.php';

$output = [
    'success' => false,
    'error' => '',
    'code' => 480,
    'file' => $_FILES, //除錯用
    'getData' => $_GET // 除錯用的
];
// echo("123");
$keywords = $_GET['keywords'];
if (empty($keywords)) {
    $output['error'] = '參數不足';
    echo ('請輸入');
    exit;
}
// echo $_POST['keywords'];
// echo $keywords;
$sql = "SELECT * FROM `shop_list` WHERE `shop_address_city` LIKE '$keywords' OR `shop_address_area` LIKE '$keywords' ORDER BY sid DESC";
// echo("456");
$rows = $pdo->query($sql)->fetchAll();
// $output['rows'] = $rows;
// echo("789");
if (empty($rows)) {
    $output['postData'] = '沒有符合的資料';
    echo ('沒有符合的資料');
    exit;
}
// echo("000");
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
            <a href="search-shop-list.php"><button type="button">返回店家總表</button></a>
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
    <?php include __DIR__ . '/parts/html-foot.php'; ?>