<?php
$cur_page = "home";
include("connection.php");
include("include_pages/navbar.php");
?>
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Features Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Authenticated User</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <a href="<?=$baseUrl ?>/shop">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <img src="./images/buy.png" style="width: 50px;" class="m-0 mr-2" />
                    <h5 class="font-weight-semi-bold m-0">Buy</h5>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <a href="<?=$baseUrl ?>/shop?list_type=swap">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Swap</h5>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <a href="<?=$baseUrl ?>/shop?list_type=rent">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <img src="./images/rent.png" style="width: 50px;" class="m-0 mr-2" />
                    <h5 class="font-weight-semi-bold m-0">Rent</h5>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Features End -->

<!--category listing -->
<?php
$get_category_query = "SELECT * FROM `category` WHERE `status`='active' ORDER BY id DESC LIMIT 12";
$get_category_run = mysqli_query($con, $get_category_query);
if (mysqli_num_rows($get_category_run) > 0) {
?>
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
        <div class="row px-xl-5 pb-3">
            <?php
            while ($categoryData = mysqli_fetch_assoc($get_category_run)) {
                $cat_name = $categoryData["name"];
                $image_name = $categoryData["image"];
                $cat_id = $categoryData["id"];
                $image_link = "";

                $prod_count_query = mysqli_query($con, "SELECT COUNT(*) AS prod_count FROM product WHERE category_id='$cat_id'");
                $prod_count_row = mysqli_fetch_assoc($prod_count_query);
                $prod_count = $prod_count_row["prod_count"];
                if($prod_count > 0) {
                    if ($image_name != "") {
                        if (file_exists("images/category/" . $image_name)) {
                            $image_link = $baseUrl . "/images/category/" . $image_name;
                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                                <a class="text-decoration-none" href="<?=$baseUrl ?>/shop?category=<?=$cat_id ?>">
                                    <div class="cat-item d-flex align-items-center mb-4">
                                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                            <img class="img-fluid" src="<?= $image_link ?>" alt="">
                                        </div>
                                        <div class="flex-fill pl-3">
                                            <h6><?= $cat_name ?></h6>
                                            <small class="text-body"><?=$prod_count ?> Books</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
<?php
}
?>

<!-- Products Start -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Recent Products</span></h2>
    <div class="row px-xl-5">
        <?php
        $get_data_query = "SELECT `product`.*, `category`.`name` AS category_name FROM `product` INNER JOIN `category` ON `product`.category_id=`category`.id WHERE `product`.status='active' ORDER BY `product`.id DESC LIMIT 12";
        $get_data_run = mysqli_query($con, $get_data_query);
        while ($data = mysqli_fetch_assoc($get_data_run)) {
            $prod_id = $data["id"];
            $for_purchase = $data["for_purchase"];
            $for_rent = $data["for_rent"];
            $for_swapping = $data["for_swapping"];
            $getImage_query = "SELECT * FROM `product_images` WHERE `product_id`='$prod_id' AND `status`='active' ORDER BY id ASC LIMIT 1";
            $getImage = mysqli_query($con, $getImage_query);
            if (mysqli_num_rows($getImage) > 0) {
                $imageData = mysqli_fetch_assoc($getImage);
                $image_name = $imageData["image_name"];
                $image_link = "img/product-1.jpg";
                if ($image_name != "") {
                    if (file_exists("images/product/" . $image_name)) {
                        $image_link = $baseUrl . "/images/product/" . $image_name;
                    }
                }
            }

        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="<?= $image_link ?>" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="<?=$baseUrl ?>/detail?product=<?= $data["id"] ?>"><i class="fa fa-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="<?=$baseUrl ?>/detail?product=<?= $data["id"] ?>"><?= $data["generic_name"] ?></a>
                        <?php
                        if ($for_purchase == "true") {
                        ?>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h6 class="text-muted">For Purchase </h6><h5 class="ml-2">₹ <?= $data["selling_price"] ?></h5>
                                <h6 class="text-muted ml-2"><del>₹ <?= $data["mrp"] ?></del></h6>
                            </div>
                        <?php
                        }
                        if ($for_rent == "true") {
                        ?>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h6 class="text-muted">For Rent </h6><h5 class="ml-2">₹ <?= $data["rent_sp"] ?></h5>
                                <h6 class="text-muted ml-2"><del>₹ <?= $data["rent_mrp"] ?></del></h6>
                            </div>
                        <?php
                        }
                        if ($for_swapping == "true") {
                            ?>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h6 class="text-muted">For Swap </h6><h5 class="ml-2">₹ <?= $data["swap_sp"] ?></h5>
                                    <h6 class="text-muted ml-2"><del>₹ <?= $data["swap_mrp"] ?></del></h6>
                                </div>
                            <?php
                            }
                        ?>
                        
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </div>
</div>
<!-- Products End -->


<?php
include("include_pages/footer.php");
?>