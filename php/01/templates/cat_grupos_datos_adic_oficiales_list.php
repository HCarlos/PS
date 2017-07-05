<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgrupo  = $_POST['idgrupo'];
$grupo = $_POST['grupo'];
$grado = $_POST['grado'];
$idciclo = $_POST['idciclo'];

?>
<div class="row-fluid" id="testp">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">

	<h3 class="header smaller lighter blue" id="title">

		<i class="red icon-home bigger-110"></i>
		Datos Adicionales Oficiales
		<a class="label label-info arrowed-in-right arrowed closeFormGenListaGruAlu0 pull-right" >Regresar</a>

        <a  type="button" class="btn btn-minier btn-default center border" style="margin-left: 3em;" title='Formato de Posicionamiento' id="posLecSep">
	        <i class="fa fa-th"></i>
        </a>

	</h3>




	<form id="frmDatAdicOf" role="form">


			<table id="tblDatAdicOf" class="bordered">
				<thead>
					<th>ID</th>
					<th># Lista</th>
					<th>Nombre Completo</th>
					<th>Prom 1</th>
					<th>Prom 2</th>
					<th>Prom 3</th>
					<th>Prom 4</th>
					<th>Prom 5</th>
					<th>Prom 6</th>
					<th>Prom Gral</th>
					<th></th>
				</thead>
				<tbody></tbody>
			</table>			
			

	    <input type="hidden" name="idgrupo" id="idgrupo" value="<?php echo $idgrupo; ?>">
	    <input type="hidden" name="alumnos" id="alumnos" value="">
	    <input type="hidden" name="idnivel" id="idnivel" value="0">
	    <input type="hidden" name="idemp" id="idemp" value="0">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">

		<div class="row-fluid">
		    <div class="span12">

			    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
			    	<span class="muted"></span>
			    	<button type="submit" class="btn btn-primary " style='margin-right: 4em;'><i class="glyphicon glyphicon-download-alt"></i>Guardar</button>
				</div>
			</div>
		</div>

	</form>

</div>




</div>
<!--PAGE CONTENT ENDS-->


<script typy="text/javascript">        

jQuery(function($) {

	var stream = io.connect(obj.getValue(4));

	var arr = Array();
	var idgrupo = <?php echo $idgrupo; ?>;
	var Grupo = "<?php echo $grupo; ?>";
	var Grado = <?php echo $grado; ?>;
	var IdNivel = 0;
	var IdEmp = localStorage.IdEmp;
	var IdCiclo = <?php echo $idciclo; ?>;


	$("#preloaderPrincipal").hide();

	$("#clave").focus();

	getGrupo(idgrupo);

	function getGrupo(IdGrupo){
		$("#preloaderPrincipal").show();
		$("#tblDatAdicOf > tbody").html('');
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;
		$.post(obj.getValue(0) + "data/", {o:1, t:55, c:nc, p:0, from:0, cantidad:0,s:''},
			function(json){
				$.each(json, function(i, item) {
					
					var alu = item.data; 
					arr[i] = alu;

					var xs = "<tr id='tr1-"+alu+"'>";
						xs += "<td><span id='alu-"+alu+"' class='altoMoz tbl30W clsidAlu' >"+alu+"</span></td>";
						xs += "<td><span class='altoMoz tbl30W' >"+item.num_lista+"</span></td>";
						xs += "<td><span class='altoMoz tbl250W'>"+item.label+"</span></td>";

						IdNivel = item.idnivel;

						xs += "<td><input type='text' name='dap0_"+alu+"' id='dap0_"+alu+"' value=''  class='altoMoz tbl40W' /></td>";
						xs += "<td><input type='text' name='dap1_"+alu+"' id='dap1_"+alu+"' value=''  class='altoMoz tbl40W' /></td>";
						xs += "<td><input type='text' name='dap2_"+alu+"' id='dap2_"+alu+"' value=''  class='altoMoz tbl40W' /></td>";
						xs += "<td><input type='text' name='dap3_"+alu+"' id='dap3_"+alu+"' value=''  class='altoMoz tbl40W' /></td>";
						xs += "<td><input type='text' name='dap4_"+alu+"' id='dap4_"+alu+"' value=''  class='altoMoz tbl40W' /></td>";
						xs += "<td><input type='text' name='dap5_"+alu+"' id='dap5_"+alu+"' value=''  class='altoMoz tbl40W' /></td>";
						xs += "<td class='textRight'><span id='dap6_"+alu+"'></span></td>";
						xs += "<td>";
						xs += '		<div class="action-buttons">';	
						xs += '			<a class="green modDatAdicOf0" href="#" id="modDatAdicOf0-'+alu+'-'+item.label+'" data-rel="tooltip" data-placement="top" title="Ver Mas Datos">';
						xs += '				<i class="icon-pencil bigger-130"></i>';
						xs += '			</a>';
						xs += '			<a class="gray modDatAdicOf1" href="#" id="modDatAdicOf1-'+alu+'-'+item.label+'" data-rel="tooltip" data-placement="top" title="Modificar Reprobatorias">';
						xs += '				<i class="icon-fire bigger-130"></i>';
						xs += '			</a>';
						xs += '		</div>';
						xs += "</td>";
						xs += "</tr>";

					$("#tblDatAdicOf > tbody").append(xs);

				});
		
				$(".modDatAdicOf0").on("click",function(event){
					event.preventDefault();
					var arr = event.currentTarget.id.split('-');
					obj.setIsTimeLine(false);
					getPropDatAdicOf1(arr[1],arr[2],Grupo,IdNivel,IdEmp);
				});
		
				$(".modDatAdicOf1").on("click",function(event){
					event.preventDefault();
					var arr = event.currentTarget.id.split('-');
					obj.setIsTimeLine(false);
					getPropDatAdicOf2(arr[1],arr[2],Grupo,IdNivel,IdEmp);
				});

				for(i=0;i<arr.length; ++i ){	
					
					var v1 = arr[i];
					
					
					nc = "idemp="+localStorage.IdEmp+"&idalumno="+v1+"&idnivel="+IdNivel;

					$.post(obj.getValue(0) + "data/", {o:43, t:91, c:nc, p:11, from:0, cantidad:0, s:' limit 1 '},
						function(json){

							var alu = json[0].idalumno;
							
							if ( json.length > 0 ){

								if ( parseInt(json[0].prom0,0) > 0 ){
									$("#dap0_"+alu).val( parseFloat(json[0].prom0).toFixed(2) );	
								}

								if ( parseInt(json[0].prom1,0) > 0 ){
									$("#dap1_"+alu).val( parseFloat(json[0].prom1).toFixed(2) );	
								}


								if ( parseInt(json[0].prom2,0) > 0 ){
									$("#dap2_"+alu).val( parseFloat(json[0].prom2).toFixed(2) );	
								}


								if ( parseInt(json[0].prom3,0) > 0 ){
									$("#dap3_"+alu).val( parseFloat(json[0].prom3).toFixed(2) );	
								}


								if ( parseInt(json[0].prom4,0) > 0 ){
									$("#dap4_"+alu).val( parseFloat(json[0].prom4).toFixed(2) );	
								}

								if ( parseInt(json[0].prom5,0) > 0 ){
									$("#dap5_"+alu).val( parseFloat(json[0].prom5).toFixed(2) );	
								}
								
								var promeGral = parseInt(json[0].promedio_general,0);

								if ( promeGral > 0 ){
									$("#dap6_"+alu).html( parseFloat(json[0].promedio_general).toFixed(2) );	
								}

								if ( promeGral < 6){
									$("#tr1-"+alu).addClass('colorreprobado');

								}


							}

					},'json');

				};
					
				$("#preloaderPrincipal").hide();
		},'json');



	}

    $("#frmDatAdicOf").unbind("submit");
	$("#frmDatAdicOf").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();
		var xIdAlu = '';

		$(this).find(".clsidAlu").each(function () {
			var v1 = $(this).attr('id').split('-');
			var v0 = $(this).val()=='' ? 0 : $(this).val();
			if (v1[0]=="alu"){
				xIdAlu += xIdAlu == '' ? v1[1] : '|'+v1[1];
			}	
		});

		$("#user").val(localStorage.nc);
		$("#alumnos").val(xIdAlu);
		$("#idnivel").val(IdNivel);
		$("#idemp").val(localStorage.IdEmp);

		var queryString = $(this).serialize();

        $.post(obj.getValue(0) + "data/", {o:43, t:1, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					stream.emit("cliente", {mensaje: "PLATSOURCE-DATOS_ADICIONALES_OFICIALES-IDGPO-"+idgrupo});
					getGrupo(idgrupo);
    			}else{
    				alert(json[0].msg);	
					$("#preloaderPrincipal").hide();
    			}
    	}, "json");		


	});

	$(".closeFormGenListaGruAlu0").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").html("");
            $("#contentProfile").show();
        });
        resizeScreen();
        return false;
	});

	$("#posLecSep").on("click",function(event){
		event.preventDefault();
        $("#contentLevel4").empty();
        $("#contentLevel3").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "gru-dat-adic-pos-lecsep/", {
				user: nc,
				grupo:Grupo,
				grado:Grado,
				idnivel: IdNivel,
				idciclo: IdCiclo,
				idemp: IdEmp
	            },
	            function(html) {	                
	                $("#contentLevel4").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Mas Datos Adicionales Oficiales '));
	                });
	            }, "html");
        });
        return false;

	});

	function getPropDatAdicOf1(IdAlumno, Alumno, Grupo, IdNivel, IdEmp ){
        $("#contentLevel4").empty();
        $("#contentLevel3").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "gru-dat-adic-of-prop/", {
				user: nc,
				idalumno: IdAlumno,
				grupo:Grupo,
				idnivel: IdNivel,
				idemp: IdEmp,
				alumno:Alumno,
				idciclo: IdCiclo
	            },
	            function(html) {	                
	                $("#contentLevel4").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Mas Datos Adicionales Oficiales '));
	                });
	            }, "html");
        });
        return false;
	}

	function getPropDatAdicOf2(IdAlumno, Alumno, Grupo, IdNivel, IdEmp ){
        $("#contentLevel4").empty();
        $("#contentLevel3").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "gru-dat-adic-of-prop-reprob-sec/", {
				user: nc,
				idalumno: IdAlumno,
				grupo:Grupo,
				idnivel: IdNivel,
				idemp: IdEmp,
				idciclo: IdCiclo,
				alumno:Alumno
	            },
	            function(html) {	                
	                $("#contentLevel4").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Mas Datos Adicionales Oficiales '));
	                });
	            }, "html");
        });
        return false;
	}


});

</script>