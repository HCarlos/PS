// JavaScript Document


$(document).on("ready", init);

function init() {

    obj.setIsTimeLine(true);

    if (!sessionStorage.Id) {
        if ($("#username").length <= 0) {
            window.location.href = obj.getValue(0);
        }
    }

    $("#preloaderPrincipal").hide();
    var IDTUSer = parseInt(localStorage.IdUserNivelAcceso, 0);

    uParam0 = obj.getkeyUP(IDTUSer, 0);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-catalogos/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    uParam0 = obj.getkeyUP(IDTUSer, 0);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-config/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    uParam0 = obj.getkeyUP(IDTUSer, 0);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-caja/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    uParam0 = obj.getkeyUP(IDTUSer, 0);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-rel-pub/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    uParam0 = obj.getkeyUP(IDTUSer, 5);
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-tareas-alu/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
            
    }

    uParam0 = obj.getkeyUP(IDTUSer, 6);
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-gru-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-tareas-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

    }

    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    uParam0 = obj.getkeyUP(IDTCve, 30); // 3 = Comunica
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-comunica/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    uParam0 = obj.getkeyUP(IDTCve, 40); // PSA
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-psa/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-tutores/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-comunica/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");


    }

    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    uParam0 = obj.getkeyUP(IDTCve, 7); // 7 = Tutores
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-tutores/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    uParam0 = obj.getkeyUP(IDTCve, 28); // 7 = Tutores
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-familiares/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    uParam0 = obj.getkeyUP(IDTCve, 29); // 29 = Tutores
    if (uParam0 !== -1) {
        
        $.post(obj.getValue(0) + "menu-tutores/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-rel-pub/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    
    }

    uParam0 = obj.getkeyUP(IDTUSer, 888);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-clau/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    uParam0 = obj.getkeyUP(IDTUSer, 0);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-sol-mat/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    uParam0 = obj.getkeyUP(IDTUSer, 6);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-sol-mat/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }

    uParam0 = obj.getkeyUP(IDTUSer, 200);
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-administrativos/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-sol-mat/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");


    }

    uParam0 = obj.getkeyUP(IDTUSer, 201);
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-gru-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-tareas-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-tutores/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

    }

    uParam0 = obj.getkeyUP(IDTUSer, 202);
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-gru-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-tareas-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-sol-mat/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-comunica/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

    }

    uParam0 = obj.getkeyUP(IDTUSer, 222);
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-tareas-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-sol-mat/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-comunica/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

    }

    uParam0 = obj.getkeyUP(IDTUSer, 333);
    if (uParam0 !== -1) {

        $.post(obj.getValue(0) + "menu-gru-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-tareas-prof/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-sol-mat/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

        $.post(obj.getValue(0) + "menu-comunica/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");

    }


    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    for(i=8; i<=12;i++){
        if (obj.getkeyUP(IDTCve, i) !== -1) {
            $.post(obj.getValue(0) + "menu-servesco/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
            break;
        }
    }

    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    if (obj.getkeyUP(IDTCve, 60) !== -1) {
        
        $.post(obj.getValue(0) + "menu-caja/", {},
        function(html) {
            $("#menuPrincipal").append(html);
        }, "html");

        $.post(obj.getValue(0) + "menu-tutores/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");


    }

    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    for(i=0; i<=100;i++){
        if (obj.getkeyUP(IDTCve, i) !== -1) {
            
            $.post(obj.getValue(0) + "menu-sol-mat/", {},
            function(html) {
                if ( $("#subMenuSolicitudePedidos0").length <= 0  ){
                    $("#menuPrincipal").append(html);
                }
            }, "html");
        }
    }

    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);    
    if (obj.getkeyUP(IDTCve, 27) !== -1) {
        
        $.post(obj.getValue(0) + "menu-convenios/", {},
        function(html) {
            $("#menuPrincipal").append(html);
        }, "html");

        $.post(obj.getValue(0) + "menu-comunica/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");


    }

    uParam0 = obj.getkeyUP(IDTUSer, 1);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-sol-mat/", {},
        function(html) {
            if ( $("#subMenuSolicitudePedidos0").length <= 0  ){
                $("#menuPrincipal").append(html);
            }
        }, "html");
    }

    uParam0 = obj.getkeyUP(IDTUSer, 3);
    if (uParam0 !== -1) {
        $.post(obj.getValue(0) + "menu-directivos/", {},
            function(html) {
                $("#menuPrincipal").append(html);
            }, "html");
    }


    // uParam0 = obj.getkeyUP(IDTUSer, 2);
    // if (uParam0 !== -1) {
    //     $.post(obj.getValue(0) + "menu-clau/", {},
    //         function(html) {
    //             $("#menuPrincipal").append(html);
    //         }, "html");
    // }


    window.onload = function() {

        $("#preloaderSingle").hide();

        if (!sessionStorage.name) {
            if ($("#username").length <= 0) {
                window.location.href = obj.getValue(0);
            }
        }
        if ($("#menuOptsMain").length) {
            $.post(obj.getValue(0) + "session/", {},
                function(html) {
                    $("#menuOptsMain").prepend(html);
                    $.post(obj.getValue(0) + "data/", {
                            o: 1,
                            t: -3,
                            p: 11,
                            c: "u=" + localStorage.nc,
                            from: 0,
                            cantidad: 0,
                            s: ""
                        },
                        function(json) {
                            obj.setConfig($.map(json, function(el) {
                                return el;
                            }));
                            
                            
                        }, "json"
                    );
                }, "html");
        }

        $("#contentLevel5").empty();
        $("#contentLevel4").empty();
        $("#contentLevel3").empty();
        $("#contentProfile").empty();
        $("#contentMain").empty();

        $.post(obj.getValue(0) + "well/", {},
            function(html) {
                $("#contentMain").html(html);
        }, "html");


        var cantidad = 5;
        var cvsEl, ctx;
        if (!window.WebGLRenderingContext) {

            //window.location = "http://get.webgl.org";

        } else {

            var canvas = document.createElement('canvas'),
                context;

            if (!canvas.getContext) {
                $("#alertaNavegador").removeClass("hide");
                $("#signin-row").addClass("hide");
            } else {
                $("#signin-row").removeClass("hide");
                $("#alertaNavegador").addClass("hide");
            }
        }

        resizeScreen();


    }; // End Window.onload

}

function resizeScreen() {
    var hH;

    if ($("#menuOptsMain").length) {
        if (!obj.getFormResponse()) {
            $("#contentMain").html($("#InitDiv").html());
            hH = $( document ).height() - 130;
            obj.setMinHeight(hH);
            
            $("#contentMain").css("min-height", obj.getMinHeight());
            // $("#contentProfile").css("min-height", obj.getMinHeight());
            // $("#contentLevel3").css("min-height", obj.getMinHeight());
            // $("#contentLevel4").css("min-height", obj.getMinHeight());
            // $("#contentLevel5").css("min-height", obj.getMinHeight());
            obj.setFormResponse(true);

            //alert("Resize");
        } else {
            $("#contentMain").css("min-height", obj.getMinHeight());
        }
        //alert(obj.getMinHeight());
    }

    if ($("#signin-row").length) {
        if (!obj.getFormResponse()) {
            hH = $(this).height() - ($(".footer").height() * 10.0);
            $("#signin-row").css("min-height", hH);
            obj.setFormResponse(true);
        }
    }

}

function sendSticker(titulo, msg, srcimg, milisegundos) {
    var unique_id = $.gritter.add({
        title: titulo,
        text: msg,
        image: srcimg,
        sticky: true,
        time: '',
        class_name: 'gritter-info'
    });

    setTimeout(function(){

                    $.gritter.remove(unique_id, {
                        fade: true,
                        speed: 'slow'
                    });

                }, parseInt(milisegundos,0));

    

    return false;

}


function resizeScreenProfile() {
    var hH;

    $("#contentProfile").html($("#InitDiv").html());
    hH = $( document ).height() - 130;
    obj.setMinHeight(hH);
    $("#contentProfile").css("min-height", obj.getMinHeight());
    obj.setFormResponse(true);
}

