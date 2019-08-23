<?php $controlScript = '<script src="js/commentFetch.js"></script>'; ?>


<?php ob_start(); ?>

<div class="row mt-3 mx-auto px-auto">
    <div class="post col-lg-12 my-auto">
        <div class="row d-flex bg-dark text-light rounded-top">
            <p class="m-2 pt-1 pb-0"><span class="h4 text-warning font-italic"><?= htmlspecialchars($post->title())?></span> par : <?= htmlspecialchars($post->userPseudo())?>, le : <?= htmlspecialchars($post->date())?></p>
        </div>
        <div class="row">
            <div class="post_content_overlay col-lg-12 p-0">
                <div class="px-3 py-1 post_content bg-light" ><?= $post->content()?></div>
            </div>
        </div>
    </div>
    <div class="row col-12 mx-auto px-0">
        <h2 class="mt-4 mb-5 p-2 bg-dark rounded text-warning">Commentaires</h2>
        <div id="comment" class="row col-12">
            <?php foreach ($comments as $aComment): ?>
                <div class="col-md-11 mx-auto my-2">
                    <div class="row d-flex justify-content-between bg-secondary text-light rounded-top">
                        <p class="m-2"><span class="h5 font-italic text-warning"><?= htmlspecialchars($aComment->title())?></span> par : <span class="font-weight-bold text-dark"><?= htmlspecialchars($aComment->userPseudo())?></span> le : <?= htmlspecialchars($aComment->date())?></p>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if ($_SESSION['user_id'] == htmlspecialchars($aComment->userId())): ?>
                                <p class="m-2"><a href="index.php?action=comment_edit&amp;id=<?= htmlspecialchars($aComment->id())?>" class="btn btn-outline-light btn-sm">Modifier</a></p>
                            <?php else: ?>
                                <p class="m-2"><a href="index.php?action=report&amp;id=<?= $aComment->id()?>" class="btn btn-outline-warning btn-sm">Signaler</a></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="p-2 col-12 bg-light rounded-bottom" ><?= htmlspecialchars($aComment->content())?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
        </div>

    </div>
    <?php if (isset($countPages) && $countPages > 1): ?>
        <?= $pagination ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['pseudo'])): ?>
        <div class="row col-md-12 mx-auto mt-4">
            <form id="comment_form" class="col-md-12 mx-auto mb-5 p-auto bg-dark text-light rounded">
                <div class="form-group" >
                    <label for="title">Titre du commentaire</label><br />
                    <input type="text" id="title" name="title" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="comment">Commentaire</label><br />
                    <textarea id="comment" name="comment" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input id="post_id" name="post_id" type="hidden" value="<?= htmlspecialchars($post->id()) ?>" />
                    <input id="user_pseudo" name="user_pseudo" type="hidden" value="<?= htmlspecialchars(Session::getUserPseudo()) ?>" />
                    <input id="user_id" name="user_id" type="hidden" value="<?= htmlspecialchars(Session::getUserId()) ?>" />
                    <button type="submit" class="btn btn-warning font-weight-bold" >Envoyer</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
