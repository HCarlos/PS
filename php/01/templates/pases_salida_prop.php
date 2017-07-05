<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user           = $_POST['user'];
$idpsa          = $_POST['idpsa'];
$param          = $_POST['param'];
$idgrupo        = $_POST['idgrupo'];
$clave_nivel    = $_POST['clave_nivel'];
$idciclo        = $_POST['idciclo'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title">Pases de Salida de Alumno</h3>
	<form id="frmData" role="form">

                <table class="wd100prc">
                    <tr>
                        <td >
                        	<label for="referencia"><strong class="lblForm100">Referencia:</strong> 
                                <span class="add-on"><i class="icon-asterisk red"></i></span>
					    	    <input type="text" class="altoMoz wd80prc" id="referencia" name="referencia" required autofocus>
                            </label>
                        </td>
                        <td></td>
                    </tr>
                </table>

                <table class="wd60prc">
                    <tr>
                        <td>
                        	<label for="motivos"><strong class="lblForm100">Motivos:</strong> 
                                <span class="add-on"><i class="icon-asterisk red"></i></span>
                                <select class=" altoMoz" name="motivos" id="motivos" size="1" required>
                                	<option value="Ninguno" selected>Ninguno</option>
                                	<option value="Familia">Familiar</option>
                                	<option value="Por enfermedad">Por enfermedad</option>
                                	<option value="Por accidente">Por accidente</option>
                                	<option value="Por consulta médica">Por consulta médica</option>
                                	<option value="Por Viaje">Por Viaje</option>
                                	<option value="Otro">Otro</option>
                                </select>
                            </label>
                        </td>
                        <td>
                            <div class="hide" id="OtroMotivo">
                        	    <label for="otro_motivo">Otro: 
					    	      <input type="text" class="altoMoz wd80prc" id="otro_motivo" name="otro_motivo" >
                                </label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                        	<label for="idautorizo"><strong class="lblForm100">Autorización:</strong> 
                                <span class="add-on"><i class="icon-asterisk red"></i></span>
                                <select class=" altoMoz" name="idautorizo" id="idautorizo" size="1" required>
                                </select>
                            </label>
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>
                        	<label for="regreso"><strong class="lblForm100">Regreso:</strong> 
                                <span class="add-on"><i class="icon-asterisk red"></i></span>
                                <select class=" altoMoz" name="regreso" id="regreso" size="1" required>
                                	<option value="Una hora" selected>Una hora</option>
                                	<option value="Dos horas">Dos horas</option>
                                	<option value="Tres horas">Tres horas</option>
                                	<option value="Hasta mañana">Hasta mañana</option>
                                	<option value="Hasta pasado mañana">Hasta pasado mañana</option>
                                	<option value="Dentro de una semana">Dentro de una semana</option>
                                	<option value="No sabe">No sabe</option>
                                	<option value="Otro">Otro</option>
                                </select>
                            </label>
                        </td>
                        <td>
                            <div class="hide" id="OtroRegreso">
                            	<label for="otro_regreso">Otro: 
    					    	      <input type="text" class="altoMoz wd80prc" id="otro_regreso" name="otro_regreso" >
                                </label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                        	<label for="recoge"><strong class="lblForm100">Lo(a) Recoge:</strong> 
                                <span class="add-on"><i class="icon-asterisk red"></i></span>
                                <select class=" altoMoz" name="recoge" id="recoge" size="1" required>
                                	<option value="Chofer" selected>Chofer</option>
                                	<option value="Mamá">Mamá</option>
                                	<option value="Papá">Papá</option>
                                	<option value="Tutor">Tutor</option>
                                	<option value="Tía">Tía</option>
                                	<option value="Otro">Otro</option>
                                </select>
                            </label>
                        </td>
                        <td>
                            <div class="hide" id="OtroRecoge">
                            	<label for="otro_recoge">Otro: 
    					    	      <input type="text" class="altoMoz wd80prc" id="otro_recoge" name="otro_recoge" >
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>    
                <table class="wd100prc">
                    <tr>
                        <td>
                        	<label for="comentario"><strong class="lblForm100">Comentario:</strong> 
                                <span class="add-on"><i class="icon-asterisk white"></i></span>
    					    	<input type="text" class="altoMoz wd80prc" id="comentario" name="comentario"  >
                            </label>
                        </td>
                        <td></td>
                    </tr>

                </table>    

	    <input type="hidden" name="idgrupo" id="idgrupo" value="<?= $idgrupo; ?>">
        <input type="hidden" name="idciclo" id="idciclo" value="<?= $idciclo; ?>">
        <input type="hidden" name="clave_nivel" id="clave_nivel" value="<?= $clave_nivel; ?>">
        <input type="hidden" name="idpsa" id="idpsa" value="<?= $idpsa; ?>">
	    <input type="hidden" name="param" id="param" value="<?= $param; ?>">
	    <input type="hidden" name="user" id="user" value="<?= $user; ?>">
        <input type="hidden" name="fecha" id="fecha" value="<?= date('Y-m-d'); ?>">
        <input type="hidden" name="status_psa" id="status_psa" value="1">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Cerrar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#clave").focus();

	var idpsa = <?= $idpsa ?>;
    var IdUNA = localStorage.IdUserNivelAcceso;
    var Param = localStorage.Param1;


	function getPSA00(IdPSA){
		$.post(obj.getValue(0) + "data/", {o:51, t:11, c:IdPSA, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#referencia").val(json[0].referencia);
                    $("#motivos").val(json[0].motivos);
                    $("#otro_motivo").val(json[0].otro_motivo);
                    $("#idautorizo").val(json[0].idautorizo);
                    $("#recoge").val(json[0].recoge);
                    $("#otro_recoge").val(json[0].otro_recoge);
                    $("#regreso").val(json[0].regreso);
                    $("#otro_regreso").val(json[0].otro_regreso);
                    $("#comentario").val(json[0].comentario);

                    if ( $("#motivos").val() == "Otro" ){
                        $("#OtroMotivo").removeClass('hide');
                    }

                    if ( $("#regreso").val() == "Otro" ){
                        $("#OtroRegreso").removeClass('hide');
                    }

                    if ( $("#recoge").val() == "Otro" ){
                        $("#OtroRecoge").removeClass('hide');
                    }


				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    // alert(queryString)
	    
	    // return false;

		// var data = new FormData();

		// if (validForm()){
			var IdPSA = (idpsa==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:51, t:IdPSA, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-ADD_ALUMNOS_PSA-PROP-"+IdPSA});
                        $("#preloaderPrincipal").hide();
                        $("#contentLevel3").hide(function(){
                            $("#contentLevel3").empty();
                            $("#contentProfile").show();
                        });
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        			}
        	}, "json");
		// }else{
		// 	$("#preloaderPrincipal").hide();
		// }

	});

    $("#closeFormUpload").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").empty();
            $("#contentProfile").show();
        });
        resizeScreen();
        return false;
    });

	function validForm(){

		if ($("#observaciones").val().length <= 0) {
			alert("Faltan el Pases de Salida de Alumnos");
			$("#observaciones").focus();
			return false;
		}

		return true;

	}

    function getDirectores(){
        var nc = "u="+localStorage.nc+"&clavenivelacceso="+IdUNA;
        $("#idautorizo").empty();
        $.post(obj.getValue(0)+"data/", { o:51, t:51, p:51, c:nc, from:0, cantidad:0, s:Param },
            function(json){
               $.each(json, function(i, item) {
                    $("#idautorizo").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });

                if (idpsa<=0){ // Nuevo Registro
                    $("#title").html("Nuevo registro");
                }else{ // Editar Registro
                    $("#title").html("Editando el registro: "+idpsa);
                    getPSA00(idpsa);                        
                }

            }, "json"
        );  
    }

    $("#motivos").on("change",function(event){
        event.preventDefault();
        if ( $(this).val() == "Otro" ){
            $("#OtroMotivo").removeClass('hide');
            $("#otro_motivo").focus();
        }else{
            $("#otro_motivo").val("") ;
            $("#OtroMotivo").addClass('hide');
        }
    });

    $("#regreso").on("change",function(event){
        event.preventDefault();
        if ( $(this).val() == "Otro" ){
            $("#OtroRegreso").removeClass('hide');
            $("#otro_regreso").focus();
        }else{
            $("#otro_regreso").val("") ;
            $("#OtroRegreso").addClass('hide');
        }
    });

    $("#recoge").on("change",function(event){
        event.preventDefault();
        if ( $(this).val() == "Otro" ){
            $("#OtroRecoge").removeClass('hide');
            $("#otro_recoge").focus();
        }else{
            $("#otro_recoge").val("") ;
            $("#OtroRecoge").addClass('hide');
        }
    });

    getDirectores();


});

</script>