
<?php foreach($dataSelectOne['dataIlot'] as $data): ?>
    
    <h1> <?= $data['iloCodeIlot']; ?> - [<?= $data['iloLibelleIlot']; ?>] <span style="float: right; margin-right: 15px;">utilisé : <?= $data['used'];?></span></h1>
    <hr />
    <div class="bloc_front">
    <div class="bloc_front_titre">Compétence / type d' îlot <span>:</span></div><div class="bloc_front_aff"><?=  $data['coIdCompetence']; ?></div><br />
    <br />
    <div class="bloc_front_titre">Service utilisateur de l' îlot <span>:</span></div><div class="bloc_front_aff"><?= $data['sedIdServDem']; ?> - <?= $data['sedLibelleServDem'];	?></div><br />
    <div class="bloc_front_titre">Domaine d' activité <span>:</span></div><div class="bloc_front_aff"><?= $data['dacIdDomAct']; ?> - <?= $data['daLibelleDomAct']; ?></div><br />
    <div class="bloc_front_titre">Complément domaine d' activité <span>:</span></div><div class="bloc_front_aff">Activité Fibre</div><br />
    <div class="bloc_front_titre">Entreprise(s) intervenante(s) <span>:</span></div><div class="bloc_front_aff"><?= $data['enLibelleEntreprise']; ?></div><br />
    <br />
    <div class="bloc_front_titre">Ilot optimisé <span>:</span></div><div class="bloc_front_aff"><?= $data['iloOptim']; ?></div><br />
    <div class="bloc_front_titre">SAV / PROD <span>:</span></div><div class="bloc_front_aff"><?= $data['prsLibelleProdSav'];?></div><br />
    <div class="bloc_front_titre">Périmètre d' intervention <span>:</span></div><div class="bloc_front_aff champ" infoBulle="<?=$data['Liste_sites'];?>"><?= $data['siIdSite'];?></div><br />
    </div>
    <div class="bloc_side">
    <span class="a">Date de création :</span><?= $data['iloDateCreation']; ?><br />
    <span class="a">Modifié le :</span><?= $data['iloDateModif']; ?><br />
    <span class="a">Type d' îlot :</span> <?= $data['tiIdTypeIot']; ?> - <?= $data['tiLibelleTypeIlot']; ?><br />
    <span class="a">Bandeau :</span> <?= $data['banIdBandeau']; ?><br />
    </div>
    <br />
    <div class="bloc_front_coms">
    <div class="bloc_front_titre">Commentaire <span>:</span></div><div class="bloc_front_infos"><?= $data['iloInfo']; ?></div>
    <br /><br />
    <div class="bloc_front_titre">Commentaire Admin <span>:</span></div><div class="bloc_front_infos"><?= $data['iloInfoAdmin'];?></div>
    </div>

<?php endforeach ?>
