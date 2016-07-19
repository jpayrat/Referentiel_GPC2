<div class="container" id="ilot_corps">

    <h1> Administration </h1>
    <hr />


    <form method="post" id="form_ilot" action="<?= WEBPATH; ?>AD/admin/connexion" class="formulaire">

        <center>
            <input type="hidden" name="mail" id="mail" />
            <input type="text" name="e-mail" id="e-mail" class="input-e-mail" /><br />
               <?= $inputNom; ?>

        <br /><br />
               <?= $inputPass; ?>
        <br /><br />
        <button class="" type="submit" name="Envoyer">Log in</button>
        </center>
        <br />
        <br />
    </form>

    <br />
</div>
</section>