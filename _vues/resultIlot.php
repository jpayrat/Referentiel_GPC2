<h2><?= $dataSelectAll['nbIlots'] ?>  <?= $dataSelectAll['nbIlots']== 1 ? ' îlot correspond' : ' îlots correspondent'; ?> 
à votre recherche sur <?=$dataSelectAll['Complement_Titre']; ?></h2>

<!-- lien telechargement -->

<?php $i=1; ?>
<?php foreach($dataSelectAll['dataIlot'] as $row): 
    $row['iloCodeIlot'] = strtoupper($row['iloCodeIlot']);
    $row['iloLibelleIlot'] = strtoupper($row['iloLibelleIlot']);
    $row['iloOptim'] =  $row['iloOptim'] == 1 ? 'Oui' : 'Non';
    if ($row['used'] == '')             {  $row['used'] = ' - '; }
    if ($row['coIdCompetence'] == '')   {  $row['coIdCompetence'] = ' - '; }
    if ($row['sedIdServDem'] == '')     {  $row['sedIdServDem'] = ' - '; }
    if ($row['enIdEntreprise'] == '')   {  $row['enIdEntreprise'] = ' - '; }
    if ($row['siIdSite'] == '')         {  $row['siIdSite'] = ' - '; }
    if ($row['dacIdDomAct'] == '')      {  $row['dacIdDomAct'] = ' - '; }
    ?>
   
    <a href="#" class="lienIlotAjax <?= ++$i%2==0 ? '' : 'couleur_ligne_pair';?>" ilot="<?= $row['iloCodeIlot'];?>" >
    <div class="champ iloCode"><b><?= $row['iloCodeIlot'];?></b></div> - <div class="champ iloLibelle">[<b><?=$row['iloLibelleIlot'];?> </b>]</div>
    <div class="champ servDem"  infoBulle="<?= $row['sedLibelleServDem'];?>">Service : <b><?= $row['sedIdServDem'];?></b></div> 
    <div class="champ ilotTypeIlot" infoBulle="<?= $row['tiLibelleTypeIlot'];?>">Type de l\'îlot : <b><?= $row['tiIdTypeIot'];?></b></div>
    <div class="champ">Optimisé : <b><?= $row['iloOptim'];?></b></div>
    <div class="champ">Utilisé : <b><?= $row['used'];?></b></div>
    <br />
    <div class="champ dacIdDomAct" infoBulle="<?=$row['daLibelleDomAct'];?>">Domaine d\'activité : <b><?=$row['dacIdDomAct'];?> </b></div> 
    <div class="champ competence" infoBulle="<?=$row['coLibelleCompetence'];?>">Compétence : <b><?=$row['coIdCompetence'];?></b></div> 
    <div class="champ site" infoBulle="<?=$row['Liste_sites'];?>">Zone d\'intervention : <b><?=$row['siIdSite'];?></b></div>
    <div class="champ entreprise" infoBulle="<?=$row['enLibelleEntreprise']?>">Entreprise : <b><?=$row['enIdEntreprise'];?></b></div>
    <br />
    <div class="champ"><b>Commentaire :</b> <?=$row['iloInfo'];?></div>
    </a>
    
<hr />
    
<?php endforeach ?>

