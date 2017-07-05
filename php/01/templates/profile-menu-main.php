
                <li class="grey">
                        <a data-toggle="dropdown" class="dropdown-toggle mnuGruAluTareasN" href="#" id="notifyMensajesNuevos-1">
                            <i class="icon-envelope icon-animated-vertical"></i>
                            <span class="badge badge-important"><span id="numMsgNvos"></span></span>
                        </a>
                </div> 

                <li class="orange">
                    <a data-toggle="dropdown" class="dropdown-toggle mnuGruAluTareasN" href="#" id="notifyTareasNuevas-0">
                        <i class="icon-bell-alt icon-animated-bell"></i>
                        <span class="badge badge-important"><span id="numTarNvas"></span></span>
                    </a>
                </li>


                <li class=" transparent" >
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle ajusteliMenuMain transparent" >
                        <img class="nav-user-photo" id="imgFoto" name="imgFoto" alt="" />
                        <span class="user-info transparent" id="nameuser"></span>
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-green dropdown-caret dropdown-closer ">
                        <li>
                            <a href="#" id="profileUserPWD">
                                <i class="icon-key"></i>
                                Cambiar Password
                            </a>
                        </li>

                        <li>
                            <a href="#" id="profileUserFoto">
                                <i class="icon-picture"></i>
                                Cambiar Foto
                            </a>
                        </li>

                        <li>
                            <a href="#" id="profileUser">
                                <i class="icon-user"></i>
                                Perfil
                            </a>
                        </li>

                        <li>
                            <a href="#" id="usersConnect">
                                <i class="icon-group"></i>
                                Usuarios Conectados
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="#" id="closeSession">
                                <i class="icon-off"></i>
                                Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
                
<script typy="text/javascript">     


    $(".mnuGruAluTareasN").hide();

        
    if ($("#closeSession").length) {
        $("#closeSession").unbind("click");
        $("#closeSession").on("click", function(event) {
            event.preventDefault();
            $.post(obj.getValue(0) + "data/", {o:49, t:1, p:52, c:"u=" +localStorage.nc, from: 0, cantidad: 0, s: ""},
            function(json) {
                // alert(json[0].msg);
                if (json[0].msg=="OK"){
                var stream = io.connect(obj.getValue(4));
                stream.emit("cliente", {mensaje: "PLATSOURCE-UCONNECTDELL-"+localStorage.IdUser+'-'+localStorage.nc});
                console.log("Desconectado...");
                delete sessionStorage.Id;
                delete localStorage.nc;
                delete localStorage.IdEmp;
                delete localStorage.IdUser;
                delete localStorage.Empresa;
                delete localStorage.IdUserNivelAcceso;
                delete localStorage.TRPP;
                delete localStorage.IdEmpresaHome
                // alert(json[0].msg);
                document.location.href = obj.getValue(0);

                }else{
                    alert(json[0].msg);
                }
            }, "json");

        });
    }

    if ($("#nameuser")){
        var nc = localStorage.nc

        $.post(obj.getValue(0) + "data/", {o:0, t:0, c:nc, p:10, from:0, cantidad:0, s:""},
                function(json) {
                            //alert(json.length);
                            
                            var strx = json[0].foto.split(".");
                            var imgPath;
                            if (json[0].foto!=""){
                                imgPath = obj.getValue(0) + "upload/"+strx[0]+"-36."+strx[1];
                            }else{
                                imgPath = obj.getValue(0) + "images/emoticons/user-36.jpg";
                            }

//                                            var imgPath = obj.getValue(0) + "upload/"+strx[0]+"-36."+strx[1];
                            $("#imgFoto").attr("src",imgPath);
                            $("#nameuser").text(json[0].nombres+" "+json[0].apellidos);
                            
                }, "json");

    }

    if ($("#profileUser").length) {
        $("#profileUser").unbind("click");
        $("#profileUser").on("click", function(event) {
            event.preventDefault();
            cfgBase0();
            $("#preloaderSingle").show();

            var nc = localStorage.nc;
            $.post(obj.getValue(0) + "profile/", {
                    user: nc
                },
                function(html) {
                    $("#preloaderPrincipal").hide();
                    $('#breadcrumb').html(getBar('Inicio,Profile'));
                    $("#contentMain").html("").fadeOut('slow',function(event){
                       $("#contentProfile").html(html).fadeIn('slow'); 
                    });
                    
                }, "html");
        });
    }


    if ($("#profileUserFoto").length) {
        $("#profileUserFoto").unbind("click");
        $("#profileUserFoto").on("click", function(event) {
            event.preventDefault();
            cfgBase0();
            $("#preloaderSingle").show();

            var nc = localStorage.nc.split("@");
            $.post(obj.getValue(0) + "profileFoto/", {
                    user: nc[0]
                },
                function(html) {
                    $("#preloaderPrincipal").hide();
                    $('#breadcrumb').html(getBar('Inicio,Avatar'));
                    $("#contentMain").html("").fadeOut('slow',function(event){
                       $("#contentProfile").html(html).fadeIn('slow'); 
                    });
                }, "html");
        });
    }

    if ($("#profileUserPWD").length) {
        $("#profileUserPWD").unbind("click");
        $("#profileUserPWD").on("click", function(event) {
            event.preventDefault();
            cfgBase0();
            $("#preloaderSingle").show();

            var nc = localStorage.nc.split("@");
            $.post(obj.getValue(0) + "profilePWD/", {
                    user: nc[0]
                },
                function(html) {
                    $("#preloaderPrincipal").hide();
                    $('#breadcrumb').html(getBar('Inicio,Cambiar Password'));
                    $("#contentMain").html("").fadeOut('slow',function(event){
                       $("#contentProfile").html(html).fadeIn('slow'); 
                    });
                }, "html");
        });
    }

    if ($("#usersConnect").length) {
        $("#usersConnect").unbind("click");
        $("#usersConnect").on("click", function(event) {
            event.preventDefault();
            cfgBase0();
            $("#preloaderSingle").show();

            var nc = localStorage.nc;
            $.post(obj.getValue(0) + "usersConnect/", {
                    user: nc
                },
                function(html) {
                    $("#preloaderPrincipal").hide();
                    $('#breadcrumb').html(getBar('Inicio,Profile'));
                    $("#contentMain").empty().fadeOut('slow',function(event){
                       $("#contentProfile").html(html).fadeIn('slow'); 
                    });
                    
                }, "html");
        });
    }

    var stream = io.connect(obj.getValue(4));
    stream.on("servidor", jsNewEstado);
    function jsNewEstado(datosServer) {
        var ms = datosServer.mensaje.split("|");
        if (ms[0]=='NT') {
            sendSticker(ms[1], ms[2], ms[3], ms[4]);
        }

        var ms = datosServer.mensaje.split("-");

        if ( ms[1] == 'DESTINATARIOS_TAREAS' ) {
            var alus =  ms[4].split('|');
            var ise = alus.indexOf(localStorage.IdUser);
            if (ise >= 0){
                if ( parseInt(localStorage.IdUser,0) == parseInt(alus[ise],0) ){
                    getTareasNuevas();
                }
            }
        }

        if ( ms[1] == 'DESTINATARIOS_COM_MENSAJE' ) {
            var alus =  ms[4].split('|');
            var ise = alus.indexOf(localStorage.IdUser);
            if (ise >= 0){
                if ( parseInt(localStorage.IdUser,0) == parseInt(alus[ise],0) ){
                    getMensajeNuevos();
                }
            }
        }

    }

    function getTareasNuevas(){

        $.post(obj.getValue(0) + "tareas-get-nuevas-01/", {u:localStorage.nc},
        function(json) {

                if (json.length > 0){
                    $("#notifyTareasNuevas-0").show();
                    $("#numTarNvas").html(json.length);   
                    
                    $(".mnuGruAluTareasN").on("click",function(event){

                       event.preventDefault();
                       var ar = event.currentTarget.id.split('-');
                       var dtn = ['contentMain','contentProfile'];
                       var arr = ['tareas-alu-list/','comunica-mensaje-inbox-list/'];
                       var msg = ['Tareas','Mensajes'];
                       var i = parseInt(ar[1],0);
                        cfgBase0();
                        $("#contentMain").empty();
                        $("#contentMain").hide();
                        var nc = localStorage.nc;
                        $.post(obj.getValue(0) + arr[i], {
                                user: nc,
                                objeto:dtn[i]
                            },
                            function(html) {
                                $("#"+dtn[i]).show();
                                $("#"+dtn[i]).html(html);
                                $('#breadcrumb').html(getBar('Inicio, '+msg[i] ));
                            }, "html");
                        return false;         

                    }) ;  
                                                 
                }                                          
        }, "json");

    }

    function getMensajeNuevos(){

        $.post(obj.getValue(0) + "comunica-get-mensajes-01/", {u:localStorage.nc},
        function(json) {

                if (json.length > 0){
                    $("#notifyMensajesNuevos-1").show();
                    $("#numMsgNvos").html(json.length);   
                    
                    $(".mnuGruAluTareasN").on("click",function(event){

                       event.preventDefault();
                       var ar = event.currentTarget.id.split('-');
                       var dtn = ['contentMain','contentProfile'];
                       var arr = ['tareas-alu-list/','comunica-mensaje-inbox-list/'];
                       var msg = ['Tareas','Mensajes'];
                       var i = parseInt(ar[1],0);
                        cfgBase0();
                        $("#contentMain").hide();
                        var nc = localStorage.nc;
                        $.post(obj.getValue(0) + arr[i], {
                                user: nc,
                                objeto:dtn[i]
                            },
                            function(html) {
                                $("#"+dtn[i]).show();
                                $("#"+dtn[i]).html(html);
                                $('#breadcrumb').html(getBar('Inicio, '+msg[i] ));
                            }, "html");
                        return false;         

                    }) ;  
                                                 
                }                                          
        }, "json");

    }

    function cfgBase0(){
        resizeScreen();
        $("#contentLevel5").empty();
        $("#contentLevel5").hide();
        $("#contentLevel4").empty();
        $("#contentLevel4").hide();
        $("#contentLevel3").empty();
        $("#contentLevel3").hide();
        $("#contentProfile").empty();
        $("#contentProfile").hide();
        $("#contentMain").show();
        $("#contentMain").empty();
        $("#preloaderPrincipal").show();
        obj.setIsTimeLine(false);
    }

    getTareasNuevas();

    getMensajeNuevos();


</script>