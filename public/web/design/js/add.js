//Attribution du chemin d'accès du fichier de bip
var beep_link = "/gpp/web/assets/images/beep";



toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-bottom-left",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
/////////////////////////////////////////////////
function showload() {
    var $loader = '<i class="fa fa-spinner fa-spin" style="color:#3c763d;"></i>';
    hideload(); // on vide le champs
    $('.loader').append($loader);
}

var $suivielt = $('.suivielt');
$(document).ready(function () {
    $.extend({
        playSound: function () {
            return $("<embed src='" + arguments[0] + ".ogg' hidden='true' autostart='true' loop='false' class='playSound'>" + "<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='" + arguments[0] + ".ogg' /></audio>").appendTo('body');
        }
    });

////////////////////////////////DEBUT MODULE AJAX
    var sfFunction = {
        single: function (Url, callback) {

// erreur gestion 
            var myFailure = function (error) {
                console.log("Erreur lors d'envoi" + error);
            };
            // succes gestion 
            var mySuccess = function (json) {
                callback(json);
            };
            sfFunction.singleValue(Url, mySuccess, myFailure);
        },
        singleValue: function (UrlFormRoute, onSuccess, onFailure) {
            $.ajax({
                type: 'GET',
                url: UrlFormRoute,
                dataType: 'json',
                success: onSuccess,
                error: onFailure
            });
        }
    };

////////////////////////////////FIN MODULE AJAX
    var cnotif = $(".notif");
    var lnk = "";
    //var UrlNotif = Routing.generate('default_notififajax');
    //tnotif = setInterval(notification, 60000);
    function notification() {
        sfFunction.single(UrlNotif, fnotif);
    }

    function fnotif(data) {
        console.log(UrlNotif);
        cnotif.html(data.cnotif);
        val = data.notifs;
        for (var i = 0; i <= val.length - 1; i++)
        {
            if (val[i]['Error'] > 0) {
                lnk = Routing.generate(val[i]['lnk'], {'id': val[i]['id']});
                toastr["success"]("<div><a href='" + lnk + "'>" + val[i]['msg'] + "<br/><i>Date: </i>" + val[i]['date'] + "<br/><i>BL:</i> " + val[i]['numBl'] + "</a></div>");
                $.playSound(beep_link);
            } else {
                console.log(val[i]['Errormsg']);
            }
            //Update

        }
    }
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            language: 'fr',
            defaultDate: 'now'
        }
        );
        $(".datepicker").datepicker("setDate", new Date());
        $(".separateurMillier").inputmask('999 999 999 999', {numericInput: true,
            rightAlign: false, placeholder: '', removeMaskOnSubmit: true, greedy: false});
    });

    notification();
});

