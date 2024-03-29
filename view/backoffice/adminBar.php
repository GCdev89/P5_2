<?php ob_start(); ?>
<div id="admin_bar" class="navbar navbar-expand-lg fixed-bottom p-1 navbar-dark bg-dark">
    <h4 class="navbar-brand font-italic text-warning ml-2">Administration</h4>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAdmin"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse ml-2" id="navbarAdmin">
        <ul class="navbar-nav">
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'editor' OR $_SESSION['role'] == 'writer'): ?>
                <li class="nav-item <?php if(isset($isActive) && $isActive == 'newPost'){echo'active';} ?>"><a href="index.php?action=new" class="nav-link">Nouveau contenu</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'editor' OR $_SESSION['role'] == 'writer'): ?>
                <li class="nav-item <?php if(isset($isActive) && $isActive == 'myContents'){echo'active';} ?>"><a href="index.php?action=update_list_my_contents&amp;type=article" class="nav-link">Mes contenus</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'editor'): ?>
                <li class="nav-item <?php if(isset($isActive) && $isActive == 'allContents'){echo'active';} ?>"><a href="index.php?action=update_list_contents" class="nav-link">Liste des contenus</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'moderator'): ?>
                <li class="nav-item <?php if(isset($isActive) && $isActive == 'moderation'){echo'active';} ?>"><a href="index.php?action=moderation" class="nav-link">Modération</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'moderator'): ?>
                <li class="nav-item <?php if(isset($isActive) && $isActive == 'users'){echo'active';} ?>"><a href="index.php?action=users_list" class="nav-link">Utilisateurs</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php $adminBar = ob_get_clean(); ?>
