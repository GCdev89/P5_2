<?php $controlScript = '<script src="js/newContent.js"></script>'; ?>

<?php ob_start(); ?>
<div class="row col-lg-12 mx-auto px-0">
    <h2 class="h2 mb-4">Rédiger du contenu</h2>
    <div class="row col-md-12">
        <?php if (Session::hasAdminAccess()): ?>
            <h3>Que souhaitez vous souhaitez rédiger ?</h3>
            <div class="form-group mx-3">
                <button id="toggleArticleForm" class="btn btn-outline-dark">Un article</button>
                <button id="togglePostForm" class="btn btn-outline-dark mx-3">Un billet de blog</button>
            </div>
            <div class="row col-12 m-0 p-0">
                <?= $articleForm ?>
                <?= $postForm ?>
            </div>
        <?php else: ?>
            <?= $articleForm ?>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
