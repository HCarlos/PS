<?php

include("includes/metas.php");

$user = $_POST['user'];
$idasesoria  = $_POST['idasesoria'];
$idalumno  = $_POST['idalumno'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">

	<form id="frmAse1" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					<span class="header smaller lighter blue" id="title"></span>
				</a>
			</li>

		</ul>

		<div class="tabbable">

				<div class="tab-content">

					<div id="general" class="tab-pane active">
						<table class="wd100prc">
							<tr>
								<td class="wd10prc">
		                    		<label for="idpaiareadisciplinaria" class="lblH2cmb">Alumno </label>
		                    	</td>	
								<td class="wd100prc">
									<input class="input-large form-control altoMoz wd60prc show" id="search_alumno" name="search_alumno" type="text" placeholder="Alumno" autofocus>
		                    	</td>	
							</tr>
							<tr>
								<td>
		                    		<label class="lblH2cmb"> </label>
		                    	</td>	
								<td>
					    			<label id="datosAlumno" class="control-label"></label>
		                    	</td>	
							</tr>
							<tr class="bodyFrom">
								<td>
					    			<label for="titulo_reporte" class="control-label">Título Reporte</label>
		                    	</td>	
								<td>
							    	<input type="text" class="form-control altoMoz" id="titulo_reporte" name="titulo_reporte" required >
				      			</td>
							</tr>
							<tr class="bodyFrom">
								<td>
					    			<label for="reporte" class="control-label">Descriptor</label>
		                    	</td>	
								<td>
									<textarea class="form-control" rows="6" id="reporte" name="reporte"></textarea>
								</td>
							</tr>

							<tr class="bodyFrom">
								<td class="wd25prc">
		                    		<label for="idpersonaacuerdo" class="lblH2cmb">Tutor / Familiar:</label>
		                    	</td>	
								<td class="wd100prc">
				                    <select name="idpersonaacuerdo" id="idpersonaacuerdo" size="1" class="altoMoz" style="width:100% !important;" > 
				                    </select>
		                    	</td>	
							</tr>
							<tr class="bodyFrom">
								<td>
		                    		<label class="lblH2cmb">Asesor: </label>
		                    	</td>	
								<td>
					    			<label id="nombre_persona_asesoria" class="control-label altoMoz"></label>
		                    	</td>	
							</tr>
							<tr class="bodyFrom">
								<td>
									<label for="status_asesoria" class="control-label altoMoz">
											Activo
									</label>
								</td>
								<td>
									<input name="status_asesoria" id="status_asesoria" class="ace ace-switch ace-switch-6 altoMoz" type="checkbox" checked>
									<span class="lbl"></span>
								</td>
							</tr>

						</table>			

					</div>

				</div>

			    <input type="hidden" name="idasesoria" id="idasesoria" value="<?= $idasesoria; ?>">
			    <input type="hidden" name="idalumno" id="idalumno" value="<?= $idalumno; ?>">
			    <input type="hidden" name="idgrupo" id="idgrupo" value="<?= $idgrupo; ?>">
			    <input type="hidden" name="idnivel" id="idnivel" value="<?= $idnivel; ?>">
			    <input type="hidden" name="idciclo" id="idciclo" value="<?= $idciclo; ?>">
			    <input type="hidden" name="idpersona_acuerdo" id="idpersona_acuerdo" value="<?php echo $idpersona_acuerdo; ?>">
			    <input type="hidden" name="idusuario_acuerdo" id="idusuario_acuerdo" value="<?php echo $idusuario_acuerdo; ?>">
			    <input type="hidden" name="idpersona_asesoria" id="idpersona_asesoria" value="<?php echo $idpersona_asesoria; ?>">
			    <input type="hidden" name="idusuario_asesoria" id="idusuario_asesoria" value="<?php echo $idusuario_asesoria; ?>">
			    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">

			    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
			    	<button type="button" class="btn btn-default pull-right exitAse1b" data-dismiss="modal" ><i class="icon-signout"></i>Cerrar</button>
			    	<span class="muted"></span>
			    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
				</div>


		</div>

	</form>

</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var IdNivel = 0;
	var IdGrupo = 0;
	var IdAlumno = 0;
	var data = [];

	$("#preloaderPrincipal").hide();

	var idasesoria = <?= $idasesoria ?>;

	if ( idasesoria == 0  ){
		$(".bodyFrom").hide();
		getAlumnos();
		$("#search_alumno").focus();
	}else{
		$( "#search_alumno" ).prop("disabled",true);
		IdAlumno = <?= $idalumno ?>;
		getFamiliares();	
	}

	function getAsesoria(IdAsesoria){
		$.post(obj.getValue(0) + "data/", {o:69, t:84, c:IdAsesoria, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#idasesoria").val(json[0].idasesoria);
					$("#titulo_reporte").val(json[0].titulo_reporte);
					$("#reporte").html(json[0].reporte);
					$("#idpersona_acuerdo").val(json[0].idpersona_acuerdo);
					$("#nombre_persona_asesoria").val(json[0].nombre_persona_asesoria);
					$("#idusuario_acuerdo").val(json[0].idusuario_acuerdo);
					$("#idusuario_asesoria").val(json[0].idusuario_asesoria);
					$("#status_asesoria").prop("checked",json[0].status_asesoria==1?true:false);	
					$("#idalumno").val(json[0].idalumno);
					$("#idgrupo").val(json[0].idgrupo);
					$("#idnivel").val(json[0].idnivel);
					$("#idgrupo").val(json[0].idgrupo);
					$("#idciclo").val(json[0].idciclo);
					$("#idpersona_acuerdo").val(json[0].idpersona_acuerdo);
					$("#idusuario_acuerdo").val(json[0].idusuario_acuerdo);
					$("#idpersona_asesoria").val(json[0].idpersona_asesoria);
					$("#idusuario_asesoria").val(json[0].idusuario_asesoria);
					$("#idpersonaacuerdo").val(json[0].idpersona_acuerdo+' - '+json[0].idusuario_acuerdo);
				}
		},'json');
	}

    $("#frmAse1").unbind("submit");
    $("#frmAse1").on("submit",function(event){
        event.preventDefault();

        if ( validForm() ) {

            $("#preloaderPrincipal").show();
            
            getDatosTutores($("#idpersonaacuerdo"));

            var queryString = $(this).serialize();  
            
            // alert(queryString);

            var IdAsesoria = (idasesoria==0?0:1);
            $.post(obj.getValue(0) + "data/", {o:69, t:IdAsesoria, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
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



	$(".exitAse1b").on("click",function(event){
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
/*
		if(parseInt($("#idpaiareadisciplinaria").val(),0) < 0){
			alert("Faltan el Área Disciplinaria");
			$("#idpaiareadisciplinaria").focus();
			return false;
		}

		if(parseInt($("#idpaicriterio").val(),0) < 0){
			alert("Faltan el Criterio");
			$("#idpaicriterio").focus();
			return false;
		}

		if($("#objetivo").val().length <= 0){
			alert("Faltan el Objetivo");
			$("#objetivo").focus();
			return false;
		}
*/
		return true;

	}

	function getFamiliares(){
	    var nc = "u="+localStorage.nc+"&idalumno="+IdAlumno;
	    $("#idpersonaacuerdo").empty();
	    $.post(obj.getValue(0)+"data/", { o:69, t:83, p:54,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	           $.each(json, function(i, item) {
	           		var ids = item.idpersona+" - "+item.idusertutor;
	           		var lbl = item.nombre_persona+" - "+item.parentezco;
	           		var cls = parseInt(item.idpersona,0) == parseInt(item.idtutor,0) ? " selected ":"";
	                $("#idpersonaacuerdo").append('<option value="'+ids+'" '+cls+' > '+lbl+'</option>');
	            });
	           
	           if (idasesoria > 0){
					getAsesoria(idasesoria);	
	           }

	        }, "json"
	    );  
	}

	$("#idpersonaacuerdo").on("change",function(event){
		event.preventDefault();
		getDatosTutores($(this));
	});

	function getDatosTutores(obj){
		var dt = $(obj).val().split(' - ');
		$("#idpersona_acuerdo").val(dt[0]);
		$("#idusuario_acuerdo").val(dt[1]);		
	}


	//custom autocomplete (category selection)
	$.widget( "custom.catcomplete", $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
			var that = this,
			currentCategory = "";
			$.each( items, function( index, item ) {
				if ( item.category != currentCategory ) {
					ul.append( "<li class='ui-autocomplete-category' id='act-"+item.indice+"' >" + item.category + "</li>" );
					currentCategory = item.category;
				}
				that._renderItemData( ul, item );
			});
		}
	
	});

    function getAlumnos(){
        var nc = "u="+localStorage.nc;
        $.ajax({ url: obj.getValue(0)+"data/",
            data: { o:69, t:80, p:54,c:nc,from:0,cantidad:0, s:" order by label asc " },
            dataType: "json",
            type: "POST",
            success: function(json){
               $.each(json, function(i, item) {
                    if ( item.label == null ){
                        console.log(item.label);
                	}else{
                    	data[i]={ 
                    			label: item.label , 
                    			category: "Alumno", 
                    			indice: item.data, 
                    			idgrupo: item.idgrupo, 
                    			idnivel: item.idnivel, 
                    			nivel: item.nivel 
                    		};
                	};
                });
				$( "#search_alumno" ).catcomplete({
					delay: 0,
					source: data,
					autoFocus: true,
					select: function(event, ui) { 
						if (ui.item){
							IdAlumno = ui.item.indice;
							IdNivel  = ui.item.idnivel;
							IdGrupo  = ui.item.idgrupo;
							$("#idalumno").val(IdAlumno);
							$("#idnivel").val(IdNivel);
							$("#idgrupo").val(IdGrupo);
							var dta0 = ui.item.label+" - "+ui.item.nivel;
							var dta1 = dta0.split(' - ');
							var html = '<span class="blue">'+dta1[0]+'</span>'+ ' | '+
									   '<span class="orange">'+dta1[1]+'</span>'+ ' | '+
									   '<span class="green">'+dta1[2]+'</span>';
							$("#datosAlumno").html(html);
							$(".bodyFrom").show();
							$("#nombre_persona_asesoria").html( '<span class="red">'+$("#nameuser").html()+'</span>' );							
							$("#idusuario_asesoria").val(localStorage.IdUser);
							$("#titulo_reporte").focus();
							
							getFamiliares();
			        	}
			      	},
					open: function() {
						$('.ui-autocomplete-categorya').next('.ui-menu-item').addClass('ui-first');
					} 			      	
				});
				$("#search_alumno").focus();
				$("#preloaderPrincipal").hide();
            }
		});
	
	}




});

</script>