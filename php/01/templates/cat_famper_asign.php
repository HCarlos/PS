<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idfamilia  = $_POST['idfamilia'];

?>

<h3 class="header smaller lighter blue">
    <span id="title"></span>
    <a class="label label-info arrowed-in-right arrowed closeFormUpload pull-right">Regresar</a>	
</h3>

<form id="frmData"  class="form">

<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
	<div class="position-relative wd60prc">
		<div class="form-group ">
	    	<label for="familia" class="col-lg-3 control-label">Familia</label>
	    	<div class="col-lg-9">
		    	<input type="text" class="form-control altoMoz" id="familia" name="familia" >
	  		</div>
	    </div>

		<div class="form-group ">
	    	<label for="email" class="col-lg-3 control-label">Email Factura</label>
	    	<div class="col-lg-9">
		    	<input type="text" class="form-control altoMoz" id="email" name="email" >
	  		</div>
	    </div>

		<div class="form-group ">
	    	<label for="status_familia" class="col-lg-3 control-label">Status</label>
	    	<div class="col-lg-9">
				<select class="form-control input-lg"  name="status_familia" id="status_familia" size="1">
					<option value="0">Inactivo</option>
					<option value="1" selected >Activo</option>
				</select>
	  		</div>
	    </div>
	</div>
	<div class="position-relative ">
		
	</div>


	<div class="clearfix"></div>
<hr />
	<div class="widget-box" id="wdMemberFam">
		<div class="widget-header">
			<h4 class="pull-left">Miembros de la familia</h4>
				<span class="widget-toolbar">
					<a href="#" class="ui-pg-div" id="cat-famper-prop">
						<i class="ui-icon icon-plus-sign purple"></i>
					</a>
					<a href="#" class="ui-pg-div" data-action="reload" >
						<i class="ui-icon icon-refresh green"></i>
					</a>
					<a href="#" data-action="collapse">
						<i class="icon-chevron-up"></i>
					</a>					
				</span>			
		</div>
		<div class="widget-body">
			<div class="widget-main">
				<div class="row-fluid">
					<table class="table table-striped detFac" id="tblMemberFam" >
						<thead>
						    <tr>
							    <th class="tbl50W">#</th>
							    <th class="tbl80W">PARENTEZCO</th>
							    <th class="tbl200W">PERSONA</th>
							    <th class="tbl20W">Rec Email</th>
							    <th class="tbl100W"></th>
						    </tr>
						</thead>
						<tbody>
						</tbody>
						<tfoot>
						    <tr>
							    <th colspan="5"></th>
						    </tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>			

    <input type="hidden" name="idfamilia" id="idfamilia" value="<?php echo $idfamilia; ?>">
    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
	</div>

</form>

</div>
</div>

<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();


	var idfamilia = <?php echo $idfamilia ?>;

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		if (validForm()){
		    
		    var queryString = $(this).serialize();	

			var IdFamilia = (idfamilia==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:11, t:IdFamilia, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-FAMILIAS-PROP-"+idfamilia});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").html("");
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

	function getFamilia(IdFamilia){
		$("#preloaderPrincipal").show();
		$.post(obj.getValue(0) + "data/", {o:11, t:22, c:IdFamilia, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					idfamilia = json[0].idfamilia;
					$("#familia").val(json[0].familia);
					$("#email").val(json[0].email);
					$("#status_familia").val(json[0].status_familia);
                    $("#title").html("Fam: " + json[0].familia);

					$("#preloaderPrincipal").hide();

					getMemberFam(idfamilia);
				}
		},'json');

	}

	// close Form
	$(".closeFormUpload").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").html("");
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

	function validForm(){

		if($("#familia").val().length <= 0){
			alert("Faltan la Familia");
			$("#familia").focus();
			return false;
		}

		return true;

	}


	// getPisos();
	// getAplanados();
	// getPlafones();
	
	// //getMemberFam(idfamilia);

	// getUsoSuelo();
	// getNiveles();
	// getCimentaciones();
	// getEstructuras();
	// getMuros();
	// getEntrepisos();


	if (idfamilia<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando la Familia: "+idfamilia);
		getFamilia(idfamilia);
	}


/********************************************************************
MODULO DE COMPORABLES Y HOMOLOGACION
******************************************************************* */

	function getMemberFam(param){
		$("#preloaderPrincipal").show();
	    var nc = "u="+localStorage.nc+"&idfamilia="+param;
		$.post(obj.getValue(0) + "data/", {o:12, t:23, c:nc, p:11, from:0, cantidad:0,s:'idfamper'},
			function(json){
				$("#tblMemberFam > tbody ").html("");
				var str = "";
				
	           	$.each(json, function(i, item) {
	           				var isok = parseInt(item.is_email,0) == 1 ? "<img src='/img/Ok-icon.png' width='16' height='16' alt='' />":""
							str =  '  <tr>';
							str += '	    <td class="tbl50W">'+item.idfamper+'</td>';
							str += '	    <td class="tbl80W">'+item.parentezco+'</td>';
							str += '	    <td class="tbl200W">'+item.nombre_persona+'</td>';
							str += '	    <td class="tbl20W">'+isok+'</td>';
							str += '	    <td class="tbl100W">';
							str += '		<div class="action-buttons">';						
							str += '			<a class="green modMemberFam" href="#" id="modMemberFam-'+item.idfamper+'" >';
							str += '				<i class="icon-pencil bigger-130"></i>';
							str += '			</a>';
							str += '			<a class="red delMemberFam" href="#"  id="delMemberFam-'+item.idfamper+'" >';
							str += '				<i class="icon-trash bigger-130"></i>';
							str += '			</a>';
							str += '		</div>';
							str += '        </td>';
							str += '    </tr>';
							$("#tblMemberFam > tbody").append(str);
				});


				if ($(".modMemberFam").length) {
					$(".modMemberFam").on("click", function(event) {
						event.preventDefault();
						obj.setIsTimeLine(false);
						var nc = localStorage.nc;
						var aObj = event.currentTarget.id.split('-');
						$.post(obj.getValue(0) + "cat-famper-prop/", {
								user: nc,
								idfamilia: idfamilia,
								idfamper:aObj[1]
							},
							function(html) {
								$("#divUploadImage").html(html);
								$("#divUploadImage").modal('toggle',function(){
									//$("#ubicacion").focus();
								});
							}, "html");
					});
				}


				if ($(".delMemberFam").length) {
					$(".delMemberFam").on("click", function(event) {
						event.preventDefault();
						var aObj = event.currentTarget.id.split('-');
						var r = confirm("Desea eliminar el registro "+aObj[1]+"?");
						if (r == false) {
							return false;	
						}	
						obj.setIsTimeLine(false);
						//alert(aObj[1]);
				        $.post(obj.getValue(0)+"data/",  { o:12, t:2, p:2, c:aObj[1], from:0, cantidad:0,s:'' },
				            function(json){
				                if (json[0].msg=="OK"){
				                    alert("Registro eliminado con éxito!");
				                    // stream.emit("cliente", {mensaje: "AIMemberFam"});
				                    $("#preloaderPrincipal").hide();
				                    $("#divUploadImage").modal('hide');
				                }
				        }, "json");        
					});
				}

				$("#preloaderPrincipal").hide();
				
				if($boxMemberFam){
					$boxMemberFam.trigger('reloaded.ace.widget');
				}

		},'json');

	}
	
	if ($("#cat-famper-prop").length) {
		$("#cat-famper-prop").on("click", function(event) {
			event.preventDefault();
			obj.setIsTimeLine(false);
			var nc = localStorage.nc;
			$.post(obj.getValue(0) + "cat-famper-prop/", {
					user: nc,
					idfamilia: idfamilia,
					idfamper:0
				},
				function(html) {
					$("#divUploadImage").html(html);
					$("#divUploadImage").modal('toggle');
				}, "html");
		});
	}



	var $boxMemberFam = $('#wdMemberFam');
	$('#wdMemberFam').on('reload.ace.widget', function(e) {
		e.stopPropagation();//stop propagating to the event defined in ace.min.js which you should remove altogether
		getMemberFam(idfamilia);
		//getAnalisis(arrEnfoqueMercado[0].idfamilia);
	});


/*
	var stream = io.connect(obj.getValue(4));

    stream.on("servidor", jsNewAEFInformacion);
   	function jsNewAEFInformacion(datosServer) {

        if (datosServer.mensaje=='FAMPER') {
            $boxMemberFam.trigger('reload.ace.widget');
        }
    }
*/

});

</script>