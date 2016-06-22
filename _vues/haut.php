<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
        <meta name="author" content="PAYRAT Julien" />
        <meta name="description" content="Référentiel GPC" />
        <meta name="keywords" content="" />
        <link rel="stylesheet" type="text/css" href="<?= WEBPATH; ?>css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?= WEBPATH; ?>css/ilot.css" />
        <link rel="shortcut icon" href="" />
       <script> 
            var iloCodeBase='<?= $codeBase ;?>';
            var base='<?= $base ;?>';
            var Complement_Titre='<?= $libelleBase ;?>';
            var php_ilot ='<?=WEBPATH; ?>index.php';
        </script>  
        <!-- ajout des script js controleur de la vue : ModelVue.php -->
        <?php foreach($jqueryLoader as $jsScript): ?>
        <?= $jsScript;?>
        <?php endforeach; ?>

        <title>Referentiel-GPC</title>
    </head>
    <body>

        <!-- debut en-tete -->
        <!--<header>-->
        <div class="header">
            <div class="header_entete">
                <img src="<?= WEBPATH; ?>img/_design/logo_orange.gif" class="logoOrange" alt="logo orange" />
                <div class="titre"><a href="<?= WEBPATH; ?>">Référentiel GPC</a></div>

                <div class="nav">
                    <div><a href="<?= $lienHorizMP; ?>" class="<?= $classCSSLienMP; ?>">Midi-Pyrénées</a></div>
                    <div class="separateur"><a href="<?= $lienHorizLR; ?>" class="<?= $classCSSLienLR; ?>">Languedoc Roussillon</a></div>
                    <div></div>
                </div>
            </div>
        </div>