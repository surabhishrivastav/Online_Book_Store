<?php
$cur_page = "shop";
include("connection.php");
if (!isset($_GET["product"])) {
    header("Location: " . $baseUrl . "/shop");
    exit();
}

$prod_id = $_GET["product"];
$get_data_query = "SELECT `product`.*, `category`.`name` AS category_name FROM `product` INNER JOIN `category` ON `product`.category_id=`category`.id WHERE `product`.id='$prod_id'";
$get_data_run = mysqli_query($con, $get_data_query);
if (mysqli_num_rows($get_data_run) == 0) {
    header("Location: " . $baseUrl . "/shop");
    exit();
}
$prod_data = mysqli_fetch_assoc($get_data_run);
$for_purchase = $prod_data["for_purchase"];
$for_rent = $prod_data["for_rent"];
$for_swapping = $prod_data["for_swapping"];
$current_cat_id = $prod_data["category_id"];
//print_r($prod_data);

include("include_pages/navbar.php");
?>
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="<?= $baseUrl ?>">Home</a>
                <a class="breadcrumb-item text-dark" href="<?= $baseUrl ?>/shop">Books</a>
                <span class="breadcrumb-item active">(<?= $prod_data["generic_name"] ?>)</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <?php
                    $getImage_query = "SELECT * FROM `product_images` WHERE `product_id`='$prod_id' AND `status`='active' ORDER BY id ASC";
                    $getImage = mysqli_query($con, $getImage_query);
                    if (mysqli_num_rows($getImage) > 0) {
                        $i = 0;
                        while ($imageData = mysqli_fetch_assoc($getImage)) {
                            $image_name = $imageData["image_name"];
                            $image_link = "img/product-1.jpg";
                            if ($image_name != "") {
                                if (file_exists("images/product/" . $image_name)) {
                                    $image_link = $baseUrl . "/images/product/" . $image_name;
                                }
                            }
                            $active = "";
                            if ($i == 0) {
                                $active = "active";
                            }
                    ?>
                            <div class="carousel-item <?= $active ?>">
                                <img class="w-100 h-100" src="<?= $image_link ?>" alt="Image">
                            </div>
                        <?php
                            $i++;
                        }
                    } else {
                        ?>
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="img/product-1.jpg" alt="Image">
                        </div>
                    <?php
                    }
                    ?>

                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3><?= $prod_data["generic_name"] ?></h3>
                <?php

                if ($for_purchase == "true") {
                ?>
                    <div class="d-flex">
                        <h5 class="text-muted">Purchase</h5>
                        <h4 class="font-weight-semi-bold ml-4">₹ <?= $prod_data["selling_price"] ?></h4>
                        <h5 class="ml-3"><del class="text-muted">₹ <?= $prod_data["mrp"] ?></del></h5>
                    </div>
                <?php
                }
                if ($for_rent == "true") {
                ?>
                    <div class="d-flex">
                        <h5 class="text-muted">Rent</h5>
                        <h4 class="font-weight-semi-bold ml-4">₹ <?= $prod_data["rent_sp"] ?></h4>
                        <h5 class="ml-3"><del class="text-muted">₹ <?= $prod_data["rent_mrp"] ?></del></h5>
                    </div>
                <?php
                }
                if ($for_swapping == "true") {
                ?>
                    <div class="d-flex">
                        <h5 class="text-muted">Swap</h5>
                        <h4 class="font-weight-semi-bold ml-4">₹ <?= $prod_data["swap_sp"] ?></h4>
                        <h5 class="ml-3"><del class="text-muted">₹ <?= $prod_data["swap_mrp"] ?></del></h5>
                    </div>
                <?php
                }
                ?>

                <p class="mb-4"><?= $prod_data["name"] ?></p>
                <div class="d-flex mb-3">
                    <span class="text-dark mr-3">Language : <?= $prod_data["language"] ?></span>

                </div>
                <div class="d-flex mb-4">
                    <span class="text-dark mr-3">Number of page : <?= $prod_data["no_of_pages"] ?></span>

                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <?php
                    if(isset($_SESSION["userLogin"])) {
                        if ($for_purchase == "true") {
                            ?>
                            <a class="btn btn-primary px-3" href="<?=$baseUrl ?>/order/request?type=sale&product=<?=$prod_id ?>"><i class="fa fa-shopping-cart mr-1"></i> Buy</a>
                            <?php
                        }
                        if ($for_rent == "true") {
                            ?>
                            <a class="btn btn-primary px-3 ml-2" href="<?=$baseUrl ?>/order/request?type=rent&product=<?=$prod_id ?>"><i class="fa fa-shopping-cart mr-1"></i> Rent Request</a>
                            <?php
                        }
                        if ($for_swapping == "true") {
                            ?>
                            <a class="btn btn-primary px-3 ml-2" href="<?=$baseUrl ?>/order/request?type=swap&product=<?=$prod_id ?>"><i class="fa fa-shopping-cart mr-1"></i> Swap Request</a>
                            <?php
                        }
                    } else {
                        ?>
                        <p class="text-danger">Please login to see purchase options</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Book Description</h4>
                        <p><?= $prod_data["short_description"] ?></p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <p><?= $prod_data["long_description"] ?></p>
                        <div class="row">

                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Publisher : <?= $prod_data["publisher"] ?>
                                    </li>
                                    <li class="list-group-item px-0">
                                        Edition : <?= $prod_data["edition"] ?>
                                    </li>
                                    <li class="list-group-item px-0">
                                        Number of pages : <?= $prod_data["no_of_pages"] ?>
                                    </li>
                                    <li class="list-group-item px-0">
                                        Condition : <?= $prod_data["book_condition"] ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Author : <?= $prod_data["publisher"] ?>
                                    </li>
                                    <li class="list-group-item px-0">
                                        Language : <?= $prod_data["language"] ?>
                                    </li>
                                    <li class="list-group-item px-0">
                                        Weight : <?= $prod_data["weight"] ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<?php
$get_related_query = "SELECT `product`.*, `category`.`name` AS category_name FROM `product` INNER JOIN `category` ON `product`.category_id=`category`.id WHERE `product`.category_id='$current_cat_id' AND `product`.id <> '$prod_id' ORDER BY id DESC LIMIT 5";
$get_related_run = mysqli_query($con, $get_related_query);
if (mysqli_num_rows($get_related_run) > 0) {
?>
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    <?php
                    while ($related_prod = mysqli_fetch_assoc($get_related_run)) {
                        $related_prod_id = $related_prod["id"];
                        $getRelatedImage_query = "SELECT * FROM `product_images` WHERE `product_id`='$related_prod_id' AND `status`='active' ORDER BY id ASC LIMIT 1";
                        $getRelatedImage = mysqli_query($con, $getRelatedImage_query);
                        if (mysqli_num_rows($getRelatedImage) > 0) {
                            $relatedimageData = mysqli_fetch_assoc($getRelatedImage);
                            $related_image_name = $relatedimageData["image_name"];
                            $relatedimage_link = "img/product-1.jpg";
                            if ($related_image_name != "") {
                                if (file_exists("images/product/" . $related_image_name)) {
                                    $relatedimage_link = $baseUrl . "/images/product/" . $related_image_name;
                                }
                            }
                        }
                    ?>
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?= $relatedimage_link ?>" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="<?=$baseUrl ?>/detail?product=<?=$related_prod_id ?>"><?= $related_prod["generic_name"] ?></a>
                                <?php
                                if ($related_prod["for_purchase"] == "true") {
                                ?>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h6 class="text-muted">For Purchase </h6>
                                        <h5 class="ml-2">₹ <?= $related_prod["selling_price"] ?></h5>
                                        <h6 class="text-muted ml-2"><del>₹ <?= $related_prod["mrp"] ?></del></h6>
                                    </div>
                                <?php
                                }
                                if ($related_prod["for_rent"] == "true") {
                                ?>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h6 class="text-muted">For Rent </h6>
                                        <h5 class="ml-2">₹ <?= $related_prod["rent_sp"] ?></h5>
                                        <h6 class="text-muted ml-2"><del>₹ <?= $related_prod["rent_mrp"] ?></del></h6>
                                    </div>
                                <?php
                                }
                                if ($related_prod["for_swapping"] == "true") {
                                ?>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h6 class="text-muted">For Swap </h6>
                                        <h5 class="ml-2">₹ <?= $related_prod["swap_sp"] ?></h5>
                                        <h6 class="text-muted ml-2"><del>₹ <?= $related_prod["swap_mrp"] ?></del></h6>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<!-- Products End -->


<?php
include("include_pages/footer.php");
?>