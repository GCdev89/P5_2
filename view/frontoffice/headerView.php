<?php ob_start(); ?>
<div class="row mt-3 mx-auto px-auto">
    <div class="row">
        <a href="index.php?action=list_articles">
            <div id="carousel_pano" class="col-xl-12">
                  <div class="slide"><img src="../public/images/carousel/bg1.jpg" /></div>
                  <div class="slide"><img src="../public/images/carousel/bg2.jpg" /></div>
              </div>
        </a>

    </div>
</div>


<?php $headerHero = ob_get_clean(); ?>
