<?php ob_start(); ?>
<form id="articleForm" action="index.php?action=<?= htmlspecialchars($articleAction) ?>" method="post" class="col-12 mx-auto mb-5 p-auto bg-dark text-light rounded">
    <h3>Edition d'article</h3>
    <div class="form-group form-inline mt-4">
        <label for="parent">A quel parent s'adresse cet article ?</label>
        <select name="parent" id="parent" class="form-control col-md-2 mx-2" >
            <?php if (isset($thisContent)): ?>
                <option value="<?= htmlspecialchars($thisContent->parent()) ?>" selected="selected"><?= htmlspecialchars($thisContent->parent()) ?></option>
                <?php else: ?>
                    <option value="NULL" selected="selected"></option>
            <?php endif; ?>
            <option value="dad">Papa</option>
            <option value="mom">Maman</option>
            <option value="both">Les deux</option>
        </select>
        <label for="tag" class="ml-4">Catégorie</label>
        <select name="tag" id="tag" class="form-control col-md-2 mx-2" >
            <?php if (isset($thisContent)): ?>
                <option value="<?= htmlspecialchars($thisContent->tag()) ?>" selected="selected"><?= htmlspecialchars($thisContent->tag()) ?></option>
                <?php else: ?>
                    <option value="NULL" selected="selected"></option>
            <?php endif; ?>
            <option value="baby">Bébé</option>
            <option value="pregnancy">Grossesse</option>
            <option value="house">Maison</option>
        </select>
    </div>
    <div class="form-group" >
        <label for="article_title">Titre</label><br />
        <input type="text" id="article_title" name="article_title" class="form-control"
        <?php if (isset($thisContent)): ?>
            value="<?=htmlspecialchars($thisContent->title()) ?>"
        <?php endif; ?>
        />
    </div>
    <div class="form-group">
        <label for="article_content">Contenu</label><br />
        <textarea id="article_content" name="article_content" class="form-control content" ><?php if (isset($thisContent)) { echo htmlspecialchars($thisContent->content()); } ?></textarea>
    </div>
    <div class="form-group">
        <label for="description">Description</label><br />
        <textarea id="description" name="description" class="form-control" ><?php if (isset($thisContent)) { echo htmlspecialchars($thisContent->description()); } ?></textarea>
    </div>
    <div class="form-group">
        <label for="article_meta_title">Meta titre</label><br />
        <input type="text" id="article_meta_title" name="article_meta_title" class="form-control"
        <?php if (isset($thisContent)): ?>
            value="<?=htmlspecialchars($thisContent->metaTitle()) ?>"
        <?php endif; ?>
        />
    </div>
    <div class="form-group">
        <label for="article_meta_desc">Meta description</label><br />
        <textarea id="article_meta_desc" name="article_meta_desc" class="form-control" ><?php if (isset($thisContent)) { echo htmlspecialchars($thisContent->metaDesc()); } ?></textarea>
    </div>
    <div class="form-group">
        <?php if (isset($thisContent)): ?>
            <input id="content_id" name="content_id" type="hidden" value="<?= htmlspecialchars($thisContent->id()) ?>" />
        <?php endif; ?>
        <button type="submit" class="btn btn-warning text-dark font-weight-bold mb-2">Envoyer</button>
    </div>
</form>

<?php $articleForm = ob_get_clean(); ?>
