<script>
    
        {# Script de déconnexion automatique#}
        var logoutState = 1;
        //var per=(1000*60)*30;
        var url = 'http://gpersonnel.local/app_dev.php/logout';{# Url de déconnexion#}
        interval=setInterval(logout, 10);{# 30 minute de connexion #}
        $(this).keypress(function (e) {
            logoutState = 1;
        });
        $(this).mousemove(function (e) {
            logoutState = 1;
        });
        function logout() {
            switch (logoutState) {
                case 0:
                    window.location.href = url;
                    logoutState = 2;{#console.log('Bye Bye');#} //Bye bYe
                    break;
                case 1:
                    clearInterval(interval);
                    interval=setInterval(logout, per);
                    logoutState = 0;{#console.log('Working');#}
                    break;
                case 2:{#console.log('Working Working Shit'); #}
                    break;
            }
        }
    </script>