<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user     = $_POST['user'];
$idalumno = $_POST['idalumno'];
$idemeralu = $_POST['idemeralu'];
?>

<div class="span7">
        <form id="frmEmerAlu2" class="form" role="form" >
                <h3 id="tituloPanel"></h3>

                <table>


                    <tr>
                        <td><label for="idemergencia" class="textRight">Emergencia</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idemergencia" id="idemergencia" size="1">
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
                <input type="hidden" name="idemeralu" id="idemeralu" value="<?php echo $idemeralu; ?>">
                <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <fieldset class="fieldset3">
                <h3></h3>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFrmEmerAlu2"><i class="icon-signout"></i>Cerrar</button>
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

    var idemeralu = <?php echo $idemeralu; ?>;
    var idalumno = <?php echo $idalumno; ?>;

    $("#frmEmerAlu2").unbind("submit");
    $("#frmEmerAlu2").on("submit",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").show();
        var vVal = parseInt($("#idemergencia").val());
        if ( vVal <= 0 ){
            alert("Seleccione un Médico");
            return false;
        }        
        var queryString = $(this).serialize();

        // alert(queryString);
        
        var IdEmerAlu = (idemeralu==0?3:4);
        $.post(obj.getValue(0)+"data/",  { o:53, t:IdEmerAlu, p:52, c:queryString, from:0, cantidad:0,s:'' },
            function(json){
                if (json[0].msg=="OK"){
                    alert("Información guardada con éxito!");
                    // stream.emit("cliente", {mensaje: "PLATSOURCE-MEDALU-PROP-"+idemeralu});
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
        if (idemeralu>0){
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0) + "data/", {o:53, t:26, c:idemeralu, p:54, from:0, cantidad:0,s:nc},
                function(json){
                    $("#idemergencia").val(json[0].idemergencia);            
                    $("#predeterminado").prop("checked",json[0].predeterminado==1?true:false);
                    $("#idemergencia").focus();  
            },'json');
        }else{
            $("#tituloPanel").html("Nuevo Registro");  
            $("#idalumno").focus();
        }
    }

    function getEmerAlu(){
        $("#idemergencia").empty();
        $("#idemergencia").append('<option value="0">Selecciona una Persona</option>');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:53, t:27, p:54,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc;
               $.each(json, function(i, item) {
                    $("#idemergencia").append('<option value="'+item.idemergencia+'"> '+item.nombre+'</option>');
                });
                updateForm();
            }, "json"
        );  
    }

    getEmerAlu();

    // var stream = io.connect(obj.getValue(4));

});
});

</script>
