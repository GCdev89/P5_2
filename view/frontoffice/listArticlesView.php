<?php
$metaTitle = 'Code Bébé - Les articles';
$metaDesc = 'Vous vous posez des questions sur votre grossesse, ou la grossesse de votre femme ? Et comment ça se passe une fois que bébé est là ? Vous trouverez ici un ensemble d\'articles sur le sujet';
?>

<?php ob_start(); ?>
<div class="row col-lg-10  my-5 mx-0 mx-lg-auto px-0">
    <div class="row d-lg-none mx-auto mx-md-2">
        <div class="dropdwon ml-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown_categories" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catégories</button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <a href="index.php?action=list_articles&amp;parent=<?= $parent ?>" class="dropdown-item <?php  if($tag == NULL){echo'active';} ?>" type="button">Tous les articles</a>
                <a href="index.php?action=list_articles&amp;parent=<?= $parent ?>&amp;tag=baby" class="dropdown-item <?php  if($tag == 'baby'){echo'active';} ?>" type="button">Bébé</a>
                <a href="index.php?action=list_articles&amp;parent=<?= $parent ?>&amp;tag=house" class="dropdown-item <?php  if($tag == 'house'){echo'active';} ?>" type="button">La maison</a>
                <a href="index.php?action=list_articles&amp;parent=<?= $parent ?>&amp;tag=pregnancy" class="dropdown-item <?php  if($tag == 'pregnancy'){echo'active';} ?>" type="button">Grossesse</a>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-between col-lg-12 mx-auto">
        <?php foreach ($contents as $aContent): ?>
            <div class="col-lg-3 mx-lg-4 mx-1 my-3  mb-3 post bg-light">
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

</div>


<?php if (isset($countPages) && $countPages > 1): ?>
    <?= $pagination ?>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
