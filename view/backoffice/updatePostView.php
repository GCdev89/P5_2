<?php ob_start(); ?>
<div class="row col-lg-12 mx-auto">
    <h2 class="h2 mb-4">Mettre à jour un article</h2>
    <form action="index.php?action=updatedPost" method="post" class="col-12 mx-auto mb-5 p-auto bg-dark text-light rounded">
        <div class="form-group" >
            <label for="title">Titre</label><br />
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($post->title())?>" class="form-control" />
        </div>
        <div class="form-group">
            <label for="content">Contenu</label><br />
            <textarea id="content" name="content" class="form-control"><?=$post->content()?></textarea>
        </div>
        <div class="form-group">
            <label for="meta_title">Meta titre</label><br />
            <input type="text" id="meta_title" name="meta_title" class="form-control" value="<?= htmlspecialchars($post->metaTitle()) ?>"/>
        </div>
        <div class="form-group">
            <label for="meta_desc">Meta description</label><br />
            <textarea id="meta_desc" name="meta_desc" class="form-control"><?= htmlspecialchars($post->metaDesc()) ?></textarea>
        </div>
        <div class="form-group d-flex justify-content-around mb-2">
            <input id="post_id" name="post_id" type="hidden" value="<?= htmlspecialchars($post->id()) ?>" />
            <button type="submit" class="btn btn-primary">Envoyer</button>
            <a href="index.php?action=delete_post&amp;id=<?= htmlspecialchars($post->id())?>" class="btn btn-danger">Supprimer</a>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
