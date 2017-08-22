<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idregfis  = $_POST['idregfis'];

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
                            <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
<!--                             <input class="altoMoz" name="rfc" id="rfc" type="text" pattern="^[A-Za-zñ&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9]([A-Za-z0-9]{3})?" required>
 -->
                            <input class="altoMoz" name="rfc" id="rfc" type="text" autofocus>

                      </td>

                        <td><label for="curp" class="marginLeft2em textRight">CURP</label></td>
                        <td>
                            <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
                            <input class="altoMoz" name="curp" id="curp" type="text" pattern="^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$">
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
                        <td><label for="email1" class="textRight">EMail 1</label></td>
                        <td>
                            <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
                            <input class="altoMoz" name="email1" id="email1" type="text" >
                        </td>
                        <td><label for="email2" class="marginLeft2em textRight">Email 2</label></td>
                        <td>
                            <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
                            <input class="altoMoz" name="email2" id="email2" type="text" >
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="is_email" class="textRight">Rec Mail</label></td>
                        <td>
                            <input name="is_email" id="is_email" class="ace ace-switch ace-switch-6" type="checkbox">
                            <span class="lbl"></span>
                        </td>
                        <td><label for="is_extranjero" class="marginLeft2em textRight">Es Extranjero</label></td>
                        <td>
                            <input name="is_extranjero" id="is_extranjero" class="ace ace-switch ace-switch-6" type="checkbox">
                            <span class="lbl"></span>
                        </td>
                        <td><label for="status_regfis" class="marginLeft2em textRight">Estatus</label></td>
                        <td>
                            <input name="status_regfis" id="status_regfis" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="referencia" class="marginTop1em textRight">Referencia</label></td>
                        <td colspan="3">
                            <input class="altoMoz marginTop1em wd100prc" name="referencia" id="referencia" type="text">
                        </td>
                        <td><label for="idfammig" class="marginLeft2em textRight">IdFamMig</label></td>
                        <td>
                            <input class="altoMoz" name="idfammig" id="idfammig" type="text" >
                        </td>
                    </tr>
                  

                </table>


    <input type="hidden" name="idregfis" id="idregfis" value="<?php echo $idregfis; ?>">
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

	var idregfis = <?php echo $idregfis ?>;

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		if (validForm()){
		    
		    var queryString = $(this).serialize();	

			var IdRegFis = (idregfis==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:14, t:IdRegFis, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-REGFIS-PROP-"+idregfis});
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

	function getRegFis(IdRegFis){
		$("#preloaderPrincipal").show();
		$.post(obj.getValue(0) + "data/", {o:14, t:28, c:IdRegFis, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					idregfis = json[0].idregfis;
					$("#rfc").val(json[0].rfc);
					$("#curp").val(json[0].curp);
					$("#razon_social").val(json[0].razon_social);
					$("#calle").val(json[0].calle);
					$("#num_ext").val(json[0].num_ext);
					$("#num_int").val(json[0].num_int);
					$("#colonia").val(json[0].colonia);
					$("#localidad").val(json[0].localidad);
					$("#estado").val(json[0].estado);
					$("#pais").val(json[0].pais);
                    $("#cp").val(json[0].cp);
					$("#email1").val(json[0].email1);
					$("#email2").val(json[0].email2);
					$("#referencia").val(json[0].referencia);
                    $("#idfammig").val(json[0].idfammig);

                    $("#is_email").prop("checked",json[0].is_email==1?true:false);
                    $("#is_extranjero").prop("checked",json[0].is_extranjero==1?true:false);
                    $("#status_regfis").prop("checked",json[0].status_regfis==1?true:false);

                    $("#title").html("Reg: " + json[0].idregfis);

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
			$("#contentProfile").empty();
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


	// getPisos();
	// getAplanados();
	// getPlafones();
	
	// //getMemberFam(idregfis);

	// getUsoSuelo();
	// getNiveles();
	// getCimentaciones();
	// getEstructuras();
	// getMuros();
	// getEntrepisos();


	if (idregfis<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
        $("#rfc").focus();
	}else{ // Editar Registro
		$("#title").html("Editando la RegFis: "+idregfis);
		getRegFis(idregfis);
	}

	// var stream = io.connect(obj.getValue(4));


});

</script>