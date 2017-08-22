<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgrupo  = $_POST['idgrupo'];
$grupo = $_POST['grupo'];
$idciclo = $_POST['idciclo'];

?>

	<h3 class="header smaller lighter blue" id="title">
		<i class="red icon-home bigger-110"></i>
		Control de Pases de Salida
		<a class="label label-info closeGenPasesDeSalida00 pull-right" >Regresar</a>
	</h3>

		<div class="row-fluid">

			<div class="widget-box span6">

				<div class="widget-header header-color-blue2">
					<h4 class="lighter smaller">Seleccione los Alumnos</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main padding-8">

						<table id="tblGrupoPasesDeSalida00" class="bordered">
							<thead>
								<th>
									<label>
										<input class='ace idgrualuhead' type='checkbox' name='idgrualuhead' id='idgrualuhead' >
										<span class='lbl'></span>
									</label>
								</th>
								<th>#</th>
								<th>Nombre Completo</th>
								<th></th>
							</thead>
							<tbody></tbody>

						</table>			

					</div>
				</div>
			</div>


			<div class="widget-box span6">
				<div class="widget-header header-color-green2">
					<h4 class="lighter smaller">Pase de Salida</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main padding-8">

						<form action="#" method="post">
							<div>
								<label for="name">Text Input:</label>
								<input type="text" name="name" id="name" value="" tabindex="1" />
							</div>
						
							<div>
								<h4>Radio Button Choice</h4>
						
								<label for="radio-choice-1">Choice 1</label>
								<input type="radio" name="radio-choice-1" id="radio-choice-1" tabindex="2" value="choice-1" />
						
								<label for="radio-choice-2">Choice 2</label>
								<input type="radio" name="radio-choice-2" id="radio-choice-2" tabindex="3" value="choice-2" />
							</div>
						
							<div>
								<label for="select-choice">Select Dropdown Choice:</label>
								<select name="select-choice" id="select-choice">
									<option value="Choice 1">Choice 1</option>
									<option value="Choice 2">Choice 2</option>
									<option value="Choice 3">Choice 3</option>
								</select>
							</div>
							
							<div>
								<label for="textarea">Textarea:</label>
								<textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>
							</div>
							
							<div>
								<label for="checkbox">Checkbox:</label>
								<input type="checkbox" name="checkbox" id="checkbox" />
							</div>
						
							<div>
								<input type="submit" value="Submit" />
							</div>
						</form>


					</div>
				</div>
			</div>


		</div>	


<script typy="text/javascript">        

jQuery(function($) {

	// var stream = io.connect(obj.getValue(4));

	var idgrupo = <?php echo $idgrupo ?>;
	var Grupo = "<?php echo $grupo; ?>";
	var IdCiclo = <?php echo $idciclo ?>;

	$("#preloaderPrincipal").hide();

	getGrupo(idgrupo);

	function getGrupo(IdGrupo){
		$("#tblGrupoPasesDeSalida00 > tbody").html('');
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo+"&grupo="+Grupo+"&idciclo="+IdCiclo;
		$.post(obj.getValue(0) + "data/", {o:1, t:21, c:nc, p:0, from:0, cantidad:0,s:''},
			function(json){
				$.each(json, function(i, item) {
						var xs = "<tr>";
							xs += " <td>";
							xs += "		<label>";
							xs += "			<input class='ace chkPSA00' type='checkbox' name='chkPSA00-"+item.idalumno+"' id='chkPSA00-"+item.idalumno+"' >";
							xs += "			<span class='lbl'></span>";
							xs += "		</label>";
							xs += "	</td>";
							xs += " <td class='center'>"+item.num_lista+"</td>";
							xs += " <td>"+item.label+"</td>";
							xs += " <td>";
							xs += " </td>";
							xs += "<tr>";
					$("#tblGrupoPasesDeSalida00 > tbody").append(xs);
				});

				$("#preloaderPrincipal").hide();

				// $(".modGruMatProKRDX01").on("click",function(event){
				// 	event.preventDefault();
				// 	var arr = event.currentTarget.id.split('-');
				// 	obj.setIsTimeLine(false);
				// 	modGruMatProKRDX01(arr[1]);
				// });



		},'json');
	}

 //    $("#frmDataGenNumListaPorGrupo").unbind("submit");
	// $("#frmDataGenNumListaPorGrupo").on("submit",function(event){
	// 	event.preventDefault();

	// 	$("#preloaderPrincipal").show();
	// 	var xIdGruAlu = '';
	// 	var xIdGruAluVal = '';

	// 	$(this).find('input').each(function () {
	// 		var v1 = $(this).attr('id').split('-');
	// 		var v0 = $(this).val()=='' ? 0 : $(this).val();
	// 		if (v1[0]=="idgrualu"){
	// 			xIdGruAlu += xIdGruAlu == '' ? v1[1] : '|'+v1[1];
	// 			xIdGruAluVal += xIdGruAluVal == '' ? v0 : '|'+v0;
	// 		}	
	// 	});

	// 	var nc = "user="+localStorage.nc+"&idgrupo="+idgrupo+"&idgrualu="+xIdGruAlu+"&idgrualuval="+xIdGruAluVal;

 //        $.post(obj.getValue(0) + "data/", {o:22, t:3, c:nc, p:2, from:0, cantidad:0, s:''},
 //        function(json) {
 //        		if (json[0].msg=="OK"){
 //        			alert("Lista guardada con éxito.");
	// 				stream.emit("cliente", {mensaje: "PLATSOURCE-LISTA_ORDENADA_GRUPO-IDGPO-"+idgrupo});
	// 				getGrupo(idgrupo);
 //    			}else{
 //    				alert(json[0].msg);	
	// 				$("#preloaderPrincipal").hide();
 //    			}
 //    	}, "json");		

	// });


	$(".closeGenPasesDeSalida00").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
        });
        resizeScreen();
        return false;
	});


	// $('[data-rel=tooltip]').tooltip();

 	// function modGruMatProKRDX01(IdAlumno){

		// var nc = "u="+localStorage.nc+"&idalumno=";        
  //       var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
  //       var url = obj.getValue(0)+"kardex-alumno-arji/";

  //       var temp=document.createElement("form");
  //       temp.action=url;
  //       temp.method="POST";
  //       temp.target="_blank";
  //       temp.style.display="none";
  //       for(var x in PARAMS) {
  //           var opt=document.createElement("textarea");
  //           opt.name=x;
  //           opt.value=PARAMS[x];
  //           temp.appendChild(opt);
  //       }
  //       document.body.appendChild(temp);
  //       temp.submit();
  //       return temp;
 	// }

});


</script>