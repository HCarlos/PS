<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idcommensaje = $_POST['idcommensaje'];
$mensaje = $_POST['mensaje'];
$param1 = md5($user.$idcommensaje);

?>


<style type="text/css">

    #uploadingFileTar[disabled] {
        cursor: default;
        background-image: none;
        opacity: 0.65;
        filter: alpha(opacity=65);
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        color: #333;
        background-color: #E6E6E6;
    }

</style>

<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <i class="icon-circle green"></i> <strong id="spIdtarea"><?php echo $idcommensaje ?></strong>: <b class="text-success"><?php echo $mensaje ?></b> 
    </div>


    <div class="widget-body">
        <div class="widget-main">
            
            <div class="row-fluid">

                <form id="frmComMenArch0" role="form">
                    
                    <div class="form-group ">
                        <label for="descripcion_archivo" class="col-lg-2 control-label">Descripción</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control altoMoz" id="descripcion_archivo" name="descripcion_archivo" autofocus  >
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="filex" class="col-lg-2 control-label">Archivo</label>
                        <div class="col-lg-5">
                            <input type="file" class="ace ace-file-input filex wd40prc" id="filex" name="filex" /> 
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="hr hr-dotted col-lg-12"></div>
                    </div>

                    <input type="hidden" name="idcommensaje" id="idcommensaje" value="<?php echo $idcommensaje; ?>">
                    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
                    <input type="hidden" name="v2" id="v2" value="<?php echo $param1; ?>">
                    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
                        <button type="button" class="btn btn-default pull-right closeFormUpload" data-dismiss="modal" ><i class="icon-signout "></i>Cerrar</button>
                        <span class="muted"></span>
                        <button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;' id="uploadingFileTar"><i class="icon-cloud-upload"></i>Subir</button>
                    </div>

                </form>


            </div> <!-- row-fluid Redactar Tarea-->

        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {


	$("#preloaderPrincipal").hide();

    var idcommensaje = <?php echo $idcommensaje ?>;

    $("#frmComMenArch0").unbind("submit");
    $("#frmComMenArch0").on("submit",function(event){
        event.preventDefault();

        if ( validForm() ) {

            $("#uploadingFileTar").html('<i class="fa fa-refresh fa-spin"> </i> <i>Subiendo Archivo</i>');

            $("#preloaderPrincipal").show();

                var data = new FormData();
                
                $("#uploadingFileTar").prop('disabled', true);

                jQuery.each($('input[type=file]')[0].files, function(i, file) {
                    data.append('file_0', file);
                    console.log('file_0');
                });

                var queryString = $(this).serialize();  

                data.append('data', queryString);

                $.ajax({
                    url:obj.getValue(0)+"uf-file-com-mensaje/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    type: 'POST',
                    success: function(json){
                        
                        alert( json.message );

                        if (json.status=="OK"){
                            stream.emit("cliente", {mensaje: "PLATSOURCE-UPLOAD_FILES_COM_MENSAJE-PROP-"+idcommensaje});
                        }
                        
                        $("#preloaderPrincipal").hide();
                        $("#contentLevel3").hide(function(){
                            $("#contentLevel3").empty();
                            $("#contentProfile").show();
                        });        
                        $("#uploadingFileTar").prop('disabled', false);
                            
                    }
                });

        }else{

            $("#preloaderPrincipal").hide();
            
        }

    });

    function validForm(){

        if ($("#descripcion_archivo").val().length <= 0){
            alert("Faltan la Descripcion");
            $("#descripcion_archivo").focus();
            return false;
        }

        return true;

    }

    // close Form
    $(".closeFormUpload").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").empty();
            $("#contentProfile").show();
        });        
        resizeScreen();
        return false;
    });

    $('.filex').ace_file_input({
        no_file:'Sin Archivo ...',
        btn_choose:'Seleccione un archivo',
        btn_change:'Cambiar',
        droppable:false,
        onchange:null,
        thumbnail:true, //| true | large
        whitelist:'gif|png|jpg|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx|txt',
        blacklist:'exe|php|odt'
        //onchange:''
        //
    });



    var stream = io.connect(obj.getValue(4));

    $("#descripcion_archivo").focus();


});

</script>