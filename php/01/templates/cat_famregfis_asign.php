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


		<div class="widget-box" id="wdMemberFam">
			<div class="widget-header">
				<h4 class="pull-left">Registros Fiscales relacionados con esta Familia</h4>
					<span class="widget-toolbar">
						<a href="#" class="ui-pg-div" id="cat-famregfis-prop">
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
								    <th class="tbl80W">RFC</th>
								    <th class="tbl200W">RAZON SOCIAL</th>
								    <th class="tbl50W">Default</th>
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

	    <input type="hidden" name="idfamilia" id="idfamilia" vregfise="<?php echo $idfamilia; ?>">
	    <input type="hidden" name="user" id="user" vregfise="<?php echo $user; ?>">

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
		$.post(obj.getValue(0) + "data/", {o:15, t:29, c:nc, p:11, from:0, cantidad:0,s:'idfamregfis'},
			function(json){
				if (json.length > 0){
					//$("#title").html("Fam: " + json[0].familia);

					$("#tblMemberFam > tbody ").html("");
					var str = "";
					
		           	$.each(json, function(i, item) {
		           				var pred = parseInt(item.predeterminado,0) == 1 ? "<img src='/img/Ok-icon.png' width='16' height='16' alt='' />":""
								str =  '  <tr>';
								str += '	    <td class="tbl50W">'+item.idfamregfis+'</td>';
								str += '	    <td class="tbl80W">'+item.rfc+'</td>';
								str += '	    <td class="tbl200W">'+item.razon_social+'</td>';
								str += '	    <td class="tbl50W">'+pred+'</td>';
								str += '	    <td class="tbl100W">';
								str += '		<div class="action-buttons">';						
								str += '			<a class="green modMemberFam" href="#" id="modMemberFam-'+item.idfamregfis+'" >';
								str += '				<i class="icon-pencil bigger-130"></i>';
								str += '			</a>';
								str += '			<a class="red delMemberFam" href="#"  id="delMemberFam-'+item.idfamregfis+'" >';
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
							$.post(obj.getValue(0) + "cat-famregfis-prop/", {
									user: nc,
									idfamilia: idfamilia,
									idfamregfis: aObj[1]
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
					        $.post(obj.getValue(0)+"data/",  { o:15, t:2, p:2, c:aObj[1], from:0, cantidad:0,s:'' },
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
				}else{
					 $("#preloaderPrincipal").hide();
					 return false;
				}

		},'json');

	}
	
	if ($("#cat-famregfis-prop").length) {
		$("#cat-famregfis-prop").on("click", function(event) {
			event.preventDefault();
			obj.setIsTimeLine(false);
			var nc = localStorage.nc;
			$.post(obj.getValue(0) + "cat-famregfis-prop/", {
					user: nc,
					idfamilia: idfamilia,
					idfamregfis :0
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

        if (datosServer.mensaje=='FAMREGFIS') {
            $boxMemberFam.trigger('reload.ace.widget');
        }
    }

*/

});

</script>