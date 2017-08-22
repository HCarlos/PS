<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user     = $_POST['user'];
$idsolicituddematerial = $_POST['idsolicituddematerial'];
$idsolicituddematerialdetalle = $_POST['idsolicituddematerialdetalle'];
?>

<div class="span7">
        <form id="frmSolMatDet0" class="form" role="form" >
                <h3 id="tituloPanel"></h3>

                <table>

                    <tr>
                        <td><label for="idproducto" class="textRight">Producto</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idproducto" id="idproducto" size="1" required>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="idcolor" class="textRight">Color</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idcolor" id="idcolor" size="1">
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="cantidad_solicitada" class="textRight">Cantidad</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz wd62prc" name="cantidad_solicitada" id="cantidad_solicitada" type="text"  pattern="[-+]?[0-9]*[.,]?[0-9]+" required>
                        </td>
                    </tr>
                  
                    <tr>
                        <td><label for="observaciones_solicitud" class="textRight">Observaciones</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <textarea rows="4" cols="50" class="" id="observaciones_solicitud" name="observaciones_solicitud"></textarea>                  
                            <span class="lbl"></span>
                        </td>
                    </tr>
                  

                </table>


                <input type="hidden" name="idsolicituddematerial" id="de" value="<?php echo $idsolicituddematerial; ?>">
                <input type="hidden" name="idsolicituddematerialdetalle" id="idsolicituddematerialdetalle" value="<?php echo $idsolicituddematerialdetalle; ?>">
                <input type="hidden" name="costo_unitario" id="costo_unitario" value="0">
                <input type="hidden" name="idprod" id="idprod" value="0">
                <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <fieldset class="fieldset3">
                <h3></h3>
                <button type="button" class="btn btn-default pull-right marginLeft2em" data-dismiss="modal" id="closeFrmSolMatDet0"><i class="icon-signout"></i>Cerrar</button>
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

        $("#frmSolMatDet0").unbind("submit");
        $("#frmSolMatDet0").on("submit",function(event){
            $("#preloaderPrincipal").show();
            event.preventDefault();
            
            var y = $('select[name="idproducto"] option:selected').val(); 
            
            $("#costo_unitario").val( arritems[y].costo_unitario ); 
            $("#idprod").val( arritems[y].idproducto ); 
            
            var queryString = $(this).serialize();
            
            var IdSolMatDet = (idsolicituddematerialdetalle==0?0:1);
            $.post(obj.getValue(0)+"data/",  { o:39, t:IdSolMatDet, p:2, c:queryString, from:0, cantidad:0,s:'' },
                function(json){
                    if (json[0].msg=="OK"){
                        //alert("Información guardada con éxito!");
                        
                        // stream.emit("cliente", {mensaje: "PLATSOURCE-SOLMATDET-PROP-"+idsolicituddematerial});
                    

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
            if (idsolicituddematerialdetalle>0){
                var nc = "u="+localStorage.nc;
                $.post(obj.getValue(0) + "data/", {o:39, t:86, c:idsolicituddematerialdetalle, p:10, from:0, cantidad:0,s:nc},
                    function(json){

                        $("#idproducto").val(json[0].idproducto);            
                        $("#idprod").val( json[0].idproducto );            
                        $("#idcolor").val(json[0].idcolor);            
                        $("#costo_unitario").val( json[0].costo_unitario );            
                        $("#observaciones_solicitud").val(json[0].observaciones_solicitud);            
                        $("#cantidad_solicitada").val(json[0].cantidad_solicitada);            
                        $("#cantidad_solicitada").focus();  
                },'json');
            }else{
                $("#tituloPanel").html("Nuevo Registro");  
                $("#cantidad_solicitada").focus();
            }
        }

        function getProductos(){
            $("#idproducto").html('');
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0)+"data/", { o:1, t:38, p:0,c:nc,from:0,cantidad:0, s:"" },
                function(json){
                    var y;
                    y = json.length;
                   $.each(json, function(i, item) {
                        //console.log(item.data+"|"+item.costo_unitario);
                        arritems[item.data] = {idproducto:item.data, costo_unitario:item.costo_unitario};

                        $("#idproducto").append('<option value="'+item.data+'">'+item.label+'</option>');
                        if (y == i+1){
                            console.log(item.data+"|"+item.costo_unitario);
                            updateForm();
                        }
                    });
                    
                }, "json"
            );  
        }

        function getColors(){
            $("#idcolor").html('<option value="0">Seleccione un Color</option>');
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0)+"data/", { o:1, t:32, p:0,c:nc,from:0,cantidad:0, s:"" },
                function(json){
                   $.each(json, function(i, item) {
                        $("#idcolor").append('<option value="'+item.data+'"> <span class="btn-colorpicker" style="background-color:'+item.codigo_color_hex+'"> '+item.label+' </span> </option>');
                    });
                    getProductos();
                }, "json"
            );  
        }

       getColors();

        // var stream = io.connect(obj.getValue(4));

        $('[data-rel=popover]').popover({container:$('.span7')});

       // alert("Init");

    });
});

</script>
