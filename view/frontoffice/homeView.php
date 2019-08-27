<?php $myScript = '<script src="js/carousel.js"></script>'; ?>


<?php ob_start(); ?>
<div class="row mx-auto px-auto">
    <div class="row d-flex justify-content-between mt-2">
        <a href="index.php?action=list_articles&amp;parent=dad" class="font-weight-bolder mx-auto px-auto my-2 py-2 my-md-auto py-md-auto btn btn-outline-dark">Que vous soyez un papa ?</a>
        <div class="col-lg-6">
            <a href="index.php?action=list_articles" class="my-lg-auto py-auto text-decoration-none">
                <p class="h4 text-center  text-dark p-2 bg-light border rounded">Que vous attendiez un enfant, ou bien qu'il soit déjà là, vous trouvez ici un ensemble de ressources pour vous aider à profiter pleinement de votre nouvelle vie en famille. <br />Cliquez pour retrouver nos articles</p>
            </a>
        </div>
        <a href="index.php?action=list_articles&amp;parent=mom" class="font-weight-bolder mx-auto px-auto my-2 py-2 my-md-auto py-md-auto btn btn-outline-dark">Que vous soyez une maman ?</a>
    </div>
</div>



<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
