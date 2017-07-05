<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user     = $_POST['user'];
$idalumno = $_POST['idalumno'];
$idmedalu = $_POST['idmedalu'];
?>

<div class="span7">
        <form id="frmMedAlu2" class="form" role="form" >
                <h3 id="tituloPanel"></h3>

                <table>


                    <tr>
                        <td><label for="idmedico" class="textRight">Médicos</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idmedico" id="idmedico" size="1">
                            </select>
                        </td>
                    </tr>
                  

                    <tr>
                        <td><label for="predeterminado" class="textRight">Default</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input name="predeterminado" id="predeterminado" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                    </tr>
                  

                </table>


                <input type="hidden" name="idalumno" id="de" value="<?php echo $idalumno; ?>">
                <input type="hidden" name="idmedalu" id="idmedalu" value="<?php echo $idmedalu; ?>">
                <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <fieldset class="fieldset3">
                <h3></h3>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFrmMedAlu2"><i class="icon-signout"></i>Cerrar</button>
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

    var idmedalu = <?php echo $idmedalu; ?>;
    var idalumno = <?php echo $idalumno; ?>;

    $("#frmMedAlu2").unbind("submit");
    $("#frmMedAlu2").on("submit",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").show();
        var vVal = parseInt($("#idmedico").val());
        if ( vVal <= 0 ){
            alert("Seleccione un Médico");
            return false;
        }        
        var queryString = $(this).serialize();

        // alert(queryString);
        
        var IdMedAlu = (idmedalu==0?3:4);
        $.post(obj.getValue(0)+"data/",  { o:48, t:IdMedAlu, p:2, c:queryString, from:0, cantidad:0,s:'' },
            function(json){
                if (json[0].msg=="OK"){
                    alert("Información guardada con éxito!");
                    // stream.emit("cliente", {mensaje: "PLATSOURCE-MEDALU-PROP-"+idmedalu});
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
        if (idmedalu>0){
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0) + "data/", {o:48, t:107, c:idmedalu, p:10, from:0, cantidad:0,s:nc},
                function(json){
                    $("#idmedico").val(json[0].idmedico);            
                    $("#predeterminado").prop("checked",json[0].predeterminado==1?true:false);
                    $("#idmedico").focus();  
            },'json');
        }else{
            $("#tituloPanel").html("Nuevo Registro");  
            $("#idalumno").focus();
        }
    }

    function getMedAlu(){
        $("#idmedico").empty();
        $("#idmedico").append('<option value="0">Selecciona un Médico</option>');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:48, t:109, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc;
               $.each(json, function(i, item) {
                    $("#idmedico").append('<option value="'+item.idmedico+'"> '+item.app_medico+' '+item.apm_medico+' '+item.nombre_medico+'</option>');
                });
                updateForm();
            }, "json"
        );  
    }

    getMedAlu();

    // var stream = io.connect(obj.getValue(4));

});
});

</script>
