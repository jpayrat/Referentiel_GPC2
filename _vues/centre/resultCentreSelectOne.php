<?php foreach($dataSelectOne['dataCentre'] as $row):

    $specificite = '';
    $row['rhIlot'] == '' ? $specificite .= '' : $specificite .= ' [ Répartiteur Habité ] '; /* Répartiteur habité */
    $row['cenNRAOkNok'] == '0' ? $specificite .= '' : $specificite .= ' [ NRA pas encore en service ] '; /* Nra pas en service */
    $row['cenZoneBlanche'] == '0' ? $specificite .='' : $specificite .= ' [ Zone Blanche ] '; /* Zone blanche */

?>
    
    <h1> <?= $row['cenCodeCentre']; ?> - [ <?= $row['cenLibelleCentre']; ?> ]
        <span class="specificite"><?= $specificite; ?></span>
    </h1>
    <hr />

    <div class="bloc_front">

        <div class="bloc_front_titre">Adresse <span>:</span></div>
        <div class="bloc_front_aff"><?= $row['cenNumero'].' '.$row['cenRue']. ' '.$row['cenCodePostal']; ?></div>

        <br />
        <div class="bloc_front_titre">Coordonnées GPS <span>:</span></div>
        <div class="bloc_front_aff">N : <?= $row['coordGPS'][0].'<br /> E : '.$row['coordGPS'][1]; ?>
            <br />
            <a href="http://www.google.com/maps/place/<?=$row['coordGPS'][0];?>,<?=$row['coordGPS'][1];?>" target="_blank" title="Lien GoogleMap">
                <img src="<?= WEBPATH; ?>img/_design/googlemap.png" alt="googlemap" />
            </a>
        </div>

        <br />

        <div class="bloc_front_titre">Zone ETR <span>:</span></div>
         <div class="bloc_front_aff"><?= $row['zeLibelleZoneETR']; ?></div>

        <br />
        <div class="bloc_front_titre">Zone GPC <span>:</span></div>
          <div class="bloc_front_aff"><?= $row['siLibelleSite']; ?></div>

        <br /><br />
        <div class="bloc_front_titre">Sous-Répartiteur (SR) associés <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['cenZones']; ?></div>
    </div>

    <div class="bloc_side">
        <span class="a">Centre d'origine :</span> <?= $row['cenCentreOrigine']; ?>
        <br />
        <span class="a">Type de NRA :</span> <?= $row['tnraTypeNRA']; ?>
        <br />
        <span class="a">Blocage R2 :</span> <?= $row['cenBlocageR2']; ?>
        <br />
        <span class="a">Information R2 :</span> <?= $row['cenInfoR2']; ?>
        <br /><br />

        <span class="a">Date de création :</span><?= $row['cenDateCreation']; ?>
        <br />
        <span class="a">Modifié le :</span><?= $row['cenDateModif']; ?>
    </div>

    <div class="bloc_front_coms">
        <div class="bloc_front_titre">Information complémentaire <span>:</span></div>
            <div class="bloc_front_infos"><?= $row['cenInfoAdmin']; ?></div>
        </div>
    </div>

    <?php
        if($row['rhIlot'] != NULL){
    ?>
        <br /><br />
        <div class="bloc_front">

            <div class="bloc_front_titre">Ville du répartiteur habité <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['rhVille']; ?></div>

            <br />
            <div class="bloc_front_titre">Ilot de répartiteur habité <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['rhIlot']; ?></div>

            <br />
            <div class="bloc_front_titre">Habité / Semi-habité <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['trhTypeRepHab']; ?> - <?= $row['trhLibelleTypeRepHab']; ?></div>

            <br />
            <div class="bloc_front_titre">Horaire <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['rhHoraire']; ?></div>

            <br />
            <div class="bloc_front_titre">Techniciens Associés <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['rhTechnicien']; ?></div>

            <br />
            <div class="bloc_front_titre">Horaire <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['rhHoraire']; ?></div>

            <br />
            <div class="bloc_front_titre">Numéro du répartiteur <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['rhNumero']; ?></div>

            <br />
            <div class="bloc_front_titre">Imprimante <span>:</span></div>
            <div class="bloc_front_aff"><?= $row['rhImprimante']; ?></div>
        </div>

     <?php
        }
     ?>

<?php endforeach ?>