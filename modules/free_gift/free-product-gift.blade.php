

<div id='div_free_product_gift_container'>

<div id="radio_free_product_gift_title">
<input type="radio" checked /><label>Choose Your <span>FREE</span> Scent Bottle</label>
</div>

<div id="div_options_container">


<?php foreach( $free_products as $free_product )
{    
    $id = $free_product->get_id();
    $title = $free_product->get_title();
    $image = $free_product->get_image();

    ?>

    <div class="div_free_product_gift">
        <?php echo $image ?>
        <input type="radio" name="radio_free_product_gift" value=" <?php echo $id; ?>"/><label>{{$title}}</label>
    </div>

    <?php
} ?>

</div>

</div>