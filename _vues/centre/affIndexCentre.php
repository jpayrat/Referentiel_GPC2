<div class="container" id="ilot_corps">

    <form method="post" id="form_ilot" action="#" class="formulaire">

        <h1> Centres <?php echo '- ' . $libelleBase; ?><span class=""><?= $nbCentre>0 ? ' ('.$nbCentre.' centres )' : ''; ?></span></h1>
        <hr />

        <label for="rechercheGlobal" class="gen">Recherche globale</label>
        <?= $inputCentreGlobal; ?>

        <div style="border: 0px solid #000; display: inline-block;text-align: center; width: 52%;">
            <span id="all_form">Lister tous les centres</span>
            <span id="reinit_form">Réinitialiser le formulaire</span>
        </div>

        <br />

        <label for="recherchedetail" class="gen" id="search_ilot_detail">Recherche avancée</label><span id="arrow" class="arrowBottom"></span>

        <div class="search_ilot_detail">
            <div style="width: 62%; display: inline-block;">
                <label for="ilot_tape" class="gen">Centre </label>
                <?= $inputCentreTape; ?>
                <span>ou</span>
                <?= $selectCentreList; ?>
            </div>
            
            <div style="width: 37%; display: inline-block;">
                <label for="typeIlot" class="gen">Zone ETR </label>
                <?= $selectZoneETR; ?>
            </div>

            <br />

            <div style="width: 32%; display: inline-block;">
                <label for="used" class="gen">Zone GPC </label>
                <?= $selectIdSiteGPC; ?>
            </div>

            <div style="width: 32%; display: inline-block;">
                <label for="NRA" class="gen">NRA </label>
                <?= $selectNRA; ?>
            </div>

            <div style="width: 32%; display: inline-block;">
                <label for="siteGeo" class="gen">Blocage R2 </label>
                <?= $selectBlocageR2; ?>
            </div>

            <div style="width: 45%; display: inline-block;">
                <label for="serviceCible" class="gen">Répartieur habité </label>
                <?= $selectRepHab; ?>
            </div>

            <div style="width: 45%; display: inline-block;">
                <label for="entreprise" class="gen">Zone blanche</label>
                <?= $selectZoneBlanche; ?>
            </div>



            <br />



        </div>
        <br />
        <br />
    </form>

    <!-- div du retour de la requete Ajax -->
    <div id="results_centre" style="display: none;"></div>
    <br />

</div>
</section>