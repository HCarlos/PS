<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idfamilia  = $_POST['idfamilia'];

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
				<h4 class="pull-left">Alumnos relacionados con esta Familia</h4>
					<span class="widget-toolbar">
						<a href="#" class="ui-pg-div" id="cat-famalu-prop">
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
								    <th class="tbl50W">ID ALU</th>
								    <th class="tbl80W">ALUMNO</th>
								    <th class="tbl200W">TUTOR</th>
								    <th class="tbl20W">Menor</th>
								    <th class="tbl20W">Vive con</th>
								    <th class="tbl100W"></th>
							    </tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
							    <tr>
								    <th colspan="7"></th>
							    </tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>			

	    <input type="hidden" name="idfamilia" id="idfamilia" value="<?php echo $idfamilia; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">


	</div>
	</div>


	</form>

<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();


	var idfamilia = <?php echo $idfamilia ?>;

	getMemberFam(idfamilia);

	$("#title").html("Editando la Familia: "+idfamilia);

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

	function getMemberFam(param){
		$("#preloaderPrincipal").show();
	    var nc = "u="+localStorage.nc+"&idfamilia="+param;
		$.post(obj.getValue(0) + "data/", {o:13, t:25, c:nc, p:11, from:0, cantidad:0,s:'idfamalu'},
			function(json){
				//$("#title").html("Fam: " + json[0].familia);

				$("#tblMemberFam > tbody ").html("");
				var str = "";
				
	           	$.each(json, function(i, item) {
	           				var isminor = parseInt(item.is_minor,0) == 1 ? "<img src='/img/Ok-icon.png' width='16' height='16' alt='' />":""
	           				var vivecon = item.parentezco != null ? item.parentezco:"";
							str =  '  <tr>';
							str += '	    <td class="tbl50W">'+item.idfamalu+'</td>';
							str += '	    <td class="tbl50W">'+item.idalumno+'</td>';
							str += '	    <td class="tbl80W">'+item.nombre_alumno+'</td>';
							str += '	    <td class="tbl200W">'+item.nombre_tutor+'</td>';
							str += '	    <td class="tbl20W">'+isminor+'</td>';
							str += '	    <td class="tbl20W">'+vivecon+'</td>';
							str += '	    <td class="tbl100W">';
							str += '		<div class="action-buttons">';						
							str += '			<a class="green modMemberFam" href="#" id="modMemberFam-'+item.idfamalu+'" >';
							str += '				<i class="icon-pencil bigger-130"></i>';
							str += '			</a>';
							str += '			<a class="red delMemberFam" href="#"  id="delMemberFam-'+item.idfamalu+'" >';
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
						$.post(obj.getValue(0) + "cat-famalu-prop/", {
								user: nc,
								idfamilia: idfamilia,
								idfamalu: aObj[1]
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
				        $.post(obj.getValue(0)+"data/",  { o:13, t:2, p:2, c:aObj[1], from:0, cantidad:0,s:'' },
				            function(json){
				                if (json[0].msg=="OK"){
				                    alert("Registro eliminado con éxito!");
				                    stream.emit("cliente", {mensaje: "AIMemberFam"});
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
	
	if ($("#cat-famalu-prop").length) {
		$("#cat-famalu-prop").on("click", function(event) {
			event.preventDefault();
			obj.setIsTimeLine(false);
			var nc = localStorage.nc;
			$.post(obj.getValue(0) + "cat-famalu-prop/", {
					user: nc,
					idfamilia: idfamilia,
					idfamalu :0
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



	var stream = io.connect(obj.getValue(4));

    stream.on("servidor", jsNewAEFInformacion);
   	function jsNewAEFInformacion(datosServer) {

        if (datosServer.mensaje=='FAMALU') {
            $boxMemberFam.trigger('reload.ace.widget');
        }
    }


});

</script>