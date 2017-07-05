<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user     = $_POST['user'];
$idsolicituddematerial = $_POST['idsolicituddematerial'];
$idsolicituddematerialdetalle = $_POST['idsolicituddematerialdetalle'];
?>

<div class="span7">
        <form id="frmSolMatDet2" class="form" role="form" >
                <h3 id="tituloPanel"></h3>

                <table>



                    <tr>
                        <td><label for="cantidad_entregado" class="textRight">Cantidad</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz wd62prc" name="cantidad_entregado" id="cantidad_entregado" type="text"  pattern="[-+]?[0-9]*[.,]?[0-9]+" required>
                        </td>
                    </tr>
                  
                    <tr>
                        <td><label for="observaciones_entrega" class="textRight">Observaciones</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <textarea rows="4" cols="50" class="" id="observaciones_entrega" name="observaciones_entrega" ></textarea>                  
                            <span class="lbl"></span>
                        </td>
                    </tr>

                  

                </table>


                <input type="hidden" name="idsolicituddematerial" id="de" value="<?php echo $idsolicituddematerial; ?>">
                <input type="hidden" name="idsolicituddematerialdetalle" id="idsolicituddematerialdetalle" value="<?php echo $idsolicituddematerialdetalle; ?>">
                <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <fieldset class="fieldset3">
                <h3></h3>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFrmSolMatDet0"><i class="icon-signout"></i>Cerrar</button>
                <span class="muted"></span>
                <button type="submit" class="btn btn-primary pull-right"><i class="icon-save"></i>Guardar</button>
            </fieldset>
        </form>
</div>
<script type="text/javascript">

jQuery(function($) {
    $(document).ready(function () {

        $("#preloaderPrincipal").hide();
        var arritems = [];
        //$("#divUploadImage").modal('show');

        var idsolicituddematerialdetalle = <?php echo $idsolicituddematerialdetalle; ?>;
        var idsolicituddematerial = <?php echo $idsolicituddematerial; ?>;

        $("#closeFrmSolMatDet0").on("click",function(event){
            event.preventDefault();
            $("#preloaderPrincipal").hide();
            $("#contentLevel3").hide(function(){
                $("#contentLevel3").html("");
                $("#contentProfile").show();
            });
            resizeScreen();
            return false;
        });

        $("#frmSolMatDet2").unbind("submit");
        $("#frmSolMatDet2").on("submit",function(event){
            $("#preloaderPrincipal").show();
            event.preventDefault();

            var queryString = $(this).serialize();
            
            //alert(queryString);

            $.post(obj.getValue(0)+"data/",  { o:39, t:6, p:2, c:queryString, from:0, cantidad:0,s:'' },
                function(json){
                    if (json[0].msg=="OK"){
                        //alert("Información guardada con éxito!");
                        stream.emit("cliente", {mensaje: "PLATSOURCE-SOLMATDETOBS-PROP-"+idsolicituddematerial});
                    

                        $("#preloaderPrincipal").hide();
                        $("#contentLevel3").hide(function(){
                            $("#contentLevel3").html("");
                            $("#contentProfile").show();
                        });
                        resizeScreen();
                        return false;

                    }else{
                        $("#preloaderPrincipal").hide();
                        alert(json[0].msg);
                        return false;
                    }
            }, "json");        
        });

        function updateForm(){
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0) + "data/", {o:39, t:86, c:idsolicituddematerialdetalle, p:10, from:0, cantidad:0,s:nc},
                function(json){

                    $("#cantidad_entregado").val(json[0].cantidad_entregado);            
                    $("#observaciones_entrega").val(json[0].observaciones_entrega); 

                    $("#tituloPanel").html("Editando el Item: "+idsolicituddematerialdetalle);  
                    $("#cantidad_entregado").focus();

            },'json');
        }

        updateForm();

        var stream = io.connect(obj.getValue(4));

        $('[data-rel=popover]').popover({container:$('.span7')});

    });
});

</script>
