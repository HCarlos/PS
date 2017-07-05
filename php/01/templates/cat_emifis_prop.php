<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idemisorfiscal  = $_POST['idemisorfiscal'];

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
                        <td><label for="rfc" class="textRight">RFC</label></td>
                        <td>
                            <input class="altoMoz" name="rfc" id="rfc" type="text" autofocus>

                      </td>

                        <td></td>
                        <td>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="razon_social" class="textRight">Razón Social</label></td>
                        <td colspan="5">
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz wd62prc" name="razon_social" id="razon_social" type="text" required>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="calle" class="textRight">Calle</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="calle" id="calle" type="text" required>
                        </td>
                        <td><label for="num_ext" class="marginLeft2em textRight">Num Ext</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="num_ext" id="num_ext" type="text" required>
                        </td>
                        <td><label for="num_int" class="marginLeft2em textRight">Num Int</label></td>
                        <td>
                            <input class="altoMoz" name="num_int" id="num_int" type="text" >
                        </td>
                    </tr>

                    <tr>
                        <td><label for="colonia" class="textRight">Colonia</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="colonia" id="colonia" type="text" required>
                        </td>
                        <td><label for="localidad" class="marginLeft2em textRight">Localidad</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="localidad" id="localidad" type="text" required>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="estado" class="textRight">Estado</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="estado" id="estado" type="text" required>
                        </td>
                        <td><label for="pais" class="marginLeft2em textRight">Pais</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="pais" id="pais" value="México" type="text" required>
                        </td>
                        <td><label for="cp" class="marginLeft2em textRight">CP</label></td>
                        <td>
                            <input class="altoMoz" name="cp" id="cp" type="text" >
                        </td>
                    </tr>


                    <tr>
                        <td><label for="status_emisor_fiscal" class="textRight">Estatus</label></td>
                        <td>
                            <input name="status_emisor_fiscal" id="status_emisor_fiscal" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td><label for="is_iva" class="marginLeft2em textRight">Is IVA</label></td>
                        <td>
                            <input name="is_iva" id="is_iva" class="ace ace-switch ace-switch-6" type="checkbox">
                            <span class="lbl"></span>
                        </td>
                        <td><label for="serie" class="marginLeft2em textRight">Serie</label></td>
                        <td>
                            <input class="altoMoz" name="serie" id="serie" type="text" >
                        </td>
                    </tr>

                    <tr>
                        <td><label for="tipo_comprobante" class="textRight">Comprobante:</label></td>
                        <td>
                            <select id="tipo_comprobante" name="tipo_comprobante" size="1">
                                <option value="0" selected>Factura </option>
                                <option value="1">Recibo </option>
                            </select>
                        </td>
                        <td></td>
                        <td>
                            <span class="lbl"></span>
                        </td>
                        <td>
                            <span class="lbl"></span>
                        </td>
                        <td>
                        </td>
                    </tr>



                </table>


    <input type="hidden" name="idemisorfiscal" id="idemisorfiscal" value="<?php echo $idemisorfiscal; ?>">
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

    $("#rfc").focus();

	var idemisorfiscal = <?php echo $idemisorfiscal ?>;

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		if (validForm()){
		    
		    var queryString = $(this).serialize();	

            // alert(queryString);

			var IdEmiFis = (idemisorfiscal==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:26, t:IdEmiFis, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-EMIFIS-PROP-"+idemisorfiscal});
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

	function getEmiFis(IdEmiFis){
		$("#preloaderPrincipal").show();
		$.post(obj.getValue(0) + "data/", {o:26, t:10006, c:IdEmiFis, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					idemisorfiscal = json[0].idemisorfiscal;
					$("#rfc").val(json[0].rfc);
					$("#razon_social").val(json[0].razon_social);
					$("#calle").val(json[0].calle);
					$("#num_ext").val(json[0].num_ext);
					$("#num_int").val(json[0].num_int);
					$("#colonia").val(json[0].colonia);
					$("#localidad").val(json[0].localidad);
					$("#estado").val(json[0].estado);
					$("#pais").val(json[0].pais);
                    $("#cp").val(json[0].cp);
                    $("#serie").val(json[0].serie);
                    $("#status_emisor_fiscal").prop("checked",json[0].status_emisor_fiscal==1?true:false);
                    $("#is_iva").prop("checked",json[0].is_iva==1?true:false);
                    $("#tipo_comprobante").val(json[0].tipo_comprobante);
                    $("#title").html("Reg: " + json[0].idemisorfiscal);

					$("#preloaderPrincipal").hide();

                    $("#rfc").focus();

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

		if($("#rfc").val().length <= 0){
			alert("Faltan el RFC");
			$("#rfc").focus();
			return false;
		}

		return true;

	}



	if (idemisorfiscal<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
        $("#rfc").focus();
	}else{ // Editar Registro
		$("#title").html("Editando la EmiFis: "+idemisorfiscal);
		getEmiFis(idemisorfiscal);
	}

	var stream = io.connect(obj.getValue(4));


});

</script>