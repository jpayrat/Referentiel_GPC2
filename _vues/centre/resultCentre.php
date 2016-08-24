<h2><?= $dataSelectAll['nbCentre'] ?>  <?= $dataSelectAll['nbCentre']== 1 ? ' Centre correspond' : ' Centres correspondent'; ?>
 à votre recherche sur <?=$dataSelectAll['Complement_Titre']; ?>

<!-- lien telechargement -->
<?php if ($dataSelectAll['nbCentre'] > 0): ?>
    <a href="<?=$dataSelectAll['linkXls'] ?>" class="exportcsv">
        <img src=<?= $dataSelectAll['imgXls'] ?> alt='csv' /> Téléchargement
    </a>
<?php endif; ?></h2>
<!-- fin lien -->
<hr />
<?php $i=1; ?>
<?php foreach($dataSelectAll['dataCentre'] as $row): ?>

    <?php
    //Modifie les données pour changer la couleur du texte qui est tapé dans recherche globale ou ilotTape
    if ($dataSelectAll['rechercheCentreGlobal'] != '')
    {
        if ($dataSelectAll['centre'] != '') { $req_cenCodeCentre = preg_replace('#('.$dataSelectAll['centre'].')#i', '<span class="surligner">$1</span>', strtoupper($row['cenCodeCentre'])); }
        else { $req_cenCodeCentre = preg_replace('#('.$dataSelectAll['rechercheCentreGlobal'].')#i', '<span class="surligner">$1</span>', $row['cenCodeCentre']); }
        $row['cenLibelleCentre'] = preg_replace('#('.$dataSelectAll['rechercheCentreGlobal'].')#i', '<span class="surligner">$1</span>', $row['cenLibelleCentre']);
        $row['cenInfoAdmin'] = preg_replace('#('.$dataSelectAll['rechercheCentreGlobal'].')#i', '<span class="surligner">$1</span>', $row['cenInfoAdmin']);
        $row['siLibelleSite'] = preg_replace('#('.$dataSelectAll['rechercheCentreGlobal'].')#i', '<span class="surligner">$1</span>', $row['siLibelleSite']);

    }
    else {
        if ($row['cenCodeCentre'] != '') { $req_cenCodeCentre = preg_replace('#('.$dataSelectAll['centre'].')#i', '<span class="surligner">$1</span>', strtoupper($row['cenCodeCentre'])); }
        else { $req_cenCodeCentre = $row['cenCodeCentre']; }
    }

        $specificite = '';
        $row['rhIlot'] == '' ? $specificite .= '' : $specificite .= ' [ Répartiteur Habité ] '; /* Répartiteur habité */
        $row['cenNRAOkNok'] == '0' ? $specificite .= '' : $specificite .= ' [ NRA pas encore en service ] '; /* Nra pas en service */
        $row['cenZoneBlanche'] == '0' ? $specificite .='' : $specificite .= ' [ Zone Blanche ] '; /* Zone blanche */
    ?>

    <div href="#" class="lienCentreAjax <?= $i++%2==0 ? '' : 'couleur_ligne_pair';?>" centre="<?= $row['cenCodeCentre'];?>" >

        <div class="champ cenCode"><b><?= $req_cenCodeCentre;?></b></div> - <div class="champ cenLibelle">[ <b><?=$row['cenLibelleCentre'];?></b> ]</div>
        <div class="champ siLibelleSite">Zone GPC : <b><?= $row['siLibelleSite'];?></b></div>
        <div class="champ zeZoneETR">Zone ETR : <b><?= $row['zeLibelleZoneETR'];?></b></div>
        <div class="champ googleMap">
            <a href="http://www.google.com/maps/place/<?=$row['coordGPS'][0];?>,<?=$row['coordGPS'][1];?>" target="_blank" title="Lien GoogleMap"><img src="<?= WEBPATH; ?>img/_design/googlemap.png" alt="googlemap" /></a>
        </div>

        <?php if($specificite != ''){
            echo '<br /><div class="champ specificite">Spécificité(s) : <b>'.$specificite.'</b></div>';
        }?>

        <?php if($row['cenInfoAdmin'] != ''){
            echo '<br /><div class="champ infoAdmin"><b>Info admin : </b>'.$row['cenInfoAdmin'].'</div>';
        }?>
    </div>
    <br />

<?php endforeach ?>