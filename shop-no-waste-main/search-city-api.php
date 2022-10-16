<?php
require __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    // 'areaRows' => $areaRows,
    'getdata' => $_GET['city_sid']
];

// if (empty($_POST['account']) or empty($_POST['password'])) {
//     $output['error'] = '請輸入帳號或密碼！';
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }

$a_sql = "SELECT `shop_address_area`.* FROM `shop_address_area` JOIN `shop_address_city` ON `shop_address_area`.`shop_city_sid` = `shop_address_city`.`sid` WHERE `shop_address_city`.`sid` = ?";
        
$stmt = $pdo->prepare($a_sql);

$stmt->execute([$_GET['city_sid']]);

$areaRows = $stmt->fetchAll();

$output = ['areaRows'=> $areaRows];

//找找看有沒有這個帳號
if (empty($areaRows)) {
    $output['error'] = '縣市錯誤！';
    $output['code'] = 401;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
// //驗證密碼
// if (password_verify($_POST['password'], $row['shop_password'])) {
//     $output['success'] = true;
//     $_SESSION['shop'] = [
//         'sid' => $row['sid'],
//         'account' => $row['shop_email'],
//     ];
// } else {
//     $output['error'] = '帳號或密碼錯誤！';
//     $output['code'] = 431;
// }

echo json_encode($areaRows, JSON_UNESCAPED_UNICODE);
