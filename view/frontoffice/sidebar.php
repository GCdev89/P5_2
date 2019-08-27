<?php ob_start(); ?>
<nav class="col-lg-1 d-none d-lg-block bg-light border-right" id="sidebar">
    <div class="navbar-light my-auto">
        <h5 class="h3 text-dark mt-2">Catégories</h5>
        <ul class="navbar-nav flex-column nav-dark">
            <li class="nav-item <?php  if($tag == NULL){echo'h5 active';} ?>"><a href="index.php?action=list_articles&amp;parent=<?= $parent ?>" class="nav-link">Tous les articles</a></li>
            <li class="nav-item <?php  if($tag == 'baby'){echo'h5 active';} ?>"><a href="index.php?action=list_articles&amp;parent=<?= $parent ?>&amp;tag=baby" class="nav-link">Bébé</a></li>
            <li class="nav-item <?php  if($tag == 'house'){echo'h5 active';} ?>" class="nav-link"><a href="index.php?action=list_articles&amp;parent=<?= $parent ?>&amp;tag=house" class="nav-link">La maison</a></li>
            <li class="nav-item <?php  if($tag == 'pregnancy'){echo'h5 active';} ?>"><a href="index.php?action=list_articles&amp;parent=<?= $parent ?>&amp;tag=pregnancy" class="nav-link">Grossesse</a></li>
        </ul>
    </div>
</nav>

<?php $sidebar = ob_get_clean(); ?>
