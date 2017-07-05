<?php

include("includes/metas.php");

$data = $_POST['data'];

if (!isset($data)){
	header('Location: http://platsource.mx/');
}

require('../diag/sector.php');
require_once('../oFunctions.php');
$Q = oFunctions::getInstance();
require_once('../oCenturaPDO.php');
$f = oCenturaPDO::getInstance();

parse_str($data);

// echo $data;

$rs = $f->getQueryPDO(63,$data,0,0,0,array(),"",1);

?>

<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-default">
			
			<div class="widget-toolbar border pull-right">
			    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeWinRep01 " style="margin: 0 1em !important;" >
	                <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
			        Regresar
			    </button>
			</div>

			<div class="widget-toolbar orange pull-left no-border ">
				<h3 class="grey lighter  pull-left position-relative wd100prc">
					<i class="icon-coffee cafe"></i>
					<strong class="orange">LISTADO DE EXALUMNOS</strong>
				</h3>
			</div>

			<div class="widget-toolbar border pull-right">
			    <button  type="button" class="btn btn-minier btn-success arrowed-in-right arrowed " id="repExatoXLSX01" >
			       <i class="fa fa-table icon-on-right" aria-hidden="true"></i>
			        Exportar a MS Excel
			    </button>
			</div>

			<div class="widget-toolbar border pull-right">
			    <button  type="button" class="btn btn-minier btn-pink arrowed-in-right arrowed " id="repExatoMail01" >
			        <i class=" icon-envelope icon-on-right"></i>
			        Redactar Email
			    </button>
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
										<input class="ace" type="checkbox" id="chkIdExa01" checked>
										<span class="lbl"> All / None</span>
									</label>
								</th>
								<th aria-label="nombre_exalumno: activate to sort column ascending" style="width: 200px;" aria-controls="tblExal" tabindex="1" role="columnheader" class="sorting">EXALUMNO</th>
								<th aria-label="generacion: activate to sort column ascending" style="width: 50px;" aria-controls="tblExal" tabindex="5" role="columnheader" class="sorting">GEN.</th>
								<th aria-label="email: activate to sort column ascending" style="width: 100px;" aria-controls="tblExal" tabindex="4" role="columnheader" class="sorting">EMAIL</th>
								<th aria-label="profesion: activate to sort column ascending" style="width: 100px;" aria-controls="tblExal" tabindex="2" role="columnheader" class="sorting">PROF.</th>
								<th aria-label="ocupacion: activate to sort column ascending" style="width: 100px;" aria-controls="tblExal" tabindex="3" role="columnheader" class="sorting">OCUP.</th>
								<th style="width: 150px;" role="columnheader" class="sorting_disabled"></th>
							</tr>
						</thead>
										
						<tbody aria-relevant="all" aria-live="polite" role="alert">
							<?php 
								if ( count($rs) > 0 ){
									$l=0;
									foreach ($rs as $i => $value) {
												$chkRec002 = $rs[$i]->email==''?'':'chkRec002';
												$checked = $rs[$i]->email==''?'':'checked';
												$disabled = $rs[$i]->email==''?'disabled':'';
												
							?>
							<tr>
								<td>
									<label class="pull-right">
										<input class="ace <?= $chkRec002; ?> chkRec003" type="checkbox" id="id|<?= $rs[$i]->idexalumno; ?>|<?= $rs[$i]->email; ?>" <?= $checked; ?>  <?= $disabled; ?> >
										<span class="lbl"><small><?= $rs[$i]->idexalumno; ?></small></span>
									</label>									
								</td>
								<td><?= $rs[$i]->nombre_exalumno; ?></td>
								<td><?= $rs[$i]->generacion; ?></td>
								<td id="lstEmails<?= $rs[$i]->idexalumno; ?>"><?= $rs[$i]->email; ?></td>
								<td><?= $rs[$i]->profesion; ?></td>
								<td><?= $rs[$i]->ocupacion; ?></td>
								<td>
									<div class="hidden-phone visible-desktop action-buttons">
						
										<a class="green modExaPro01" href="#" id="idexalumno-<?= $rs[$i]->idexalumno; ?>" >
											<i class="icon-pencil bigger-130"></i>
										</a>

									</div>

								</td>

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
	var arrEmails = [];
	var arrIDExa = [];

	var datax = "<?= $data; ?>";

	console.firebug=true;

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
	        "aaSorting": [[ 2, "asc" ],[ 1, "asc" ]],			
			"aoColumns": [ { "bSortable": false }, null, null, null, null, null, null],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});

	}

	$(".closeWinRep01").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentLevel3").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

	$(".modExaPro01").on("click",function(event){
		event.preventDefault();
		var arr = event.currentTarget.id.split('-');
		getPropExa01(arr[1]);
	});

	function getPropExa01(IdExa){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-exalumnos-prop/", {
				user: nc,
				idexalumno: IdExa,
				objOrigen: 'contentLevel3',
				objDestino: 'contentProfile'
	            },
	            function(html) {	                
	                $("#contentLevel3").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Propiedades de un nuevo ExAlumno '));
	                });
	            }, "html");
        });
        return false;
	}

	getTable();

	$("#chkIdExa01").on("change",function(event){
		event.preventDefault();

		if ( $(this).prop('checked') ) {
		    $(".chkRec002").prop('checked',true);
		} else {
		    $(".chkRec002").prop('checked',false);
		}

	});


    $("#repExatoMail01").on("click", function(event) {
        event.preventDefault();
        
		showFormSendQuery();

	});

	function selectObject2(){

        arrEmails = [];
		arrIDExa = [];
		var totalElementos;
        var cont = 0;
        var cad = "";
        console.log( "Hola Mundo" );
        $(".chkRec002").each(function(i,item){
        	var arrids = item.id.split('|');
			if ( $(this).is(':checked') ){
				var cad = $("#lstEmails"+arrids[1]).text().trim();
				if ( (cad != '') && !(arrEmails.indexOf(cad) != -1) ){
					cad = cad.trim().replace(' ','');
					if ( obj.isEmail(cad) ) {
						arrEmails[cont] = cad;
						arrIDExa[cont] = arrids[1];
						cont++;
					}
				}
			}
		});	
		totalElementos = arrEmails.length;
		cad = arrEmails.toString();
		cad = cad.split(';').join(',');
		cad = cad.replace(' ','');

		ide = arrIDExa.toString(); 
		ide = ide.split(';').join(',');
		ide = ide.replace(' ','');
		
		return cad+'|'+ide+'|'+totalElementos;

	}

	 function showFormSendQuery(){

        var PARAMS, arrstr, emails, idsexa;

        arrstr = selectObject2().split('|');

		PARAMS = {para:arrstr[0],idexalumnos:arrstr[1],totalElementos:arrstr[2],objOrigen:'contentLevel3',objDestino:'contentProfile',titulo:'',mensaje:'',idexaemailenviado:0};

        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        $.post(obj.getValue(0) + "exa-enviar-emails-1/", PARAMS,
	            function(html) {	                
	                $("#contentLevel3").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Enviar email '));
	                });
	            }, "html");
        });
		resizeScreen();
        return false;


	 }

	function getIds(){
		var arrID = [];
        $(".chkRec003").each(function(i,item){
        	var arrids = item.id.split('|');
				arrID[i] = arrids[1];
		});	
		
		return arrID.toString();

	}

	 
    $("#repExatoXLSX01").on("click", function(event) {
        event.preventDefault();
        
		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;

		var arrstr = getIds();

		var nc = "user="+localStorage.nc+"&iddestinatarios="+arrstr+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo;
		
        var PARAMS = {o:0, t:60, c:nc, p:54, from:0, cantidad:0, s:''};
        url = obj.getValue(0)+"exa-to-xlsx-1/";

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

function resizeScreen() {
	
   $("#contentMain").css("min-height", obj.getMinHeight());
   $("#contentProfile").css("min-height", obj.getMinHeight());

}


</script>
