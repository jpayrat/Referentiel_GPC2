<div class="container" id="ilot_corps">

    <h1> Administration </h1>
    <hr />


    <form method="post" id="form_ilot" action="#" class="formulaire">


        <label for="rechercheGlobal" class="gen">Recherche globale</label>
        <?= $inputIlotGlobal; ?>

        <div style="border: 0px solid #000; display: inline-block;text-align: center; width: 52%;">
            <span id="all_form">Lister tous les îlots</span>
            <span id="reinit_form">Réinitialiser le formulaire</span>
        </div>

        <br />
        <br />
    </form>

    <!-- div du retour de la requete Ajax -->
    <div id="results_ilot" style="display: none;"></div>
    <br />

</div>
</section>