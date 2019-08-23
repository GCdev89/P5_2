<?php ob_start(); ?>
<div class="row mt-3 mx-auto px-auto">

<?php foreach ($article as $anArticle): ?>
    <div class="post col-lg-3 my-auto mx-4">
        <div class="row d-flex justify-content-between bg-dark text-light rounded-top">
            <p class="m-2 pt-1 pb-0"><span class="h4 text-warning font-italic"><?= htmlspecialchars($anArticle->title())?></span> par : <?= htmlspecialchars($anArticle->userPseudo())?>, le : <?= htmlspecialchars($anArticle->date())?></p>
        </div>
        <div class="row">
            <div class="post_content_overlay col-lg-12 p-0">
                <div class="px-3 py-1 post_content bg-light" ><?= $anArticle->content()?></div>
            </div>
        </div>
    </div>
    <div class="row col-lg-3 ml-2 my-3">
        <p class="col-lg-12"><a href="index.php?action=article&amp;id=<?= htmlspecialchars($anArticle->id())?>" class="comment_btn btn btn-warning btn-sm font-weight-bold">Voir les commentaires</a></p>
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
