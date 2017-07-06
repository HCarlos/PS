<?php

include("includes/metas.php");

$user     = $_POST['user'];
$idfamilia = $_POST['idfamilia'];
$idfamregfis = $_POST['idfamregfis'];
?>

<div class="span4">
        <form id="frmFamAlu" class="form" role="form" >
                <h3 id="tituloPanel"></h3>

                <table>


                    <tr>
                        <td><label for="idregfis" class="textRight">Registro</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idregfis" id="idregfis" size="1">
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

                    <tr>
                        <td><label for="status_famregfis" class="textRight">Estatus</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input name="status_famregfis" id="status_famregfis" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                    </tr>

                </table>

                <input type="hidden" name="idfamilia" id="de" value="<?php echo $idfamilia; ?>">
                <input type="hidden" name="idfamregfis" id="idfamregfis" value="<?php echo $idfamregfis; ?>">
                <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            
            <fieldset class="fieldset3">
                <h3></h3>
                <button type="button" class="btn btn-default pull-right marginLeft2em" data-dismiss="modal" id="closeFormUpload">
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

    var idfamregfis = <?php echo $idfamregfis; ?>;
    var idfamilia = <?php echo $idfamilia; ?>;

    $("#frmFamAlu").unbind("submit");
    $("#frmFamAlu").on("submit",function(event){
        $("#preloaderPrincipal").show();
        event.preventDefault();
        var queryString = $(this).serialize();
        var IdFamRegFis = (idfamregfis==0?0:1);
        $.post(obj.getValue(0)+"data/",  { o:15, t:IdFamRegFis, p:2, c:queryString, from:0, cantidad:0,s:'' },
            function(json){
                if (json[0].msg=="OK"){
                    //alert("Información guardada con éxito!");
                    stream.emit("cliente", {mensaje: "PLATSOURCE-FAMREGFIS-PROP-"+idfamregfis});

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
        if (idfamregfis>0){
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0) + "data/", {o:13, t:30, c:idfamregfis, p:10, from:0, cantidad:0,s:nc},
                function(json){
                    $("#idregfis").val(json[0].idregfis);            
                    $("#status_famregfis").prop("checked",json[0].status_famregfis==1?true:false);
                    $("#predeterminado").prop("checked",json[0].predeterminado==1?true:false);
                    $("#tituloPanel").html("Fam: " + json[0].familia);
                    $("#idregfis").focus();  
            },'json');
        }else{
            $("#tituloPanel").html("Nuevo Registro");  
            $("#idregfis").focus();
        }
    }

    function getRegFis(){
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:11, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc;
               $.each(json, function(i, item) {
                    $("#idregfis").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                updateForm();
            }, "json"
        );  
    }

    getRegFis();

    var stream = io.connect(obj.getValue(4));

    $('[data-rel=popover]').popover({container:$('.span7')});

});
});

</script>
