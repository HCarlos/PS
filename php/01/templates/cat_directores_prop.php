<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$iddirector  = $_POST['iddirector'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmDataDirectoresCatList" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					Director
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="idprofesor" class="col-lg-2 control-label">Director</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="idprofesor" id="idprofesor" size="1" autofocus>
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="idnivel" class="col-lg-2 control-label">Nivel</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="idnivel" id="idnivel" size="1">
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_director" class="col-lg-2 control-label">Status</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="status_director" id="status_director" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="iddirector" id="iddirector" value="<?php echo $iddirector; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Cerrar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Agregar</button>
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

	var iddirector = <?php echo $iddirector ?>;

	function getdirector(IDDirector){
		$.post(obj.getValue(0) + "data/", {o:23, t:501, c:IDDirector, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#idprofesor").val(json[0].idprofesor);
					$("#idnivel").val(json[0].idnivel);
					$("#status_director").val(json[0].status_director);
				}
		},'json');
	}

    $("#frmDataDirectoresCatList").unbind("submit");
	$("#frmDataDirectoresCatList").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    //alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
			var IdDirector = (iddirector==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:23, t:IdDirector, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-DIRECTORES-PROP-"+iddirector});
						$("#preloaderPrincipal").hide();
						$("#divUploadImage").modal('hide');
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        			}
        	}, "json");
		}else{
			$("#preloaderPrincipal").hide();
		}

	});

	$("#closeProp").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});

	function validForm(){

		if($("#idprofesor").val() <= 0){
			alert("Faltan el Director");
			$("#idprofesor").focus();
			return false;
		}

		return true;

	}


	function getProfesores(){
	    var nc = "u="+localStorage.nc;
	    $.post(obj.getValue(0)+"data/", { o:1, t:12, p:0,c:nc,from:0,cantidad:0, s:" order by nombre_profesor asc " },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idprofesor").append('<option value="'+item.data+'" > '+item.label+'</option>');
	            });
	            
				if (iddirector<=0){ // Nuevo Registro
					$("#title").html("Nuevo registro");
				}else{ // Editar Registro
					$("#title").html("Editando el registro: "+iddirector);
					getdirector(iddirector);
				}
				$("#idprofesor").focus();


	        }, "json"
	    );  
	}

	function getNiveles(){
	    var nc = "u="+localStorage.nc;
	    $("#idnivel").html('');
	    $.post(obj.getValue(0)+"data/", { o:1, t:3, p:0,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idnivel").append('<option value="'+item.data+'"> '+item.label+'</option>');
	            });
	            getProfesores();    
	        }, "json"
	    );  
	}

	getNiveles();

});

</script>