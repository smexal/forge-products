<?php if(!class_exists('raintpl')){exit;}?><div class="wrapper component-productlist">
    <div class="row">
        <div class="col-lg-12"><h2><?php echo $title;?></h2></div>
    </div>
    <div class="row">
        <?php $counter1=-1; if( isset($products) && is_array($products) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <a class="product-card" <?php if( $value1["link"] ){ ?>href="<?php echo $value1["link"];?>"<?php } ?>>
                <div class="img"><img src="<?php echo $value1["image"];?>" /></div>
                <div class="info">
                    <h3><?php echo $value1["title"];?></h3>
                    <p><?php echo $value1["description"];?></p>
                    <p class="price"><?php echo $value1["price"];?></p>
                </div>
            </a>
        </div>
        <?php if( ($key1+1)%4==0 ){ ?>

        </div><div class="row">
        <?php } ?>

        <?php } ?>

    </div>
</div>