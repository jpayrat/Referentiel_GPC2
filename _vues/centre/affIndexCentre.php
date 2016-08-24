<div class="container" id="centre_corps">

    <form method="post" id="form_centre" action="#" class="formulaire">

        <h1> Centres <?php echo '- ' . $libelleBase; ?><span class=""><?= $nbCentre>0 ? ' ('.$nbCentre.' centres )' : ''; ?></span></h1>
        <hr />

        <label for="rechercheCentreGlobal" class="gen">Recherche globale</label>
        <?= $inputCentreGlobal; ?>

        <div style="border: 0px solid #000; display: inline-block;text-align: center; width: 52%;">
            <span id="all_form">Lister tous les centres</span>
            <span id="reinit_form">Réinitialiser le formulaire</span>
        </div>

        <br />

        <label for="recherchedetail" class="gen" id="search_centre_detail">Recherche avancée</label><span id="arrow" class="arrowBottom"></span>

        <div class="search_centre_detail">
            <div style="width: 62%; display: inline-block;">
                <label for="rechercheCentreTape" class="gen">Centre </label>
                <?= $inputCentreTape; ?>
                <span>ou</span>
                <?= $selectCentreList; ?>
            </div>
            
            <div style="width: 37%; display: inline-block;">
                <label for="zoneETR" class="gen">Zone ETR </label>
                <?= $selectZoneETR; ?>
            </div>

            <br />

            <div style="width: 32%; display: inline-block;">
                <label for="idSiteGPC" class="gen">Zone GPC </label>
                <?= $selectIdSiteGPC; ?>
            </div>

            <div style="width: 32%; display: inline-block;">
                <label for="NRA" class="gen">NRA </label>
                <?= $selectNRA; ?>
            </div>

            <div style="width: 32%; display: inline-block;">
                <label for="blocageR2" class="gen">Blocage R2 </label>
                <?= $selectBlocageR2; ?>
            </div>

            <div style="width: 45%; display: inline-block;">
                <label for="repHab" class="gen">Répartieur habité </label>
                <?= $selectRepHab; ?>
            </div>

            <div style="width: 45%; display: inline-block;">
                <label for="zoneBlanche" class="gen">Zone blanche</label>
                <?= $selectZoneBlanche; ?>
            </div>



            <br />



        </div>
        <br />
        <br />
    </form>

    <!-- div du retour de la requete Ajax -->
    <div id="ajaxLoader" style="display: none;"><img src="<?=WEBPATH; ?>img/_design/ajax-loader.gif" alt="Chargement..." id="ajax-loader" /></div>
    <div id="results_centre" style="display: none;"></div>
    <br />

</div>
</section>