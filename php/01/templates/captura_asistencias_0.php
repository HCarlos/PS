<?php

include("includes/metas.php");

$idgrumat = $_POST['idgrumat'];
$materia = 	$_POST['materia'];
$num_eval = $_POST["num_eval"];

$grupo = $_POST['grupo'];
$idgrupo = $_POST['idgrupo'];
$profesor = $_POST['profesor'];

?>
<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-default">
			<h3 class="smaller  lighter orange">
				<small><b class="orange"><?= $grupo; ?></b> <span class="grey">|</span> <b class="orange"><?= $materia; ?></b> </small>
			</h3>
			<div class="widget-toolbar border pull-right">
			    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed btnCloseCapCalMKB002 " id="btnCloseCapCalMKB002" style="margin: 0 1em !important;" >
			        <i class="icon-angle-left icon-on-right"></i>
			        Regresar
			    </button>
			</div>


			<div class="widget-toolbar pull-right black">
			    <div class="control-group" >
					<label class="control-label grey" for="cmbFechaAsistencia">Fecha:</label>
					<input class="date-picker input-small" style="margin-top: 0.7em;" id="cmbFechaAsistencia" name="cmbFechaAsistencia" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
				</div>
			</div>

			<div class="widget-toolbar pull-right">
			    <div class="control-group action-buttons" >
					<a href="#"  id="btnDeleteAsistDate01" title="Elimina esta lista de asistencia.">
						<i class="fa fa-trash bigger-150 red  "></i>
					</a>
				</div>
			</div>

			<div class="widget-toolbar pull-right black">
			    <div class="control-group action-buttons" >
					<a class="white" href="#"  id="btnPrintListaAsistencia01" title="Imprime todas las Asistencias de esta Materia.">
						<i class="fa fa-print bigger-150 cafe"></i>
					</a>
				</div>
			</div>

		</div>
		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

				<form class="form"role="form" id="frmCapAsist0">
					<table id="tblMKBCap0" role="table" class="bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>NOMBRE  DEL  ALUMNO</th>
								<th>ASISTENCIA</th>
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
								Guardar Lista de Asistencia
							</button><span id="spLoading1" class="marginLeft1em"><i class="fa fa-spinner fa-spin orange" aria-hidden="true"></i> Guardando datos, por favor espere...</span>
						</div>

					</div>


				</form>

				</div>
			</div>
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
	var Num_Eval = <?= $num_eval ?>;

	var Grupo = '<?= $grupo ?>';
	var IdGrupo = <?= $idgrupo ?>;
	var Profesor = '<?= $profesor ?>';

	var IsExist = false;

	$("#preloaderPrincipal").hide();
	$("#spLoading1").hide();

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

	function validDate(){
		$("#cmdSaveCapCalMKB023").prop("disabled",true);
		var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&fecha="+$("#cmbFechaAsistencia").val();
		
		$.post(obj.getValue(0)+"data/", { o:0, t:2, p:54, c:nc, from:0, cantidad:0, s:"" },
			function(json){
				if ( json.length >= 1 ){
					IsExist = true;
					validDateExist(json);
				}else{
					IsExist = false;
					validDateNotExist();
				}
			},'json'
		);		
	}

	function validDateNotExist(){

       	$("#preloaderPrincipal").show();
       	$("#tblMKBCap0 > tbody").empty();
       	var It = 1;
		var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat;
		// alert(nc);
		$.post(obj.getValue(0)+"data/", { o:0, t:1, p:54, c:nc, from:0, cantidad:0, s:"" },
			function(json){
				var InputObs;
				$.each(json, function(i, item) {
						var tr =  "<tr class=''>";
							tr += "<td class='center'>"+item.num_lista+"</td>";
							tr += "<td>"+item.alumno+"</td>";
							tr += "<td>";
							tr += "			<div class='controls'>";
							tr += "				<label>";
							tr += "					<input name='or-"+item.idboleta+"' id='or-"+item.idboleta+"-0' class='ace' type='radio' checked tabindex="+It+" value='1'  title='Asistencia'>";
							tr += "					<span class='lbl'> A</span>";
							tr += "				</label>";
							It++;
							// tr += "				<label>";
							// tr += "					<input name='or-"+item.idboleta+"' id='or-"+item.idboleta+"-1' class='ace' type='radio' tabindex="+It+" value='2' title='Retardo'>";
							// tr += "					<span class='lbl'> R</span>";
							// tr += "				</label>";
							// It++;
							tr += "				<label>";
							tr += "					<input name='or-"+item.idboleta+"' id='or-"+item.idboleta+"-2' class='ace' type='radio' tabindex="+It+" value='0' title='Falta'>";
							tr += "					<span class='lbl'> F</span>";
							tr += "				</label>";
							It++;
							tr += "				<label>";
							tr += "					<input name='or-"+item.idboleta+"' id='or-"+item.idboleta+"-3' class='ace' type='radio' tabindex="+It+" value='3' title='Doble Falta'>";
							tr += "					<span class='lbl'> FF</span>";
							tr += "				</label>";
							tr += "			</div>";
							tr += "</td>";
							InputObs = "<input type='text' value='' name='obs01-"+item.idboleta+"' id='obs01-"+item.idboleta+"' class='Input-Cal tbl350W' >";						
							tr += "<td id='tdobs1-"+item.idboleta+"'>"+InputObs+"</td>";
							tr += "</tr>";
						It++;
					$("#tblMKBCap0 > tbody").append(tr);
				});
               	$("#preloaderPrincipal").hide();
           		$("#cmdSaveCapCalMKB023").prop("disabled",false);
			}, "json"
		);
	}	


	function validDateExist(json){

       	$("#preloaderPrincipal").show();
       	$("#tblMKBCap0 > tbody").empty();
       	var It = 1;       	
		$.each(json, function(i, item) {
				

				var chk0 = parseInt(item.asistencia)==0?' checked ':'';
				var chk1 = parseInt(item.asistencia)==1?' checked ':'';
				var chk2 = parseInt(item.asistencia)==2?' checked ':'';
				var chk3 = parseInt(item.asistencia)==3?' checked ':'';
				var tr =  "<tr class=''>";
					tr += "<td class='center'>"+item.num_lista+"</td>";
					tr += "<td>"+item.alumno+"</td>";
					tr += "<td>";
					tr += "			<div class='controls'>";
					tr += "				<label>";
					tr += "					<input name='or-"+item.idbolasist+"' id='or-"+item.idbolasist+"-0' class='ace' type='radio' "+chk1+" tabindex="+It+" value='1' title='Asistencia'>";
					tr += "					<span class='lbl'> A</span>";
					tr += "				</label>";
					It++;
					// tr += "				<label>";
					// tr += "					<input name='or-"+item.idbolasist+"' id='or-"+item.idbolasist+"-1' class='ace' type='radio' "+chk2+" tabindex="+It+" value='2' title='Retardo'>";
					// tr += "					<span class='lbl'> R</span>";
					// tr += "				</label>";
					// It++;
					tr += "				<label>";
					tr += "					<input name='or-"+item.idbolasist+"' id='or-"+item.idbolasist+"-2' class='ace' type='radio' "+chk0+" tabindex="+It+" value='0' title='Falta'>";
					tr += "					<span class='lbl'> F</span>";
					tr += "				</label>";
					It++;
					tr += "				<label>";
					tr += "					<input name='or-"+item.idbolasist+"' id='or-"+item.idbolasist+"-3' class='ace' type='radio' "+chk3+" tabindex="+It+" value='3' title='Doble Falta'>";
					tr += "					<span class='lbl'> FF</span>";
					tr += "				</label>";
					tr += "			</div>";
					tr += "</td>";
					InputObs = "<input type='text' value='"+item.observaciones+"' name='obs01-"+item.idbolasist+"' id='obs01-"+item.idbolasist+"' class='Input-Cal tbl350W' >";						
					tr += "<td id='tdobs1-"+item.idbolasist+"'>"+InputObs+"</td>";
					tr += "</tr>";
				It++;
			$("#tblMKBCap0 > tbody").append(tr);
		});
       	$("#preloaderPrincipal").hide();
   		$("#cmdSaveCapCalMKB023").prop("disabled",false);
	}	




	$("#frmCapAsist0").on("submit",function(event){
		event.preventDefault();

		var Tipo = !IsExist ? 0 : 1;
		var fecha = $("#cmbFechaAsistencia").val();

		if (!IsExist){
			var r = confirm("Desea crear una Lista de Asistencia en esta Fecha: "+fecha+"?");
			if (r !== true) {
				return false;
			}
		}

       	$("#preloaderPrincipal").show();
		$("#cmdSaveCapCalMKB023").prop("disabled",true);
		$("#spLoading1").show();

		var xIdBolParMKB = '';
		var xIdBolParMKBCal = '';
		var xIdBolObsMKBCal = '';

		$("#frmCapAsist0").find('input[type=radio]:checked').each(function () {
			var v1 = $(this).attr('id').split('-');
			var v0 = $(this).val()=='' ? 0 : $(this).val();

			if (v1[0]=="or"){
				xIdBolParMKB += xIdBolParMKB == '' ? v1[1] : '|'+v1[1];
				xIdBolParMKBCal += xIdBolParMKBCal == '' ? v0 : '|'+v0;
			}	

		});

		$("#frmCapAsist0").find('input').each(function () {
			var v1 = $(this).attr('id').split('-');
			var v2 = $(this).val()=='' ? ' ' : $(this).val();

			if (v1[0]=="obs01"){
				xIdBolObsMKBCal += xIdBolObsMKBCal == '' ? v2 : '|'+v2;
			}

		});


		var nc = "u="+localStorage.nc+"&cal0="+xIdBolParMKB+"&cal1="+xIdBolParMKBCal+"&obs1="+xIdBolObsMKBCal+"&fecha="+fecha+"&evaluacion="+Num_Eval;
		
		$.post(obj.getValue(0)+"data/", { o:47, t:Tipo, p:52, c:nc, from:0, cantidad:0, s:"" },
			function(json){
        		if (json[0].msg=="OK"){
        			alert("Lista de Asistencia guardada con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-CAPLISTASIST-PROP-"+localStorage.grupo_cal});
					validDate();					
					$("#preloaderPrincipal").hide();
					$("#cmdSaveCapCalMKB023").prop("disabled",false);
					$("#spLoading1").hide();
    			}else{
					$("#preloaderPrincipal").hide();
					$("#cmdSaveCapCalMKB023").prop("disabled",false);
					$("#spLoading1").hide();
    				alert("Error: "+json[0].msg);	
    			}
				
			}, "json"
		);

        return false;

	});



	$("#btnPrintListaAsistencia01").on("click",function(event){
		event.preventDefault();

			var logoEmp =obj.getConfig(100,0); 
			var nc = "u=" + localStorage.nc+
					"&grupo=" + localStorage.grupo_cal + 
					"&idgrupo=" + IdGrupo + 
					"&idgrumat=" + IdGruMat+
					"&materia=" + Materia+
					"&profesor=" + Profesor+
					"&eval=" + Num_Eval+
					"&logoEmp=" + logoEmp;
			
			

	        var PARAMS = {o:50, t:7, c:nc, p:54, from:0, cantidad:0, s:''};  
	        var url = obj.getValue(0)+"lista-asistencias-profesor-1/";

	        var temp=document.createElement("form");
	        temp.action=url;
	        temp.method="POST";
	        temp.target="_blank";
	        temp.style.display="none";
	        for(var x in PARAMS) {
	            var opt=document.createElement("textarea");
	            opt.name=x;
	            opt.value=PARAMS[x];
	            temp.appendChild(opt);
	        }
	        document.body.appendChild(temp);
	        temp.submit();
	        return temp;


	});	



	$("#btnDeleteAsistDate01").on("click",function(event){

		event.preventDefault();

		var fecha = $("#cmbFechaAsistencia").val();

		if (!IsExist){
			alert("No se puede eliminar esta Lista de Asistencia porque que no existe.");
			return false;
		}

		var r = confirm("Desea eiminar la Lista de Asistencia que esta visualizando?");
		if (r !== true) {
			return false;
		}


       	$("#preloaderPrincipal").show();

		var xIdBolParMKB = '';
		var xIdBolParMKBCal = '';
		var xIdBolObsMKBCal = '';

		$("#frmCapAsist0").find('input[type=radio]:checked').each(function () {
			var v1 = $(this).attr('id').split('-');
			var v0 = $(this).val()=='' ? 0 : $(this).val();

			if (v1[0]=="or"){
				xIdBolParMKB += xIdBolParMKB == '' ? v1[1] : '|'+v1[1];
				xIdBolParMKBCal += xIdBolParMKBCal == '' ? v0 : '|'+v0;
			}	

		});

		$("#frmCapAsist0").find('input').each(function () {
			var v1 = $(this).attr('id').split('-');
			var v2 = $(this).val()=='' ? ' ' : $(this).val();

			if (v1[0]=="obs01"){
				xIdBolObsMKBCal += xIdBolObsMKBCal == '' ? v2 : '|'+v2;
			}

		});


		var nc = "u="+localStorage.nc+"&cal0="+xIdBolParMKB+"&cal1="+xIdBolParMKBCal+"&obs1="+xIdBolObsMKBCal+"&fecha="+fecha+"&evaluacion="+Num_Eval;
		
		$.post(obj.getValue(0)+"data/", { o:47, t:2, p:52, c:nc, from:0, cantidad:0, s:"" },
			function(json){
        		if (json[0].msg=="OK"){
        			alert("Lista de Asistencia eliminada con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-CAPLISTASIST-PROP-"+localStorage.grupo_cal});
					validDate();
					$("#preloaderPrincipal").hide();
    			}else{
					$("#preloaderPrincipal").hide();
    				alert("Error: "+json[0].msg);	
    			}
				
			}, "json"
		);

        return false;
	});

	validDate();

	$('.date-picker').datepicker({
    	format: 'yyyy-mm-dd',
		autoclose: true
	});

	$('.date-picker').on('changeDate', function(event){
	    $(this).datepicker('hide');
	    validDate();
	});

});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>