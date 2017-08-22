<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idcommensaje = $_POST['idcommensaje'];
$idcommensajedestinatario = $_POST['idcommensajedestinatario'];
$iddestinatario = $_POST['iddestinatario'];
$origenacceso = $_POST['origenacceso'];
$remitente =  $_POST['remitente'];

?>
<div class="widget-box">
    <div class="widget-header widget-header-flat">

        <h4 class="smaller lighter blue">
            <i class="icon-flag"></i>
            <span id="tituloPanel"></span>
        </h4>                
        
        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

        <div class="widget-toolbar no-border">
            <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " style="margin: 0 1em !important;" >
                <i class="icon-angle-left icon-on-right"></i>
                Regresar
            </button>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-main">
            
            <div> 
                <i class="icon-calendar blue"></i>  
                <span><strong>Fecha:</strong></span>
                <span id="fecha"></span>

            </div> 

            <div class="hr hr2 hr-double"></div>

            <div> 
                <h3 class="header smaller lighter green">
                    <i class="icon-bullhorn"></i>
                    Mensaje
                </h3>                
                <div id="mensaje"></div>
            </div> <br/>

            <div class="hr hr2 hr-double"></div>

            <h3 class="header smaller lighter orange">
                <i class="fa fa-paperclip bigger-130 cafe"></i>
                Archivos adjuntos proporcionados por el Remitente
            </h3>

            <ul class="wd95prc" id="tbl_FR_ComMen0"></ul>

            <div>Por: <strong><?php echo $remitente; ?></strong></div>

        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>


<div class="widget-box">
    <div class="widget-header widget-header-flat">
        <h4 id="tituloPanel">Respuesta</h4> 

        <div class="widget-toolbar">

            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>

        </div>

        <div class="widget-toolbar">

            <div class="ui-pg-div" id="btnRereshComMenResp0" data-action="reload" title="Recargar Respuestas">
                <span class="ui-icon icon-refresh green"></span>
            </div>

        </div>

        <div class="widget-toolbar" id="wt-AddFilesResp10">

            <div class="ui-pg-div" id="btnAddFilesResp0" title="Agregar Archivo en la Respuesta">
                <span class="ui-icon fa-paperclip cafe"></span>
            </div>

        </div>

        <div class="widget-toolbar">

            <div class="ui-pg-div" id="btnAddComMenResp10"  title="Agregar Respuesta">
                <span class="ui-icon icon-plus-sign purple"></span>
            </div>
        
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-main">
            
            <div id="respuestas">

            </div>

            <div class="hr hr2 hr-double"></div>

            <h3 class="header smaller lighter orange">
                <i class="fa fa-paperclip bigger-130 cafe"></i>
                Archivos adjuntos porporcionados por el Destinatario
            </h3>

            <ul class="wd95prc" id="tbl_FR_ComMen11"></ul>


        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

<div class="hr hr2 hr-double"></div>

<div class="space-12"></div>


<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {


	$("#preloaderPrincipal").show();

    $("#wt-AddFilesResp10").hide();

	var idcommensaje = <?php echo $idcommensaje ?>;
    var idcommensajedestinatario = <?php echo $idcommensajedestinatario ?>;
    var iddestinatario = <?php echo $iddestinatario ?>;
    var origenacceso = <?php echo $origenacceso ?>;
    var idcommensajedestinatariorespuesta = 0;

/*
    $("#frmTareaRespuesta").unbind("submit");
    $("#frmTareaRespuesta").on("submit",function(event){
        event.preventDefault();

        $("#preloaderPrincipal").show();

        var queryString = $(this).serialize();  
        
        var IdComMensaje = idcommensaje <= 0 ? 0 : 1;

        $.post(obj.getValue(0) + "data/", {o:40, t:IdComMensaje, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
                if (json[0].msg=="OK"){
                    alert("Datos guardados con éxito");
                    stream.emit("cliente", {mensaje: "PLATSOURCE-TAREA_EDIT-PROP-"+IdComMensaje});
                    $("#preloaderPrincipal").hide();
                    // if (is_fotos){
                        $("#contentProfile").hide(function(){
                            $("#contentProfile").html("");
                            $("#contentMain").show();
                        });
                    // }
                    
                }else{
                    $("#preloaderPrincipal").hide();
                    alert(json.msg);    
                }

        }, "json");

    });
*/

    // ============================================================================================================
    // 
    // TAREA NUEVA ( INICIO )
    // 
    // ============================================================================================================


    function getComMen02(IdComMensaje){
        
        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idcommensaje="+IdComMensaje;
        $.post(obj.getValue(0)+"data/", { o:42, t:31004, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                
                $("#tituloPanel").html ( json[0].titulo_mensaje );
                $("#mensaje").html ( json[0].mensaje.replace(/\n/g, "<br />") );

                $("#fecha").html ( json[0].cfecha );

                $("#preloaderPrincipal").hide();
                getComMenArch0(idcommensaje);

                if ( parseInt( localStorage.IdUser,0 ) == parseInt( iddestinatario,0 )  ){
                    setLectura10(idcommensajedestinatario);
                }

            }, "json"
        ); 
    }

    function setLectura10(IdComMensajeDestinatario){
        var nc = "user="+localStorage.nc+"&idcommensajedestinatario="+IdComMensajeDestinatario;
        $.post(obj.getValue(0) + "data/", {o:42, t:9, c:nc, p:2, from:0, cantidad:0, s:''},
        function(json) {
                if (json[0].msg!="OK"){
                    $("#preloaderPrincipal").hide();
                    alert(json[0].msg); 
                }
        }, "json");
    }
    
    function getComMenArch0(IdComMensaje){
        
        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idcommensaje="+IdComMensaje;
        $("#tbl_FR_ComMen0").html("<li>Sin Archivos</li>");
        $.post(obj.getValue(0)+"data/", { o:42, t:31005, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var rp;
                $("#tbl_FR_ComMen0").empty();
                $.each(json, function(i, item) {

                    rp = '  <li ><a href="'+obj.getValue(0)+item.directorio+item.archivo+'" target="_blank" data-rel="tooltip" data-placement="top" title="Ver Archivo">'+item.descripcion_archivo+'</a>  <small class="grey"><i>'+item.creado_el+'</i></small>  </li>';
                    $("#tbl_FR_ComMen0").append(rp);

                });

                getComMensajeDestinatario(idcommensajedestinatario);

                $("#preloaderPrincipal").hide();
                
            }, "json"
        ); 
    }

    function getComMensajeDestinatario(IdComMensajeDestinatario){
        
        $("#preloaderPrincipal").show();

        // Buscamos su Mensaje
        var encontrado = false;
        var nc = "u="+localStorage.nc+"&idcommensajedestinatario="+IdComMensajeDestinatario;
        $.post(obj.getValue(0)+"data/", { o:42, t:31006, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                if (json.length > 0){
                    encontrado = true;
                    // $("#respuesta").html ( json[0].respuesta );
                    // $("#idcommensajedestinatariorespuesta").val(json[0].idcommensajedestinatariorespuesta);

                    var rp, strx, imgPath;
                    $("#respuestas").empty();
                    $.each(json, function(i, item) {
 

                        strx  = item.foto_destinatario.split(".");
                        if (item.foto_destinatario!=""){
                            imgPath = obj.getValue(0) + "upload/"+strx[0]+"-36."+strx[1];
                        }else{
                            imgPath = obj.getValue(0) + "images/emoticons/user-36.jpg";
                        }


                        rp = '<div class="timeline-items">';
                        rp += '    <div class="timeline-item clearfix">';
                        rp += '    <div class="timeline-info">';
                        rp += '       <img alt="" src="'+imgPath+'" id="avatar-'+item.idcommensajedestinatariorespuesta+' " />';
                        rp += '       <span class="label label-info"> '+item.nivel_de_acceso+' </span>';
                        rp += '   </div>';

                        rp += '   <div class="widget-box transparent">';
                        rp += '       <div class="widget-header widget-header-small">';

                        rp += '                <h5 class="smaller">';
                        rp += '                    <a href="#" class="blue" id="userdestresp-'+item.idcommensajedestinatariorespuesta+' ">'+item.apellidos_destinatario+ ' ' + item.nombres_destinatario+ ' </a>';
                        rp += '                    <span class="grey">ha respondido</span>';
                        rp += '                </h5>';

                        rp += '                <span class="widget-toolbar ">';
                        rp += '                    <i class="icon-time bigger-110"></i>';
                        rp += '                    <span id="fecha_respuesta-'+item.idcommensajedestinatariorespuesta+'">'+item.fecha_respuesta+'</span>';
                        rp += '                </span>';

                        if ( parseInt( localStorage.IdUser,0 ) == parseInt( item.idparent,0 )  ){

                            rp += '                <span class="tools widget-toolbar ">';

                            rp += '                    <div class="ui-pg-div removeComMenDestResp1" id="removeComMenDestResp1-'+item.idcommensajedestinatariorespuesta+' ">';
                            rp += '                        <span class="ui-icon icon-trash red"></span>';
                            rp += '                    </div>';

                            rp += '                </span>';

                            rp += '                <span class="tools widget-toolbar ">';

                            rp += '                    <div class="ui-pg-div editComMenDestResp1" id="editComMenDestResp1-'+item.idcommensajedestinatariorespuesta+' ">';
                            rp += '                        <span class="ui-icon icon-pencil blue"></span>';
                            rp += '                    </div>';

                            rp += '                </span>';

                        }

                        rp += '            </div>';

                        rp += '            <div class="widget-body">';
                        rp += '                <div class="widget-main">';
                        rp += '                   <div id="respuestacommen-'+item.idcommensajedestinatariorespuesta+'">'+item.respuesta.replace(/\n/g, "<br />")+'<div>';
                        rp += '                   <div class="space-6"></div>';

                        rp += '                   <div class="widget-toolbox clearfix">';
                        rp += '                   </div>';

                        rp += '               </div>';
                        rp += '           </div>';
                        rp += '       </div>';
                        rp += '   </div>';
                        rp += '</div>  ';
                        rp += '<div class="clearfix"></div>';
                        rp += '<div class="space-6"></div>';

                        $("#respuestas").append(rp);  
                        //$("#respuesta-"+item.idcommensajedestinatariorespuesta).html(item.respuesta);                      


                    });

                    $(".editComMenDestResp1").on("click",function(event){
                        event.stopPropagation();
                        obj.setIsTimeLine(false);
                        var arr = event.currentTarget.id.split('-');
                        getPropComMenRem1(idcommensajedestinatario,arr[1]);

                    });

                    $(".removeComMenDestResp1").on("click",function(event){
                        event.preventDefault();
                        var resp =  confirm("Desea eliminar esta respuesta?");
                        //alert(resp);
                        //return false;
                        if (resp){
                            var arr = event.currentTarget.id.split('-');
                            $("#preloaderPrincipal").show();
                            $.post(obj.getValue(0) + "data/", {o:42, t:8, c:arr[1], p:2, from:0, cantidad:0, s:''},
                            function(json) {
                                    if (json[0].msg=="OK"){
                                        getComMensajeDestinatario(idcommensajedestinatario);
                                    }else{
                                        alert(json[0].msg); 
                                    }
                            }, "json");
                            $("#preloaderPrincipal").hide();
                        }
                    });

                    if ( parseInt( localStorage.IdUser,0 ) == parseInt( iddestinatario,0 )  ){
                        $("#wt-AddFilesResp10").show();   
                    }    


                    $("#wt-AddFilesResp10").on("click",function(event){
                        event.stopPropagation();
                        obj.setIsTimeLine(false);
                        addIFU_ComMenDest01(idcommensajedestinatario);
                    })

                    getComMenResp01(idcommensajedestinatario);

                     $("#preloaderPrincipal").hide();

                }
                
            }, "json"
        ); 


        // Buscamos su Foto
        if (!encontrado){
            
 
           $("#respuestas").html("Aún no hay respuestas"); 

        }

        $("#preloaderPrincipal").hide();



    }

    function getComMenResp01(IdComMensajeDestinatario){
        
        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idcommensajedestinatario="+IdComMensajeDestinatario;

        $("#tbl_FR_ComMen11").html("<li>Sin Archivos</li>");
        $.post(obj.getValue(0)+"data/", { o:42, t:31007, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var rp;
                $("#tbl_FR_ComMen11").empty();
                $.each(json, function(i, item) {
                    
                    if ( parseInt( localStorage.IdUser,0 ) == parseInt( item.creado_por,0 )  ){
                        rp = '  <li ><a href="'+obj.getValue(0)+item.directorio+item.archivo+'" title="Ver Archivo" target="_blank" >'+item.descripcion_archivo+'</a>  <a href="#" target="_blank" class="uploadImage ajusteliMenuMain" id="deleteFileFromRespuestaAlu-'+item.idcommensajearchivorespuesta+'-'+item.archivo+'"><i class="icon icon-trash red marginLeft1em icon-1x"></i></a>  <small class="grey"><i>'+item.creado_el+'</i></small> </li>';
                    }else{
                        rp = '  <li ><a href="'+obj.getValue(0)+item.directorio+item.archivo+'" title="Ver Archivo" target="_blank" >'+item.descripcion_archivo+'</a>  <small class="grey"><i>'+item.creado_el+'</i></small> </li>';
                    }
                    $("#tbl_FR_ComMen11").append(rp);

                });

                

                $(".uploadImage").on("click",function(event){
                    event.preventDefault();
                    $("#preloaderPrincipal").show();
                    var resp =  confirm("Desea eliminar este Archivo?");
                    if (resp){
                        var arr = event.currentTarget.id.split('-');
                        DelFEComMenDestArch01(arr[1],arr[2]); 
                         $("#preloaderPrincipal").hide();
                    }
                });


                $("#preloaderPrincipal").hide();
                
            }, "json"
        ); 
    }


    // ============================================================================================================
    // 
    // EVENTS
    // 
    // ============================================================================================================
 


    $("#btnRereshComMenResp0").on("click",function(event){
        event.stopPropagation();
        obj.setIsTimeLine(false);
        getComMensajeDestinatario(idcommensajedestinatario);

    })

    $("#btnAddComMenResp10").on("click",function(event){
        event.stopPropagation();
        obj.setIsTimeLine(false);
        getPropComMenRem1(idcommensajedestinatario,0);

    })

    function getPropComMenRem1(IdComMensajeDestinatario, IdComMensajeDestinatarioRespuesta){
        $("#contentLevel4").empty();
        $("#contentLevel3").hide(function(){
            $("#preloaderPrincipal").show();
            obj.setIsTimeLine(false);
            var nc = localStorage.nc;
            $.post(obj.getValue(0) + "comunica-mensaje-resp-prop/", {
                user: nc,
                idcommensajedestinatario: IdComMensajeDestinatario,
                idcommensajedestinatariorespuesta: IdComMensajeDestinatarioRespuesta
                },
                function(html) {               
                    //$("#contentLevel4").show();     
                    $("#contentLevel4").html(html).show('slow',function(){
                        
                    });
                }, "html");
        });
        return false;
    }

    function addIFU_ComMenDest01(IdComMensajeDestinatario){

        $("#contentLevel4").empty();
        $("#contentLevel3").hide(function(){
        var nc = localStorage.nc; 
        $.post(obj.getValue(0) + "comunica-mensaje-resp-archivos-prop/", {
                    user: nc,
                    idcommensajedestinatario: IdComMensajeDestinatario
            },
            function(html) {
                    //$("#contentLevel4").show();     
                    $("#contentLevel4").html(html).show('slow',function(){
                        
                    });
            }, "html");
        });

    }

    function DelFEComMenDestArch01(IdComMensajeArchivoRespuesta, Archivo){



                $("#preloaderPrincipal").show();

                var queryString = "idcommensajearchivorespuesta="+IdComMensajeArchivoRespuesta+"&archivo="+Archivo;

                var data = new FormData();

                data.append('data', queryString);


                $.ajax({
                    url:obj.getValue(0)+"ucmdfe-resp/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    type: 'POST',
                    success: function(json){
                        if (json.status=="OK"){
                            //alert( json.message );
                            getComMenResp01(idcommensajedestinatario);
                             $("#preloaderPrincipal").hide();
                        }else{
                            $("#preloaderPrincipal").hide();
                            alert("Error: "+json.message);    
                        }
                    }
                });


    }

	// close Form
	$(".closeFormUpload").on("click",function(event){
		event.preventDefault();
        $("#preloaderPrincipal").hide();
        switch ( parseInt(origenacceso) ){
            case 0:
        		$("#contentProfile").hide(function(){
        			$("#contentProfile").empty();
        			$("#contentMain").show();
        		});
                break;

            case 1:
                $("#contentLevel3").hide(function(){
                    $("#contentLevel3").empty();
                    $("#contentProfile").show();
                });        
                break;

        }
		resizeScreen();
		return false;
	});

    $("#tituloPanel").html("Editando la Mensaje: "+idcommensaje);

    getComMen02(idcommensaje);

/*
    var stream = io.connect(obj.getValue(4));
    stream.on("servidor", jsNewSolMatEnc0);
    function jsNewSolMatEnc0(datosServer) {
        var ms = datosServer.mensaje.split("-");

        if (ms[1]=='RESPUESTA_COM_MEN') {
             getComMensajeDestinatario(idcommensajedestinatario);
        }       

        if (ms[1]=='UPLOAD_FILES_COM_MENSAJE_RESP') {
             getComMenResp01(idcommensajedestinatario);
        }       

    }

    var stream = io.connect(obj.getValue(4));
*/


    getComMenResp01(idcommensajedestinatario);

});

</script>