<?php ob_start(); ?>
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark pt-1 my-auto">
    <a class="navbar-brand" href="index.php"><img id="nav_logo" src="../public/images/logo/x1.png" alt="Code Bebe logo" /></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse my-auto" id="navbarMain">
        <ul class="navbar-nav mr-auto ml-3 my-auto">
            <li class="nav-item pr-3 <?php if(isset($isActive) && $isActive == 'home'){echo'h3 active';} ?>"><a class="nav-link" href="index.php">Accueil</a></li>
            <li class="nav-item pr-3 <?php if(isset($isActive) && $isActive == 'both'){echo'h3 active';} ?>"><a class="nav-link" href="index.php?action=list_articles&amp;parent=both">Le coin des parents</a></li>
            <li class="nav-item pr-3 <?php if(isset($isActive) && $isActive == 'dad'){echo'h3 active';} ?>"><a class="nav-link" href="index.php?action=list_articles&amp;parent=dad">Le coin des papas</a></li>
            <li class="nav-item pr-3 <?php if(isset($isActive) && $isActive == 'mom'){echo'h3 active';} ?>"><a class="nav-link" href="index.php?action=list_articles&amp;parent=mom">Le coin des mamans</a></li>

            <li class="nav-item pr-3 <?php if(isset($isActive) && $isActive == 'blog'){echo'h3 active';} ?>"><a class="nav-link" href="index.php?action=list_posts">Le blog</a></li>
        </ul>
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['pseudo'])): ?>
            <div class="text-light mr-4"><span class="badge badge-warning mr-3 my-auto p-2"><a href="index.php?action=user_profile" class=" text-decoration-none text-dark"><?= htmlspecialchars($_SESSION['pseudo'])?></a></span>
            <a href="index.php?action=disconnect" class="my-auto btn btn-outline-danger">Déconnexion</a></div>
            <?php else: ?>
                <form class="form-inline" action="index.php?action=connect" method="post" >
                    <input class="form-control mr-2 mb-2 mb-lg-0" type="text" name="pseudo" placeholder="Pseudo"/>
                    <input class="form-control mr-2 mb-2 mb-lg-0" type="password" name="password" placeholder="Mot de passe" />
                    <button class="btn btn-outline-success mb-2 mb-lg-0" type="submit">Connexion</button>
                </form>
                <a href="index.php?action=registration&amp;sent=no" class="ml-md-3 btn btn-outline-warning">Inscription</a>
        <?php endif; ?>
    </div>
</nav>


<?php $nav = ob_get_clean(); ?>
