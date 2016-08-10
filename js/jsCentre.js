$(document).ready(function () {

// 1 - Récupération des valeurs du formulaire (Centre) et requête AJAX
    var rechercheCentreGlobal;
    var rechercheCentreTape;
    var centreList;
    var zoneETR;
    var idSiteGPC;
    var NRA;
    var repHab;
    var zoneBlanche;
    var blocageR2;

    var centre;
    var all_form;


    function recup_form_ilot()
    {
        rechercheCentreGlobal = $('#rechercheCentreGlobal').val();
        if ($('#rechercheCentreTape').val() == '')
        {
            if ($('#centreList').val() == '***') {
                centre = ''
            }
            else {
                centre = $('#centreList').val().substr(0, 3);
            }
        }
        else {
            centre = $('#rechercheCentreTape').val();
        }

        zoneETR = $('#zoneETR').val();
        idSiteGPC = $('#idSiteGPC').val();
        NRA = $('#NRA').val();
        repHab = $('#repHab').val();
        zoneBlanche = $('#zoneBlanche').val();
        blocageR2 = $('#blocageR2').val();

        /* Vérification de la réception des champs du formulaire
        alert(
            rechercheCentreGlobal +
            centre +
            zoneETR +
            idSiteGPC +
            NRA +
            repHab +
            zoneBlanche +
            blocageR2
        );*/
    }

    function requete_formulaire(critere)
    {
        //alert('requete_formulaire : ('+critere+')'); // undefined (selection des choix du formulaire) - select_all (bouton lister tout)  - réinit (bouton réinitialisation)

        data_get = 'url=' + base +'/centreAjax/'; // param url pour prise en compte par le routeur sur index.php
        // passe la base,  le controleur ilotAjax
        
        if (critere === 'select_all') {
            data_get += 'select_all';
        }
        else if (critere === 'select_one') {
            data_get += 'select_one/iloCodeBase=' + iloCodeBase + '/Complement_Titre=' + Complement_Titre + '/ilot=' + ilot;
        }
        else if (critere === 'reinit') {
            data_get += ''; // methode par defaut (dans routeur) : affIndex
        }        
        else {
            data_get += 'selectAny/rechercheCentreGlobal=' + rechercheCentreGlobal
                + '/centre=' + centre + '/zoneETR=' + zoneETR + '/idSiteGPC=' + idSiteGPC
                + '/NRA=' + NRA + '/repHab=' + repHab
                + '/zoneBlanche=' + zoneBlanche + '/blocageR2=' + blocageR2;
        }
        
        //alert('data_get '+data_get);

        // Si le formulaire est vide, on affiche rien
        if (typeof critere === 'undefined' && rechercheCentreGlobal == '' && centre == '' && zoneETR == '***' && idSiteGPC == '***' && NRA == '***' && repHab == '***' && zoneBlanche == '***' && blocageR2 == '***' )
        {
            //alert('critere ' + critere + data_get);
            $('#results_centre').empty();
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
                    
                    $('#results_centre').empty();
                    $('#results_centre').html('</br /><center><img src="img/_design/ajax-loader.gif" alt="loader" id="ajax-loader" /></center>'); // ajout d'un loader pour signifier l'action
                },
                success: function (data) {
                    // traitements JS à faire APRES le retour du fichier .php
                    //alert('success: '+data);
                    $('#results_centre').fadeIn().html(data); // affichage des résultats dans le bloc #results
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

    $('#rechercheCentreGlobal').on('keyup', function () {
        recup_form_ilot();
        requete_formulaire();
    });

    $('#centreList').on('change', function () {
        $('#rechercheCentreTape').val(''); // réinit de l'autre choix de l'îlot (ilot tapé)
        recup_form_ilot();
        requete_formulaire();
    });
    $('#rechercheCentreTape').on('keyup', function () {
        $('#centreList').prop('selectedIndex', 0);// réinit de l'autre choix de l'îlot (ilot listé)
        recup_form_ilot();
        requete_formulaire();
    });
    $('#zoneETR').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#idSiteGPC').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#NRA').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#repHab').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#zoneBlanche').on('change', function () {
        recup_form_ilot();
        requete_formulaire();
    });
    $('#blocageR2').on('change', function () {
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



