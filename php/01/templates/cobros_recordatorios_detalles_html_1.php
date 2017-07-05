<?php

include("includes/metas.php");

$data = $_POST['data'];

if (!isset($data)){
	header('Location: http://platsource.mx/');
}

parse_str($data);

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();

require_once('../oCentura.php');
$f = oCentura::getInstance();

require_once('../oCenturaPDO.php');
$fP = oCenturaPDO::getInstance();

// $rs = $fP->getQueryPDO(30,$data,0,0,0,array(),"",1);
$rs = $fP->getQueryPDO(45,$data,0,0,0,array(),"",1);

?>

<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-default">

		
			<div class="widget-toolbar border pull-right">
			    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeWinRep01 " style="margin: 0 1em !important;" >
			        <i class="icon-angle-left icon-on-right"></i>
			        Regresar
			    </button>
			</div>

			<div class="widget-toolbar border pull-right">
				<!--
			    <button  type="button" class="btn btn-minier btn-success arrowed-in-right arrowed " id="sendEmail" style="margin: 0 1em !important;" >
			        <i class="white icon-envelope bigger-110"></i>
			        Enviar E-mails
			    </button>
			    -->
				<button data-toggle="dropdown" class="btn btn-minier btn-success arrowed-in-right arrowed dropdown-toggle">
					<i class="white icon-print bigger-110"></i>Enviar E-mails
					<span class="caret"></span>
				</button>

				<ul class="dropdown-menu dropdown-success">
					<li>
						<a href="#" id="sendEmail1">Formato 1</a>
					</li>

					<li>
						<a href="#" id="sendEmail2">Formato 2</a>
					</li>

				</ul>
			</div>

			<div class="widget-toolbar border pull-right">

				<button data-toggle="dropdown" class="btn btn-minier btn-success arrowed-in-right arrowed dropdown-toggle">
					<i class="white icon-print bigger-110"></i>												Imprimir
					<span class="caret"></span>
				</button>

				<ul class="dropdown-menu dropdown-success">
					<li>
						<a href="#" id="printFormato1">Formato 1</a>
					</li>

					<li>
						<a href="#" id="printFormato2">Formato 2</a>
					</li>


				</ul>

			</div>

			<div class="widget-toolbar orange pull-left no-border ">
				<h3 class="grey lighter  pull-left position-relative wd100prc">
					<i class="icon-print green"></i>
					LISTADO DE VENCIMIENTOS PARA <strong>RECORDATORIOS</strong>	
				</h3>
			</div>

		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

					<table aria-describedby="sample-table-2_info" id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
										
						<thead>
							<tr role="row">
								<th style="width: 100px;" colspan="1" rowspan="1" role="columnheader" tabindex="0" class="sorting_disabled">
									<label class="pull-right">
										<input class="ace" type="checkbox" id="idChK" checked>
										<span class="lbl"> All / None</span>
									</label>
								</th>
								<th aria-label="alumno: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">ALUMNO</th>
								<th aria-label="familia: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="2" role="columnheader" class="sorting">FAMILIA</th>
								<th aria-label="concepto: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting">CONCEPTO</th>
								<th aria-label="total: activate to sort column ascending" style="width: 80px;" aria-controls="sample-table-2" tabindex="4" role="columnheader" class="sorting">IMPORTE</th>
								<th aria-label="grupo: activate to sort column ascending" style="width: 80px;" aria-controls="sample-table-2" tabindex="6" role="columnheader" class="sorting">GRUPO</th>
								<th aria-label="email_enviado: activate to sort column ascending" style="width: 80px;" aria-controls="sample-table-2" role="columnheader"  tabindex="7" class="sorting">E-Mail</th>
							</tr>
						</thead>
										
						<tbody aria-relevant="all" aria-live="polite" role="alert">
							<?php 
								if ( count($rs) > 0 ){
									foreach ($rs as $i => $value) {
										$total = 0;
										$dt = "u=".$u."&vconcepto=".$vconcepto."&clave_nivel=".$clave_nivel."&idfamilia=".$rs[$i]->idfamilia."&idalumno=".$rs[$i]->idalumno."&fvencimiento=$fvencimiento";
										// $rsa = $fP->getQueryPDO(31,$dt,0,0,0,array(),"",1);
										$rsa = $fP->getQueryPDO(46,$dt,0,0,0,array(),"",1);
										//if ( count($rsa) > 0 ){
											$meses = "";
											$total = 0;
											foreach ($rsa as $j => $value) {
												$checked = $rsa[$j]->email_fiscal==''?'':'checked';
												$meses .= $meses == "" ? $rsa[$j]->mes : ", ".$rsa[$j]->mes ;
												$total = $total + floatval($rsa[$j]->total);	
											}	

							?>
							<tr>
								<td>
									<label class="pull-right">
										<input class="ace chkrec001" type="checkbox" id="id|<?= $rsa[0]->idedocta; ?>|<?= $rsa[0]->idfamilia; ?>|<?= $rsa[0]->email_fiscal; ?>|<?= $rsa[0]->familia; ?>" <?= $checked ?> >
										<span class="lbl"><?= $rsa[0]->idedocta.'-<small>'.$rsa[0]->idfamilia.'</small>'; ?></span>
									</label>									
								</td>
								<td><?= $rsa[0]->alumno; ?></td>
								<td><?= $rsa[0]->familia; ?></td>
								<td><?= $rsa[0]->concepto." ".$meses; ?></td>
								<td><?= $total; ?></td>
								<td><?= $rsa[0]->grupo; ?></td>
								<td><?= $rsa[0]->email_fiscal; ?></td>
							</tr>	
							<?php 
										// }
									}
								}
							?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript"> 

jQuery(function($) {

	var oTable;

	var datax = "<?= $data; ?>";

	$("#alerta").hide();	

	function getTable(){

		oTable = $('#sample-table-2').dataTable({
	        "oLanguage": {
	                    	"sLengthMenu": "_MENU_ registros por página",
	                    	"oPaginate": {
	                                		"sPrevious": "Prev",
	                                		"sNext": "Next"
	                                     },
	                        "sSearch": "Buscar",
	                        "sProcessing":"Procesando...",
	                        "sLoadingRecords":"Cargando...",
	 						"sZeroRecords": "No hay registros",
	            			"sInfo": "_START_ - _END_ de _TOTAL_ registros",
	            			"sInfoEmpty": "No existen datos",
	            			"sInfoFiltered": "(De _MAX_ registros)"                                        
	        			},	
	        "aaSorting": [[ 0, "desc" ]],			
			"aoColumns": [ { "bSortable": false }, null, null, null, null, null, null],
			"aLengthMenu": [[20, 25, 50, -1], [20, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});

	}

	$(".closeWinRep01").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

	$(".clsidfac0").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('*');
		window.open(obj.getValue(0) + "uw_fe/"+item[1],'_blank');
	});

	$(".clsidfac1").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('*');
		window.open(obj.getValue(0) + "uw_fe/"+item[1],'_blank');
	});

	getTable();

	$("#idChK").on("change",function(event){
		event.preventDefault();

		if ( $(this).prop('checked') ) {
		    $(".chkrec001").prop('checked',true);
		} else {
		    $(".chkrec001").prop('checked',false);
		}

	});


    $("#printFormato1").on("click", function(event) {
        event.preventDefault();
        
		selectObject(0); // formato 1

	});

    $("#printFormato2").on("click", function(event) {
        event.preventDefault();
        
		selectObject(1); // formato 2

	});



    $("#sendEmail1").on("click", function(event) {
        event.preventDefault();
        
		selectObject(100); // sendEmail1

	});

    $("#sendEmail2").on("click", function(event) {
        event.preventDefault();
        
		selectObject(101); // sendEmail2

	});

	function selectObject(flag){

        var url, cad, nRep, email, fam;

        cad = email = fam = "";
        $(".chkrec001").each(function(i,item){
			if ($(this).is(':checked') ){
				var ids = item.id.split('|');
				var isexist = cad.indexOf(ids[2]);
				if (isexist == -1){
					cad += cad == "" ? ids[2] : "|"+ids[2];
					email += email == "" ? ids[3] : "|"+ids[3];
					fam += fam == "" ? ids[4] : "|"+ids[4];
				}
			}
		});	

		switch(flag) {
			case 0:
					nRep = "rep-caja-arji-recorda-fmt-1/";
					url = obj.getValue(0)+nRep;
					selectOperation(url, nRep, cad, email, fam, flag);
					break;
			case 1:
					nRep = "rep-caja-arji-recorda-fmt-2/";
					url = obj.getValue(0)+nRep;
					selectOperation(url, nRep, cad, email, fam, flag);
					break;
			case 100:
					nRep = "send-recordatorio-arji-1/";
					url = obj.getValue(0)+nRep;
					selectOperation(url, nRep, cad, email, fam, flag);
					break;
			case 101:
					nRep = "send-recordatorio-arji-2/";
					url = obj.getValue(0)+nRep;
					selectOperation(url, nRep, cad, email, fam, flag);
					break;
			default :

				break;
		}

	}

	function selectOperation(url, nRep, cad, email, fam, flag){
        var PARAMS;

		switch(flag) {
			case 0: //Enviamos por formato 1
			case 1: //Enviamos por formato 2

					PARAMS = {data:datax, cads:cad, emails:email, familias: fam};

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
				
					break;

			case 100: //Enviamos por E-Mail
			case 101: //Enviamos por E-Mail
					var x = confirm("Desea enviar los recordatorios a los elementos marcados?\n\nEste proceso puede tardar, espere hasta que se le indique que ya terminó.");
					if (!x){
						return false;
					}
					
					$("#sendEmail1").prop("disabled",true);
					$("#sendEmail2").prop("disabled",true);
					
					//alert("Se envian");
					//return false;

					var idfamilias = cad.split("|");
					// email = "devch@arji.edu.mx;rived67@hotmail.com;kr.los.h@hotmail.com;jgmrz@hotmail.com;caja@arji.edu.mx";
					// email = "kr.los.h@hotmail.com";
					var emails = email.split("|");
					var fams = fam.split("|");
					for(i=0; i<idfamilias.length;i++){
						PARAMS = { data:datax, idfamilia:idfamilias[i], familia: fams[i], mails:emails[i] };
						$.post(url, PARAMS,
							function(json){
						},'json');
						if ( (idfamilias.length-1) == i ){
							alert("Proceso terminado con éxito.");
						}
					}

					break;



			default :
				
				break;
		}

	}




	$("#preloaderPrincipal").hide();

});		

</script>
