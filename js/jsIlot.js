$(document).ready(function () {


   // var php_ilot = 'ilotAjax'; // controleur


// 1 - Récupération des valeurs du formulaire (ilot) et requête AJAX
    var rechercheGlobal;
    var optim;
    var ilot;
    var typeIlot;
    var used;
    var competence;
    var serviceCible;
    var entreprise;
    var siteGeo;
    var domaineAct;

    var all_form;
    var ilot;

 /* 
  * initialisation des 2 variables dans la vue haut.php  
  *  var php_ilot 
    iloCodeBase ='K2'; // K2 pour test
    Complement_Titre = 'jsIlotComplement_Titre';
  */  
    function recup_form_ilot()
    {
        //alert('recup_form_ilot : ');
        rechercheGlobal = $('#rechercheIlotGlobal').val();
        optim = $('input:radio[name="optim"]:checked').val();
        // récupération de l'îlot
        if ($('#rechercheIlotTape').val() == '')
        {
            if ($('#ilotList').val() == '***') {
                ilot = ''
            }
            else {
                ilot = $('#ilotList').val().substr(0, 3);
            }
        }
        else {
            ilot = $('#rechercheIlotTape').val();
        }

        typeIlot = $('#typeIlot').val();
        used = $('#used').val();
        competence = $('#competence').val();
        serviceCible = $('#serviceCible').val();
        entreprise = $('#entreprise').val();
        siteGeo = $('#siteGeo').val();
        domaineAct = $('#domaineAct').val();
        
        
        
    }

    function requete_formulaire(critere)
    {
        //alert('requete_formulaire : ('+critere+')');
//        data_get = '';
        
        data_get = 'url=' + base +'/ilotAjax/'; // param url pour prise en compte par le routeur sur index.php
        // passe la base,  le controleur ilotAjax
        
        if (critere === 'select_all') {
            //data_get = 'select_all' + iloCodeBase + '/' + Complement_Titre;
            data_get += 'select_all/iloCodeBase=' + iloCodeBase + '/Complement_Titre=' + Complement_Titre;
        }
        else if (critere === 'select_one') {
            
            data_get += 'select_one/iloCodeBase=' + iloCodeBase + '/Complement_Titre=' + Complement_Titre + '/ilot=' + ilot;
        }
        else if (critere === 'reinit') {
            data_get += ''; // methode par defaut (dans routeur) : affIndex
        }        
        else {
            data_get += 'selectAny/rechercheGlobal=' + rechercheGlobal 
                    + '/optim=' + optim + '/ilot=' + ilot + '/typeIlot=' + typeIlot 
                    + '/used=' + used + '/competence=' + competence 
                    + '/serviceCible=' + serviceCible + '/entreprise=' + entreprise  
                    + '/siteGeo=' + siteGeo + '/domaineAct=' + domaineAct 
                    + '/iloCodeBase=' + iloCodeBase + '/Complement_Titre=' + Complement_Titre;
        }
        
        //alert('data_get '+data_get);


        // Si le formulaire est vide, on affiche rien
        if (typeof critere === 'undefined' && rechercheGlobal == '' && optim == 'tous' && ilot == '' && typeIlot == '***' && used == '***' && competence == '***' && serviceCible == '***' && entreprise == '***' && siteGeo == '***' && domaineAct == '***')
        {
            //alert('critere ' + critere + data_get);
            $('#results_ilot').empty();
        }

        else
        {
            	//alert(phpAjax);

            // on envoie la valeur recherché en GET au fichier de traitement
            $.ajax({
                type: 'GET', // envoi des données en GET ou POST
                url: phpAjax, // url du fichier de traitement : index.php
                // renseignée dans le haut de la page : vues/haut.php
                data: data_get,
                beforeSend: function () { // traitements JS à faire AVANT l'envoi
                    //alert('beforeSend php_ilot : ' + php_ilot);

                    $('#results_ilot').empty();
                    $('#ajaxLoader').show(); // ajout d'un loader pour signifier l'action
                },
                success: function (data) {
                    // traitements JS à faire APRES le retour du fichier .php
                    //alert('success: '+data);
                    $('#ajaxLoader').hide();
                    $('#results_ilot').fadeIn().html(data); // affichage des résultats dans le bloc #results
                }
            });
        }
    }

    $('#reinit_form').on('click', function () {
        $('#form_ilot')[0].reset();
        recup_form_ilot();
        requete_formulaire('reinit');
    });
    $('#all_form').on('click', function () {
        $('#form_ilot')[0].reset();
        requete_formulaire('select_all');
    });

    $('#rechercheIlotGlobal').on('keyup', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    
    $('input:radio[name="optim"]').change(function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#ilotList').on('change', function () {
        $('#rechercheIlotTape').val(''); // réinit de l'autre choix de l'îlot (ilot tapé)
        recup_form_ilot();
        requete_formulaire();
    });
    $('#rechercheIlotTape').on('keyup', function () {
        $('#ilotList').prop('selectedIndex', 0);// réinit de l'autre choix de l'îlot (ilot listé)
        recup_form_ilot();
        requete_formulaire();
    });
    $('#typeIlot').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#used').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#competence').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#serviceCible').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#entreprise').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#siteGeo').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#domaineAct').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });

    // Clic sur un ilot pour afficher le détail de ce dernier
    $('#results_ilot').on('click', '.lienIlotAjax', function () {
        $("#form_ilot").hide(); // On cache le formulaire
//				$("#blocIlot").empty(); // On vide le <h1> et le <hr /> qui contient Ilot GPC - MidiPy
        $("#results_ilot").empty(); // On vide le div qui reçoit les infos de l'îlot
        $('.infoBulle').remove(); // On efface les infobulles qui peuvent être affichées

        ilot = $(this).attr('ilot'); // On récupère l'îlot
        requete_formulaire('select_one');  // On fait l'affichage
    });
// Fin du 1

// Affichage de la recherche avancé
    $('.search_ilot_detail').hide(); // On cache la recherche avancé de base
    $('#search_ilot_detail').on('click', function () {
        $('.search_ilot_detail').fadeToggle();
        $('#arrow').toggleClass('arrowBottom arrowTop');
    });


// Affichage des infosBulles
    $(document).on({
        mouseenter: function (event) {
            var toolTip;
            toolTip = $(this).attr('infoBulle');

            if ((typeof toolTip != 'undefined') && (toolTip != ''))
            {
                //alert(toolTip);
                $('<span class="infoBulle"></span>').html(toolTip)
                        .appendTo(this)
                        .fadeIn('slow')
                        .css('display', 'inline-block')
                        .css('top', (event.pageY - 10) + 'px')
                        .css('left', (event.pageX + 20) + 'px');
            }
        },
        mouseleave: function () {
            $('.infoBulle').remove();
        }
    }, '.champ').mousemove(function (event) {
        $('.infoBulle').css('top', (event.pageY - 10) + 'px').css('left', (event.pageX + 20) + 'px');
    });
// Fin de l'affichage des infosBulles



// Fonction permettant la mise à jour d'un ilot unique



    $('#results_ilot').on('click', '#majBDD_tm_ilots', function () {
        if (confirm('Etes-vous sûr de voulour mettre à jour cet îlot ?')) {

            varMajUsed = $('#majUsed').val();
            varIloCodeIlot = $('#iloCodeIlot').val();
            varIloCodeBase = $('#iloCodeBase').val();
            varCoIdCompetence = $('#coIdCompetence').val();
            varSedIdServDem = $('#sedIdServDem').val();
            varDacIdDomAct = $('#dacIdDomAct').val();
            varDaDetailDomAct = $('#daDetailDomAct').val();
            varEnIdEntreprise = $('#enIdEntreprise').val();
            varPrsIdProdSav = $('#prsIdProdSav').val();
            varSiIdSite = $('#siIdSite').val();
            varIloInfo = $('#iloInfo').val();
            varIloInfoAdmin = $('#iloInfoAdmin').val();

            //alert(varMajUsed+' - '+varCoIdCompetence+' - '+varSedIdServDem+' - '+varDacIdDomAct+' - '+varDaDetailDomAct+' - '+varEnIdEntreprise+' - '+varPrsIdProdSav+' - '+varSiIdSite+' - '+varIloInfo+' - '+varIloInfoAdmin);


            data_get = 'majUsed=' + varMajUsed + '&iloCodeIlot=' + varIloCodeIlot + '&iloCodeBase=' + varIloCodeBase + '&coIdCompetence=' + varCoIdCompetence + '&sedIdServDem=' + varSedIdServDem + '&dacIdDomAct=' + varDacIdDomAct + '&daDetailDomAct=' + varDaDetailDomAct + '&enIdEntreprise=' + varEnIdEntreprise + '&prsIdProdSav=' + varPrsIdProdSav + '&siIdSite=' + varSiIdSite + '&iloInfo=' + varIloInfo + '&iloInfoAdmin=' + varIloInfoAdmin;

            $.ajax({
                type: 'GET', // envoi des données en GET ou POST
                url: '_php/maj_ilot.php', // url du fichier de traitement
                data: data_get,
                beforeSend: function () {
                    $('#results_ilot').empty();
                }, // traitements JS à faire AVANT l'envoi
                success: function (data) {
                    // traitements JS à faire APRES le retour du fichier .php

                    $('#results_ilot').fadeIn().html(data); // affichage des résultats dans le bloc #results
                }
            });



        }
    });

});



