<?php ob_start(); ?>
<div class="row col-lg-12 mx-auto mb-4 px-auto">
    
<?php foreach ($posts as $aPost): ?>
    <div class="row col-12 mt-3 mx-auto">
        <div class="post col-lg-12 my-auto">
            <div class="row d-flex justify-content-between bg-dark text-light rounded-top">
                <p class="m-2 pt-1 pb-0"><span class="h4"><?= htmlspecialchars($aPost->title())?></span> par : <?=htmlspecialchars($aPost->userPseudo())?>, le : <?=htmlspecialchars($aPost->date())?></p>
                <div class="my-md-auto"><a href="index.php?action=updatePost&amp;id=<?= htmlspecialchars($aPost->id())?>" class="btn btn-outline-light btn-sm mr-md-2">Modifier</a></div>
            </div>
            <div class="row">
                <div class="post_content_overlay col-lg-12 p-0">
                    <div class="px-3 py-1 post_content" ><?=$aPost->content()?></div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if (isset($countPages) && $countPages > 1): ?>
    <?= $pagination ?>
<?php endif; ?>

</div>
<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
