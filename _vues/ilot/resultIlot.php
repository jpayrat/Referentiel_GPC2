<h2><?= $dataSelectAll['nbIlots'] ?>  <?= $dataSelectAll['nbIlots']== 1 ? ' îlot correspond' : ' îlots correspondent'; ?> 
à votre recherche sur <?=$dataSelectAll['Complement_Titre']; ?>

    

<!-- lien telechargement -->
<?php if ($dataSelectAll['nbIlots'] > 0): ?>
    <a href="<?=$dataSelectAll['linkXls'] ?>" class="exportcsv">
        <img src=<?= $dataSelectAll['imgXls'] ?> alt='csv' /> Téléchargement
    </a>
<?php endif; ?></h2>
<!-- fin lien -->
<hr />
<?php $i=1; ?>
<?php foreach($dataSelectAll['dataIlot'] as $row): ?>
   <?php

    //Modifie les données pour changer la couleur du texte qui est tapé dans recherche globale ou ilotTape


    if ($dataSelectAll['rechercheGlobal'] != '')
    {
        if ($dataSelectAll['ilot'] != '') { $req_iloCodeIlot = preg_replace('#('.$dataSelectAll['ilot'].')#i', '<span class="surligner">$1</span>', strtoupper($row['iloCodeIlot'])); }
        else { $req_iloCodeIlot = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['iloCodeIlot']); }
        $row['iloLibelleIlot'] = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['iloLibelleIlot']);
        // Pas Utile, la recherche se fait que sur 1 ou 0 // $row['iloOptim = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['iloOptim']);
        $row['tiIdTypeIot'] = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['tiIdTypeIot']);
        $row['used'] = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['used']);
        $row['coIdCompetence'] = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['coIdCompetence']);
        $row['sedIdServDem'] = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['sedIdServDem']);
        $row['enIdEntreprise'] = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['enIdEntreprise']);
        $row['siIdSite'] = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['siIdSite']);
        $row['dacIdDomAct'] = preg_replace('#('.$dataSelectAll['rechercheGlobal'].')#i', '<span class="surligner">$1</span>', $row['dacIdDomAct']);
    }
    else {
        if ($row['iloCodeIlot'] != '') { $req_iloCodeIlot = preg_replace('#('.$dataSelectAll['ilot'].')#i', '<span class="surligner">$1</span>', strtoupper($row['iloCodeIlot'])); }
        else { $req_iloCodeIlot = $row['iloCodeIlot']; }
    }


    ?>
   
    <a href="#" class="lienIlotAjax <?= $i++%2==0 ? '' : 'couleur_ligne_pair';?>" ilot="<?= $row['iloCodeIlot'];?>" >
    <div class="champ iloCode"><b><?= $req_iloCodeIlot;?></b></div> - <div class="champ iloLibelle">[<b><?=$row['iloLibelleIlot'];?> </b>]</div>
    <div class="champ servDem"  infoBulle="<?= $row['sedLibelleServDem'];?>">Service : <b><?= $row['sedIdServDem'];?></b></div> 
    <div class="champ ilotTypeIlot" infoBulle="<?= $row['tiLibelleTypeIlot'];?>">Type de l'îlot : <b><?= $row['tiIdTypeIot'];?></b></div>
    <div class="champ">Optimisé : <b><?= $row['iloOptim'];?></b></div>
    <div class="champ">Utilisé : <b><?= $row['used'];?></b></div>
    <br />
    <div class="champ dacIdDomAct" infoBulle="<?=$row['daLibelleDomAct'];?>">Domaine d'activité : <b><?=$row['dacIdDomAct'];?> </b></div> 
    <div class="champ competence" infoBulle="<?=$row['coLibelleCompetence'];?>">Compétence : <b><?=$row['coIdCompetence'];?></b></div> 
    <div class="champ site" infoBulle="<?=$row['Liste_sites'];?>">Zone d'intervention : <b><?=$row['siIdSite'];?></b></div>
    <div class="champ entreprise" infoBulle="<?=$row['enLibelleEntreprise']?>">Entreprise : <b><?=$row['enIdEntreprise'];?></b></div>
    <br />
    <div class="champ"><b>Commentaire :</b> <?=$row['iloInfo'];?></div>
    </a>
    
<?php endforeach ?>

