<?php
include("header.php");
$cat_dish = '';
$cat_dish_arr = array();
$dish_type = '';
if (isset($_GET['cat_dish'])) {
    $cat_dish = get_safe_value($_GET['cat_dish']);
    $cat_dish_arr = array_filter(explode(':', $cat_dish));
    $cat_dish_str = implode(",", $cat_dish_arr);
}

if (isset($_GET['dish_type'])) {
    $dish_type = get_safe_value($_GET['dish_type']);
}

$arrType = array("veg", "non-veg", "both");
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo FRONT_SITE_PATH ?>shop">Shop</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-page-area pt-100 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-topbar-wrapper">
                    <div class="product-sorting-wrapper">
                        <div class="product-show shorting-style">
                            <?php
                            foreach ($arrType as $list) {
                                $type_radio_selected = '';
                                if ($list == $dish_type) {
                                    $type_radio_selected = "checked='checked'";
                                }
                            ?>
                                <?php echo strtoupper($list) ?> <input type="radio" name="dish_type" <?php echo  $type_radio_selected ?> value="veg" style='width: 16px;height: 12px;margin-right: 5px;margin-left: 5px;' onclick="setFoodType('<?php echo $list ?>')" />&nbsp;&nbsp;
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                $cat_id = 0;
                $product_sql = "select * from dish where status=1";
                if (isset($_GET['cat_dish']) && $_GET['cat_dish'] != '') {
                    $product_sql .= " and category_id in ($cat_dish_str)";
                }
                if ($dish_type != '' && $dish_type != 'both') {
                    $product_sql .= " and type ='$dish_type'";
                }
                $product_sql .= " order by dish desc";
                $product_res = mysqli_query($con, $product_sql);
                $product_count = mysqli_num_rows($product_res);
                ?>
                <div class="grid-list-product-wrapper">
                    <div class="product-grid product-view pb-20">
                        <?php if ($product_count > 0) {  ?>
                            <div class="row">
                                <?php
                                while ($product_row = mysqli_fetch_assoc($product_res)) {
                                ?>
                                    <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                        <div class="product-wrapper">
                                            <div class="product-img">
                                                <a href="product-details.html">
                                                    <img src="<?php echo SITE_DISH_IMAGE . $product_row['image']; ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h4>
                                                    <?php
                                                    if ($product_row['type'] == 'veg') {
                                                        echo "<img src='" . FRONT_SITE_PATH . "assets/img/icon-img/veg.png' style='height: 30px;'/>";
                                                    } else {
                                                        echo "<img src='" . FRONT_SITE_PATH . "assets/img/icon-img/non-veg.png' style='height: 30px;'/>";
                                                    }
                                                    ?>
                                                    <a href="javascript:void(0)"><?php echo $product_row['dish']; ?></a>
                                                </h4>
                                                <?php
                                                $dish_attr_res = mysqli_query($con, "select * from dish_details where status='1' and dish_id='" . $product_row['id'] . "' order by price asc");
                                                ?>
                                                <div class="product-price-wrapper">
                                                    <?php
                                                    while ($dish_attr_row = mysqli_fetch_assoc($dish_attr_res)) {
                                                        echo "<input type='radio' style='width: 16px;height: 12px;margin-right: 5px;margin-left: 5px;' name='radio_" . $product_row['id'] . "' value='" . $dish_attr_row['id'] . "'/>";
                                                        echo $dish_attr_row['attribute'];
                                                        echo "&nbsp;&nbsp;";
                                                        echo "<span>(" . $dish_attr_row['price'] . ")</span>";
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else {
                            echo "No Dish Found";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            $cat_res = mysqli_query($con, "select * from category where status=1 order by order_number desc");
            ?>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Shop By Categories</h4>
                        <div class="shop-catigory">
                            <ul id="faq" class="category_list">
                                <li><a href="<?php echo FRONT_SITE_PATH ?>shop"><u>clear</u></a></li>
                                <?php
                                while ($cat_row = mysqli_fetch_assoc($cat_res)) {
                                    $class = "";
                                    if ($cat_id == $cat_row['id']) {
                                        $class = "active";
                                    }
                                    $is_checked = '';
                                    if (in_array($cat_row['id'], $cat_dish_arr)) {
                                        $is_checked = "checked='checked'";
                                    }
                                    echo "<li> <input $is_checked onclick=set_checkbox('" . $cat_row['id'] . "') type='checkbox' name='cat_arr[]' value='" . $cat_row['category'] . "' style=' width: 15px;height: 12px;'/>" . $cat_row['category'] . "</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="get" id="frmCatDish">
    <input type="hidden" name="cat_dish" id="cat_dish" value='<?php echo  $cat_dish; ?>' />
    <input type="hidden" name="dish_type" id="dish_type" value='<?php echo  $dish_type; ?>' />
</form>
<script>
    function set_checkbox(id) {
        // alert(id);
        var cat_dish = jQuery('#cat_dish').val();
        var check = cat_dish.search(":" + id);
        if (check != '-1') {
            cat_dish = cat_dish.replace(":" + id, '');
        } else {
            cat_dish = cat_dish + ":" + id;
        }
        jQuery('#cat_dish').val(cat_dish);
        jQuery('#frmCatDish')[0].submit();
    }

    function setFoodType(dish_type) {
        jQuery('#dish_type').val(dish_type);
        jQuery('#frmCatDish')[0].submit();

    }
</script>
<?php
include("footer.php");
?>