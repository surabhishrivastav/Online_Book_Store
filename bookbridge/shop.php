<?php
$cur_page = "shop";
include("connection.php");
include("include_pages/navbar.php");

$list_type = "purchase";
$query_add = "";
if (isset($_GET["list_type"])) {
    if ($_GET["list_type"] != "" && ($_GET["list_type"] == "purchase" || $_GET["list_type"] == "rent" || $_GET["list_type"] == "swap")) {
        $list_type = $_GET["list_type"];
    }
}
if ($list_type == "purchase") {
    $query_add = " AND `product`.for_purchase = 'true' ";
} else if ($list_type == "rent") {
    $query_add = " AND `product`.for_rent = 'true' ";
} else {
    $query_add = " AND `product`.for_swapping = 'true' ";
}

$list_cat = "";
if (isset($_GET["category"])) {
    if ($_GET["category"] != "") {
        $list_cat = $_GET["category"];
        $query_add .= " AND `product`.category_id=" . $list_cat . " ";
    }
}

$limit = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$get_prod_query = "SELECT `product`.*, `category`.`name` AS category_name FROM `product` INNER JOIN `category` ON `product`.category_id=`category`.id WHERE `product`.status='active' " . $query_add . " ORDER BY `product`.id DESC LIMIT $limit OFFSET $offset";
$get_prod_run = mysqli_query($con, $get_prod_query);

$total_query = "SELECT COUNT(*) AS total FROM `product` WHERE `product`.status='active' " . $query_add . "";
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

?>
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="<?= $baseUrl ?>/shop">Shop</a>
                <span class="breadcrumb-item active">Shop List</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">

            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Products List Type</span></h5>
            <div class="bg-light p-4 mb-30">
                <div>
                    <?php
                    $params = $_GET;
                    $paramsPurchase = $params;
                    $paramsRent = $params;
                    $paramsSwap = $params;
                    $paramsPurchase['list_type'] = "purchase";
                    $paramsRent['list_type'] = "rent";
                    $paramsSwap['list_type'] = "swap";
                    $queryStringPurchase = http_build_query($paramsPurchase);
                    $queryStringRent = http_build_query($paramsRent);
                    $queryStringSwap = http_build_query($paramsSwap);
                    ?>
                    <div class="custom-control d-flex align-items-center justify-content-between mb-3">
                        <a class="text-dark" href="<?= $baseUrl ?>/shop?<?=$queryStringPurchase ?>"><?php if ($list_type == "purchase") { ?> <span class="text-success"><i class="fas fa-check"></i> </span> <?php } ?> Purchase</a>
                    </div>
                    <div class="custom-control d-flex align-items-center justify-content-between mb-3">
                        <a class="text-dark" href="<?= $baseUrl ?>/shop?<?=$queryStringRent ?>"><?php if ($list_type == "rent") { ?> <span class="text-success"><i class="fas fa-check"></i> </span> <?php } ?> Rent</a>
                    </div>
                    <div class="custom-control d-flex align-items-center justify-content-between mb-3">
                        <a class="text-dark" href="<?= $baseUrl ?>/shop?<?=$queryStringSwap ?>"><?php if ($list_type == "swap") { ?> <span class="text-success"><i class="fas fa-check"></i> </span> <?php } ?> Swap</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1 mb-4">

                </div>
                <?php
                if (mysqli_num_rows($get_prod_run) > 0) {
                    while ($prod_data = mysqli_fetch_assoc($get_prod_run)) {
                        $prod_id = $prod_data["id"];
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

                        $prod_mrp = 0;
                        $prod_sp = 0;
                        if ($list_type == "purchase") {
                            $prod_mrp = $prod_data["mrp"];
                            $prod_sp = $prod_data["selling_price"];
                        } else if ($list_type == "rent") {
                            $prod_mrp = $prod_data["rent_mrp"];
                            $prod_sp = $prod_data["rent_sp"];
                        } else if ($list_type == "swap") {
                            $prod_mrp = $prod_data["swap_mrp"];
                            $prod_sp = $prod_data["swap_sp"];
                        }
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="<?= $image_link ?>" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href="<?=$baseUrl ?>/detail?product=<?= $prod_data["id"] ?>"><i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="<?= $baseUrl ?>/detail?product=<?= $prod_data["id"] ?>"><?= $prod_data["generic_name"] ?></a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>₹ <?= $prod_sp ?></h5>
                                        <h6 class="text-muted ml-2"><del>₹ <?= $prod_mrp ?></del></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-12">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php
                                $params = $_GET;
                                $params['page'] = $page;
                                if ($page > 1) {
                                    $prevPage = $page - 1;
                                    $params['page'] = $prevPage;
                                    $queryString = http_build_query($params);
                                ?>
                                    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>">Previous</span></a></li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a></li>
                                <?php
                                }
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    $params['page'] = $i;
                                    $queryString = http_build_query($params);
                                ?>
                                    <li class="page-item <?php if ($page == $i) {
                                                                echo "active";
                                                            } ?>"><a class="page-link" href="?<?= $queryString ?>"><?= $i ?></a></li>
                                <?php
                                }
                                if ($page < $total_pages) {
                                    $nextPage = $page + 1;
                                    $params['page'] = $nextPage;
                                    $queryString = http_build_query($params);
                                ?>
                                    <li class="page-item"><a class="page-link" href="?<?= $queryString ?>">Next</a></li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item disabled"><a class="page-link " href="#">Next</a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                    <?php
                } else {
                    ?>
                    <center><h6>No Books Found</h6></center>
                    <?php
                }
                ?>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->

<?php
include("include_pages/footer.php");
?>