<?php ob_start(); ?>
<div class="row col-12 mx-auto px-auto">
    <div class="row col-12 mt-4">
        <p><a href="index.php?action=<?= htmlspecialchars($comment->type()) ?>&amp;id=<?= htmlspecialchars($comment->contentId()); ?>" class="btn btn-outline-dark btn-sm">Retour au contenu</a></p>
        <form action="index.php?action=comment_updated" method="post" class="col-12 mx-auto mb-5 p-auto bg-light">
            <div class="form-group" >
                <input id="type" name="type" type="hidden" value="<?= htmlspecialchars($comment->type()) ?>" />
                <input id="content_id" name="content_id" type="hidden" value="<?= htmlspecialchars($comment->id()) ?>" />
            </div>
            <div class="form-group">
                <label for="comment">Commentaire</label><br />
                <textarea id="comment" name="comment" class="form-control"><?= $comment->content(); ?></textarea>
            </div>
            <div class="form-group d-flex justify-content-around mb-2">
                <button type="submit" class="btn btn-primary">Envoyer</button>
                <a href="index.php?action=delete_comment&amp;id=<?= $comment->id()?>" class="btn btn-danger">Supprimer</a>
            </div>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
