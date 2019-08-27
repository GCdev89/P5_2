<?php
$myScript = '<script src="js/newContent.js"></script>';
$tinyScript = '<script src="tinymce/tinymce.js" referrerpolicy="origin"></script>
        <script>
        tinymce.init({
            language : "fr_FR",
            selector: \'.content\'
        });
        </script>';

?>

<?php ob_start(); ?>
<div class="row col-lg-12 mx-0 mx-lg-auto px-0 px-lg-auto">
    <h2 class="h2 mb-4">Rédiger du contenu</h2>
    <div class="row col-md-12 mx-0">
        <?php if (Session::hasAdminAccess()): ?>
            <h3>Que souhaitez vous souhaitez rédiger ?</h3>
            <div class="form-group mx-auto mx-md-3">
                <button id="toggleArticleForm" class="btn btn-outline-dark">Un article</button>
                <button id="togglePostForm" class="btn btn-outline-dark mx-3">Un billet de blog</button>
            </div>
            <div class="row col-lg-12 m-0 p-0">
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
