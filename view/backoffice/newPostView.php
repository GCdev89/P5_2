<?php ob_start(); ?>
<div class="row col-lg-12 mx-auto px-0">
    <h2 class="h2 mb-4">Rédiger du contenu</h2>
    <form action="index.php?action=addPost" method="post" class="col-12 mx-auto mb-5 p-auto bg-dark text-light rounded">
        <div class="form-group">

        </div>
        <div class="form-group" >
            <label for="title">Titre</label><br />
            <input type="text" id="title" name="title" class="form-control" />
        </div>
        <div class="form-group">
            <label for="content">Contenu</label><br />
            <textarea id="content" name="content" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="meta_title">Meta titre</label><br />
            <input type="text" id="meta_title" name="meta_title" class="form-control" />
        </div>
        <div class="form-group">
            <label for="meta_desc">Meta description</label><br />
            <textarea id="meta_desc" name="meta_desc" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-warning text-dark font-weight-bold">Envoyer</button>
        </div>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php
require('../view/navbar.php');
require('../view/backoffice/adminBar.php');
require('../view/template.php');
