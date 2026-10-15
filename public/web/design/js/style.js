/*
$(document).ready(function () {
            $('.datetimepicker').daterangepicker(null, function (end, start, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });

$(document).ready(function () {
    $('.datetimepicker').datetimepicker({
        format: "d-m-Y",
        numberOfMonths: 2
    });
})



       
$(document).ready(function(){
  alert("aaa");
  if($('#agent_agentbundle_agent_Fonction').val() == 10){
    $('#dc').attr('required'):false;
  }
  else{
    $('#dc').attr('required'):true;
  }
});
 */
$(document).ready(function(){

  $('.marche').each(
      function(index){
        //console.log("b");
        //console.log(index + " : "+$(this).find("select").val());
        var test = $(this).find(".form-control").val();

        if (test){
          $(this).show();
        }

      }
    );
})

$(document).ready(function () {



        $(".btnShow").click(function () {
           // alert($(this).val());
            var fileName = $(this).val();
            $("#dialog").dialog({
                modal: true,

                title: "VISUALISER",
                width: 1000,
                height: 1300,

                open: function () {
                    var object = "<object data=\"{FileName}\" type=\"application/pdf\" width=\"100%\" height=\"100%\">";

                    object += "</object>";
                    object = object.replace(/{FileName}/g, fileName);
                    $("#dialog").html(object);
                }
            });
        });
    })

$(document).ready(function () {
    $('.datetimepicker').datepicker({
              format: 'dd-mm-yyyy',
              changeMonth: true,
              changeYear: true,
              yearRange: "-100:+0"
    });
})

/************************************/
$(document).ready(function(){
    $(".date1").datepicker({
        onSelect: function(selected) {
          $(".date2").datepicker("option","minDate", selected)
        }
    });
    $(".date2").datepicker({
        onSelect: function(selected) {
           $(".date1").datepicker("option","maxDate", selected)
        }
    });
});
/************************************/



function Chargement()
{
    var validation=document.getElementById('verif');
    validation.style.visibility=hidden;
}
function active()
{
	var select1 =document.getElementById("agent_agentbundle_agent_Sexe");
        var sexe = select1.options[select1.selectedIndex].value;

        var select2 = document.getElementById("agent_agentbundle_agent_situationMatri");
        var situ = select2.options[select2.selectedIndex].value;


        var select3 = document.getElementById("agent_agentbundle_agent_nomJeuneFille");
        var select4 = document.getElementById("agent_agentbundle_agent_prenoms");



        var positionM= document.getElementById("agent_agentbundle_agent_situationMili")

        if ((sexe==2 && situ==2) || (sexe==2 && situ==3) )
        {

           

            select3.disabled=false;
                select4.disabled=true;
                select4.value="";
        }
            else{
                 select4.disabled=false;
            select3.disabled=true;
        }
        if (sexe==2)
        {
            positionM.disabled=true;
        }
            else{
                positionM.disabled=false;
        }
}
function activeAffecter()
{
    var select1 =document.getElementById("agent_agentbundle_affecter_agent_Sexe");
    var sexe = select1.options[select1.selectedIndex].value;

    var select2 = document.getElementById("agent_agentbundle_affecter_agent_situationMatri");
    var situ = select2.options[select2.selectedIndex].value;


    var select3 = document.getElementById("agent_agentbundle_affecter_agent_nomJeuneFille");

    var positionM= document.getElementById("agent_agentbundle_affecter_agent_situationMili")
    var prenoms = document.getElementById("agent_agentbundle_affecter_agent_prenoms");
    if ((sexe==2 && situ==2) || (sexe==2 && situ==3) )
    {

        select3.disabled=false;
        prenoms.disabled=true;
    }
    else{

        select3.disabled=true;
        prenoms.disabled=false;

    }
    if (sexe==2)
    {
        positionM.disabled=true;
    }
    else{
        positionM.disabled=false;
    }
}
function activeBis()
{
	    var select1 =document.getElementById("agent_agentbundle_affecter_SexeAffectation");
        var sexe = select1.options[select1.selectedIndex].value;

        var select2 = document.getElementById("agent_agentbundle_affecter_SituationAffectation");
        var situ = select2.options[select2.selectedIndex].value;


        var select3 = document.getElementById("agent_agentbundle_affecter_nomJeuneFille");
        var prenoms = document.getElementById("agent_agentbundle_affecter_agent_prenoms");

        if ((sexe==2 && situ==2) || (sexe==2 && situ==3) )
        {

            select3.disabled=false;
            prenoms.disabled=false;
        }
            else{
                select3.innerHTML="";
                select3.disabled=true;
                prenoms.disabled=false;

        }

}


function VerifPassword()
{
    //suppession du boutton Js
    divBoutton=document.getElementById('boutton');
    Boutton=document.getElementById('btn-js');
    AncienBoutton=divBoutton.removeChild(Boutton);


    var texte=document.getElementById('verif');
    texte.style.visibility='visible';

}

$(function() {
    $('a[data-confirm]').click(function(ev) {
        var href = $(this).attr('href');

        if (!$('#dataConfirmModal').length) {
                $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel"><strong>Merci</strong> de <span style="color:green">confirmer</span></h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button><a class="btn btn-success" id="dataConfirmOK">Oui</a></div></div></div></div>');
        }
        $('#dataConfirmModal').find('.modal-body').html($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', href);
        $('#dataConfirmModal').modal({show:true});

        return false;
		});
	});
     /*
jQuery(document).ready(function()
{
    $('#agent_agentbundle_document_Matricule').attr('disabled', 'false');
    });
    */

    $(function() {
        $('form[data-confirm]').click(function(ev) {
            var action = $(this).attr('action');

            if (!$('#dataConfirmModal').length) {
                    $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel"><strong>Merci</strong> de <span style="color:green">confirmer</span></h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button><a class="btn btn-success" id="dataConfirmOK">Oui</a></div></div></div></div>');
            }
            $('#dataConfirmModal').find('.modal-body').html($(this).attr('data-confirm'));
            $('#dataConfirmOK').attr('action', action);
            $('#dataConfirmModal').modal({show:true});

            return false;
    		});
    	});
var $loaderr = '<div class="loader" align="center"><i class="fa fa-spinner fa-spin" style="font-size:72px"></i></div>';
function showloader(div) {
    $(div).append($loaderr);
    //$(".loader").fadeTo(10000, 1.6);
    //alert("testons");
}

function hideloader() {
    $(".loader").fadeOut(10, function () {
        $(".loader").remove();
    });
    //alert("testons");
}
function searchList($sourceval, $route, $destval, $div)
{
    $source = $($sourceval).val();
    //alert($source);
    if ($source.length > 0 ){

        $source=$source;
        showloader('#cacher');
    }else{
            $source=0;
        }

    $paramroute = {'id': $source};
    //alert(Routing.generate($route, $paramroute));
    //alert($div); exit;
    //console.log($div);

    $.ajax({
       type: 'GET',
       url: Routing.generate($route, $paramroute),
       dataType: 'json',
       success: function(data) {
        //console.log(data);
          // alert(jQuery.isEmptyObject(data));


           if (jQuery.isEmptyObject(data) == false){
               // alert("ok");
               $($destval).children('option:not(:first)').remove();
               //$($destval).append('<option>---- Choisir un Service-----</option>');
               $.each(data, function(key, value) {
                   // alert(key+ ""+value);
                    //console.log(value);
                 $($destval).append('<option value= "' + key + '">' + value[0] + '</option>');

                // $($destval).html("ggggg");
               if (value[1] == 0){

                   $('#label_sd').html("Section");
                   $($destval).children('option:first').empty();
                   $($destval).children('option:first').append('<option style="text-align:center;">---- Choisir une section-----</option>');
               }else if (value[1] == 1) {
                   $('#label_sd').html("Sous-Directions");
                   $($destval).children('option:first').empty();
                   $($destval).children('option:first').append('<option style="text-align:center;">---- Choisir une Sous-Direction -----</option>');
               }
               });
               if ($sourceval == "#dg"){
                   $('#viewdc').hide();
                   $('#viewsd').hide();
                   $('#viewsc').hide();
               }
               if ($sourceval == "#dc"){
                   $('#viewsd').hide();
                   $('#viewsc').hide();
               }
               if ($sourceval == "#sd"){
                   $('#viewsc').hide();
               }
                hideloader();
                $($div).show();
           }
           else{
               //console.log($sourceval);
              //  alert("no");
               if ($sourceval == "#dg"){
                   $('#viewdc').hide();
                   $('#viewsd').hide();
                   $('#viewsc').hide();
               }
               if ($sourceval == "#dc"){
                   $('#viewsd').hide();
                   $('#viewsc').hide();
               }
               if ($sourceval == "#sd"){
                   $('#viewsc').hide();
               }
               hideloader();
               //$($sourceval).show();
               console.log($sourceval);
           }
       }
   });

}

    
var $collectionHolder;

// setup an "add a tag" link
var $addTagButton = $('<button class="btn btn-info add_tag_link" type="button"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <small><em>Ajouter Email</small></em></button></div>');
var $newLinkLi = $('<div></div>').append($addTagButton);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.tags');
    $collectionHolder.css("list-style-type","none");
    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);
    
    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
});

/////////////////////
function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    
    addTagFormDeleteLink($newFormLi);
}   

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button class="btn btn-danger" type="button"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> <small><em></small></em></button></div>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

