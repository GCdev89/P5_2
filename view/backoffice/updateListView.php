<?php ob_start(); ?>
<div class="row col-lg-12  my-lg-5 mx-0 mx-lg-auto px-0">
    <div class="row col-lg-12 ml-2">
        <h3 class="h2 mt-lg-5">Liste des contenus</h3>
    </div>

    <?php if (Session::hasAdminAccess()): ?>
        <div class="row col-lg-12 mx-auto">
            <div class="form-group mt-lg-4">
                <a href="index.php?action=update_list_my_contents&amp;type=article" class="btn btn-outline-dark">Voir mes articles</a>
                <a href="index.php?action=update_list_contents" class="btn btn-outline-dark ml-3">Voir tous les articles</a>
                <a href="index.php?action=update_list_my_contents&amp;type=post" class="btn btn-outline-dark mx-auto mt-2 ml-lg-3">Voir les billets</a>
            </div>
        </div>
        <h4 class="h3 mt-3">Les <?php if($type == 'article'){echo 'articles';}else{echo 'billets';} ?></h4>
    <?php endif; ?>

    <div class="row col-12 mx-auto">
        <table class="table table-responsive-md table-striped table-dark mb-5">
            <thead>
                <th scope="col">Auteur</th>
                <th scope="col">Titre</th>
                <?php if ($type == 'article'): ?>
                    <th scope="col">Parent</th>
                    <th scope="col">Catégorie</th>
                <?php endif; ?>
                <th scope="col">Date de création</th>

            </thead>
            <tbody>
                <?php if (!empty($contents)): ?>
                    <?php foreach ($contents as $aContent): ?>
                        <tr>
                            <td><?=htmlspecialchars($aContent->userPseudo())?></td>
                            <td><?=htmlspecialchars($aContent->title())?></td>
                            <?php if ($type == 'article'): ?>
                                <td><?=htmlspecialchars($aContent->parent())?></td>
                                <td><?=htmlspecialchars($aContent->tag())?></td>
                            <?php endif; ?>
                            <td><?=htmlspecialchars($aContent->date())?></td>
                            <td><a href="index?action=update_content&amp;type=<?= $type ?>&amp;id=<?= $aContent->id() ?>" class="btn btn-sm btn-outline-light">Modifier</a></td>
                            <?php if (Session::hasEditionAccess()): ?>
                                <td><a href="index?action=delete_content&amp;type=<?= $type ?>&amp;id=<?= $aContent->id() ?>" class="btn btn-sm btn-outline-danger">Supprimer</a></td>

                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if (isset($countPages) && $countPages > 1): ?>
            <?= $pagination ?>
        <?php endif; ?>

    </div>
</div>



<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
