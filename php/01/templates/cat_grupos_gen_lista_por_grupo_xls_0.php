<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgrupo  = $_POST['idgrupo'];
$grupo = $_POST['grupo'];
$idciclo  = $_POST['idciclo'];

?>
<div class="row-fluid" id="testp">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">

	<h3 class="header smaller lighter blue" id="title">
		<i class="red icon-home bigger-110"></i>
		Listado de Alumnos
		<a class="label label-info arrowed-in-right arrowed closeFormGenListaGruAlu0 pull-right" >Regresar</a>
	</h3>
	<form id="frmDataGenNumListaPorGrupo" role="form">


			<table id="tblGenNumListaPorGrupo" class="bordered">
				<thead>
					<th>Número</th>
					<th>Nuevo Número</th>
					<th>Nombre Completo</th>
					<th>U/Alumno</th>
					<th>Tutor</th>
					<th>U/Tutor</th>
					<th>Id Fam</th>
					<th>Familia</th>
					<th>Email 1</th>
					<th>Email 2</th>
					<th>Email Fiscal</th>
					<th></th>
				</thead>
				<tbody></tbody>
			</table>			
			

	    <input type="hidden" name="idgrupo" id="idgrupo" value="<?php echo $idgrupo; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">

		<div class="row-fluid">
		    <div class="span12">

			    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
			    	<span class="muted"></span>
			    	<a class="btn btn-info " style='margin-right: 4em;'  id="OrdenaListaAlumnos0"><i class="glyphicon glyphicon-list"></i>Ordenar Automáticamente</a>
			    	<button type="submit" class="btn btn-primary " style='margin-right: 4em;'><i class="glyphicon glyphicon-download-alt"></i>Guardar Cambios</button>

					<div class="btn-group">
						<button data-toggle="dropdown" class="btn btn-small btn-info dropdown-toggle">
							<i class="icon-print  bigger-125 icon-on-left"></i>
							Imprimir
							<i class="icon-angle-down icon-on-right"></i>
						</button>

						<ul class="dropdown-menu dropdown-danger">
							<li id="printFormGenListaGruAlu0">
								<a href="#">Lista de Asistencia</a>
							</li>

							<li  class="printCatGenAluForGpoPDF0" id="printCatGenAluForGpoPDF0-0">
								<a href="#">Catálogo General de Alumnos de este Grupo</a>
							</li>

							<li  class="printCatGenAluForGpoPDF0"  id="printCatGenAluForNivPDF0-1">
								<a href="#">Catálogo General de Alumnos de este Nivel</a>
							</li>

							<li class="divider"></li>

							<li id="printFormGenListaGruAlu1">
								<a href="#">Exportar el Listado de este Grupo a MS Excel</a>
							</li>

							<li id="printFormGenListaNivel1">
								<a href="#">Exportar el Listado de este Nivel a MS Excel</a>
							</li>

							<li id="printFormGenListaBajasNivel1">
								<a href="#">Exportar el listado de bajas de este Nivel a MS Excel</a>
							</li>

						</ul>
					</div><!--/btn-group-->


				</div>
			</div>
		</div>

	</form>

</div>




</div>
<!--PAGE CONTENT ENDS-->


<script typy="text/javascript">        

jQuery(function($) {

	// var stream = io.connect(obj.getValue(4));

	var idgrupo = <?php echo $idgrupo ?>;
	var Grupo = "<?php echo $grupo; ?>";
	var IdCiclo = <?php echo $idciclo ?>;

	$("#preloaderPrincipal").hide();

	$("#clave").focus();

	getGrupo(idgrupo);

	function getGrupo(IdGrupo){
		$("#tblGenNumListaPorGrupo > tbody").html('');
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo+"&Grupo="+Grupo+"&idciclo="+IdCiclo;
		$.post(obj.getValue(0) + "data/", {o:1, t:21, c:nc, p:0, from:0, cantidad:0,s:''},
			function(json){
				$.each(json, function(i, item) {
					var xs = "<tr>";
							xs += " <td>"+item.num_lista+"</td>";
							xs += " <td><input type='number' class='altoMoz tbl50W' id='idgrualu-"+item.data+"-"+item.num_lista+"' name= id='idgrualu-"+item.data+"-"+item.num_lista+"' value='"+item.num_lista+"'/></td>";
							xs += " <td>"+item.label+"</td>";
							xs += " <td>"+item.usernamealumno+"</td>";
							xs += " <td>"+item.nombre_tutor+"</td>";
							xs += " <td>"+item.username_tutor+"</td>";
							xs += " <td>"+item.idfamilia+"</td>";
							xs += " <td>"+item.familia+"</td>";
							xs += " <td>"+item.email_tutor1+"</td>";
							xs += " <td>"+item.email_tutor2+"</td>";
							xs += " <td>"+item.email_fiscal+"</td>";
							xs += ' <td class=" ">';
							xs += '		<div class="hidden-phone visible-desktop action-buttons">';
							if ( parseInt(item.genero,0) == 0 ){
								xs += '			<a class="pink modGruMatProKRDX01 tooltip-info" href="#" id="idgrualu2two-'+item.idalumno+'-'+item.iduseralu+'" data-rel="tooltip" data-placement="top" data-original-title="Ver Kardex" title="Ver Kardex" >';
								xs += '				<i class="fa fa-female bigger-150"></i>';
							}else{
								xs += '			<a class="blue modGruMatProKRDX01 tooltip-info" href="#" id="idgrualu2two-'+item.idalumno+'-'+item.iduseralu+'" data-rel="tooltip" data-placement="top" data-original-title="Ver Kardex" title="Ver Kardex" >';
								xs += '				<i class="fa fa-male bigger-150"></i>';
							}
							xs += '			</a>';
							xs += '		</div>';
							xs += ' </td>';
							xs += "<tr>";
					$("#tblGenNumListaPorGrupo > tbody").append(xs);
				});

				$("#preloaderPrincipal").hide();

				$(".modGruMatProKRDX01").on("click",function(event){
					event.preventDefault();
					var arr = event.currentTarget.id.split('-');
					obj.setIsTimeLine(false);
					modGruMatProKRDX01(arr[1],arr[2]);
				});



		},'json');
	}

    $("#frmDataGenNumListaPorGrupo").unbind("submit");
	$("#frmDataGenNumListaPorGrupo").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();
		var xIdGruAlu = '';
		var xIdGruAluVal = '';

		$(this).find('input').each(function () {
			var v1 = $(this).attr('id').split('-');
			var v0 = $(this).val()=='' ? 0 : $(this).val();
			if (v1[0]=="idgrualu"){
				xIdGruAlu += xIdGruAlu == '' ? v1[1] : '|'+v1[1];
				xIdGruAluVal += xIdGruAluVal == '' ? v0 : '|'+v0;
			}	
		});

		var nc = "user="+localStorage.nc+"&idgrupo="+idgrupo+"&idgrualu="+xIdGruAlu+"&idgrualuval="+xIdGruAluVal+"&idciclo="+IdCiclo;

        $.post(obj.getValue(0) + "data/", {o:22, t:3, c:nc, p:2, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
        			alert("Lista guardada con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-LISTA_ORDENADA_GRUPO-IDGPO-"+idgrupo});
					getGrupo(idgrupo);
    			}else{
    				alert(json[0].msg);	
					$("#preloaderPrincipal").hide();
    			}
    	}, "json");		


	});

	$("#OrdenaListaAlumnos0").on("click",function(event){
		event.preventDefault();
		var nc = "user="+localStorage.nc+"&idgrupo="+idgrupo;
		// alert(nc);
        $.post(obj.getValue(0) + "data/", {o:0, t:0, c:nc, p:13, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
        			alert("Lista ordenada con éxito.");
					//stream.emit("cliente", {mensaje: "PLATSOURCE-GRUPOS-PROP-"+IdGrupo});
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

	$("#printFormGenListaGruAlu0").on("click",function(event){
		
		event.preventDefault();

		var nc = "u="+localStorage.nc+"&idgrupo="+idgrupo+"&grupo="+Grupo+"&idciclo="+IdCiclo;
        
        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
        var url = obj.getValue(0)+"lista-Asistencia/";

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

 	

	$(".printCatGenAluForGpoPDF0").on("click",function(event){
		
		event.preventDefault();

		var id = event.currentTarget.id.split('-');

		var cad = "";
		var nc = "u="+localStorage.nc+"&idgrupo="+idgrupo+"&idciclo="+IdCiclo;
		$.post(obj.getValue(0) + "data/", {o:1, t:1, c:nc, p:51, from:0, cantidad:0,s:''},
		function(json){
			$.each(json, function(i, item) {
				cad += cad == "" ? item.data : '-' + item.data;
			});

			// alert(cad);
			
			if ( parseInt(id[1],0) == 0 ){
				cad = idgrupo;	
			} 
			

			var nc = "u="+localStorage.nc+"&idgrupos="+cad+"&grupo="+Grupo+"&idciclo="+IdCiclo;
        
	        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
	        var url = obj.getValue(0)+"lista-catalogo-general-alumnos/";

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

		},'json');


 	});


	$("#printFormGenListaGruAlu1").on("click",function(event){
		
		event.preventDefault();

		var nc = "u="+localStorage.nc+"&idgrupos="+idgrupo+"&grupo="+Grupo+"&idciclo="+IdCiclo;
        
        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
        var url = obj.getValue(0)+"lista-alumnos-xls-0/";

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

	$('[data-rel=tooltip]').tooltip();

	$("#printFormGenListaNivel1").on("click",function(event){
		
		event.preventDefault();

		var cad = "";
		var nc = "u="+localStorage.nc+"&idgrupo="+idgrupo+"&idciclo="+IdCiclo;
		$.post(obj.getValue(0) + "data/", {o:1, t:1, c:nc, p:51, from:0, cantidad:0,s:''},
		function(json){
			$.each(json, function(i, item) {
				cad += cad == "" ? item.data : '-' + item.data;
			});

			// alert(cad);

			var nc = "u="+localStorage.nc+"&idgrupos="+cad+"&grupo="+Grupo+"&idciclo="+IdCiclo;
	        
	        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
	        var url = obj.getValue(0)+"lista-alumnos-xls-0/";

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

		},'json');


 	});




	$("#printFormGenListaBajasNivel1").on("click",function(event){
		
		event.preventDefault();

		var cad = "";
		var nc = "u="+localStorage.nc+"&idgrupo="+idgrupo+"&idciclo="+IdCiclo;
		$.post(obj.getValue(0) + "data/", {o:1, t:1, c:nc, p:51, from:0, cantidad:0,s:''},
		function(json){
			$.each(json, function(i, item) {
				cad += cad == "" ? item.data : '-' + item.data;
			});

			// alert(cad);

			var nc = "u="+localStorage.nc+"&idgrupos="+cad+"&grupo="+Grupo+"&idciclo="+IdCiclo;
	        
	        var PARAMS = {o:1, t:73, c:nc, p:0, from:0, cantidad:0, s:''};  
	        var url = obj.getValue(0)+"lista-alumnos-bajas-xls-0/";

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

		},'json');


 	});


 	function modGruMatProKRDX01(IdAlumno,IdUserAlu){

		var nc = "u="+localStorage.nc+"&idalumno="+IdAlumno+'&idgrupo='+idgrupo+"&idciclo="+IdCiclo+"&iduseralu="+IdUserAlu;        
        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
        var url = obj.getValue(0)+"kardex-alumno-arji/";

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
 	}

});


</script>