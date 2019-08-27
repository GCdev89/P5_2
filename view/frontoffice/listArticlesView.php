<?php ob_start(); ?>
<div class="row d-flex justify-content-between my-5 mx-0 mx-lg-auto px-auto">

<?php foreach ($contents as $aContent): ?>
    <div class="col-lg-3 mx-lg-4 my-3 my-lg-auto post bg-light">
            <div class="row d-flex justify-content-between bg-dark text-light rounded-top">
                <p class="m-2 pt-1 pb-0"><a href="index.php?action=article&amp;id=<?= htmlspecialchars($aContent->id()) ?>" class=" h4 text-warning font-italic text-decoration-none"><?= htmlspecialchars($aContent->title())?></a> par : <?= htmlspecialchars($aContent->userPseudo())?>, le : <?= htmlspecialchars($aContent->date())?></p>
            </div>
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="px-3 py-1 bg-light" ><?= $aContent->description()?></div>
                </div>
            </div>
            <div class="row bg-light mt-auto mb-0">
                <a href="index.php?action=article&amp;id=<?= htmlspecialchars($aContent->id()) ?>" class="btn btn-warning ml-auto mr-4 my-4">Lire l'article</a>
            </div>
    </div>
<?php endforeach; ?>
</div>


<?php if (isset($countPages) && $countPages > 1): ?>
    <?= $pagination ?>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
