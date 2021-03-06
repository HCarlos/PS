<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idtareadestinatario = $_POST['idtareadestinatario'];
$param1 = md5($user.$idtareadestinatario);

?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <i class="icon-circle green"></i> <strong id="spIdtarea"><?php echo $idtareadestinatario; ?></strong>: <b class="text-success">Nuevo Archivo</b> 
    </div>


    <div class="widget-body">
        <div class="widget-main">
            
            <div class="row-fluid">

                <form id="frmTarea" role="form">
                    
                    <div class="form-group ">
                        <label for="descripcion_archivo" class="col-lg-2 control-label">Descripción</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control altoMoz" id="descripcion_archivo" name="descripcion_archivo" autofocus  >
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="filex" class="col-lg-2 control-label">Archivo</label>
                        <div class="col-lg-6">
                            <input type="file" class="ace ace-file-input filex wd60prc" id="filex" name="filex" /> 
                            <small class="help-block">Tipos de Archivos: jpg, jpeg, gif, png, pdf, doc, docx, xls, xlsx, ppt, pptx, txt, mp3, mp4</small>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="hr hr-dotted col-lg-12"></div>
                    </div>

                    <input type="hidden" name="idtareadestinatario" id="idtareadestinatario" value="<?php echo $idtareadestinatario; ?>">
                    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
                    <input type="hidden" name="v4" id="v4" value="<?php echo $param1; ?>">
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

    var idtareadestinatario = <?php echo $idtareadestinatario ?>;

    $("#frmTarea").unbind("submit");
    $("#frmTarea").on("submit",function(event){
        event.preventDefault();

        if ( validForm() ) {

                $("#uploadingFileTar").html('<i class="fa fa-refresh fa-spin"> </i> <i>Subiendo Archivo</i>');

                $("#preloaderPrincipal").show();

                $("#uploadingFileTar").prop('disabled', true);

                var data = new FormData();

                jQuery.each($('input[type=file]')[0].files, function(i, file) {
                    data.append('file_0', file);
                    console.log('file_0');
                });

                var queryString = $(this).serialize();  

                data.append('data', queryString);

                $.ajax({
                    url:obj.getValue(0)+"fu-uta-resp/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    type: 'POST',
                    success: function(json){

                        alert( json.message );
                        
                        if (json.status=="OK"){
                            // stream.emit("cliente", {mensaje: "PLATSOURCE-UPLOAD_FILES_TAREAS_ALUMNO-PROP-"+idtareadestinatario});
                        }
                        $("#preloaderPrincipal").hide();
                        $("#contentLevel3").hide(function(){
                            $("#contentLevel3").html("");
                            $("#contentProfile").show();
                        });        
                        $("#uploadingFileTar").prop('disabled', false);
                            
                    }
                });
        }else{
            $("#preloaderPrincipal").hide();
        }
    });

    // close Form
    $(".closeFormUpload").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").html("");
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

    function validForm(){

        if ($("#descripcion_archivo").val().length <= 0){
            alert("Faltan la Descripcion");
            $("#descripcion_archivo").focus();
            return false;
        }

        return true;

    }



    // var stream = io.connect(obj.getValue(4));

    $("#descripcion_archivo").focus();


});

</script>