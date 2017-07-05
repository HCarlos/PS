<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idalumno  = $_POST['idalumno'];
$alumno  = $_POST['alumno'];

?>

<h3 class="header smaller lighter blue">
    <span id="title"></span>
    <a class="label label-info arrowed-in-right arrowed closeFormMedAlu0 pull-right">Regresar</a>	
</h3>

	<div class="widget-box" id="wdMedAlu">
		<div class="widget-header">
			<h4 class="pull-left">Médicos del Alumno</h4>
				<span class="widget-toolbar">
					<a href="#" class="ui-pg-div" id="cat-alumno-medicos-prop">
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
					<table class="table table-striped detFac" id="tblMedAlu" >
						<thead>
						    <tr>
							    <th class="tbl20W">#</th>
							    <th class="tbl120W">MÉDICO</th>
							    <th class="tbl100W">TELÉFONOS</th>
							    <th class="tbl200W">EMAILS</th>
							    <th class="tbl20W">DEFAULT</th>
							    <th class="tbl80W"></th>
						    </tr>
						</thead>
						<tbody>
						</tbody>
						<tfoot>
						    <tr>
							    <th colspan="6"></th>
						    </tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>			

    <input type="hidden" name="idalumno" id="idalumno" value="<?php echo $idalumno; ?>">
    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">


<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();


	var idalumno = <?= $idalumno ?>;
	var alumno   = "<?= $alumno ?>";

	// close Form
	$(".closeFormMedAlu0").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").html("");
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});



	$("#title").html(idalumno+": <strong class='orange'>"+alumno+"</strong>");
	getMedicosALu(idalumno);

/********************************************************************
MODULO DE COMPORABLES Y HOMOLOGACION
******************************************************************* */

	function getMedicosALu(param){
		$("#preloaderPrincipal").show();
	    var nc = "u="+localStorage.nc+"&idalumno="+param;
		$.post(obj.getValue(0) + "data/", {o:48, t:108, c:nc, p:11, from:0, cantidad:0,s:'idmedalu'},
			function(json){
				$("#tblMedAlu > tbody ").html("");
				var str = "";
				
	           	$.each(json, function(i, item) {
	           				var isok = parseInt(item.predeterminado,0) == 1 ? "<img src='/img/Ok-icon.png' width='16' height='16' alt='' />":""
							str =  '  <tr>';
							str += '	    <td class="tbl20W">'+item.idmedalu+'</td>';
							str += '	    <td class="tbl120W">'+item.medico+'</td>';
							str += '	    <td class="tbl100W">'+item.tel1+', '+item.tel2+'</td>';
							str += '	    <td class="tbl200W">'+item.email1+', '+item.email2+'</td>';
							str += '	    <td class="tbl20W">'+isok+'</td>';
							str += '	    <td class="tbl80W">';
							str += '			<div class="action-buttons">';						
							str += '				<a class="green modMedAlu" href="#" id="modMedAlu-'+item.idmedalu+'" >';
							str += '					<i class="icon-pencil bigger-130"></i>';
							str += '				</a>';
							str += '				<a class="red delMedAlu" href="#"  id="delMedAlu-'+item.idmedalu+'" >';
							str += '					<i class="icon-trash bigger-130"></i>';
							str += '				</a>';
							str += '			</div>';
							str += '        </td>';
							str += '    </tr>';
							$("#tblMedAlu > tbody").append(str);
				});


				if ($(".modMedAlu").length) {
					$(".modMedAlu").on("click", function(event) {
						event.preventDefault();
						obj.setIsTimeLine(false);
						var nc = localStorage.nc;
						var aObj = event.currentTarget.id.split('-');
						$.post(obj.getValue(0) + "cat-alumno-medicos-prop/", {
								user: nc,
								idalumno: idalumno,
								idmedalu:aObj[1]
							},
							function(html) {
								$("#divUploadImage").html(html);
								$("#divUploadImage").modal('toggle',function(){
									//$("#ubicacion").focus();
								});
							}, "html");
					});
				}


				if ($(".delMedAlu").length) {
					$(".delMedAlu").on("click", function(event) {
						event.preventDefault();
						var aObj = event.currentTarget.id.split('-');
						var r = confirm("Desea eliminar el registro "+aObj[1]+"?");
						if (r == false) {
							return false;	
						}	
						obj.setIsTimeLine(false);
						// alert(aObj[1]);
				        $.post(obj.getValue(0)+"data/",  { o:48, t:5, p:2, c:aObj[1], from:0, cantidad:0,s:'' },
				            function(json){
				                if (json[0].msg=="OK"){
				                	$boxMedAlu.trigger('reloaded.ace.widget');
				                    alert("Registro eliminado con éxito!");
				                    // stream.emit("cliente", {mensaje: "MedAlu"});
				                    $("#preloaderPrincipal").hide();
				                    $("#divUploadImage").modal('hide');
				                }
				        }, "json");        
					});
				}

				$("#preloaderPrincipal").hide();
				
				if($boxMedAlu){
					$boxMedAlu.trigger('reloaded.ace.widget');
				}

		},'json');

	}
	
	if ($("#cat-alumno-medicos-prop").length) {
		$("#cat-alumno-medicos-prop").on("click", function(event) {
			event.preventDefault();
			obj.setIsTimeLine(false);
			var nc = localStorage.nc;
			$.post(obj.getValue(0) + "cat-alumno-medicos-prop/", {
					user: nc,
					idalumno: idalumno,
					idmedalu:0
				},
				function(html) {
					$("#divUploadImage").html(html);
					$("#divUploadImage").modal('toggle');
				}, "html");
		});
	}



	var $boxMedAlu = $('#wdMedAlu');
	$('#wdMedAlu').on('reload.ace.widget', function(e) {
		e.stopPropagation();//stop propagating to the event defined in ace.min.js which you should remove altogether
		getMedicosALu(idalumno);
	});


/*

	var stream = io.connect(obj.getValue(4));

    stream.on("servidor", jsNewAEFInformacion);
   	function jsNewAEFInformacion(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='MEDALU') {
            //$boxMedAlu.trigger('reload.ace.widget');
            getMedicosALu(idalumno);
        }
    }

*/

});

</script>