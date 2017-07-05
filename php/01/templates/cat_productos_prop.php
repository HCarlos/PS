<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idproducto  = $_POST['idproducto'];

?>

<h3 class="header smaller lighter blue">
    <span id="title"></span>
    <a class="label label-info arrowed-in-right arrowed closeFormUpload pull-right">Regresar</a>
</h3>

<form id="frmData"  class="form">

<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">

                <table>

                    <tr>
                        <td><label for="idproveedor" class="textRight">Proveedor</label></td>
                        <td>
                            <select class="form-control altoMoz"  name="idproveedor" id="idproveedor" size="1">
                        </td>
                        <td><label for="idmedida" class="marginLeft2em textRight">Medida</label></td>
                        <td>
                            <select class="form-control altoMoz"  name="idmedida" id="idmedida" size="1">
                        </td>

                        <td><label for="idcolor" class="marginLeft2em textRight">Color</label></td>
                        <td>
                            <select class="form-control altoMoz"  name="idcolor" id="idcolor" size="1">
                        </td>
                    </tr>

                    <tr>
                        <td><label for="producto" class="textRight">Producto</label></td>
                        <td colspan="3">
                            <input class="altoMoz wd62prc" name="producto" id="producto" type="text" required>
                        </td>
                        <td><label for="costo_unitario" class="marginLeft2em textRight">Costo Unitario</label></td>
                        <td>
                            <input class="altoMoz wd62prc" name="costo_unitario" id="costo_unitario" type="text"  pattern="[-+]?[0-9]*[.,]?[0-9]+" required>
                        </td>
            
                    </tr>

                    <tr>
                        <td><label for="iscolor" class="textRight">Con Color</label></td>
                        <td>
                            <input name="iscolor" id="iscolor" class="ace ace-switch ace-switch-6" type="checkbox">
                            <span class="lbl"></span>
                        </td>
                        <td><label for="status_producto" class="marginLeft2em textRight">Estatus</label></td>
                        <td>
                            <input name="status_producto" id="status_producto" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                    </tr>

                </table>


    <input type="hidden" name="idproducto" id="idproducto" value="<?php echo $idproducto; ?>">
    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
	</div>

</form>

</div>
</div>

<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();

    $("#idmedida").focus();

    accounting.settings = {
        currency: {
            symbol : "", 
            format: "%s%v",
            decimal : ".",
            thousand: ",",  
            precision : 2   
        },
        number: {
            precision : 0,  
            thousand: ",",
            decimal : "."
        }
    }


	var idproducto = <?php echo $idproducto ?>;

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		if (validForm()){
		    
		    var queryString = $(this).serialize();	

			var IdProducto = (idproducto==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:31, t:IdProducto, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-PRODUCTOS-PROP-"+idproducto});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").html("");
							$("#contentMain").show();
						});
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        			}
        	}, "json");
		}else{
			$("#preloaderPrincipal").hide();
		}
	});

	function getProducto(IdProducto){
		$("#preloaderPrincipal").show();
		$.post(obj.getValue(0) + "data/", {o:31, t:79, c:IdProducto, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					idproducto = json[0].idproducto;
					$("#idmedida").val(json[0].idmedida);
					$("#idcolor").val(json[0].idcolor);
                    $("#idproveedor").val(json[0].idproveedor);
					$("#producto").val(json[0].producto);
                    $("#costo_unitario").val( json[0].costo_unitario );

                    $("#iscolor").prop("checked",json[0].iscolor==1?true:false);
                    $("#status_producto").prop("checked",json[0].status_producto==1?true:false);

                    $("#title").html("Reg: " + json[0].idproducto);

					$("#preloaderPrincipal").hide();

                    $("#idmedida").focus();

				}
		},'json');

	}

	// close Form
	$(".closeFormUpload").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").html("");
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

	function validForm(){

		if($("#idmedida").val().length <= 0){
			alert("Faltan la Medida");
			$("#idmedida").focus();
			return false;
		}

		return true;

	}

    function getProveedores(){
       $("#preloaderPrincipal").show();
       $("#idproveedor").html('<option value="0" > Seleccione un Proveedor </option>');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:35, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc,it;
               $.each(json, function(i, item) {
                    $("#idproveedor").append('<option value="'+item.data+'" > '+item.label+'</option>');
                });
                $("#preloaderPrincipal").hide();
               getMedidas();
            }, "json"
        );  
    }

    function getMedidas(){
       $("#preloaderPrincipal").show();
       $("#idmedida").html('');
       // $("#idmedida").html('<option value="0" > Seleccione un Color </option>');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:34, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc,it;
               $.each(json, function(i, item) {
                    $("#idmedida").append('<option value="'+item.data+'" > '+item.label+'</option>');
                });
                $("#preloaderPrincipal").hide();
               getColores();
            }, "json"
        );  
    }

    function getColores(){
       $("#preloaderPrincipal").show();
       $("#idcolor").html('<option value="0" > Seleccione un Color </option>');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:32, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc,it,df;
               $.each(json, function(i, item) {
                    df = parseInt(item.isdefault,0);
                    df = df==1?' selected':'';
                    $("#idcolor").append('<option value="'+item.data+'" '+df+' > '+item.label+'</option>');
                });
                $("#preloaderPrincipal").hide();

                if (idproducto<=0){ // Nuevo Registro
                    $("#title").html("Nuevo registro");
                    $("#idmedida").focus();
                }else{ // Editar Registro
                    $("#title").html("Editando el Producto: "+idproducto);
                    getProducto(idproducto);
                }

            }, "json"
        );  
    }



    getProveedores();

	var stream = io.connect(obj.getValue(4));


});

</script>