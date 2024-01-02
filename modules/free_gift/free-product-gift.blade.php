

<div id='div_free_product_gift_container'>

<div id="radio_free_product_gift_title">
<input type="radio" checked /><label>Choose your free scent bottle</label>
</div>


<?php foreach( $product_gifts as $product_gift )
{    
    $id = $product_gift->get_id();
    $title = $product_gift->get_title();
    $image = $product_gift->get_image();

    ?>

    <div class="div_free_product_gift">
        <?php echo $image ?>
        <input type="radio" name="radio_free_product_gift" value=" <?php echo $id; ?>"/><label>{{$title}}</label>
    </div>

    <?php
} ?>

    <?php //print_r($product_gifts)  ?>

</div>