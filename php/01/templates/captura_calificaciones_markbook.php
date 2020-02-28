<?php

include("includes/metas.php");

$idgrumat = $_POST['idgrumat'];
$materia = 	$_POST['materia'];
$idgrupo = 	$_POST['idgrupo'];
$idgrumatcon = $_POST['idgrumatcon'];
$idgrumatconmkb = $_POST['idgrumatconmkb'];
$num_eval = $_POST["num_eval"];
$configmat = $_POST["configmat"];
$configmkb = $_POST["configmkb"];
$grupo = $_POST['grupo'];

?>
<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-default">
			<h3 class="smaller  lighter orange">
				<small><b class="orange"><?= $grupo; ?></b> <span class="grey">|</span> <b class="orange"><?= $materia; ?></b> <span class="grey">|</span> <b class="orange"><?= $configmat; ?></b> <span class="grey">|</span> <b class="orange"><?= $configmkb; ?></b></small>
			</h3>
			<div class="widget-toolbar border pull-right">
			    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed btnCloseCapCalMKB002 " id="btnCloseCapCalMKB002" style="margin: 0 1em !important;" >
			        <i class="icon-angle-left icon-on-right"></i>
			        Regresar
			    </button>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

				<form class="form"role="form" id="frmCapCalMKB030">
					<table id="tblMKBCap0" role="table" class="bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>NOMBRE  DEL  ALUMNO</th>
								<th>CAL</th>
								<th>COMENTARIOS</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

					<input type="hidden" name="idgrumat" id="idgrumat" value="<?= $idgrumat; ?>">
					<input type="hidden" name="idgrupo" id="idgrupo" value="<?= $idgrupo; ?>">
					<input type="hidden" name="idgrumatcon" id="idgrumatcon" value="<?= $idgrumatcon; ?>">
					<input type="hidden" name="idgrumatconmkb" id="idgrumatconmkb" value="<?= $idgrumatconmkb; ?>">
					<input type="hidden" name="num_eval" id="num_eval" value="<?= $num_eval; ?>">

					<div class="col-lg-12">

						<div class="form-actions center">
							<button class="btn btn-primary" type="submit" id="cmdSaveCapCalMKB023">
								<i class="icon-ok icon-on-left bigger-130"></i>
								Guardar Calificaciones
							</button><span id="spLoading1" class="marginLeft1em"><i class="fa fa-spinner fa-spin orange" aria-hidden="true"></i> Guardando datos, por favor espere...</span>
						</div>

					</div>


				</form>

				</div>
			</div>
		</div>	
		<div id="sop">
		</div>
	</div>
</div>
<style type="text/css">
	
</style>

<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var IdGruMat = <?= $idgrumat ?>;
	var Materia = 	'<?= $materia ?>';
	var IdGrupo = 	<?= $idgrupo ?>;
	var IdGruMatCon = <?= $idgrumatcon ?>;
	var IdGruMatConMKB = <?= $idgrumatconmkb ?>;
	var Num_Eval = <?= $num_eval ?>;

	localStorage.SOP = navigator.platform;
	$("#sop").html(localStorage.SOP);

	$("#spLoading1").hide();
	$("#preloaderPrincipal").hide();
	var IdUNA = localStorage.IdUserNivelAcceso;

	$("#btnCloseCapCalMKB002").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});



	function getCalMKB(){

		var nc = "u="+localStorage.nc+"&idgrumatconmkb="+IdGruMatConMKB;
       	$("#preloaderPrincipal").show();
       	$("#tblMKBCap0 > tbody").empty();

       	// alert(nc);
       	var It = 1;
		$.post(obj.getValue(0)+"data/", { o:0, t:0, p:54, c:nc, from:0, cantidad:0, s:" order by num_lista asc " },
			function(json){
				$.each(json, function(i, item) {
					var defcolorep = parseInt(item.calificacion,0)<60?'colorreprobado':'';
					var tr =  "<tr class='"+defcolorep+"'>";
						tr += "<td class='center'>"+item.num_lista+"</td>";
						tr += "<td>"+item.ap_paterno+' '+item.ap_materno+' '+item.nombre+"</td>";
						tr += "<td class='textRight td-Input-Cal'><input type='text' value='"+parseInt(item.calificacion,0)+"' class='calif Input-Cal' maxlength='3' name='idbolparmkb-"+item.idbolparmkb+"'  id='idbolparmkb-"+item.idbolparmkb+"' tabindex="+It+" ></td>";
						// tr += "<td> <input type='text' value='"+item.observaciones+"' name='obs-"+item.observaciones+"' id='obs-"+item.observaciones+"' class='Input-Cal tbl350W'> </td>";
						tr += "<td id='tdobs0-"+item.idbolparmkb+"'></td>";
						tr += "</tr>";
						It++;
					$("#tblMKBCap0 > tbody").append(tr);
				});
				
				$.each(json, function(i, item) {
					var InputObs = "<input type='text' value='"+item.observaciones+"' name='obs0-"+item.idbolparmkb+"' id='obs0-"+item.idbolparmkb+"' class='Input-Cal tbl350W' tabindex="+It+">";
					$("#tdobs0-"+item.idbolparmkb).html(InputObs);
					It++;
				});


				$( ".calif" ).on('keydown',function(event) {
					console.log(event.keyCode);
					var kLL = obj.getkeyLatLon( event.keyCode );
					if ( kLL == -1 && !event.shiftKey){
						//alert("Caracter no válido ("+event.keyCode+")");
						event.preventDefault();
						$(this).keypress(8);
					}
					
					// alert(event.key+" => "+event.keyCode);

					var arrKey = [];
					if ( 
						(localStorage.SOP == "iPad" && event.key == "*") || 
						(localStorage.SOP == "MacIntel" && event.key == "*") 
						){ 
						//alert(event.key);
						arrKey = [56, 106, 171, 187];
					}else{
						arrKey = [106, 171, 187];
					}


					if ( arrKey.indexOf( parseInt(event.keyCode,0) ) != -1 ){
						$(this).val(evalAsteriskCapCal(event.currentTarget.id));
					}

				});

				$(".calif").focus(function() {
				   $(this).select();
				});		

				$( ".calif" ).on('focusout',function(event) {
					var xs = parseInt($(this).val(),0);
					if (xs > 100){
						$(this).val(evalAsteriskCapCal(event.currentTarget.id,xs));
					}

				});

				$(".calif").on('keyup',function(event) {
					
					var ids;

					if (event.currentTarget.id.indexOf('cond') != -1) {
						ids = 1;
					} else if (event.currentTarget.id.indexOf('obs') != -1) {
						ids = 3;
					}else{
						ids = 2;
					}	
					
					// console.log(event.currentTarget.id);

					if ( $("#"+event.currentTarget.id).val().length >= ids ){
				        event.stopPropagation();
				        event.preventDefault();
				    	var ind = parseInt($("#"+event.currentTarget.id).attr('tabindex'),0)+1;
					 	$("[tabindex='"+ind+"']").focus();
				    	return false;
					};

				});


               $("#preloaderPrincipal").hide();

			}, "json"
		);


	}	



	$("#frmCapCalMKB030").on("submit",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").show();

		var xIdBolParMKB = '';
		var xIdBolParMKBCal = '';
		var xIdBolObsMKBCal = '';

		$("#frmCapCalMKB030").find('input').each(function () {
			var v1 = $(this).attr('id').split('-');
			var v0 = $(this).val()=='' ? 0 : $(this).val();
			var v2 = $(this).val()=='' ? ' ' : $(this).val();

			if (v1[0]=="idbolparmkb"){
				xIdBolParMKB += xIdBolParMKB == '' ? v1[1] : '|'+v1[1];
				xIdBolParMKBCal += xIdBolParMKBCal == '' ? v0 : '|'+v0;
			}	

			if (v1[0]=="obs0"){
				xIdBolObsMKBCal += xIdBolObsMKBCal == '' ? v2 : '|'+v2;
			}

		});

		// alert(xIdBolObsMKBCal);
		// return false;
		$("#cmdSaveCapCalMKB023").prop("disabled",true);
		$("#spLoading1").show();
		var nc = "u="+localStorage.nc+"&cal0="+xIdBolParMKB+"&cal1="+xIdBolParMKBCal+"&obs1="+xIdBolObsMKBCal;
		$.post(obj.getValue(0)+"data/", { o:46, t:1, p:52, c:nc, from:0, cantidad:0, s:"" },
			function(json){
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					//stream.emit("cliente", {mensaje: "PLATSOURCE-CAPCAL-PROP-"+localStorage.grupo_cal});
					getCalMKB();
					$("#preloaderPrincipal").hide();
					$("#cmdSaveCapCalMKB023").prop("disabled",false);
					$("#spLoading1").hide();
    			}else{
    				alert("Error: "+json[0].msg);	
					$("#preloaderPrincipal").hide();
					$("#cmdSaveCapCalMKB023").prop("disabled",false);
					$("#spLoading1").hide();
    			}
				
			}, "json"
		);

        return false;

	});



	getCalMKB();


});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>