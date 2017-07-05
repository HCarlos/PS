<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgrumat  = $_POST['idgrumat'];
$idgrupo  = $_POST['idgrupo'];
$grupo = $_POST['grupo'];
$grado = $_POST['grado'];
$idciclo  = $_POST['idciclo'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmData2" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					Alumnos Asignados
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="idalumno" class="col-lg-2 control-label">Alumnos</label>
			    	<div class="col-lg-8">
						<select class="form-control "  name="idalumno" id="idalumno" size="1" >
						</select>

		      		</div>
			    	<div class="col-lg-2">
						<a href="#" class="btn btn-minier btn-success" id="addIdBolGruMatAlu">Agregar</a>
		      		</div>
			    </div>
				<div class="clearfix"></div>
				<div class="form-group ">
			    	<label for="lstAlumnos" class="col-lg-2 control-label">Listado</label>
			    	<div class="col-lg-10">
						<select class="form-control"  name="lstAlumnos" id="lstAlumnos" size="31" multiple="multiple" style="height: 14em;">
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label class="col-lg-2 control-label"></label>
			    	<div class="col-lg-10">
						<span class="label label-large label-yellow arrowed-in pull-left" id="lbl01"></span>
						<a href="#" class="btn btn-minier btn-danger pull-right" id="removeIdBolGruMatAlu">Quitar</a>


		      		</div>
			    </div>


			</div>

		</div>

	    <input type="hidden" name="idgrumat" id="idgrumat" value="<?php echo $idgrumat; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
		<div class="form-actions" >
			<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-close"></i>Regresar</button>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {


	$("#preloaderPrincipal").hide();

	var Grupo = '<?php echo $grupo; ?>';
	var idgrumat = <?php echo $idgrumat; ?>;
	var idgrupo = <?php echo $idgrupo; ?>;
	var IdCiclo = <?php echo $idciclo; ?>;

	$("#closeProp").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});


	function getAlumnos(){

	    $("#idalumno").html('');
	    var nc = "u="+localStorage.nc+"&idgrupo="+idgrupo+"&idciclo="+IdCiclo;

	    $.post(obj.getValue(0)+"data/", { o:1, t:14, p:0,c:nc,from:0,cantidad:0, s:" order by alumno asc " },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idalumno").append('<option value="'+item.data+'" > '+item.label+'</option>');
	            });



	        }, "json"
	    );  
	}

	function getListAlumnos(){

	    $("#lstAlumnos").html('');
	    var nc = "u="+localStorage.nc+"&idgrumat="+idgrumat;

	    $.post(obj.getValue(0)+"data/", { o:1, t:15, p:0,c:nc,from:0,cantidad:0, s:" order by alumno asc " },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#lstAlumnos").append('<option value="'+item.data+'" > '+item.label+'</option>');
	            });
	           	$("#lbl01").html(json.length+" alumnos")


	        }, "json"
	    );  
	}



	$("#addIdBolGruMatAlu").on("click",function(event){
		event.preventDefault();
		var idgrualu = $("#idalumno").val();
    	var y = "idgrumat="+idgrumat+"&idgrualu="+idgrualu+"&u="+localStorage.nc;
	    $.post(obj.getValue(0) + "data/", {o:17, t:5, c:y, p:2, from:0, cantidad:0, s:''},
	    function(json) {
	    		if (json[0].msg=="OK"){
					$("#preloaderPrincipal").hide();
					getListAlumnos();
				}else{
					$("#preloaderPrincipal").hide();
					alert(json[0].msg);	
				}
		}, "json");
	});


	$("#removeIdBolGruMatAlu").on("click",function(event){
		event.preventDefault();
		var resp = confirm("Si quita este(os) alumno(os), puede perder información relacionada con su Boleta de Caificaciones. \n\n¿Desea continuar?");
		if (!resp) return false;

		$("#preloaderPrincipal").show();
		var y="";  
		$("select[name='lstAlumnos'] option:selected").each(function () {
    		y += y==''?$(this).val():','+$(this).val();
		});					
		if (y != "" ){
		    $.post(obj.getValue(0) + "data/", {o:17, t:4, c:y, p:2, from:0, cantidad:0, s:''},
		    function(json) {
		    		if (json[0].msg=="OK"){
						$("#preloaderPrincipal").hide();
						getListAlumnos();
					}else{
						$("#preloaderPrincipal").hide();
						alert(json[0].msg);	
					}
			}, "json");
		}
			
	});


getAlumnos();
getListAlumnos();


});

</script>