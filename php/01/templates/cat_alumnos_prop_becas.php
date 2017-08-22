<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idalumno  = $_POST['idalumno'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmCatAluListBecas0" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li >
				<a data-toggle="tab" href="#becas">
					<i class="orange fa fa-life-ring bigger-110"></i>
					Becas
				</a>
			</li>


		</ul>

		<div class="tab-content">


			<div id="becas" class="tab-pane active">

				<div class="form-group ">
			    	<label for="beca_sep" class="col-lg-2 control-label">Beca SEP</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="beca_sep" name="beca_sep" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Beca otorgada por la SEP" value="0.00" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="beca_arji" class="col-lg-2 control-label">Beca Colegio</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="beca_arji" name="beca_arji" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Beca otorgada por el Colegio"  value="0.00" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="beca_sp" class="col-lg-2 control-label">Beca S.P.F.</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="beca_sp" name="beca_sp" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Beca otorgada por la Sociedad de Padres de Familia"  value="0.00" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="beca_bach" class="col-lg-2 control-label">Beca Bachilleres</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="beca_bach" name="beca_bach" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Beca otorgada por Colegio de Bachilleres"  value="0.00" >
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idalumno" id="idalumno" value="<?php echo $idalumno; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
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

	var lc = parseInt(localStorage.IdUserNivelAcceso,0);

	// var stream = io.connect(obj.getValue(4));

	$("#preloaderPrincipal").hide();

	var idalumno = <?php echo $idalumno ?>;

	function getAlumno(IdAlumno){
		$.post(obj.getValue(0) + "data/", {o:5, t:10, c:IdAlumno, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					$("#beca_sep").val(json[0].beca_sep);
					$("#beca_arji").val(json[0].beca_arji);
					$("#beca_sp").val(json[0].beca_sp);
					$("#beca_bach").val(json[0].beca_bach);

					$("#beca_sep").focus();
				}
		},'json');
	}

    $("#frmCatAluListBecas0").unbind("submit");
	$("#frmCatAluListBecas0").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	

	    
	    // alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
            $.post(obj.getValue(0) + "data/", {o:5, t:3, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-ALUMNOS_BECAS_CAJA-PROP-"+idalumno});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").empty();
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

	$("#closeFormUpload").on("click",function(event){
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

		return true;

	}

	$("#title").html("Editando el registro: "+idalumno);
	getAlumno(idalumno);


});

</script>