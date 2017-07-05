<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user     = $_POST['user'];
$idfamilia = $_POST['idfamilia'];
$idfamper = $_POST['idfamper'];
?>

<div class="span7">
        <form id="frmFamPer" class="form" role="form" >
                <h3 id="tituloPanel"></h3>

                <table>

                    <tr>
                        <td><label for="idpersona" class="textRight">Persona</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idpersona" id="idpersona" size="1">
                            </select>
                        </td>
                    </tr>
                  

                    <tr>
                        <td><label for="idparentezco" class="textRight">Parentezco</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class=" altoMoz" name="idparentezco" id="idparentezco" size="1">
                            </select>
                        </td>
                    </tr>
                  
                    <tr>
                        <td><label for="is_email" class="textRight">Recibir Email</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input name="is_email" id="is_email" class="ace ace-switch ace-switch-6" type="checkbox">
                            <span class="lbl"></span>
                        </td>
                    </tr>
                  

                    <tr>
                        <td><label for="status_famper" class="textRight">Estatus</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input name="status_famper" id="status_famper" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                    </tr>
                  

                </table>


                <input type="hidden" name="idfamilia" id="de" value="<?php echo $idfamilia; ?>">
                <input type="hidden" name="idfamper" id="idfamper" value="<?php echo $idfamper; ?>">
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

        var idfamper = <?php echo $idfamper; ?>;
        var idfamilia = <?php echo $idfamilia; ?>;

        $("#frmFamPer").unbind("submit");
        $("#frmFamPer").on("submit",function(event){
            $("#preloaderPrincipal").show();
            event.preventDefault();
            var queryString = $(this).serialize();
            var IdFamPer = (idfamper==0?0:1);
            $.post(obj.getValue(0)+"data/",  { o:12, t:IdFamPer, p:2, c:queryString, from:0, cantidad:0,s:' ' },
                function(json){
                    if (json[0].msg=="OK"){
                        //alert("Información guardada con éxito!");
                        stream.emit("cliente", {mensaje: "PLATSOURCE-FAMPER-PROP-"+idfamper});
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
            if (idfamper>0){
                var nc = "u="+localStorage.nc;
                $.post(obj.getValue(0) + "data/", {o:12, t:24, c:idfamper, p:10, from:0, cantidad:0,s:nc},
                    function(json){
                        $("#idpersona").val(json[0].idpersona);            
                        $("#idparentezco").val(json[0].idparentezco);            
                        //$("#is_email").val(json[0].is_email);            
                        //$("#status_famper").val(json[0].status_famper);            
                        $("#is_email").prop("checked",json[0].is_email==1?true:false);
                        $("#status_famper").prop("checked",json[0].status_famper==1?true:false);
                        $("#tituloPanel").html("Fam: " + json[0].familia);
                        $("#idpersona").focus();  
                },'json');
            }else{
                $("#tituloPanel").html("Nuevo Registro");  
                $("#idpersona").focus();
            }
        }

        function getPersonas(){
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0)+"data/", { o:1, t:9, p:0,c:nc,from:0,cantidad:0, s:" order by label asc " },
                function(json){
                    var nc;
                   $.each(json, function(i, item) {
                        $("#idpersona").append('<option value="'+item.data+'"> '+item.label+'</option>');
                    });
                    getParentezcos();
                }, "json"
            );  
        }

        function getParentezcos(){
            var nc = "u="+localStorage.nc;
            $.post(obj.getValue(0)+"data/", { o:1, t:8, p:0,c:nc,from:0,cantidad:0, s:"" },
                function(json){
                    var nc;
                   $.each(json, function(i, item) {
                        $("#idparentezco").append('<option value="'+item.data+'"> '+item.label+'</option>');
                    });
                    updateForm();
                }, "json"
            );  
        }

        getPersonas();

        var stream = io.connect(obj.getValue(4));

        $('[data-rel=popover]').popover({container:$('.span7')});

    });
});

</script>
