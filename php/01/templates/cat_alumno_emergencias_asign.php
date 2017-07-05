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
    <a class="label label-info arrowed-in-right arrowed closeFormEmerAlu0 pull-right">Regresar</a>	
</h3>

	<div class="widget-box" id="wdEmerAlu">

		<div class="widget-header">
			<h4 class="pull-left">Emergencias del Alumno</h4>
				<span class="widget-toolbar">
					<a href="#" class="ui-pg-div" id="cat-alumno-emergencias-prop">
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
					<table class="table table-striped detFac" id="tblEmerAlu" >
						<thead>
						    <tr>
							    <th class="tbl20W">#</th>
							    <th class="tbl120W">NOMBRE</th>
							    <th class="tbl100W">TELÉFONOS</th>
							    <th class="tbl200W">PARENTESCO</th>
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
	$(".closeFormEmerAlu0").on("click",function(event){
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
	getEmerALu(idalumno);

/********************************************************************
MODULO DE COMPORABLES Y HOMOLOGACION
******************************************************************* */

	function getEmerALu(param){
		$("#preloaderPrincipal").show();
	    var nc = "u="+localStorage.nc+"&idalumno="+param;
		$.post(obj.getValue(0) + "data/", {o:53, t:25, c:nc, p:54, from:0, cantidad:0,s:'idemeralu'},
			function(json){
				$("#tblEmerAlu > tbody ").html("");
				var str = "";
				
	           	$.each(json, function(i, item) {
	           				var isok = parseInt(item.predeterminado,0) == 1 ? "<img src='/img/Ok-icon.png' width='16' height='16' alt='' />":""
							str =  '  <tr>';
							str += '	    <td class="tbl20W">'+item.idemeralu+'</td>';
							str += '	    <td class="tbl120W">'+item.nombre+'</td>';
							str += '	    <td class="tbl100W">'+item.tel1+'</td>';
							str += '	    <td class="tbl200W">'+item.parentezco+'</td>';
							str += '	    <td class="tbl20W">'+isok+'</td>';
							str += '	    <td class="tbl80W">';
							str += '			<div class="action-buttons">';						
							str += '				<a class="green modEmerAlu" href="#" id="modEmerAlu-'+item.idemeralu+'" >';
							str += '					<i class="icon-pencil bigger-130"></i>';
							str += '				</a>';
							str += '				<a class="red delEmerAlu" href="#"  id="delEmerAlu-'+item.idemeralu+'" >';
							str += '					<i class="icon-trash bigger-130"></i>';
							str += '				</a>';
							str += '			</div>';
							str += '        </td>';
							str += '    </tr>';
							$("#tblEmerAlu > tbody").append(str);
				});


				if ($(".modEmerAlu").length) {
					$(".modEmerAlu").on("click", function(event) {
						event.preventDefault();
						obj.setIsTimeLine(false);
						var nc = localStorage.nc;
						var aObj = event.currentTarget.id.split('-');
						$.post(obj.getValue(0) + "cat-alumno-emergencias-prop/", {
								user: nc,
								idalumno: idalumno,
								idemeralu:aObj[1]
							},
							function(html) {
								$("#divUploadImage").html(html);
								$("#divUploadImage").modal('toggle',function(){
									//$("#ubicacion").focus();
								});
							}, "html");
					});
				}


				if ($(".delEmerAlu").length) {
					$(".delEmerAlu").on("click", function(event) {
						event.preventDefault();
						var aObj = event.currentTarget.id.split('-');
						var r = confirm("Desea eliminar el registro "+aObj[1]+"?");
						if (r == false) {
							return false;	
						}	
						obj.setIsTimeLine(false);
						// alert(aObj[1]);
				        $.post(obj.getValue(0)+"data/",  { o:53, t:5, p:52, c:aObj[1], from:0, cantidad:0,s:'' },
				            function(json){
				                if (json[0].msg=="OK"){
				                	$boxEmerAlu.trigger('reloaded.ace.widget');
				                    alert("Registro eliminado con éxito!");
				                    // stream.emit("cliente", {mensaje: "EmerAlu"});
				                    $("#preloaderPrincipal").hide();
				                    $("#divUploadImage").modal('hide');
				                }
				        }, "json");        
					});
				}

				$("#preloaderPrincipal").hide();
				
				if($boxEmerAlu){
					$boxEmerAlu.trigger('reloaded.ace.widget');
				}

		},'json');

	}
	
	if ($("#cat-alumno-emergencias-prop").length) {
		$("#cat-alumno-emergencias-prop").on("click", function(event) {
			event.preventDefault();
			obj.setIsTimeLine(false);
			var nc = localStorage.nc;
			$.post(obj.getValue(0) + "cat-alumno-emergencias-prop/", {
					user: nc,
					idalumno: idalumno,
					idemeralu:0
				},
				function(html) {
					$("#divUploadImage").html(html);
					$("#divUploadImage").modal('toggle');
				}, "html");
		});
	}



	var $boxEmerAlu = $('#wdEmerAlu');
	$('#wdEmerAlu').on('reload.ace.widget', function(e) {
		e.stopPropagation();//stop propagating to the event defined in ace.min.js which you should remove altogether
		getEmerALu(idalumno);
	});


/*

	var stream = io.connect(obj.getValue(4));

    stream.on("servidor", jsNewAEFInformacion);
   	function jsNewAEFInformacion(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='MEDALU') {
            //$boxEmerAlu.trigger('reload.ace.widget');
            getEmerALu(idalumno);
        }
    }

*/

});

</script>