<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user     = $_POST['user'];
$idfamilia = $_POST['idfamilia'];
$idfamalu = $_POST['idfamalu'];
?>

<div class="span7">
        <form id="frmFamAlu" class="form" role="form" >
                <h3 id="tituloPanel"></h3>

                <table>

                    <tr>
                        <td><label for="idalumno" class="textRight">Alumno</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idalumno" id="idalumno" size="1">
                            </select>
                        </td>
                    </tr>
                  

                    <tr>
                        <td><label for="idtutor" class="textRight">Tutor</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idtutor" id="idtutor" size="1">
                            </select>
                        </td>
                    </tr>
                  
                    <tr>
                        <td><label for="vive_con" class="textRight">Vive Con</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="vive_con" id="vive_con" size="1">
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="is_minor" class="textRight">Es el Menor</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input name="is_minor" id="is_minor" class="ace ace-switch ace-switch-6" type="checkbox">
                            <span class="lbl"></span>
                        </td>
                    </tr>
                  
                    <tr>
                        <td><label for="status_famalu" class="textRight">Estatus</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input name="status_famalu" id="status_famalu" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                    </tr>
                  

                </table>


                <input type="hidden" name="idfamilia" id="de" value="<?php echo $idfamilia; ?>">
                <input type="hidden" name="idfamalu" id="idfamalu" value="<?php echo $idfamalu; ?>">
                <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <fieldset class="fieldset3">
                <h3></h3>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                    Cerrar
                </button>
                <span class="muted"></span>
                <button type="submit" class="btn btn-primary pull-right"><i class="icon-save"></i>Guardar</button>
            </fieldset>
        </form>
</div>
<script type="text/javascript">

jQuery(function($) {
$(document).ready(function () {

    $("#preloaderPrincipal").hide();
    //$("#divUploadImage").modal('show');

    var idfamalu = <?php echo $idfamalu; ?>;
    var idfamilia = <?php echo $idfamilia; ?>;

    $("#frmFamAlu").unbind("submit");
    $("#frmFamAlu").on("submit",function(event){
        $("#preloaderPrincipal").show();
        event.preventDefault();
        var queryString = $(this).serialize();
        var IdFamAlu = (idfamalu==0?0:1);
        $.post(obj.getValue(0)+"data/",  { o:13, t:IdFamAlu, p:2, c:queryString, from:0, cantidad:0,s:'' },
            function(json){
                if (json[0].msg=="OK"){
                    //alert("Información guardada con éxito!");
                    stream.emit("cliente", {mensaje: "PLATSOURCE-FAMALU-PROP-"+idfamalu});
                    $("#preloaderPrincipal").hide();
                    $("#divUploadImage").modal('hide');
                }else{
                    $("#preloaderPrincipal").hide();
                    alert(json[0].msg);
                    return false;
                }
        }, "json");        
    });

    function updateForm(){
        if (idfamalu>0){
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0) + "data/", {o:13, t:26, c:idfamalu, p:10, from:0, cantidad:0,s:nc},
                function(json){
                    $("#idalumno").val(json[0].idalumno);            
                    $("#idtutor").val(json[0].idtutor);            
                    $("#is_minor").prop("checked",json[0].is_minor==1?true:false);
                    $("#vive_con").val(json[0].vive_con); 
                    $("#status_famalu").prop("checked",json[0].status_famalu==1?true:false);
                    $("#tituloPanel").html("Fam: " + json[0].familia);
                    $("#idalumno").focus();  
            },'json');
        }else{
            $("#tituloPanel").html("Nuevo Registro");  
            $("#idalumno").focus();
        }
    }

    function getAlumnos(){
        $("#idalumno").html('');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:5, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc;
               $.each(json, function(i, item) {
                    $("#idalumno").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                getMemberFam();
            }, "json"
        );  
    }

    function getMemberFam(){
        $("#idtutor").empty();
        $("#vive_con").empty();
        var nc = "u="+localStorage.nc+"&idfamilia="+idfamilia;
        $.post(obj.getValue(0)+"data/", { o:1, t:10, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc;
               $.each(json, function(i, item) {
                    $("#idtutor").append('<option value="'+item.data+'"> '+item.label+'</option>');
                    $("#vive_con").append('<option value="'+item.idfamper+'"> '+item.label+' ('+item.parentezco+')</option>');
                });
                updateForm();
            }, "json"
        );  
    }

    getAlumnos();

    var stream = io.connect(obj.getValue(4));

    $('[data-rel=popover]').popover({container:$('.span7')});

});
});

</script>
