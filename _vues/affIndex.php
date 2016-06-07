        <div class="container">

            <form method="post" id="form_ilot" action="#" class="formulaire">
                <h1> Îlots GPC <?php echo '- '.$libelleBase; ?></h1>
                <hr />

                <label for="rechercheGlobal" class="gen souligner">Recherche globale</label><input type="text" name="rechercheGlobal" id="rechercheGlobal" tabindex="1" size="30" maxlength="28" />

                <div style="border: 0px solid #000; display: inline-block;text-align: center; width: 52%;">
                    <span id="all_form">Lister tous les îlots</span>
                    <span id="reinit_form">Réinitialiser le formulaire</span>
                </div>

                <br />

                <label for="recherchedetail" class="gen souligner" id="search_ilot_detail">Recherche avancée</label><span id="arrow" class="arrowBottom"></span>

                <div class="search_ilot_detail">
                    <div style="width: 55%; display: inline-block;">
                        <label for="ilot_tape" class="gen">Ilot </label> <input type="text" name="ilot_tape" id="ilot_tape" tabindex="1" size="3" maxlength="3" /> <span>ou</span>
                        <?= $selectIlotList; ?>
                    </div>
                    <div style="width: 20%; display: inline-block;">
                        <label for="typeIlot" class="gen">Type d'îlot </label>
                        <?= $selectTypeIlot; ?>
                    </div>
                    <div style="width: 19%; display: inline-block;">
                        <label for="used" class="gen">Utilisé ? </label>
                        <?= $selectUsed; ?>
                    </div>

                    <br />

                    <div class="ligne_form">
                        <label for="competence" class="gen">Compétence de l'îlot </label>
                        <?= $selectCompetence; ?>
                    </div>

                    <div class="ligne_form">
                        <label for="serviceCible" class="gen">Service concerné </label>
                        <?= $selectServiceCible; ?>
                    </div>

                    <br />

                    <div class="ligne_form">
                        <label for="entreprise" class="gen">Entreprise</label>
                        <?= $selectEntreprise; ?>
                    </div>

                    <div class="ligne_form">
                        <label for="siteGeo" class="gen">Site géographique </label>
                        <?= $selectSiteGeo; ?>
                    </div>

                    <br />

                    <div class="ligne_form">
                        <label for="domaineAct" class="gen">Domaine d'activité </label>
                        <?= $selectDomaineAct; ?>
                    </div>

                    <div class="ligne_form_radio">
                        <label for="optim">Ilot Optimisé </label>
                        <input type="radio" id="optim_ok" value="1" name="optim" />
                        <label for="optim_ok" class="radio">Oui</label>

                        <input type="radio" id="optim_nok" value="0" name="optim" />
                        <label for="optim_nok" class="radio">Non</label>

                        <input type="radio" id="optim_tout" value="tous" name="optim" checked />
                        <label for="optim_tout" class="radio">Les deux</label>
                    </div>

                </div>


























                        <form action="Parties_pros_v0.1/PPros/rechercheGlobal" method="POST">
                <div class="formSearchGlobal">
                    <button class="rechercheGenPProsSubmit" type="submit" aria-label="Rechercher"></button>
                    <?php //echo $input; ?>
                    <br /><br />
                    <button class="rechercheRecentSubmit" id="rechercheRecentSubmit" type="submit">Parties récentes</button> - <button class="rechercheHasardSubmit" type="submit">Partie au hasard</button>
                </div>
            </form>

            <br /><br /><br /><br />
            <hr />
            <br />
            <div id="results_ilot" style="display: none;"></div>
            <br /><br /><br />

        </div>
    </section>