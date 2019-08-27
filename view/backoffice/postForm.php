<?php ob_start(); ?>
<form id="postForm" action="index.php?action=<?= $postAction ?>" method="post" class="col-lg-12 mx-auto mb-5 p-auto bg-dark text-light rounded">
    <h3>Edition de billet</h3>
    <div class="form-group" >
        <label for="post_title">Titre</label><br />
        <input type="text" id="post_title" name="post_title" class="form-control"
        <?php if (isset($thisContent)): ?>
            value="<?=htmlspecialchars($thisContent->title()) ?>"
        <?php endif; ?>
        />
    </div>
    <div class="form-group">
        <label for="post_content">Contenu</label><br />
        <textarea id="post_content" name="post_content" class="form-control content" ><?php if (isset($thisContent)) { echo htmlspecialchars($thisContent->content()); } ?></textarea>
    </div>
    <div class="form-group">
        <label for="post_meta_title">Meta titre</label><br />
        <input type="text" id="post_meta_title" name="post_meta_title" class="form-control"
        <?php if (isset($thisContent)): ?>
            value="<?=htmlspecialchars($thisContent->metaTitle()) ?>"
        <?php endif; ?>
        />
    </div>
    <div class="form-group">
        <label for="post_meta_desc">Meta description</label><br />
        <textarea id="post_meta_desc" name="post_meta_desc" class="form-control" ><?php if (isset($thisContent)) { echo htmlspecialchars($thisContent->metaDesc()); } ?></textarea>
    </div>
    <div class="form-group">
        <?php if (isset($thisContent)): ?>
            <input id="content_id" name="content_id" type="hidden" value="<?= htmlspecialchars($thisContent->id()) ?>" />
        <?php endif; ?>
        <button type="submit" class="btn btn-warning text-dark font-weight-bold mb-2">Envoyer</button>
    </div>
</form>

<?php $postForm = ob_get_clean(); ?>
