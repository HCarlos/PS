<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idtarea = $_POST['idtarea'];
$idtareadestinatario = $_POST['idtareadestinatario'];
$iddestinatario = $_POST['iddestinatario'];
$origenacceso = $_POST['origenacceso'];
$profesor =  $_POST['profesor'];

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
                <span><strong>Inicio:</strong></span>
                <span id="fecha_inicio"></span>
                <span class="add-on">:</span>
                <span id="hora0"></span>
                <span class="add-on">:</span>
                <span id="min0"></span>
                <span class="add-on">:</span>
                <span id="seg0"></span>

                <span class="marginLeft2em"></span>

                <i class="icon-calendar blue"></i>  
                 <span><strong>Entrega:</strong></span>
                <span id="fecha_fin"></span>
                <span class="add-on">:</span>
                <span id="hora01"></span>
                <span class="add-on">:</span>
                <span id="min1"></span>
                <span class="add-on">:</span>
                <span id="seg1"></span>

            </div> 

            <div class="hr hr2 hr-double"></div>

            <div> 
                <h3 class="header smaller lighter green">
                    <i class="icon-bullhorn"></i>
                    Tarea
                </h3>                
                <div id="tarea"></div>
            </div> <br/>

            <div class="hr hr2 hr-double"></div>

            <h3 class="header smaller lighter orange">
                <i class="fa fa-paperclip bigger-130 cafe"></i>
                Archivos adjuntos proporcionados por el(la) Profesor(a)
            </h3>

            <ul class="wd95prc" id="tbl_FileRespAlu0"></ul>

            <div>Por: <strong><?php echo $profesor; ?></strong></div>

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

            <div class="ui-pg-div" id="btnRereshTarResp0" data-action="reload" title="Recargar Respuestas">
                <span class="ui-icon icon-refresh green"></span>
            </div>

        </div>

        <div class="widget-toolbar" id="wt-AddFilesResp0">

            <div class="ui-pg-div" id="btnAddFilesResp0" title="Agregar Archivo en la Respuesta">
                <span class="ui-icon fa-paperclip cafe"></span>
            </div>

        </div>

        <div class="widget-toolbar">

            <div class="ui-pg-div" id="btnAddTarResp0"  title="Agregar Respuesta">
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
                Archivos adjuntos porporcionados por el(la) Alumno(a)
            </h3>

            <ul class="wd95prc" id="tbl_FileRespAlu1"></ul>


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

    $("#wt-AddFilesResp0").hide();

	var idtarea = <?php echo $idtarea ?>;
    var idtareadestinatario = <?php echo $idtareadestinatario ?>;
    var iddestinatario = <?php echo $iddestinatario ?>;
    var origenacceso = <?php echo $origenacceso ?>;
    var idtareadestinatariorespuesta = 0;


    $("#frmTareaRespuesta").unbind("submit");
    $("#frmTareaRespuesta").on("submit",function(event){
        event.preventDefault();

        $("#preloaderPrincipal").show();

        var queryString = $(this).serialize();  
        
        var IdTarea = idtarea <= 0 ? 0 : 1;

        $.post(obj.getValue(0) + "data/", {o:40, t:IdTarea, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
                if (json[0].msg=="OK"){
                    alert("Datos guardados con éxito");
                    stream.emit("cliente", {mensaje: "PLATSOURCE-TAREA_EDIT-PROP-"+IdTarea});
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


    // ============================================================================================================
    // 
    // TAREA NUEVA ( INICIO )
    // 
    // ============================================================================================================


    function getTarea(IdTarea){
        
        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idtarea="+IdTarea;
        $.post(obj.getValue(0)+"data/", { o:40, t:20001, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                
                $("#tituloPanel").html ( json[0].titulo_tarea );
                $("#tarea").html ( json[0].tarea.replace(/\n/g, "<br />") );

                $("#fecha_inicio").html ( json[0].fecha0 );
                $("#hora0").html ( json[0].hora0 );
                $("#min0").html ( json[0].min0 );
                $("#seg0").html ( json[0].seg0 );

                $("#fecha_fin").html ( json[0].fecha1 );
                $("#hora1").html ( json[0].hora1 );
                $("#min1").html ( json[0].min1 );
                $("#seg1").html ( json[0].seg1 );

                $("#preloaderPrincipal").hide();
                getTareaArchivos(idtarea);

                if ( parseInt( localStorage.IdUser,0 ) == parseInt( iddestinatario,0 )  ){
                    setLectura(idtareadestinatario);
                }

            }, "json"
        ); 
    }

    function setLectura(IdTareaDestinatario){
        var nc = "user="+localStorage.nc+"&idtareadestinatario="+IdTareaDestinatario;
        $.post(obj.getValue(0) + "data/", {o:40, t:9, c:nc, p:2, from:0, cantidad:0, s:''},
        function(json) {
                if (json[0].msg!="OK"){
                    $("#preloaderPrincipal").hide();
                    alert(json[0].msg); 
                }
        }, "json");
    }
    
    function getTareaArchivos(IdTarea){
        
        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idtarea="+IdTarea;
        $("#tbl_FileRespAlu0").html("<li>Sin Archivos</li>");
        $.post(obj.getValue(0)+"data/", { o:40, t:20002, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var rp;
                $("#tbl_FileRespAlu0").empty();
                $.each(json, function(i, item) {

                    rp = '  <li ><a href="'+obj.getValue(0)+item.directorio+item.archivo+'" target="_blank" data-rel="tooltip" data-placement="top" title="Ver Archivo">'+item.descripcion_archivo+'</a>  <small class="grey"><i>'+item.creado_el+'</i></small>  </li>';
                    $("#tbl_FileRespAlu0").append(rp);

                });

                getTareaDestinatario(idtareadestinatario);

                $("#preloaderPrincipal").hide();
                
            }, "json"
        ); 
    }

    function getTareaDestinatario(IdTareaDestinatario){
        
        $("#preloaderPrincipal").show();

        // Buscamos su Tarea
        var encontrado = false;
        var nc = "u="+localStorage.nc+"&idtareadestinatario="+IdTareaDestinatario;
        $.post(obj.getValue(0)+"data/", { o:40, t:20005, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                if (json.length > 0){
                    encontrado = true;
                    // $("#respuesta").html ( json[0].respuesta );
                    // $("#idtareadestinatariorespuesta").val(json[0].idtareadestinatariorespuesta);

                    var rp, strx, imgPath;
                    $("#respuestas").empty();
                    $.each(json, function(i, item) {
 

                        if (item.foto_destinatario!="" || item.foto_destinatario == null){
                            strx  = item.foto_destinatario.split(".");
                            imgPath = obj.getValue(0) + "upload/"+strx[0]+"-36."+strx[1];
                        }else{
                            imgPath = obj.getValue(0) + "images/emoticons/user-36.jpg";
                        }


                        rp = '<div class="timeline-items">';
                        rp += '    <div class="timeline-item clearfix">';
                        rp += '    <div class="timeline-info">';
                        rp += '       <img alt="" src="'+imgPath+'" id="avatar-'+item.idtareadestinatariorespuesta+' " />';
                        rp += '       <span class="label label-info"> '+item.nivel_de_acceso+' </span>';
                        rp += '   </div>';

                        rp += '   <div class="widget-box transparent">';
                        rp += '       <div class="widget-header widget-header-small">';

                        rp += '                <h5 class="smaller">';
                        rp += '                    <a href="#" class="blue" id="userresp-'+item.idtareadestinatariorespuesta+' ">'+item.apellidos_destinatario+ ' ' + item.nombres_destinatario+ ' </a>';
                        rp += '                    <span class="grey">ha respondido</span>';
                        rp += '                </h5>';

                        rp += '                <span class="widget-toolbar ">';
                        rp += '                    <i class="icon-time bigger-110"></i>';
                        rp += '                    <span id="fecha_respuesta-'+item.idtareadestinatariorespuesta+'">'+item.fecha_respuesta+'</span>';
                        rp += '                </span>';

                        if ( parseInt( localStorage.IdUser,0 ) == parseInt( item.idparent,0 )  ){

                            rp += '                <span class="tools widget-toolbar ">';

                            rp += '                    <div class="ui-pg-div removeTarDestResp0" id="removeTarDestResp0-'+item.idtareadestinatariorespuesta+' ">';
                            rp += '                        <span class="ui-icon icon-trash red"></span>';
                            rp += '                    </div>';

                            rp += '                </span>';

                            rp += '                <span class="tools widget-toolbar ">';

                            rp += '                    <div class="ui-pg-div editTarDestResp0" id="editTarDestResp0-'+item.idtareadestinatariorespuesta+' ">';
                            rp += '                        <span class="ui-icon icon-pencil blue"></span>';
                            rp += '                    </div>';

                            rp += '                </span>';

                        }

                        rp += '            </div>';

                        rp += '            <div class="widget-body">';
                        rp += '                <div class="widget-main">';
                        rp += '                   <div id="respuesta-'+item.idtareadestinatariorespuesta+'">'+item.respuesta.replace(/\n/g, "<br />")+'<div>';
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
                        //$("#respuesta-"+item.idtareadestinatariorespuesta).html(item.respuesta);                      


                    });

                    $(".editTarDestResp0").on("click",function(event){
                        event.stopPropagation();
                        obj.setIsTimeLine(false);
                        var arr = event.currentTarget.id.split('-');
                        getPropTarAlu0(idtareadestinatario,arr[1]);

                    });

                    $(".removeTarDestResp0").on("click",function(event){
                        event.preventDefault();
                        var resp =  confirm("Desea eliminar esta respuesta?");
                        //alert(resp);
                        //return false;
                        if (resp){
                            var arr = event.currentTarget.id.split('-');
                            $("#preloaderPrincipal").show();
                            $.post(obj.getValue(0) + "data/", {o:40, t:8, c:arr[1], p:2, from:0, cantidad:0, s:''},
                            function(json) {
                                    if (json[0].msg=="OK"){
                                        getTareaDestinatario(idtareadestinatario);
                                    }else{
                                        alert(json[0].msg); 
                                    }
                            }, "json");
                            $("#preloaderPrincipal").hide();
                        }
                    });

                    if ( parseInt( localStorage.IdUser,0 ) == parseInt( iddestinatario,0 )  ){
                        $("#wt-AddFilesResp0").show();   
                    }    


                    $("#wt-AddFilesResp0").on("click",function(event){
                        event.stopPropagation();
                        obj.setIsTimeLine(false);
                        addItemFileUpload(idtareadestinatario);
                    })

                    getTareaArchivosRespuestas(idtareadestinatario);

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

    function getTareaArchivosRespuestas(IdTareaDestinatario){
        
        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idtareadestinatario="+IdTareaDestinatario;

        $("#tbl_FileRespAlu1").html("<li>Sin Archivos</li>");
        $.post(obj.getValue(0)+"data/", { o:40, t:20007, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var rp;
                $("#tbl_FileRespAlu1").empty();
                $.each(json, function(i, item) {
                    
                    if ( parseInt( localStorage.IdUser,0 ) == parseInt( item.creado_por,0 )  ){
                        rp = '  <li ><a href="'+obj.getValue(0)+item.directorio+item.archivo+'" title="Ver Archivo" target="_blank" >'+item.descripcion_archivo+'</a>  <a href="#" target="_blank" class="uploadImage ajusteliMenuMain" id="deleteFileFromRespuestaAlu-'+item.idtareaarchivorespuesta+'-'+item.archivo+'"><i class="icon icon-trash red marginLeft1em icon-1x"></i></a>  <small class="grey"><i>'+item.creado_el+'</i></small> </li>';
                    }else{
                        rp = '  <li ><a href="'+obj.getValue(0)+item.directorio+item.archivo+'" title="Ver Archivo" target="_blank" >'+item.descripcion_archivo+'</a>  <small class="grey"><i>'+item.creado_el+'</i></small> </li>';
                    }
                    $("#tbl_FileRespAlu1").append(rp);

                });

                

                $(".uploadImage").on("click",function(event){
                    event.preventDefault();
                    $("#preloaderPrincipal").show();
                    var resp =  confirm("Desea eliminar este Archivo?");
                    if (resp){
                        var arr = event.currentTarget.id.split('-');
                        DelteFileExist(arr[1],arr[2]); 
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
 


    $("#btnRereshTarResp0").on("click",function(event){
        event.stopPropagation();
        obj.setIsTimeLine(false);
        getTareaDestinatario(idtareadestinatario);

    })

    $("#btnAddTarResp0").on("click",function(event){
        event.stopPropagation();
        obj.setIsTimeLine(false);
        getPropTarAlu0(idtareadestinatario,0);

    })

    function getPropTarAlu0(IdTareaDestinatario, IdTareaDestinatarioRespuesta){
        $("#contentLevel3").html("");
        $("#contentProfile").hide(function(){
            $("#preloaderPrincipal").show();
            obj.setIsTimeLine(false);
            var nc = localStorage.nc;
            $.post(obj.getValue(0) + "tareas-alu-resp-prop/", {
                user: nc,
                idtareadestinatario: IdTareaDestinatario,
                idtareadestinatariorespuesta: IdTareaDestinatarioRespuesta
                },
                function(html) {                    
                    $("#contentLevel3").html(html).show('slow',function(){
                        //$("#contentProfile"); 
                        $('#breadcrumb').html(getBar('Inicio, Tarea '));
                    });
                }, "html");
        });
        return false;
    }

    function addItemFileUpload(IdTareaDestinatario){

        $("#contentLevel3").html("");
        $("#contentProfile").hide(function(){
        var nc = localStorage.nc; 
        $.post(obj.getValue(0) + "tareas-alu-archivos-prop/", {
                    user: nc,
                    idtareadestinatario: IdTareaDestinatario
            },
            function(html) {
                    $("#contentLevel3").html(html).show('slow',function(){
                    });
            }, "html");
        });

    }

    function DelteFileExist(IdTareaArchivoRespuesta,Archivo){



                $("#preloaderPrincipal").show();

                var queryString = "idtareaarchivorespuesta="+IdTareaArchivoRespuesta+"&archivo="+Archivo;

                var data = new FormData();

                data.append('data', queryString);


                $.ajax({
                    url:obj.getValue(0)+"fu-ufdfe-resp/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    type: 'POST',
                    success: function(json){
                        if (json.status=="OK"){
                            //alert( json.message );
                            getTareaArchivosRespuestas(idtareadestinatario);
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

    $("#tituloPanel").html("Editando la Tarea: "+idtarea);

    getTarea(idtarea);

    var stream = io.connect(obj.getValue(4));
    stream.on("servidor", jsNewSolMatEnc0);
    function jsNewSolMatEnc0(datosServer) {
        var ms = datosServer.mensaje.split("-");

        if (ms[1]=='RESPUESTA_TAREA') {
             getTareaDestinatario(idtareadestinatario);
        }       

        if (ms[1]=='UPLOAD_FILES_TAREAS_ALUMNO') {
             getTareaArchivosRespuestas(idtareadestinatario);
        }       

    }

    var stream = io.connect(obj.getValue(4));

    getTareaArchivosRespuestas(idtareadestinatario);

});

</script>