<?php
require __DIR__ . '/parts/connect_db.php';
$c_sql = "SELECT * FROM `shop_address_city`";
$cityRows = [];
$cityRows = $pdo->query($c_sql)->fetchAll();
$output = [
    'cityRows' => $cityRows
];
// $cat_sql = "SELECT * FROM `food_category`";
// $catRows = [];
// $catRows = $pdo->query($cat_sql)->fetchAll();
?>
<?php require __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/nav-bar-admin.php'; ?>
<div class="container">
    <div class="row">
        <form action="search-shop-all.php" method="">
            <div class="col">
                <select class="form-select mb-3" name="shop_city" id="selCity" onchange="newArea(document.querySelector('#selCity').value)">
                    <option value="">請選擇縣市</option>
                    <?php foreach ($cityRows as $c) : ?>
                        <option value="<?= $c['sid'] ?>"><?= $c['shop_city'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col">
                <select name="shop_area" id="selArea" class="form-select mb-3">
                    <option value="">請選擇地區</option>
                </select>
            </div>
            <div class="col">
                <!-- <?php foreach ($catRows as $cat) : ?>
                    <input type="checkbox" id="" name="categories" value="<?= $cat['product_categories'] ?>">
                    <label for="categories"><?= $cat['product_categories'] ?></label><br>
                <?php endforeach; ?> -->
                <input type="checkbox" id="" name="categories1" value="中式">
                <label for="categories1">中式</label><br>
                <input type="checkbox" id="" name="categories2" value="美式">
                <label for="categories2">美式</label><br>
                <input type="checkbox" id="" name="categories3" value="日式">
                <label for="categories3">日式</label><br>
                <input type="checkbox" id="" name="categories4" value="泰式">
                <label for="categories4">泰式</label><br>
                <input type="checkbox" id="" name="categories5" value="早午餐">
                <label for="categories5">早午餐</label><br>
                <input type="checkbox" id="" name="categories6" value="甜點">
                <label for="categories6">甜點</label><br>
                <input type="checkbox" id="" name="categories7" value="飲料">
                <label for="categories7">飲料</label><br>
                <input type="checkbox" id="" name="categories8" value="冰品">
                <label for="categories8">冰品</label><br>
                <input type="checkbox" id="" name="categories9" value="義大利麵">
                <label for="categories9">義大利麵</label><br>
                <input type="checkbox" id="" name="categories10" value="麵包">
                <label for="categories10">麵包</label><br>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-info">搜尋</button>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    function newArea(city) {
        console.log(city);
        const area = document.querySelector('#selArea');
        area.options.length = 0;

        fetch(`search-city-api.php?city_sid=${city}`, {
                method: 'GET',
            })
            .then(r => r.json())
            .then(obj => {
                console.log(obj);
                obj.forEach((value, index, array) => {
                    let {
                        sid,
                        shop_area
                    } = value;
                    area[index] = new Option(shop_area, sid);
                })
            })
    }
</script>

<?php include __DIR__ . '/parts/html-foot.php'; ?>