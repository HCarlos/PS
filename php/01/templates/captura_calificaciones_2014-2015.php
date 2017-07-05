<?php

include("includes/metas.php");

$de       = $_POST['user'];
$idgrupo  = $_POST['idgrupo'];
$grupo    = $_POST['grupo'];

?>

<div class="row">
	<div class="marginLeft1em">
		<select name="lstMat" id="lstMat" size="1" class="bigger-125 pull-left"></select> 
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-minier btn-success pull-left marginLeft1em" id="btnGetCal" title="Ver Calificaciones">
				<i class="icon-laptop icon-only bigger-150"></i>
			</button> 
			<button class="btn btn-minier btn-purple pull-left  marginLeft1em" id="btnPartes" title="Porcentajes" disabled='disabled'>
				<i class="icon-cogs icon-only bigger-150"></i>
			</button>
			<select name="lstNoEval" id="lstNoEval" size="1" class="marginLeft1em bigger-125 pull-left" > </select>
		</div>
		 
	</div>	
	<h2 id="rigBar" class=" orange pull-right">
		<i class="glyphicon glyphicon-edit"></i>
		Calificaciones
	</h2>

</div>

<h3></h3>
<form id="frmDataCapCal" class="">
<table id="tblCal" class="bordered">
	<thead></thead>
		<th></th>
	<tbody>
		<tr>
			<td>Lista de alumnos vacia. Haga click en 'Ver Calificaciones' para consultar su lista o configure sus Porcentajes de evaluación.</td>
		</tr>
	</tbody>

</table>

<div class="clearfix"></div>
<input type="hidden" name="idgrupo" id="idgrupo" value="<?php echo $idgrupo; ?>">
<input type="hidden" name="num_eval_capcal_fmt_0" id="num_eval_capcal_fmt_0" value="0">
<input type="hidden" name="user" id="user" value="<?php echo $de; ?>">
<div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	<button type="submit" class="btn btn-primary pull-left" style='margin-right: 4em;' id="cmdSaveCapCal"><i class="icon-save"></i>Guardar</button>
	<a class="btn btn-info"  id="printFormGenListaGruAlu0">
		<i class="icon-print  bigger-125 icon-on-left"></i>
		Imprimir
	</a>				
</div>

</form>	

<script type="text/javascript">        

jQuery(function($) {
	$("#cmdSaveCapCal").hide();
	$("#printFormGenListaGruAlu0").hide();

	var TRPP = 20;
	var IdUNA = localStorage.IdUserNivelAcceso;
	var arrItems = [];
	var arrHD = [];
	var arrRow = {};
	var evalDef = 0;
	var evalMod = 0;

	if (localStorage.TRPP){
		TRPP = parseInt(localStorage.TRPP,0);	
	}
	oPag = {init:true, totalRegistros:0, totalPaginas:0, currentPage:0, registrosPorPagina:TRPP, Limit:'', Query:'' };

	var IsRegistry = false;
	var IdGrupo = <?php echo $idgrupo; ?>;	

    var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;
    $.post(obj.getValue(0)+"data/", { o:1, t:37, p:11, c:nc, from:0, cantidad:0, s:"" },
        function(json){
            if (json.length>0){
            	
            	// alert(json[0].idnivel);
            	
            	obj.getConfig(parseInt(json[0].idnivel,0),1);
            	evalMod = localStorage.eval0;
            	//alert(localStorage.eval0);	

            	obj.getConfig(parseInt(json[0].idnivel,0),0);
            	
            	if (!localStorage.eval0){
            		localStorage.eval0 = 1;
            	}
           		evalDef = localStorage.eval0; 

        		$("#lstNoEval").empty();
           		
           		if (evalMod!=evalDef){
            		$("#lstNoEval").append('<option value="'+evalMod+'">Eval. Mod: '+evalMod+'</option>')
            		$("#lstNoEval").append('<option value="'+evalDef+'" selected>Eval. Default: '+evalDef+'</option>')
            	}else{
            		$("#lstNoEval").hide();
            	}
            	
            	//alert(localStorage.eval0);	

           		$("#btnPartes").attr('Disabled', false);
           		$("#lstMat").attr('Disabled', false);
           		getMaterias();
           	}else{
           		$("#btnPartes").attr('Disabled', true);
           		$("#lstMat").attr('Disabled', true);
           	}

           	$("#barInfoR0").html(sayNoEval(localStorage.eval0));
           	$("#num_eval_capcal_fmt_0").val(localStorage.eval0);
		    $("#preloaderPrincipal").hide();

        }, "json"
    );

    function getMaterias(){
	    $("#preloaderPrincipal").show();
	    var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;
	    $("#lstMat").html("<option value='0' selected>Seleccione una Materia</option>");
	    $.post(obj.getValue(0)+"data/", { o:1, t:17, p:0, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	            if (json.length>0){
	               $.each(json, function(i, item) {
	                    $("#lstMat").append('<option value="'+item.data+'"> '+item.label+'</option>');
	                });
	               
	               $("#lstMat").on("change",function(event){
	               		event.preventDefault();

					});   

	           	}else{
	           	}

			    $("#preloaderPrincipal").hide();

	        }, "json"
	    );
	}
 
	$("#lstMat").on("change",function(event){
		event.preventDefault();
		var idgm = parseInt($("#lstMat").val(),0);
	    getGridCaptura( idgm );
        return false;
	});

	$("#btnGetCal").on("click",function(event) {
		event.preventDefault();
		var idgm = parseInt($("#lstMat").val(),0);
		if ( idgm <= 0 ){
			alert("Seleccione una Materia");
			return false;
		}
	    getGridCaptura( idgm );
        return false;
	});

	$("#lstNoEval").on("change",function(event) {
		event.preventDefault();

		var x = confirm("Ha cambiado a la Evaluación "+$(this).val()+", los datos no haya guardado se perderán.\n\nDesea continuar?");
		if (!x){
			return false;
		}

		localStorage.eval0 = $(this).val();

   		$("#btnPartes").attr('Disabled', false);
   		$("#lstMat").attr('Disabled', false);
       	$("#barInfoR0").html(sayNoEval(localStorage.eval0));
       	$("#num_eval_capcal_fmt_0").val(localStorage.eval0);

		$("#tblCal").html('<thead></thead><tbody></tbody>');
		$("#tblCal > thead").empty();
		$("#tblCal > tbody").empty();
		$("#preloaderPrincipal").show();
		var xTR;
		xTR = "<table id='tblCal' class='bordered'>";
		xTR += "<thead></thead>";
		xTR += "<th></th>";
		xTR += "<tbody>";
		xTR += "<tr>";
		xTR += "<td>Lista de alumnos vacia. Haga click en 'Ver Calificaciones' para consultar su lista o configure sus Porcentajes de evaluación.</td>";
		xTR += "</tr>";
		xTR += "</tbody>";
		xTR += "</table>";
		$("#tblCal").html(xTR);

	    $("#preloaderPrincipal").hide();

   		getMaterias();



        return false;
	});

	function getGridCaptura(IdGruMat){
		$("#tblCal").html('<thead></thead><tbody></tbody>');
		$("#tblCal > thead").empty();
		$("#tblCal > tbody").empty();
		$("#preloaderPrincipal").show();
		var xTR;
		var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+localStorage.eval0;
		$.post(obj.getValue(0)+"data/", { o:1, t:34, p:11, c:nc, from:0, cantidad:0, s:"" },
			function(json){
		        	if (json.length>0){
							xTR = "<tr>";
							xTR += "<th>No</th>";  
							xTR += "<th>Alumno</th>";  
				               $.each(json, function(i, item) {
				               		arrHD[i] = {
				               					idgrumatcon:item.idgrumatcon,
				               					descripcion:item.descripcion,
				               					porcentaje:parseInt(item.porcentaje,0)
				               					};
				               		
				               		xTR += "<th>"+item.descripcion+" "+parseInt(item.porcentaje,0)+"%"+"</th>"; 
				                });
				                getListaAlumnos(IdGruMat);
							xTR += "<th>Eval</th>";  
							xTR += "<th>Con</th>";  
							xTR += "<th>Ina</th>";  
							xTR += "<th>Obs</th>";  
						    xTR += "</tr>";
						   	$("#tblCal > thead").html(xTR);
						   	$("#cmdSaveCapCal").show();
						   	$("#printFormGenListaGruAlu0").show();

					}else{
						xTR = "<table id='tblCal' class='bordered'>";
						xTR += "<thead></thead>";
						xTR += "<th></th>";
						xTR += "<tbody>";
						xTR += "<tr>";
						xTR += "<td>Lista de alumnos vacia. Haga click en 'Ver Calificaciones' para consultar su lista o configure sus Porcentajes de evaluación.</td>";
						xTR += "</tr>";
						xTR += "</tbody>";
						xTR += "</table>";
						$("#tblCal").html(xTR);
					}

		    }, "json"
		);
	    $("#preloaderPrincipal").hide();
	}

	function getListaAlumnos(IdGruMat){

		var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+localStorage.eval0;
       	$("#preloaderPrincipal").show();
		$.post(obj.getValue(0)+"data/", { o:1, t:33, p:11, c:nc, from:0, cantidad:0, s:"" },
			function(json){
				
				arrItems = [];
				$.each(json, function(i, item) {

					arrItems[i] = {
									idboleta:item.idboleta,
									alumno:item.alumno, 
									num_lista:item.num_lista,
									cal:item.cal,
									con:item.con,
									ina:item.ina,
									obs:item.obs
									};

				});
               $("#preloaderPrincipal").hide();
               //alert(arrItems.length);
				paintTable();
			}, "json"
		);
	}

	function paintTable(){
		$("#tblCal > tbody").empty();
		var tNdxCon = 100;
		var tNdxIna = 200;
		var tNdxObs = 300;
		$.each(arrItems, function(i, item) {
	       	$("#preloaderPrincipal").show();
			var k = arrItems[i].idboleta;
			var mod = item.cal % parseInt(item.cal,0);
			var cal = mod==0?parseInt(item.cal,0):item.cal;
			var cnd = parseInt(item.con,0);
			var nss = parseInt(item.ina,0);
			var bsr = parseInt(item.obs,0);
			
			var defcolorep = cal<60?'colorreprobado':'';
		    var xTR = "<tr class='"+defcolorep+"'>";
				xTR += "<td class='center'>"+item.num_lista+"</td>";  
				xTR += "<td>"+item.alumno+"</td>";  

				$.each(arrHD, function(j, item) {

			  		xTR += "<td class='colclick alineaTextoalaDerecha' id='tdcol-"+k+'-'+item.idgrumatcon+"'></td>"; 
			  		// console.log("tdcol-"+k+'-'+item.idgrumatcon);
					if (j==arrHD.length-1){
							var vcal = cal>0?cal:'';
							var vina = nss>0?nss:'';
							var vcon = cnd>0?cnd:'';
							var vobs = bsr>0?bsr:'';
							xTR += "<td class='textRight colorcal'>"+vcal+"</td>";  
							xTR += "<td class='textRight'><input type='text' name='cond-"+k+'-'+localStorage.eval0+"' id='cond-"+k+'-'+localStorage.eval0+"' class='calif' maxlength='3' tabindex='"+tNdxCon+"' value='"+vcon+"' ></td>";  
							xTR += "<td class='center'>"+vina+"</td>";  
							xTR += "<td class='textRight'><input type='text' name='obs-"+k+'-'+localStorage.eval0+"' id='obs-"+k+'-'+localStorage.eval0+"'  class='calif' maxlength='3' tabindex='"+tNdxObs+"' value='"+vobs+"' ></td>";  
						   	//$("#tblCal > tbody").append(xTR);
						   	tNdxCon++;
						   	tNdxIna++;
						   	tNdxObs++;
			               $("#preloaderPrincipal").hide();
					}
			   	});
				xTR += "</tr>";
			   	$("#tblCal > tbody").append(xTR);
			   	if (i==arrItems.length-1){
			   		showTable();
			   	}

				$("#preloaderPrincipal").hide();
		});
	}

	function showTable(){
		
		var tNdxCal = 400;
		$.each(arrHD, function(j, item) {

	       	$("#preloaderPrincipal").show();

			var sfind = "idgrumatcon="+item.idgrumatcon;

			$.ajax({
              async:false,   
              cache:false,  
              dataType:"json",
              type: 'POST',  
              url: obj.getValue(0)+"data/",
              data:  { o:1, t:36, p:11, c:sfind, from:0, cantidad:0, s:"" },
              success:  function(json){

						$.each(json, function(j, item) {
							var vval = parseInt(item.calificacion,0) > 0 ? item.calificacion : '';
	  						$("#tdcol-"+item.idboleta+'-'+item.idgrumatcon).html(vval); 
	  						// $("#tdcol-"+item.idboleta+'-'+item.idgrumatcon).html("<input type='text' name='idbolpar-"+item.idbolpar+'-'+item.idgrumatcon+"' id='idbolpar-"+item.idbolpar+'-'+item.idgrumatcon+"'  value='"+vval+"' class='calif' maxlength='3'  disabled='disabled' >"); 
	  					});
						
						$('#frmDataCapCal').find('input').each(function () {
							if ( $(this).attr('tabindex') == null ){
								$(this).attr('tabindex', tNdxCal);
								//$(this).val(tNdxCal);
								tNdxCal++;
							} 
						});

						},
							beforeSend:function(){},
							error:function(objXMLHttpRequest){
								alert(objXMLHttpRequest.text);
								return false;
							}
			            });
			$("#preloaderPrincipal").hide();
	   	});

		$( ".calif" ).on('keydown',function(event) {
			console.log(event.keyCode);
			var kLL = obj.getkeyLatLon( event.keyCode );
			if ( kLL == -1 && !event.shiftKey){
				//alert("Caracter no válido ("+event.keyCode+")");
				event.preventDefault();
				$(this).keypress(8);
			}
			var arrKey = [106, 171, 187];
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
			
			//if ( $("#"+event.currentTarget.id).val().length == parseInt($("#"+event.currentTarget.id).prop("maxlength"),0) ){
			
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

	}  // Fin Function Get Array()


	$("#btnPartes").on("click",function(event) {
		event.preventDefault();

		if ( parseInt($("#lstMat").val(),0) <= 0 ){
			alert("Seleccione una Materia");
			return false;
		}

        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cal_partes_config/", {
				idgrumat: $("#lstMat").val(),
				materia: $("#lstMat :selected").text()
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Configuración de Partes' ));
	                });
	            }, "html");
        });

        return false;
	});

    $("#frmDataCapCal").unbind("submit");
	$("#frmDataCapCal").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();
		
	    var queryString = $(this).serialize();	
	    				var xIdBolPar = '';
	    				var xIdBolParCal = '';
	    				var xIdBolCon = '';
	    				var xIdBolConCal = '';
	    				var xIdBolIna = '';
	    				var xIdBolInaCal = '';
	    				var xIdBolObs = '';
	    				var xIdBolObsCal = '';
						$('#frmDataCapCal').find('input').each(function () {
							var v1 = $(this).attr('id').split('-');
							var v0 = $(this).val()=='' ? 0 : $(this).val();
							if (v1[0]=="idbolpar"){
								xIdBolPar += xIdBolPar == '' ? v1[1] : '|'+v1[1];
								xIdBolParCal += xIdBolParCal == '' ? v0 : '|'+v0;
							}	

							if (v1[0]=="cond"){
								xIdBolCon += xIdBolCon == '' ? v1[1] : '|'+v1[1];
								xIdBolConCal += xIdBolConCal == '' ? v0 : '|'+v0;
							}	

							if (v1[0]=="ina"){
								xIdBolIna += xIdBolIna == '' ? v1[1] : '|'+v1[1];
								xIdBolInaCal += xIdBolInaCal == '' ? v0 : '|'+v0;
							}	

							if (v1[0]=="obs"){
								xIdBolObs += xIdBolObs == '' ? v1[1] : '|'+v1[1];
								xIdBolObsCal += xIdBolObsCal == '' ? v0 : '|'+v0;
							}	

						});

		queryString = "IdBolPar="+xIdBolPar+"&IdBolParCal="+xIdBolParCal+"&IdBolCon="+xIdBolCon+"&IdBolConCal="+xIdBolConCal+"&IdBolIna="+xIdBolIna+"&IdBolInaCal="+xIdBolInaCal+"&IdBolObs="+xIdBolObs+"&IdBolObsCal="+xIdBolObsCal+"&num_eval_capcal_fmt_0="+$("#num_eval_capcal_fmt_0").val()+"&user="+$("#user").val();				
	    // alert(queryString);
        $.post(obj.getValue(0) + "data/", {o:19, t:1, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					stream.emit("cliente", {mensaje: "PLATSOURCE-CAPCAL-PROP-"+localStorage.grupo_cal});
					var igm = $("#lstMat").val();
					getGridCaptura( igm );
					$("#preloaderPrincipal").hide();
    			}else{
					$("#preloaderPrincipal").hide();
    				alert("Error: "+json[0].msg);	
    			}
    	}, "json");

	});

	$("#printFormGenListaGruAlu0").on("click",function(event){
		
		event.preventDefault();

		var thead = "";
		$('#tblCal > thead  > tr').each(function() {

			$(this).find('th').each(function (key, val) {
                thead += thead!=''?"|"+$(this)[0].textContent:$(this)[0].textContent; // val[key].innerHTML; // this isn't working
            });

		});

		//alert(thead);

		var tbody = "";
		$('#tblCal > tbody  > tr').each(function() {

			var xTR = "";
			$(this).find('td').each(function (key, val) {
				var boolEntro = false;
				$(this).find('input').each(function (key, val) {
					var valcal = $(this).val();
					if (valcal>0){
	                	xTR += xTR!=''?"|"+valcal:valcal; // val[key].innerHTML; // this isn't working
            		}else{
	                	xTR += xTR!=''?"|0":"0"; // val[key].innerHTML; // this isn't working
            		}
            		boolEntro = true;
            	});
				if (!boolEntro){
                	xTR += xTR!=''?"|"+$(this)[0].textContent:$(this)[0].textContent; // val[key].innerHTML; // this isn't working
            	}
            });
				// console.log(apol);
            	tbody += xTR;
				var apol = tbody!=''?'°':'';
            	tbody += apol;
		});

		//alert(tbody);
		//return false;
		var logoEmp =obj.getConfig(100,0); 
		var nc = "u="+localStorage.nc+
				"&grupo="+localStorage.grupo_cal + 
				"&materia="+$("#lstMat :selected").text()+
				"&profesor="+$("#nameuser").html()+
				"&head="+thead+
				"&body="+tbody+
				"&eval="+localStorage.eval0+
				"&logoEmp="+logoEmp;
				
        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
        var url = obj.getValue(0)+"lista-calificaciones-profesor/";

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


	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewEstado);
	function jsNewEstado(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='CAPCAL') {
			var idgm = parseInt($("#lstMat").val(),0);
		    // getGridCaptura( idgm );
		}
	}

});


</script>