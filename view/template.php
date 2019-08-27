<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <?php if (isset($metaTitle)): ?>
            <title><?= $metaTitle ?></title>
            <?php else: ?>
                <title>Code Bébé</title>
        <?php endif; ?>
        <?php if (isset($metaDesc)): ?>
            <meta name="description" content="<?= $metaDesc ?>" />
            <?php else: ?>
                <meta name="description" content="Bienvenue sur Code Bébé, nous cherchons à vous accompagner au mieux dans la nouvelle vie qui vous attends." />
        <?php endif; ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <?php if (isset($tinyScript)): ?>
            <?= $tinyScript ?>
        <?php endif; ?>


        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../public/css/styleMain.css" rel="stylesheet" />
    </head>

    <body>

        <?= $nav ?>

        <div class="container-fluid mb-5">
            <div class="row">
                <?php if (isset($sidebar)): ?>
                    <?= $sidebar ?>
                <?php endif; ?>
                <main class="col-lg-10 m-0 p-0 mx-lg-auto px-lg-auto">
                    <?php if (isset($headerHero)): ?>
                        <?= $headerHero ?>
                        <?php else: ?>
                            <div class="jumbotron col-8 col-lg-4 mx-auto mt-4 px-auto">
                                <div class="container mx-auto px-auto">
                                    <h1 class="display-5 mx-auto px-auto "><a href="index.php" class="mx-auto px-auto"><img id="main_logo" class="img-fluid" src="../public/images/logo/x1.png" alt="Code bebe parental solutions" /></a></h1>
                                </div>
                            </div>
                    <?php endif; ?>

                    <div class="row col-lg-12 mx-0 px-0 mx-md-auto">
                        <?= $content ?>
                    </div>
                </main>

            </div>
        </div>
        <?php if (isset($_SESSION['role'])): ?>
            <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'editor' OR $_SESSION['role'] == 'writer' OR $_SESSION['role'] == 'moderator'): ?>
                <?= $adminBar ?>
            <?php endif; ?>
        <?php endif; ?>


        <?php if (isset($myScript)) {
            echo $myScript;
        } ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>
