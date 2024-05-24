<?php
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 20,
);
$loop = new WP_Query( $args );
$cats = array();
$products = array();
while ( $loop->have_posts() ) : $loop->the_post();
    $product = wc_get_product(get_the_ID());

    // category (filters)
    $cat_id = $product->get_category_ids()[0];
    $cat_name = get_the_category_by_ID($cat_id);
    if(!in_array($cat_id,$cats)){
        $cats[$cat_id] =  $cat_name;
    }

    // product details
    $first_tag = $product->get_tag_ids()[0];
    $tag = get_term( $first_tag)->name;
    $product_price = $product->get_price();
    $product_regular_price = $product->get_regular_price();
    if($product_price != $product_regular_price) {
        $percent = floor((($product_regular_price - $product_price) / $product_regular_price) * 100);
        $regular_price = $product_regular_price;
        $sale_price = $product_price;
    }

    $products[] = array(
        'id' => $product->get_id(),
        'cat_id' => $cat_id,
        'image' => $product->get_image('medium',['class' => 'rounded-3 img-fluid']),
        'title' => $product->get_title(),
        'tag' => $tag,
        'price' => $product_price,
        'regular_price' => $percent ? $regular_price : '',
        'percent' => $percent ?: '',
        'link' => get_permalink()
    );
endwhile;
?>
<div class="container mt-5 mb-5">
    <div class="row section-1">
        <div class="col-md-9 d-flex align-items-center xs-flex-column">
            <div class="d-inline-block xs-order-1">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path d="M0 0H80V80H0V0Z" fill="url(#pattern0_1351_3180)"/>
                    <defs>
                        <pattern id="pattern0_1351_3180" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_1351_3180" transform="scale(0.00568182)"/>
                        </pattern>
                        <image id="image0_1351_3180" width="176" height="176" xlink:href="data:image/png;base64,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"/>
                    </defs>
                </svg>
            </div>
            <div class="d-inline-block me-lg-3 xs-order-2 w-100">
                <h2 class="title text-center mt-3 text-lg-end pe-lg-3"><strong>کتاب نوزاد و خردسال</strong></h2>
                <div class="row flex-wrap px-2" style="margin-top: 16px">
                    <?php
                    $i = 0;
                    foreach ($cats as $id => $name){
                    ?>
                        <div class="col-4 col-md-2">
                            <div filter="<?php echo $id ?>" class="<?php echo $i==0 ? 'active' : ''?> filter-item b-btn ms-lg-2 py-1 border-primary-faded rounded-c text-primary cursor-pointer cursor-pointer text-center w-100"><?php echo $name ?></div>
                        </div>
                    <?php
                    $i++;
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-sm-start xs-hidden">
            <a href="#" class="text-decoration-none border-primary px-4 py-2 rounded-c d-inline-block cursor-pointer">
                <span class="text-primary">فروشگاه خردسالان</span>
                <svg class="my-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.6582 7.57812C2.6582 7.30198 2.88206 7.07812 3.1582 7.07812H12.0003C12.2765 7.07812 12.5003 7.30198 12.5003 7.57812C12.5003 7.85427 12.2765 8.07812 12.0003 8.07812H3.1582C2.88206 8.07812 2.6582 7.85427 2.6582 7.57812Z" fill="#FF6901"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80465 7.22457C2.99991 7.02931 3.31649 7.02931 3.51176 7.22457L7.30123 11.014C7.49649 11.2093 7.49649 11.5259 7.30123 11.7212C7.10597 11.9164 6.78939 11.9164 6.59412 11.7212L2.80465 7.93168C2.60939 7.73642 2.60939 7.41983 2.80465 7.22457Z" fill="#FF6901"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.30123 3.43551C7.49649 3.63077 7.49649 3.94735 7.30123 4.14262L3.51176 7.93209C3.31649 8.12735 2.99991 8.12735 2.80465 7.93209C2.60939 7.73683 2.60939 7.42025 2.80465 7.22498L6.59412 3.43551C6.78939 3.24025 7.10597 3.24025 7.30123 3.43551Z" fill="#FF6901"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="row mt-3 slider section-2">
<?php
foreach ($products as $product){
    ?>
    <div id="<?php echo $product['id']; ?>" cat="<?php echo $product['cat_id'] ?>" class="item py-2 col-md-3">
        <div class="rounded-4 shadow-g p-3 mx-2">
            <?php echo $product['image'] ?>
            <div class="mt-3 d-flex text-primary align-items-center">
                <div class="g-circle"></div>
                <div class="list-title me-2"><a class="text-decoration-none" href="<?php echo $product['link'] ?>"><?php echo $product['title'] ?></a></div>
            </div>
            <div class="bg-primary text-white mt-2 d-inline-block rounded px-3 py-1"><?php echo $product['tag']; ?></div>
            <div class="d-flex mt-4 justify-content-between align-items-center">
                <div>
                    <?php
                    if($product['percent']){
                        ?>
                        <div class="d-flex align-items-center">
                            <del class="text-gray"><small class="text-gray persian-number price"><?php echo $product['regular_price']; ?></small></del>
                            <div class="bg-primary text-white rounded me-2 px-1 d-flex align-items-center"><small>%<?php echo $product['percent']; ?></small></div>
                        </div>
                    <?php
                    }
                    ?>

                    <div><span class="price"><?php echo $product['price'] ?></span></div>
                </div>
                <div class="p-2 border-primary rounded-3">
                    <a href="<?php echo $product['link'] ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.88798 17.2745C5.12904 17.2745 4.5138 17.8898 4.5138 18.6487C4.5138 19.4077 5.12904 20.0229 5.88798 20.0229C6.64692 20.0229 7.26216 19.4077 7.26216 18.6487C7.26216 17.8898 6.64692 17.2745 5.88798 17.2745ZM3.33594 18.6487C3.33594 17.2393 4.47853 16.0967 5.88798 16.0967C7.29743 16.0967 8.44002 17.2393 8.44002 18.6487C8.44002 20.0582 7.29743 21.2008 5.88798 21.2008C4.47853 21.2008 3.33594 20.0582 3.33594 18.6487Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6868 17.2745C15.9279 17.2745 15.3126 17.8898 15.3126 18.6487C15.3126 19.4077 15.9279 20.0229 16.6868 20.0229C17.4457 20.0229 18.061 19.4077 18.061 18.6487C18.061 17.8898 17.4457 17.2745 16.6868 17.2745ZM14.1348 18.6487C14.1348 17.2393 15.2774 16.0967 16.6868 16.0967C18.0963 16.0967 19.2389 17.2393 19.2389 18.6487C19.2389 20.0582 18.0963 21.2008 16.6868 21.2008C15.2774 21.2008 14.1348 20.0582 14.1348 18.6487Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.33594 2.94538C3.33594 2.62012 3.59961 2.35645 3.92487 2.35645H5.88798C6.21324 2.35645 6.47691 2.62012 6.47691 2.94538V16.0982H16.6851C17.0103 16.0982 17.274 16.3619 17.274 16.6871C17.274 17.0124 17.0103 17.2761 16.6851 17.2761H5.88798C5.56272 17.2761 5.29905 17.0124 5.29905 16.6871V3.53431H3.92487C3.59961 3.53431 3.33594 3.27064 3.33594 2.94538Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.3023 4.86633C5.32548 4.5419 5.60727 4.29768 5.9317 4.32086L19.6735 5.30241C19.8365 5.31405 19.9873 5.3929 20.0899 5.52008C20.1925 5.64727 20.2376 5.81137 20.2145 5.97314L19.233 12.844C19.1915 13.1342 18.943 13.3497 18.65 13.3497H5.88974C5.56448 13.3497 5.30081 13.086 5.30081 12.7607C5.30081 12.4355 5.56448 12.1718 5.88974 12.1718H18.1392L18.9591 6.43225L5.84778 5.49573C5.52335 5.47256 5.27913 5.19077 5.3023 4.86633Z" fill="#FF6901"/>
                    </svg>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
    </div>
    <div class="nav nav-1 d-flex justify-content-center my-2 lg-hidden"></div>
    <div class="section-3">
        <div class="col-md-3 text-sm-start lg-hidden text-center">
            <a href="#" class="text-decoration-none border-primary px-4 py-2 rounded-c d-inline-block cursor-pointer">
                <span class="text-primary">فروشگاه خردسالان</span>
                <svg class="my-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.6582 7.57812C2.6582 7.30198 2.88206 7.07812 3.1582 7.07812H12.0003C12.2765 7.07812 12.5003 7.30198 12.5003 7.57812C12.5003 7.85427 12.2765 8.07812 12.0003 8.07812H3.1582C2.88206 8.07812 2.6582 7.85427 2.6582 7.57812Z" fill="#FF6901"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80465 7.22457C2.99991 7.02931 3.31649 7.02931 3.51176 7.22457L7.30123 11.014C7.49649 11.2093 7.49649 11.5259 7.30123 11.7212C7.10597 11.9164 6.78939 11.9164 6.59412 11.7212L2.80465 7.93168C2.60939 7.73642 2.60939 7.41983 2.80465 7.22457Z" fill="#FF6901"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.30123 3.43551C7.49649 3.63077 7.49649 3.94735 7.30123 4.14262L3.51176 7.93209C3.31649 8.12735 2.99991 8.12735 2.80465 7.93209C2.60939 7.73683 2.60939 7.42025 2.80465 7.22498L6.59412 3.43551C6.78939 3.24025 7.10597 3.24025 7.30123 3.43551Z" fill="#FF6901"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="section-4 mt-4 d-flex slider-2 mt-xl-2">
        <div tag_id="1" class="g-block px-2">
            <div class="rounded-3 bg-primary-faded p-2 d-flex align-items-center justify-content-between">
                <div style="max-width: 80%;">
                    <span class="d-block list-title"><small>بهداشت و کارهای شخصی</small></span>
                    <small class="small-sub">کفش پوشیدن، مسواک زدن، زباله ریختن...</small>
                </div>
                <div class="arrow-box d-flex justify-content-center">
                    <svg class="my-arrow-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.6582 7.57812C2.6582 7.30198 2.88206 7.07812 3.1582 7.07812H12.0003C12.2765 7.07812 12.5003 7.30198 12.5003 7.57812C12.5003 7.85427 12.2765 8.07812 12.0003 8.07812H3.1582C2.88206 8.07812 2.6582 7.85427 2.6582 7.57812Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80465 7.22457C2.99991 7.02931 3.31649 7.02931 3.51176 7.22457L7.30123 11.014C7.49649 11.2093 7.49649 11.5259 7.30123 11.7212C7.10597 11.9164 6.78939 11.9164 6.59412 11.7212L2.80465 7.93168C2.60939 7.73642 2.60939 7.41983 2.80465 7.22457Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.30123 3.43551C7.49649 3.63077 7.49649 3.94735 7.30123 4.14262L3.51176 7.93209C3.31649 8.12735 2.99991 8.12735 2.80465 7.93209C2.60939 7.73683 2.60939 7.42025 2.80465 7.22498L6.59412 3.43551C6.78939 3.24025 7.10597 3.24025 7.30123 3.43551Z" fill="#FF6901"/>
                    </svg>
                </div>
            </div>
        </div>
        <div tag_id="2" class="g-block px-2">
            <div class="rounded-3 bg-primary-faded p-2 d-flex align-items-center justify-content-between">
                <div style="max-width: 80%;">
                    <span class="d-block list-title"><small>خواندن دروس مدرسه</small></span>
                    <small class="small-sub">کفش پوشیدن، مسواک زدن، زباله ریختن...</small>
                </div>
                <div class="arrow-box d-flex justify-content-center">
                    <svg class="my-arrow-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.6582 7.57812C2.6582 7.30198 2.88206 7.07812 3.1582 7.07812H12.0003C12.2765 7.07812 12.5003 7.30198 12.5003 7.57812C12.5003 7.85427 12.2765 8.07812 12.0003 8.07812H3.1582C2.88206 8.07812 2.6582 7.85427 2.6582 7.57812Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80465 7.22457C2.99991 7.02931 3.31649 7.02931 3.51176 7.22457L7.30123 11.014C7.49649 11.2093 7.49649 11.5259 7.30123 11.7212C7.10597 11.9164 6.78939 11.9164 6.59412 11.7212L2.80465 7.93168C2.60939 7.73642 2.60939 7.41983 2.80465 7.22457Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.30123 3.43551C7.49649 3.63077 7.49649 3.94735 7.30123 4.14262L3.51176 7.93209C3.31649 8.12735 2.99991 8.12735 2.80465 7.93209C2.60939 7.73683 2.60939 7.42025 2.80465 7.22498L6.59412 3.43551C6.78939 3.24025 7.10597 3.24025 7.30123 3.43551Z" fill="#FF6901"/>
                    </svg>
                </div>
            </div>
        </div>
        <div tag_id="3" class="g-block px-2">
            <div class="rounded-3 bg-primary-faded p-2 d-flex align-items-center justify-content-between active">
                <div style="max-width: 80%;">
                    <span class="d-block list-title"><small>عنوان دسته بندی موضوعی</small></span>
                    <small class="small-sub">نمایش حداقل 3 موضوع زیر مجموعه</small>
                </div>
                <div class="arrow-box d-flex justify-content-center">
                    <svg class="my-arrow-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.6582 7.57812C2.6582 7.30198 2.88206 7.07812 3.1582 7.07812H12.0003C12.2765 7.07812 12.5003 7.30198 12.5003 7.57812C12.5003 7.85427 12.2765 8.07812 12.0003 8.07812H3.1582C2.88206 8.07812 2.6582 7.85427 2.6582 7.57812Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80465 7.22457C2.99991 7.02931 3.31649 7.02931 3.51176 7.22457L7.30123 11.014C7.49649 11.2093 7.49649 11.5259 7.30123 11.7212C7.10597 11.9164 6.78939 11.9164 6.59412 11.7212L2.80465 7.93168C2.60939 7.73642 2.60939 7.41983 2.80465 7.22457Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.30123 3.43551C7.49649 3.63077 7.49649 3.94735 7.30123 4.14262L3.51176 7.93209C3.31649 8.12735 2.99991 8.12735 2.80465 7.93209C2.60939 7.73683 2.60939 7.42025 2.80465 7.22498L6.59412 3.43551C6.78939 3.24025 7.10597 3.24025 7.30123 3.43551Z" fill="#FF6901"/>
                    </svg>
                </div>
            </div>
        </div>
        <div tag_id="4" class="g-block px-2">
            <div class="rounded-3 bg-primary-faded p-2 d-flex align-items-center justify-content-between">
                <div style="max-width: 80%;">
                    <span class="d-block list-title"><small>عنوان دسته بندی موضوعی</small></span>
                    <small class="small-sub">نمایش حداقل 3 موضوع زیر مجموعه</small>
                </div>
                <div class="arrow-box d-flex justify-content-center">
                    <svg class="my-arrow-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.6582 7.57812C2.6582 7.30198 2.88206 7.07812 3.1582 7.07812H12.0003C12.2765 7.07812 12.5003 7.30198 12.5003 7.57812C12.5003 7.85427 12.2765 8.07812 12.0003 8.07812H3.1582C2.88206 8.07812 2.6582 7.85427 2.6582 7.57812Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80465 7.22457C2.99991 7.02931 3.31649 7.02931 3.51176 7.22457L7.30123 11.014C7.49649 11.2093 7.49649 11.5259 7.30123 11.7212C7.10597 11.9164 6.78939 11.9164 6.59412 11.7212L2.80465 7.93168C2.60939 7.73642 2.60939 7.41983 2.80465 7.22457Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.30123 3.43551C7.49649 3.63077 7.49649 3.94735 7.30123 4.14262L3.51176 7.93209C3.31649 8.12735 2.99991 8.12735 2.80465 7.93209C2.60939 7.73683 2.60939 7.42025 2.80465 7.22498L6.59412 3.43551C6.78939 3.24025 7.10597 3.24025 7.30123 3.43551Z" fill="#FF6901"/>
                    </svg>
                </div>
            </div>
        </div>
        <div tag_id="5" class="g-block px-2">
            <div class="rounded-3 bg-primary-faded p-2 d-flex align-items-center justify-content-between">
                <div style="max-width: 80%;">
                    <span class="d-block list-title"><small>عنوان دسته بندی موضوعی</small></span>
                    <small class="small-sub">نمایش حداقل 3 موضوع زیر مجموعه</small>
                </div>
                <div class="arrow-box d-flex justify-content-center">
                    <svg class="my-arrow-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.6582 7.57812C2.6582 7.30198 2.88206 7.07812 3.1582 7.07812H12.0003C12.2765 7.07812 12.5003 7.30198 12.5003 7.57812C12.5003 7.85427 12.2765 8.07812 12.0003 8.07812H3.1582C2.88206 8.07812 2.6582 7.85427 2.6582 7.57812Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80465 7.22457C2.99991 7.02931 3.31649 7.02931 3.51176 7.22457L7.30123 11.014C7.49649 11.2093 7.49649 11.5259 7.30123 11.7212C7.10597 11.9164 6.78939 11.9164 6.59412 11.7212L2.80465 7.93168C2.60939 7.73642 2.60939 7.41983 2.80465 7.22457Z" fill="#FF6901"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.30123 3.43551C7.49649 3.63077 7.49649 3.94735 7.30123 4.14262L3.51176 7.93209C3.31649 8.12735 2.99991 8.12735 2.80465 7.93209C2.60939 7.73683 2.60939 7.42025 2.80465 7.22498L6.59412 3.43551C6.78939 3.24025 7.10597 3.24025 7.30123 3.43551Z" fill="#FF6901"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="nav nav-2 d-flex justify-content-center mt-3 lg-hidden"></div>
    <div class="temp"></div>
</div>