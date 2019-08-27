<?php ob_start(); ?>
    <div class="row mt-2">
        <a href="index.php?action=list_articles">
            <div id="carousel_pano" class="col-12">
                  <div class="slide"><img class="img-fluid" src="../public/images/carousel/bg1.jpg" alt="slider image" /></div>
                  <div class="slide"><img class="img-fluid" src="../public/images/carousel/bg2.jpg" alt="slider image" /></div>
              </div>
        </a>
    </div>


<?php $headerHero = ob_get_clean(); ?>
