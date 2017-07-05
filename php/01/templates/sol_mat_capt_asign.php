<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idsolicituddematerial  = $_POST['idsolicituddematerial'];
$status_solicitud_de_material = $_POST['status_solicitud_de_material'];
$solicitante  = $_POST['solicitante'];

?>

<h3 class="header smaller lighter blue" >
    <span id="title"></span>
    <a class="label label-info arrowed-in-right arrowed closeFormUpload pull-right">Regresar</a>	
</h3>

	<form id="frmData"  class="form">

	<div class="row-fluid">
	<div class="span12" style="padding-left: 1em; padding-right: 1em;">


		<div class="widget-box" id="wdMemberFam">
			<div class="widget-header">
				<h4 class="pull-left">Lista de Artículos Pedidos en esta Orden</h4>
					<span class="widget-toolbar">
						<a href="#" class="ui-pg-div" id="cat-sol-mat-prop">
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
						<table class="table table-striped detFac" id="tblSolMatDet2" >
							<thead>
							    <tr>
								    <th class="tbl20W">#</th>
								    <th class="tbl180W">PROVEEDOR</th>
								    <th class="tbl180W">PRODUCTO</th>
								    <th class="tbl20W textRight">CANT.</th>
								    <th class="tbl20W textRight">PU</th>
								    <th class="tbl20W textRight">IMPORTE</th>
								    <th class="tbl200W">OBSERVACIONES</th>
								    <th class="tbl200W">FECHA AUTORIZADO</th>
								    <th class="tbl100W"></th>
							    </tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
							    <tr>
								    <th colspan="5"></th>
								    <th class=" textRight"> <span id="totalImporte"></span>  </th>								    
								    <th colspan="3"></th>
							    </tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>			

	    <input type="hidden" name="idsolicituddematerial" id="idsolicituddematerial" value="<?php echo $idsolicituddematerial; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">


	</div>
	</div>


	</form>

<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();
	if (status_solicitud_de_material==1){
		$("#cat-sol-mat-prop").hide();
	}

	accounting.settings = {
		currency: {
			symbol : " ", 
			format: "%s%v",
			decimal : ".",
			thousand: ",",  
			precision : 2   
		},
		number: {
			precision : 0,  
			thousand: ",",
			decimal : "."
		}
	}

	var idsolicituddematerial = <?php echo $idsolicituddematerial ?>;
	var status_solicitud_de_material = <?php echo $status_solicitud_de_material ?>;
	var solicitante = '<?php echo $solicitante; ?>';

	if (status_solicitud_de_material==1){
		$("#cat-sol-mat-prop").hide();
	}

	getSolMatDets0(idsolicituddematerial);

	$("#title").html("Editando ID: ("+idsolicituddematerial+") <strong style='color:orange;'>"+solicitante+"</strong>"  );

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



/********************************************************************
MODULO DE COMPORABLES Y HOMOLOGACION
******************************************************************* */

	function getSolMatDets0(param){
		$("#preloaderPrincipal").show();
	    var nc = "u="+localStorage.nc+"&idsolicituddematerial="+param;
		$.post(obj.getValue(0) + "data/", {o:38, t:85, c:nc, p:11, from:0, cantidad:0,s:' order by idsolicituddematerialdetalle asc'},
			function(json){
				//$("#title").html("Fam: " + json[0].familia);

				$("#tblSolMatDet2 > tbody ").html("");
				var str = "";
				var suma = 0;
				
	           	$.each(json, function(i, item) {
	           				//var isminor = parseInt(item.is_minor,0) == 1 ? "<img src='/img/Ok-icon.png' width='16' height='16' alt='' />":""
							var color = parseInt(item.idcolor,0) > 0 ? ' | <strong>COLOR</strong>: <strong style="color:'+item.codigo_color_hex+'">'+item.color+'</strong>':'';
							var FA = parseInt(item.status_solicitud_de_materiales,0) == 1 ? item.fecha_autorizacion :'';
							str =  '  <tr>';
							str += '	    <td class="tbl20W">'+item.idsolicituddematerialdetalle+'</td>';
							str += '	    <td class="tbl180W">'+item.proveedor+'</td>';
							str += '	    <td class="tbl180W">'+item.producto+' '+item.medida1+' '+color+'</td>';
							str += '	    <td class="tbl20W textRight">'+accounting.formatMoney(item.cantidad_solicitada)+'</td>';
							str += '	    <td class="tbl20W textRight">'+accounting.formatMoney(item.costo_unitario)+'</td>';
							str += '	    <td class="tbl20W textRight">'+accounting.formatMoney(item.importe_solicitado)+'</td>';
							str += '	    <td class="tbl200W">'+item.observaciones_solicitud+'</td>';
							str += '	    <td class="tbl20W textRight">'+FA+'</td>';
							str += '	    <td class="tbl100W">';
							str += '		<div class="action-buttons">';	
							if ( parseInt(item.status_solicitud_de_materiales,0) == 0 ){					
								str += '			<a class="green modMemberFam" href="#" id="modMemberFam-'+item.idsolicituddematerialdetalle+'" >';
								str += '				<i class="icon-pencil bigger-130"></i>';
								str += '			</a>';
								str += '			<a class="red delMemberFam" href="#"  id="delMemberFam-'+item.idsolicituddematerialdetalle+'" >';
								str += '				<i class="icon-trash bigger-130"></i>';
								str += '			</a>';
							}
							str += '		</div>';
							str += '        </td>';
							str += '    </tr>';
							$("#tblSolMatDet2 > tbody").append(str);
							suma += parseFloat(item.importe_solicitado);
				});
				
				$("#totalImporte").html(accounting.formatMoney(suma));

				if ($(".modMemberFam").length) {
					$(".modMemberFam").on("click", function(event) {
						event.preventDefault();
						obj.setIsTimeLine(false);
						var nc = localStorage.nc;
						var aObj = event.currentTarget.id.split('-');
						getPropSolMatDet0( aObj[1] );
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
				        $.post(obj.getValue(0)+"data/",  { o:39, t:2, p:2, c:aObj[1], from:0, cantidad:0,s:'' },
				            function(json){
				                if (json[0].msg=="OK"){
				                    alert("Registro eliminado con éxito!");
				                    stream.emit("cliente", {mensaje: "PLATSOURCE-SOLMATENC-PROP-"+aObj[1]});
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
	
	if (status_solicitud_de_material==1){
		$("#cat-sol-mat-prop").hide();
	}

	if ($("#cat-sol-mat-prop").length) {
		$("#cat-sol-mat-prop").on("click", function(event) {
			event.preventDefault();
			obj.setIsTimeLine(false);
			getPropSolMatDet0(0);
		});
	}


	function getPropSolMatDet0(IdSolMatEnc0){
        $("#contentLevel3").html("");
        $("#contentProfile").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
			$.post(obj.getValue(0) + "cat-sol-mat-prop/", {
					user: nc,
					idsolicituddematerial: idsolicituddematerial,
					idsolicituddematerialdetalle :IdSolMatEnc0
				},
				function(html) {
	                $("#contentLevel3").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Pedidos '));
	                });
				}, "html");
        });
        return false;
	}


	var $boxMemberFam = $('#wdMemberFam');
	$('#wdMemberFam').on('reload.ace.widget', function(e) {
		e.stopPropagation();//stop propagating to the event defined in ace.min.js which you should remove altogether
		getSolMatDets0(idsolicituddematerial);
		//getAnalisis(arrEnfoqueMercado[0].idsolicituddematerial);
	});



	var stream = io.connect(obj.getValue(4));

    stream.on("servidor", jsNewAEFInformacion);
   	function jsNewAEFInformacion(datosServer) {

		var ms = datosServer.mensaje.split("-");

		if (ms[1] == 'SOLMATDET' && parseInt(ms[3],0) == idsolicituddematerial ) {
			$boxMemberFam.trigger('reload.ace.widget');
		}

    }


});

</script>