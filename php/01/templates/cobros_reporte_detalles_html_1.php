<?php

include("includes/metas.php");

$data = $_POST['data'];

if (!isset($data)){
	header('Location: http://platsource.mx/');
}

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();
require_once('../oCentura.php');
$f = oCentura::getInstance();

parse_str($data);

$rs = $f->getQuerys(10016,$data,0,0,0,array(),"",1);
if ( $tiporeporte==3 ){
	$title = "REPORTE DE VENCIMIENTOS";
}else if ( $tiporeporte==4 ){
	$title = "REPORTE DE RECORDATORIOS";
}else{
	$title = "REPORTE DE FACTURAS";
}

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

			<div class="widget-toolbar orange pull-left no-border ">
				<h3 class="grey lighter  pull-left position-relative wd100prc">
					<i class="icon-print green"></i>
					<?= $title; ?>
				</h3>
			</div>

			<div class="widget-toolbar border pull-right">
				<button data-toggle="dropdown" class="btn btn-minier btn-success arrowed-in-right arrowed dropdown-toggle">
					<i class="white icon-print bigger-110"></i>Informes
					<span class="caret"></span>
				</button>

				<ul class="dropdown-menu dropdown-success">
					<li>
						<a href="#" id="repMDtoXLSX01">Formato 1 XLSX</a>
					</li>

				</ul>
			</div>

		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

					<table aria-describedby="sample-table-2_info" id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
										
						<thead>
							<tr role="row">
								<th aria-label="idedocta: activate to sort column ascending" style="width: 50px;" aria-controls="sample-table-2" tabindex="0" role="columnheader" class="sorting" >ID</th>
								<th aria-label="pdf: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">PDF</th>
								<th aria-label="xml: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">XML</th>
								<th aria-label="concepto: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">CONCEPTO</th>
								<th aria-label="idfamilia: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">ID FAM</th>
								<th aria-label="familia: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">FAMILIA</th>
								<th aria-label="fecha: activate to sort column ascending" style="width: 100px;" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">FECHA</th>
								<th aria-label="subtotal: activate to sort column ascending" style="width: 80px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting">IMPORTE</th>
								<th aria-label="descto: activate to sort column ascending" style="width: 80px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting">DESCTO</th>
								<th aria-label="importe: activate to sort column ascending" style="width: 80px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting">SUBTOTAL</th>
								<th aria-label="recargo: activate to sort column ascending" style="width: 80px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting">RECAGRGO</th>
								<th aria-label="total: activate to sort column ascending" style="width: 80px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting">TOTAL</th>
							</tr>
						</thead>
										
						<tbody aria-relevant="all" aria-live="polite" role="alert">
							<?php 
								if ( count($rs) > 0 ){
									$l=0;
									$r0=$r1=$r2=$r3=$r4=0;
									foreach ($rs as $i => $value) {
										$descto = $rs[$i]->descto_becas + $rs[$i]->descto;
							?>
							<tr>
								<td><?= $rs[$i]->idedocta; ?></td>
								<td><a href="#" class="blue clsidfac0" id="idfac0*<?= $rs[$i]->directorio.$rs[$i]->pdf; ?>"><?= $rs[$i]->pdf; ?></a></td>
								<td><a href="#" class="blue clsidfac1" id="idfac1*<?= $rs[$i]->directorio.$rs[$i]->xml; ?>"><?= $rs[$i]->xml; ?></a></td>
								<td><?= $rs[$i]->concepto; ?></td>
								<td><?= $rs[$i]->idfamilia; ?></td>
								<td><?= $rs[$i]->familia; ?></td>
								<td><?= $rs[$i]->fecha_de_pago; ?></td>
								<td><?= $rs[$i]->subtotal; ?></td>
								<td><?= $descto; ?></td>
								<td><?= $rs[$i]->importe; ?></td>
								<td><?= $rs[$i]->recargo; ?></td>
								<td><?= $rs[$i]->total; ?></td>
							</tr>	
							<?php 
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
			"aoColumns": [ null, null, null, null, null, null, null, null, null, null, null, null],
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


	$("#repMDtoXLSX01").on("click",function(event){
		event.preventDefault();

		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url = obj.getValue(0)+"caja-report-detalle-xlsx-1/";
        var data = "<?= $data; ?>";

		var nc = "user="+localStorage.nc+
				"&"+data+
				"&IdEmp="+localStorage.IdEmp;

		// alert(nc);
				
        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};

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

	$("#preloaderPrincipal").hide();

});		

</script>
