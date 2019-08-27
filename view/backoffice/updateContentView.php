<?php ob_start(); ?>
<h3 class="h2 my-md-5">Modifier le contenu</h3>

<?php if ($type == 'article'): ?>
    <?= $articleForm ?>
    <?php else: ?>
        <?= $postForm ?>
<?php endif; ?>



<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
