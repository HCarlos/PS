<?php

include("includes/metas.php");

$user = $_POST["user"];
$idgrupo = $_POST["idgrupo"];
$grupo = $_POST["grupo"];
?>


<div  class="row-fluid">
<!-- 	<div class="span12 widget-container-span ui-sortable"> -->
<div class="widget-box span12">

		<div  class="widget-header header-color-green2 widget-header-flat padtop05em">
			
			<div class="widget-toolbar white pull-left no-border " >

				<h4 class="smaller">
					<i class="icon-leaf lemon"></i>
					Configuración: <strong color="white"><?= $grupo; ?></strong>
				</h4>

			</div>

			<div class="widget-toolbar white pull-right no-border mute">

<!-- 				
			<a class="white tooltip-info" href="#"  id="btnPrintListCal02" data-original-title="Ver Calificaciones" data-rel="tooltip" data-placement="left" title="Ver Calificaciones">
				<i class="fa fa-list bigger-130"></i>
			</a>

 -->

 			</div>

		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

				<form class="form" role="form" id="frmCapCalMKB023">

					<div class="col-lg-12 input-group">

						<div class="col-lg-6 ">

							<div class="input-group">
								<span class="input-group-addon">
									<label class="clear-lbl-addon lbl0" for="cmbMaterias100">Materias:</label>
								</span>
								<select id="cmbMaterias100" name="cmbMaterias100" class="form-control">
									<option value="0" selected>Seleccione una Materia</option>
								</select>
							</div>

						</div>
						
						<div class="col-lg-5">

							<div class="hidden-phone visible-desktop action-buttons pull-left ">
								<a class="widget-toolbar orange no-border isModMat01" href="#"  id="btnBolAsist00" title="Lista de Asistencia" >
									<i class="fa fa-list-ol bigger-130"></i>
								</a>
							</div>

							<div class="hidden-phone visible-desktop action-buttons pull-left ">
								<a class="widget-toolbar cafe no-border isModMat01" href="#"  id="btnPrintSummaryConfig01" title="Calificaciones Materia Detalle">
									<i class="fa fa-print bigger-130 "></i>
								</a>
							</div>

							<div class="hidden-phone visible-desktop action-buttons pull-left ">
								<a class="widget-toolbar grey no-border isModMat01" href="#"  id="btnPrintSummaryConfig01xls" title="Calificaciones Materia Detalle MS Excel">
									<i class="fa fa-file-excel-o bigger-130 "></i>
								</a>
							</div>

							<div class="hidden-phone visible-desktop action-buttons pull-left ">
								<a class="widget-toolbar purple no-border isModMat01" href="#"  id="btnPrintSummaryConfig02" title="Calificaciones Materia Resume">
									<i class="fa fa-print bigger-130 "></i>
								</a>
							</div>

							<div class="hidden-phone visible-desktop action-buttons pull-left ">
								<a class="widget-toolbar blue no-border isModMat01" href="#"  id="btnAddConfigMat02" title="Ir al Panel de Configuración de Materias">
									<i class="icon-cog bigger-130"></i>
								</a>
							</div>

							<div class="hidden-phone visible-desktop action-buttons pull-left ">
								<a class="widget-toolbar green no-border isModMat01" href="#"  id="btnRefeshConfigMat02" title="Actualizar Configuraciones">
									<i class="icon-refresh bigger-130"></i>
								</a>
							</div>

							<div class="hidden-phone visible-desktop action-buttons pull-left ">
								<a class="widget-toolbar red no-border isModMat01" href="#"  id="btnPrintListCal02" title="Captura de Conductas y Observaciones">
									<i class="fa fa-list bigger-130"></i>
								</a>
							</div>

						</div>

						<div class="col-lg-2 ">
						</div>


					</div>

					<div role="separator" class="divider"></div>

					<div class="col-lg-12 input-group">

						<div class="col-lg-6 ">

							<div class="input-group">
								<span class="input-group-addon">
									<label class="clear-lbl-addon lbl0" for="cmbNumEval">Evaluación:</label>
								</span>
								<select id="cmbNumEval" name="cmbNumEval" class="form-control">
									<option value="0" selected>Seleccione una Evaluación</option>
								</select>
							</div>

						</div>

						
						<div class="col-lg-2">
						</div>

						<div class="col-lg-2 ">
						</div>

					</div>

					<div role="separator" class="divider"></div>

					<div class="col-lg-12 input-group">

						<div class="col-lg-6 ">
							<div class="input-group">
								<span class="input-group-addon">
									<label class="clear-lbl-addon lbl0" for="cmbConfigMaterias100">Configuración:</label>
								</span>
								<select id="cmbConfigMaterias100" name="cmbConfigMaterias100" class="form-control">
									<option value="0" selected>Seleccione una Configuración</option>
								</select>							
							</div>
						</div>
						
						<div class="col-lg-2">
							<small id="totalMKB002" class="orange"></small>
							<a href="#" class="btn btn-minier btn-yellow marginLeft1em " id="btnCapHoriz"><i class="icon icon-coffee"></i></a>
						</div>

						<div class="col-lg-1 ">
							
						</div>

					</div>

					<div role="separator" class="divider"></div>

					<div class="col-lg-12 input-group" id="divIdGruMatCon">

						<div class="col-lg-6 ">
							<div class="input-group">
								<span class="input-group-addon">
									<label class="clear-lbl-addon lbl0" for="cmbConfigMateriasMKB200">Elementos:</label>
								</span>
								<select id="cmbConfigMateriasMKB200" name="cmbConfigMateriasMKB200" class="form-control">
									<option value="0" selected>Seleccione una Configuración</option>
								</select>						
							</div>
						</div>
						
						<div class="col-lg-2">
							<small id="totalMKB0023" class="orange"></small>	
						</div>

						<div class="col-lg-2 ">
						</div>
					

					</div>

					<div role="separator" class="divider"></div>

					<div class="col-lg-12">

						<div class="form-actions center">
							<button class="btn btn-success" type="submit" id="cmdGoToCapCalMKB023">
								Capturar Calificaciones
								<i class="icon-arrow-right icon-on-right bigger-130"></i>
							</button>
						</div>

					</div>

					<input type="hidden" name="idgrupo" id="idgrupo" value="0">
					<input type="hidden" name="num_eval_capcal_fmt_1" id="num_eval_capcal_fmt_1" value="0">

				</form>

				</div>
			</div>
		</div>	
	</div>
</div>


<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();
	var IdUNA = localStorage.IdUserNivelAcceso;
	var evalDef = 0;
	var evalMod = 0;
	var IdGruMatCon = 0;
	var IdGruMatConMKB = 0;
	var IdGrupo = <?= $idgrupo; ?>;
	var Grupo = "<?= $grupo; ?>";
	var arrMat = [];

	$(".lbl0").width(86);

	$("#divIdGruMatCon").hide();
	$(".isModMat01").hide();
	$("#btnCapHoriz").hide();
	// $("#btnCapHoriz").css('Display', 'none');
	$("#cmdGoToCapCalMKB023").attr('Disabled', true);


	$("#cmdGoToCapCalMKB023").on("click",function(event){
		event.preventDefault();
		var ar0 = $("#cmbConfigMaterias100").val().split('-');
		var ar1 = $("#cmbConfigMateriasMKB200").val().split('-');
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "captura-cal-mkb/", {
				idgrumat: $("#cmbMaterias100").val(),
				materia: $("#cmbMaterias100 :selected").text(),
				configmat: $("#cmbConfigMaterias100 :selected").text(),
				configmkb: $("#cmbConfigMateriasMKB200 :selected").text(),
				idgrupo: IdGrupo,
				idgrumatcon: ar0[1],
				idgrumatconmkb: ar1[1],
				num_eval: evalDef,
				grupo: Grupo
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Captura de Calificaciones del Markbook' ));
	                });
	            }, "html");
        });

        return false;

	});


/*
 
	$.getEval = function (IdGrupo) {
	    var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;

	    $.post(obj.getValue(0)+"data/", { o:1, t:37, p:11, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	            if (json.length>0){
	            	
	            	obj.getConfig(parseInt(json[0].idnivel,0),1);
	            	evalMod = localStorage.eval0;

	            	obj.getConfig(parseInt(json[0].idnivel,0),0);
	            	
	            	if (!localStorage.eval0){
	            		localStorage.eval0 = 1;
	            	}
	           		evalDef = localStorage.eval0; 
	           		// alert(evalDef);
	           		getMateriasMKB(IdGrupo);

	           		$("#cmbMaterias100").attr('Disabled', false);
	           		$("#cmbConfigMaterias100").attr('Disabled', false);
	           		$("#cmbConfigMateriasMKB200").attr('Disabled', false);
	           	}else{
	           		$("#cmbMaterias100").attr('Disabled', true);
	           		$("#cmbConfigMaterias100").attr('Disabled', true);
	           		$("#cmbConfigMateriasMKB200").attr('Disabled', true);
	           	}

	           	$("#barInfoR0").html(sayNoEval(evalDef));
	           	$("#num_eval_capcal_fmt_1").val(evalDef);
			    $("#preloaderPrincipal").hide();

	        }, "json"
	    );

	}

*/





/* ***************************** METERIAS ***************************** */

    function getMateriasMKB(IdGrupo){
	    $("#preloaderPrincipal").show();
	    var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;
	    // alert(nc);
	    $("#cmbMaterias100").html("<option value='0' selected>Seleccione una Materia</option>");
	    $.post(obj.getValue(0)+"data/", { o:1, t:17, p:0, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	            if (json.length>0){
	            	arrMat = [];
	               $.each(json, function(i, item) {
	                    $("#cmbMaterias100").append('<option value="'+item.data+'"> '+item.label+'</option>');
	                    arrMat[i] = {
	                    				idgrumat: item.data, 
	                    				eval_default: item.eval_default, 
	                    				eval_mod: item.eval_mod,
	                    				bloqueada: item.materia_bloqueada
	                    			}
	                });	               
	               	$("#cmbConfigMaterias100").attr('Disabled', false);
	           		$("#cmbConfigMateriasMKB200").attr('Disabled', false);
	           	}else{
	           		$("#cmbConfigMaterias100").attr('Disabled', true);
	           		$("#cmbConfigMateriasMKB200").attr('Disabled', true);
	           	}

			    $("#preloaderPrincipal").hide();

	        }, "json"
	    );
	}

	$("#btnRefeshConfigMat02").on("click",function(event){
			event.preventDefault();
			$("#cmbConfigMaterias100").empty();
			$("#cmbConfigMateriasMKB200").empty();
	    	$("#divIdGruMatCon").hide();
			$("#totalMKB0023").empty();
			$("#totalMKB002").empty();
			$("#btnCapHoriz").hide();
	    	$(".isModMat01").hide();			
			getMateriasMKB(IdGrupo);
	});

	$("#cmbMaterias100").on("change",function(event){
		event.preventDefault();
		$("#cmdGoToCapCalMKB023").attr('Disabled', true);
		$("#cmbConfigMaterias100").empty();
		$("#cmbConfigMateriasMKB200").empty();
    	$("#divIdGruMatCon").hide();
		$("#totalMKB0023").empty();
		$("#totalMKB002").empty();
		$("#btnCapHoriz").hide();
    	$(".isModMat01").hide();
    	var IdGruMat = $(this).val();
		var val0 =  obj.searchInArray( arrMat, $('#cmbMaterias100').val(), "idgrumat" );
		if (val0 > -1 ){
			if ( arrMat[val0].bloqueada == 1 ){
				alert("Materia Bloqueda");
				return false;
			}
			$("#cmbNumEval").empty();
			$("#cmbNumEval").append('<option value="'+arrMat[val0].eval_default+'" selected>'+arrMat[val0].eval_default + '</option>');
			$("#cmbNumEval").append('<option value="'+arrMat[val0].eval_mod+'" >'+arrMat[val0].eval_mod + '</option>');
			evalDef = parseInt(arrMat[val0].eval_default);
			evalMod = parseInt(arrMat[val0].eval_mod);

           	sayNumEval(evalDef);

           	$("#cmbNumEval").on("change",function(event){
           		event.preventDefault();
				$("#cmdGoToCapCalMKB023").attr('Disabled', true);           		
				evalDef = parseInt( $(this).val() );
	           	sayNumEval(evalDef);
				$("#cmbConfigMaterias100").empty();
		    	$(".isModMat01").show();
				getConfigMatMKB( IdGruMat );
           	})


		}else{
			return false;
		}	
    	$(".isModMat01").show();
		getConfigMatMKB( $(this).val() );

	});

	function sayNumEval(evalDef){
       	$("#barInfoR0").html(sayNoEval(evalDef));
       	$("#num_eval_capcal_fmt_1").val(evalDef);		
	}

/* ***************************** CONFIG MATERIAS ***************************** */

    function getConfigMatMKB(IdGruMat){
	    $("#preloaderPrincipal").show();
	    $("#cmbConfigMaterias100").empty();
	    $("#cmbConfigMaterias100").append("<option value='0' selected>Seleccione una Configuración</option>");
	    var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+evalDef;
	    $.post(obj.getValue(0)+"data/", { o:1, t:38, p:11, c:nc, from:0, cantidad:0, s:" order by idgrumatcon asc " },
	        function(json){
	            if (json.length>0){
	            	$("#cmbConfigMaterias100").empty();
				    $("#cmbConfigMaterias100").html("<option value='0' selected>Seleccione una Configuración</option>");
	               $.each(json, function(i, item) {
	                    $("#cmbConfigMaterias100").append('<option value="modGruMatCon100-'+item.idgrumatcon+'-'+item.idgrumat+'" >'+item.descripcion+' ('+parseFloat(item.porcentaje).toFixed(0)+'%) ' + '</option>');
	                });
	               
	           		$("#cmbConfigMaterias100").attr('Disabled', false);
	           		$("#cmbConfigMateriasMKB200").attr('Disabled', false);
	           		$(".isModMat01").show();
	           	}else{
	           		$("#cmbConfigMaterias100").attr('Disabled', false); // true
	           		$("#cmbConfigMateriasMKB200").attr('Disabled', false); // true
					$(".isModMat01").show();
	           	}

			    $("#preloaderPrincipal").hide();

	        }, "json"
	    );
	}

	$("#cmbConfigMaterias100").on("change",function(event){
		event.preventDefault();
		$("#cmdGoToCapCalMKB023").attr('Disabled', true);		
		$("#cmbConfigMateriasMKB200").empty();
    	$("#divIdGruMatCon").hide();
		$("#totalMKB0023").empty();
		$("#totalMKB002").empty();
		$("#btnCapHoriz").hide();

		var ar = $(this).val().split("-");

	    var nc = "idgrumatcon|boleta_partes|idgrumatcon="+ar[1];
	    $.post(obj.getValue(0)+"data/", { o:45, t:0, p:15, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	            if (parseInt(json[0].msg)>0){
	            	$("#totalMKB002").html(json[0].msg+" alumnos");
	            	$("#btnCapHoriz").show();

	            	$("#divIdGruMatCon").show();
					getItemMKB200( ar[1] );
					IdGruMatCon = ar[1];
	            }else{
	            	$("#divIdGruMatCon").hide();
	            	$("#totalMKB002").empty();
					$("#btnCapHoriz").hide();
					IdGruMatCon = 0;
	            }
	        }, "json"
	    );
	});

	$("#btnBolAsist00").on("click",function(event){
		event.preventDefault();


        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "captura-asistencia/", {
				idgrumat: $("#cmbMaterias100").val(),
				materia: $("#cmbMaterias100 :selected").text(),
				num_eval: evalDef,
				grupo : localStorage.grupo_cal,
				idgrupo : IdGrupo,
				profesor : $("#nameuser").html()
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Captura de Asistencias' ));
	                });
	            }, "html");
        });
        return false;
	});	

	$("#btnAddConfigMat02").on("click",function(event){
		event.preventDefault();

        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cal_partes_config/", {
				idgrumat: $("#cmbMaterias100").val(),
				materia: $("#cmbMaterias100 :selected").text(),
				num_eval: evalDef,
				grupo: localStorage.grupo_cal
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Configuración de Partes' ));
	                });
	            }, "html");
        });

        return false;
	});	

	// Imprime Materias de Detalle
	$("#btnPrintSummaryConfig01").on("click",function(event){
		event.preventDefault();

			var logoEmp =obj.getConfig(100,0); 
			var nc = "u=" + localStorage.nc+
					"&grupo=" + localStorage.grupo_cal + 
					"&idgrupo=" + IdGrupo + 
					"&idgrumat=" + $("#cmbMaterias100 :selected").val()+
					"&materia=" + $("#cmbMaterias100 :selected").text()+
					"&profesor=" + $("#nameuser").html()+
					"&eval=" + evalDef+
					"&logoEmp=" + logoEmp;
			
			

	        var PARAMS = {o:0, t:38, c:nc, p:11, from:0, cantidad:0, s:''};  
	        var url = obj.getValue(0)+"lista-calificaciones-profesor-1/";

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


	// Imprime Materias de Detalle en formato MS Excel
	$("#btnPrintSummaryConfig01xls").on("click",function(event){
		event.preventDefault();

		alert("Módulo en Construcción"); 
		return false; 

		var logoEmp =obj.getConfig(100,0); 
		var nc = "u=" + localStorage.nc+
				"&grupo=" + localStorage.grupo_cal + 
				"&idgrupo=" + IdGrupo + 
				"&idgrumat=" + $("#cmbMaterias100 :selected").val()+
				"&materia=" + $("#cmbMaterias100 :selected").text()+
				"&profesor=" + $("#nameuser").html()+
				"&eval=" + evalDef+
				"&logoEmp=" + logoEmp;
		
        var PARAMS = {o:0, t:38, c:nc, p:11, from:0, cantidad:0, s:''}; 
        var url = obj.getValue(0)+"lista-calificaciones-profesor-1-xls/"; 

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


	// Imprime Materias de Resume
	$("#btnPrintSummaryConfig02").on("click",function(event){
		event.preventDefault();

			var logoEmp =obj.getConfig(100,0); 
			var nc = "u=" + localStorage.nc+
					"&grupo=" + localStorage.grupo_cal + 
					"&idgrupo=" + IdGrupo + 
					"&idgrumat=" + $("#cmbMaterias100 :selected").val()+
					"&materia=" + $("#cmbMaterias100 :selected").text()+
					"&profesor=" + $("#nameuser").html()+
					"&eval=" + evalDef+
					"&logoEmp=" + logoEmp;
			
	        var PARAMS = {o:0, t:38, c:nc, p:11, from:0, cantidad:0, s:''};  
	        var url = obj.getValue(0)+"lista-calificaciones-profesor-2/";

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

/* ***************************** CONFIG MKB ***************************** */

    function getItemMKB200(IdGruMatCon){
	    $("#preloaderPrincipal").show();
		$("#cmbConfigMateriasMKB200").empty();	    
	    $("#cmbConfigMateriasMKB200").html("<option value='0' selected>Seleccione una Opción</option>");
	    var nc = "u="+localStorage.nc+"&idgrumatcon="+IdGruMatCon;
	    $.post(obj.getValue(0)+"data/", { o:1, t:56, p:0, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	            if (json.length>0){
	               $.each(json, function(i, item) {
	                    $("#cmbConfigMateriasMKB200").append('<option value="modGruMatConMKB200-'+item.data+'" >'+item.label+ '</option>');
	                });
	               
	           	}else{
	           	}

			    $("#preloaderPrincipal").hide();

	        }, "json"
	    );
	}

	$("#cmbConfigMateriasMKB200").on("change",function(event){
		event.preventDefault();
		$("#cmdGoToCapCalMKB023").attr('Disabled', true);
		getAlumnoInMKB(nc);

	});

	$("#createBolParMKB0").on("click",function(event){
		event.preventDefault();		
	    var nc = "user="+localStorage.nc+"&idgrumatcon="+IdGruMatCon+"&idgrumatconmkb="+IdGruMatConMKB;

	    $.post(obj.getValue(0)+"data/", { o:45, t:0, p:16, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	        	if (json[0].msg = "OK"){

					getAlumnoInMKB();

	        	}else{

            		$("#totalMKB0023").empty();
					$("#btnCapHoriz").hide();
	            	IdGruMatConMKB = IdGruMatConMKB;

	        	}
	        }, "json"
	    );

	});


	function getAlumnoInMKB(){

		var ar = $("#cmbConfigMateriasMKB200").val().split("-");
	    var nc = "idgrumatconmkb|boleta_partes_markbook|idgrumatconmkb="+ar[1];

	    $.post(obj.getValue(0)+"data/", { o:45, t:0, p:15, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	            if (parseInt(json[0].msg)>0){
	            	$("#totalMKB0023").html(json[0].msg+" alumnos");
					$("#btnCapHoriz").show();
            		$("#cmdGoToCapCalMKB023").attr('Disabled', false);
	            }else{
	            	if ( parseInt(ar[1]) > 0 ){
	            		$("#totalMKB0023").empty();
						$("#btnCapHoriz").hide();
	            		$("#cmdGoToCapCalMKB023").attr('Disabled', false);
		            	IdGruMatConMKB = ar[1];
	            	}else{
	            		$("#totalMKB0023").empty();
						$("#btnCapHoriz").hide();
	            		$("#cmdGoToCapCalMKB023").attr('Disabled', true);
		            	IdGruMatConMKB = 0;
	            	}
	            }	
	        }, "json"
	    );

	}

/* ************************************************************************************************************** */	

	getMateriasMKB(IdGrupo);

/* ************************************************************************************************************** */	

	$("#btnPrintListCal02").on("click",function(event){
		event.preventDefault();

        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
            $.post(obj.getValue(0) + "captura-con-obs-pai-1/", {
                    user: nc,
                    idgrupo:IdGrupo,
                    grupo: Grupo,
                    idgrumat: $("#cmbMaterias100 :selected").val(),
                    materia : $("#cmbMaterias100 :selected").text(),
                    numeval: evalDef
                },
                function(html) {
                    $("#contentProfile").html(html).show('slow',function(){
                    $('#breadcrumb').html(getBar('Inicio, Captura de Calificaciones: <span class="smaller lighter red">'+Grupo+'</span>'  ));
                });
                }, "html");
            return false;
		});	
	});	

	/* ************************************************************************************************************** */	

	/*

		var stream = io.connect(obj.getValue(4));
		stream.on("servidor", jsNewEstado);
		function jsNewEstado(datosServer) {
			var ms = datosServer.mensaje.split("-");
			if (ms[1]=='GRUMATCON' || ms[1]=='GRUMATCONMKB') {
		    	$("#divIdGruMatCon").hide();
				$("#totalMKB0023").empty();
				$("#totalMKB002").empty();
				//getConfigMatMKB( $("#cmbMaterias100").val() );
			}
		}

	*/


	$("#btnCapHoriz").on('click',function(event){
		event.preventDefault();
		alert("Módulo en Construcción");
		return false;

	});

});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>