<div class="hero-slider position-relative">
    <!-- slider item -->
    <?php foreach($banner_principal as $banner):?>
    <div class="hero-slider-item py-160" style="background-image: url('conteudos/banner/<?php echo $banner["arquivo"];?>')" data-icon="ti-control-skip-forward" data-text="<?php echo $banner["titulo_banner"];?>"></div>
    <?php endforeach;?>
</div>