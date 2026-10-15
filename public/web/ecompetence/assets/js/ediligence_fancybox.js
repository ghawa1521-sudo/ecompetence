var oldTab= [];
oldTab['conseiller'] = [];
oldTab['assistant'] =[] ;
oldTab['chargeetudes'] =[] ;
//Fonction,  de récup de valeur checkbox coché
function RecupIndivCheck()
{
    var tab = new Array();
    var cte = 0;
    //var tabl_id = new Array();
    for (var i = 0; i < document.frm_imputer.Dest.length; i++)
    {
        if (document.frm_imputer.Dest[i].checked)
        {
            tab[cte] = document.frm_imputer.Dest[i].value + '-' + document.frm_imputer.Dest[i].id;
            //tabl_id[cte]=document.frm_imputer.Dest[i].id;
            cte++;
        } else
        {

        }

    }
    //return tab+'-'+tabl_id;
    return tab;
}


//Responsable des chooix dynamiques
function popupchk(chk)
{
    j = RecupIndivCheck();
    if (j.length == 1) {
        var k1 = j[0];
        var k2 = k1.split("-");
        var k = k2[0];
        var p = k2[1].substr(0, (k2[1].length - 1));
        ajoutnoeudchk(chk, k, p);
        // exit();
    } else if (j.length > 1)
    {
        var vtemp = 'l' + chk;
        //alert(vtemp);
        var vtxt = document.getElementById(vtemp).innerHTML;
        var vtitlediv = document.getElementById('titlediv');
        vtitlediv.innerHTML = "<a id=alg1 href=#lg1 title=" + vtxt.replace(" ", "&nbsp;") + "></a>";
        generechk(chk);
        //var chkall=document.getElementById(chk);
        //alert(chkall.childNodes.length);

        if ($("#" + chk).is(':checked')) {
            $("a#alg1").fancybox({"hideOnContentClick": false}).trigger("click");
        } else
        {
            //Div dans le quel Inséré
            var divIn = document.getElementById("d" + chk);
            divIn.innerHTML = "";
        }

        // InstructPact();
    } else {
        document.getElementById(chk).checked = false;
        alert('Choisissez un destinataire SVP');
    }

}


//Pour generer les checkbox
function generechk(chk)
{
    //Option cocher tout
    //POur la CheckBox
    j = RecupIndivCheck();
    //determiner le nbre d'occurrence de valeur

    var chkbox = document.getElementById("lg1");
    var vchk = "'" + chk + "'";
    chks = "";
    for (i = 0; i <= j.length + 1; i++)
    {
        var k1 = j[i];
        if (k1 != null)
        {
            var k2 = k1.split("-");
            var k = k2[0];
            var p = k2[1].substr(0, (k2[1].length - 1));
            
            if (k != null)
            {
                chks += "<input id=" + chk + k + p + " onClick=ajoutnoeudchk(" + vchk + ",'" + k + "','" + p + "'); type=checkbox ><label for=" + chk + k + p + ">&nbsp;" + libDest(k, p) + "</label><br/>";
            }
        }

    }
    chkbox.innerHTML = chks;
    var titlechkbox = document.getElementById("alg1");
    titlechkbox.innerHTML = "";
}

//Ajout du noeud pour finaliser le choix
function ajoutnoeudchk(chk, val, val_id)
{
    j = RecupIndivCheck();
    if (j.length == 1 && (document.getElementById(chk).checked) == true)
    {
        var $input = $('<input type="checkbox"/>');
        $input.attr('name', 'd' + chk + '[]').attr('value', val).attr('checked', true).attr('id', 'bchk' + val + chk).css('display', 'none');
        $('#d' + chk).append($input).append($('<button id=btn' + val + chk + '>' + libDest(val, val_id) + '</button>'));
    } else if (j.length > 1 && (document.getElementById(chk + val + val_id).checked) == true)
    {

        var $input = $('<input type="checkbox"/>');
        $input.attr('name', 'd' + chk + '[]').attr('value', val).attr('checked', true).attr('id', 'bchk' + val + chk).css('display', 'none');
        $('#d' + chk).append($input).append($('<button id=btn' + val + chk + '>' + libDest(val, val_id) + '</button>'));

    } else
    {
        var divIn = document.getElementById("d" + chk);
        //Pour le bouton affichage dynamique
        var btn = document.getElementById("btn" + val + chk);
        //Pour la Checkbox
        var chk = document.getElementById("bchk" + val + chk);
        divIn.removeChild(btn);
        divIn.removeChild(chk);
    }
}

//POur les instrucions particulière
/* function InstructPact()
 {
 if (document.getElementById(In15).checked)
 {
 document.getElementById(InP).disabled = true;
 }
 else
 {
 document.getElementById(InP).disabled = true;
 }
 }*/

function checkboxhide(boxvisible, boxhide)
{

    var chkboxhide = document.getElementById(boxhide);
    var chkboxvisible = document.getElementById(boxvisible);
    //alert(chkboxvisible.value);
    //exit();
    if (chkboxvisible.checked == true)
    {
        chkboxhide.checked = true;
    } else
    {
        chkboxhide.checked = false;
    }

    var x = document.getElementsByName('In[]');
    for (var i = 0; i < x.length; i++)
    {
        if (x[i].checked == true)
        {
            var divIn = document.getElementById('dIn' + x[i].value);
            //Pour le bouton affichage dynamique
            var btn = document.getElementById('btn' + chkboxvisible.value + 'In' + x[i].value);
            //Pour la Checkbox
            var chk = document.getElementById('bchk' + chkboxvisible.value + 'In' + x[i].value);
            if (btn != null)
            {
                divIn.removeChild(btn);
            }
            if (chk != null)
            {
                divIn.removeChild(chk);
            }

        }

        var w = document.getElementsByName('dIn' + x[i].value + '[]');
        //alert(w+w.length);
        if (w != null && w.length == 0) {
            document.getElementById('In' + x[i].value).checked = false;
        }

    }

}

function arr_diff(a1, a2) {

    var a = [], diff = [];
    if (Array.isArray(a2) == false) {
        diff = a1;
    } else {
        for (var i = 0; i < a1.length; i++) {
            a[a1[i]] = true;
        }

        for (var i = 0; i < a2.length; i++) {
            if (a[a2[i]]) {
                delete a[a2[i]];
            } else {
                a[a2[i]] = true;
            }
        }

        for (var k in a) {
            diff.push(k);
        }
    }
    return diff;
}




function selectboxhide(matricule,idval=null)
{
    var selectbox = $('#'+idval).val();

    var selectDelete = arr_diff(oldTab[idval] , selectbox);
    //console.log(selectDelete);
    selectDelete.forEach(function (element) {
        if (element) {
            var choix1 = 'Z' + element;
            var choix2 = 'Z' + element + 'h';
            var chkboxhide = document.getElementById(choix1);
            var chkboxvisible = document.getElementById(choix2);

            if (chkboxvisible) {

                if (chkboxvisible.checked == true && chkboxhide.checked == true)
                {
                    chkboxhide.checked = false;
                    chkboxvisible.checked = false;
                }


                var x = document.getElementsByName('In[]');

                for (var i = 0; i < x.length; i++)
                {
                    if (x[i].checked == true)
                    {
                        var divIn = document.getElementById('dIn' + x[i].value);
                        //Pour le bouton affichage dynamique
                        var btn = document.getElementById('btn' + chkboxvisible.value + 'In' + x[i].value);
                        //Pour la Checkbox
                        var chk = document.getElementById('bchk' + chkboxvisible.value + 'In' + x[i].value);
                        //console.log(chkboxvisible);
                        if (btn != null)
                        {
                            divIn.removeChild(btn);
                        }
                        if (chk != null)
                        {
                            divIn.removeChild(chk);
                        }

                    }

                    var w = document.getElementsByName('dIn' + x[i].value + '[]');
                    //alert(w+w.length);
                    if (w != null && w.length == 0) {
                        document.getElementById('In' + x[i].value).checked = false;
                    }

                }

            }
        }
    });

    if (selectbox) {
        selectbox.forEach(function (element) {
            if (element) {
                var choix1 = 'Z' + element;
                var choix2 = 'Z' + element + 'h';
               // console.log(element);
               // console.log(choix1);
               // console.log(choix2);
                //console.log($('.selectpicker').val());
                var chkboxhide = document.getElementById(choix1);
                var chkboxvisible = document.getElementById(choix2);

                if (chkboxvisible) {

                    if (chkboxvisible.checked == false && chkboxhide.checked == false)
                    {
                       // console.log(chkboxvisible);
                        chkboxhide.checked = true;
                        chkboxvisible.checked = true;
                    }
                }
            }
        });
    }


    oldTab[idval] = selectbox;
//alert(chkboxvisible.value);
//exit();



}

function prioritedefine()
{
    var x = document.getElementsByName('In[]');
    var cte = 0;
    for (var i = 0; i < x.length; i++)
    {
        //if (x[i].checked == true){

        var w = document.getElementsByName('dIn' + x[i].value + '[]');
        if (w != null && w.length == 0) {
            document.getElementById('In' + x[i].value).checked = false;
            cte = cte + 1;

        }
        if (cte == x.length) {
            alert('Veuillez remplir les champs correctement');
            return cte;
        }
        //  }

    }




    var chkbox = document.getElementById("lg1");
    var chks = "<div class=radio><label><input id=prioritedefine1 type=radio name=priorite checked value=ordinaire onclick=valide_pri(\"ordinaire\")>Ordinaire</label></div><div class=radio><label><input id=prioritedefine2 type=radio name=priorite value=urgent onclick=valide_pri(\"urgent\")>Urgent</label></div><div class=radio><label><input id=prioritedefine3 type=radio name=priorite value=confidentiel onclick=valide_pri(\"confidentiel\")>Confidentiel</label></div><div><label for=\'date_delais\'>Délais de Traitement</label><input type=\'text\' id=\'date_delais\' name=\'txt_delais\' required></div><br/><div id=\"selectdiv\"><label for=\'txt_coordon\'>Désigner Coordonateur</label><select type=\'text\' id=\'txt_coordon\' name=\'txt_coordon\'><option>Choisir le coordonateur</option></select></div><br/><button value=eff_imputation class=\"btn btn-primary pull-right form-control\" name=a_eff_imputation onclick=\"soumission()\"><span class=\"glyphicon glyphicon-ok-sign\"> SOUMETTRE L'IMPUTATION</span></button>";
    chkbox.innerHTML = chks;

    var titlechkbox = document.getElementById("alg1");
    titlechkbox.innerHTML = "";

    var vtxt = 'confirmation';
    var vtitlediv = document.getElementById('titlediv');
    vtitlediv.innerHTML = "<a id=alg1 href=#lg1 title=" + vtxt.replace(" ", "&nbsp;") + "></a>";




    $("a#alg1").fancybox({"hideOnContentClick": false}).trigger("click");
    genereSelect(0);
    //$("#date_delais").datepicker();
    $('#date_delais').datepicker({
        weekStart: 1,
        format: 'dd/mm/yyyy',
        language: 'fr'
    });
    valide_pri("ordinaire");

    // $(function() {  


    //alert("Je marche");
    //   });
}

function genereSelect(chk)
{

    //Option cocher tout
    //POur la CheckBox
    j = RecupIndivCheck();
    //alert(j[0]);exit();
    var chkbox = document.getElementById("selectdiv");
    //var vchk="'"+chk+"'";

    chks = "";
    for (i = 0; i <= j.length + 1; i++)
    {
        var k1 = j[i];
        if (k1 != null)
        {
            var k2 = k1.split("-");
            var k = k2[0];
            var p = k2[1].substr(0, (k2[1].length - 1));
            //if (parseInt(k)>=0)
            if (k != null)
            {
                chks += "<option id=" + k + " value=" + k + ">&nbsp;" + libDest(k, p) + "</option>";
            }
        }

        //k=j[i+1];
    }
    chkbox.innerHTML = "<label for=\'lstcoordon\'>Désigner Coordonateur</label>" + "<select name=\"lstcoordon\" id=\"lstcoordon\">" + "<option>Choisir  le coordonateur</option>" + chks + "</select>";

}

function valide_pri(prio)
{
    var $input = $('<input type="checkbox"/>');
    $input.attr('name', 'priorite').attr('value', prio).attr('checked', true);
    $('#val_check').append($input);

    if (prio == "urgent")
    {
        incr_day(2);
    } else
    {
        incr_day(3);
    }

}

function incr_day(nbre)
{


    Date.prototype.addDays = function (nbre)
    {
        var dateNew = new Date();
        dateNew.setTime(dateNew.getTime() + (nbre * (1000 * 60 * 60 * 24)));
        return dateNew;
    }

    var dateNew = new Date();
    vall = dateNew.addDays(nbre);
    /* var final = vall.getDate() + "/" +
     (vall.getMonth() + 1) + "/" + vall.getFullYear();*/
    var jour = vall.getDate();
    var mois = vall.getMonth() + 1;
    var annee = vall.getFullYear();
    //if((jour.toString).length<=1){jour = '0'+jour; }
    if (parseInt(jour) <= 9) {
        jour = '0' + jour;
    }
    //if((mois.toString).length<=1){mois = '0'+mois; }
    if (parseInt(mois) <= 9) {
        mois = '0' + mois;
    }
    var final = jour + "/" + mois + "/" + annee;
    $("#date_delais").val(final);
}

function soumission(mat)
{
    //Récupération des nouvelle valeurs crées
    var delais = $("#date_delais").val();
    var lstcoordon = $("#lstcoordon").val();


    var $inpu = $('<input type="checkbox"/>');
    $inpu.attr('name', 'txt_delais').attr('value', delais).attr('checked', true);
    $('#div_delais').append($inpu);


    var $lst = $('<input type="checkbox"/>');
    $lst.attr('name', 'lstcoordon').attr('value', lstcoordon).attr('checked', true);
    $('#div_select').append($lst);
    //alert(delais);
    $("form[name='frm_imputer']").submit();
}




