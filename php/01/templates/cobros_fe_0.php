<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idfactura = $_POST['idfactura'];
$idfamilia = $_POST['idfamilia'];
$idmetododepago = $_POST['idmetododepago'];
$referencia = $_POST['referencia'];
$tutor = $_POST['tutor'];

// $arr = $f->getQuerys(10009,"idfamilia=".$idfam."&u=".$user,0,0,0,array(),'alumno');
// if (count($arr)>0){

?>
<div class="row-fluid">
	<div class="span12 ">
		<form id="formTimFac0" role="form">
			<div class="widget-box transparent invoice-box">
				<div class="widget-header widget-header-large">
					<h3 class="grey lighter pull-left position-relative">
						<i class="icon-leaf green"></i>
						Factura     <small>(<?= $tutor; ?>)</small>
					</h3>

<!-- arrowed-in-right arrowed -->
					<div class="widget-toolbar no-border hidden-480">
						<h3 class="label label-info lighter closeFE0" style="cursor:pointer !important;" >Regresar</h3>
					</div>

					<div class="widget-toolbar no-border invoice-info">
						<span class="invoice-info-label">ID Docto:</span>
						<span class="red" id="spfactura"></span>

						<br>
						<span class="invoice-info-label">Fecha:</span>
						<span class="blue"><?php echo date('d-m-Y'); ?></span>
					</div>

					<div class="widget-toolbar no-border hidden-480">
						<!-- <a href="#">
							<i class="icon-print"></i>
						</a> -->

					</div>
				</div>


				<div class="widget-body">
					<div class="widget-main padding-24">
						<div class="row-fluid">
							<div class="row-fluid">
								<div class="span6">
									<div class="row-fluid">
										<div class="wd100prc label label-large">
											<b>Datos del Emisor (Empresa) y del Receptor (Cliente) </b>
										</div>
									</div>

									<div class="row-fluid">
										<ul class="unstyled spaced">
											<li>
												<i class="icon-caret-right blue"></i>
												<select id="idemisorfiscal" name="idemisorfiscal" size="1" class='altoMoz wd94prc'></select>
											</li>

											<li>
												<i class="icon-caret-right blue"></i>
												<select id="idregfis" name="idregfis" size="1" class='altoMoz wd94prc'></select>
											</li>

											<li>
												<i class="icon-caret-right blue"></i> 
												<span id="rf0"></span>
											</li>

											<li>
												<i class="icon-caret-right blue"></i>
												<span id="rf1"></span>
											</li>


										</ul>
									</div>
								</div><!--/span-->

								<div class="span6">
									<div class="row-fluid">
										<div class="wd100prc label label-large label-success">
											<b>Datos Complementarios</b>
										</div>
									</div>

									<div class="row-fluid">
									
									<table class="marginTop1em spaced">
										<tr>
											<td class="wd20prc">Método de Pago</td>
											<td class="wd80prc">
												<select id="idmetododepagoFE" name="idmetododepagoFE" size="1" class="marginLeft1em altoMoz wd80prc">
												</select> 
											</td>
										<tr>	
										<tr>
											<td class="wd20prc">Referencia</td>
											<td class="wd80prc">
												<input type="text" id="referenciaFE" name="referenciaFE" class="marginLeft1em altoMoz wd80prc" autofocus/>
											</td>
										<tr>	
										<tr>
											<td class="wd20prc">Email</td>
											<td class="wd80prc">
												<input type="text" id="email1" name="email1" class="marginLeft1em altoMoz wd80prc"/>
											</td>
										<tr>	
									</table>
									
									</div>
								</div><!--/span-->
							</div><!--row-->

							<div class="space"></div>

							<div class="row-fluid">
								<table class="table table-striped table-bordered" id="tblDelFac">
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Descripción</th>
											<th class="hidden-480 textRight">Precio</th>
											<th class="hidden-480 textRight">Descto Becas</th>
											<th class="hidden-480 textRight">Importe</th>
											<th class="hidden-480 textRight">Descuento</th>
											<th class="hidden-480 textRight">Recargo</th>
											<th class="hidden-480 textRight">Total</th>
										</tr>
									</thead>

									<tbody>

									</tbody>

								</table>

						</div>

							<div class="hr hr8 hr-double hr-dotted"></div>

							<div class="row-fluid">
								<div class="span5 pull-right">
									<h4 class="pull-right">
										Importe : $ 
										<span class="grey pull-right" id="importefactura"></span><br/>
										Descto Becas : $ 
										<span class="grey pull-right" id="desctobecasfactura"></span><br/>
										Importe 2 : $ 
										<span class="grey pull-right" id="subtotalfactura"></span><br/>
										Descto : $ 
										<span class="grey pull-right" id="desctofactura"></span><br/>
										Recargo : $ 
										<span class="grey pull-right" id="recargofactura"></span><br/>
										Subtotal : $ 
										<span class="grey pull-right" id="importe2factura"></span><br/>
										IVA : $ 
										<span class="grey pull-right" id="ivafactura"></span><br/>
										Total : $ 
										<span class="red pull-right" id="totalfactura"></span>
									</h4>
										<input type="hidden" id="cadOrd" name="cadOrd" />
										<input type="hidden" id="serie" name="serie" />
										<input type="hidden" id="subtotal" name="subtotal" />
										<input type="hidden" id="iva" name="iva" />
										<input type="hidden" id="total" name="total" />
										<input type="hidden" id="idfactura" name="idfactura" />
										<input type="hidden" id="idemp" name="idemp" />
										<input type="hidden" id="metodo_pago" name="metodo_pago" />
										<input type="hidden" id="metodo_pago2" name="metodo_pago2" />
										<input type="hidden" id="tutor" name="tutor" value="<?= $tutor; ?>"  />
										<input type="hidden" id="u" name="u" value="<?= $user; ?>" />
										<input type="hidden" id="idcliente" name="idcliente" />

								</div>

								<button type="submit" id="btnTimFac0" name="btnTimFac0" class="btn btn-primary pull-left" >
									<i class="icon-print bigger-125 icon-on-left"></i>
									Timbrar Factura
								</button>

								<button type="default" id="btnTimFac1" name="btnTimFac1" class="btn btn-default pull-right" >
									<i class="icon-print bigger-125 icon-on-left"></i>
									Botón de prueba, no tocar
								</button>

								<div class="span7 pull-left"> <!-- Extra Information --> </div>
							</div>

							<div class="space-6"></div>

							<div class="row-fluid">
								<div class="span12 well">
									<!-- Thank you for choosing Ace Company products.
We believe you will be satisfied by our services. -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</form>
	</div>
</div>

<script type="text/javascript"> 

jQuery(function($) {

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

	var stream = io.connect(obj.getValue(4));
	var IdFamilia = <?php echo $idfamilia; ?>;
	var IdFactura = <?php echo $idfactura; ?>;
	var IdMetododePago = <?php echo $idmetododepago; ?>;
	var Referencia = "<?php echo $referencia; ?>";
	var Tutor = "<?php echo $tutor; ?>";
	var init = true;
	var email1 = "";

	$("#idemp").val( localStorage.IdEmp );
	$("#tutor").val( Tutor );

	$("#preloaderPrincipal").show();

	$(".closeFE0").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        closeWindow();
	});

	function closeWindow(){
        $("#contentProfile").hide(function(){
            $("#contentProfile").empty();
            $("#contentMain").show();
        });
        resizeScreen();
        return false;
	}

    $("#idemisorfiscal").on("change",function(event){
    	getEmiFis();
    });

    function getMetodoPago(){
       $("#preloaderPrincipal").show();
       $("#idmetododepagoFE").empty();
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:31, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
            	var df;
               $.each(json, function(i, item) {

               		df = parseInt(item.default,0);
               		df = df==1?' selected':'';               	
                    $("#idmetododepagoFE").append('<option value="'+item.data+'" '+df+' >'+item.clave+' '+item.label+'</option>');

                });

            	$("#preloaderPrincipal").hide();
                
                getEmiFisCombo();
				getEmailFamilia(IdFamilia);            
            }, "json"
        );  
    }

   	// $.getEmailFamilia = function( IdFamilia ) {
   	function getEmailFamilia( IdFamilia ) {
        $.post(obj.getValue(0)+"data/", { o:28, t:22, p:10,c:IdFamilia,from:0,cantidad:0, s:"" },
            function(json){
            	if ( json.length > 0 ){
            		if ( $.trim(json[0].email) != "" ){
	            		$("#email1").val(json[0].email);
	            	}else{
	            		$("#email1").val(email1);
	            	}
            	}
            }, "json"
        );  
   	}

    function getEmiFisCombo(){
       $("#preloaderPrincipal").show();
       $("#idemisorfiscal").empty();
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:26, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc,it;
               $.each(json, function(i, item) {
               		//var it = item.data.split("-");
                    $("#idemisorfiscal").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
            	$("#preloaderPrincipal").hide();
               getEmiFis();
            }, "json"
        );  
    }

    function getEmiFis(){
       $("#preloaderPrincipal").show();
       var it = $("#idemisorfiscal").val().split('-');
       $("#serie").val(it[1]);
        $.post(obj.getValue(0)+"data/", { o:28, t:10006, p:10,c:it[0],from:0,cantidad:0, s:"" },
            function(json){
            	// $("#ef0").html(json[0].calle+" "+json[0].num_ext+' '+json[0].num_int+' '+json[0].colonia);
            	// $("#ef1").html(json[0].localidad+" "+json[0].cp+' '+json[0].estado);
            	$("#preloaderPrincipal").hide();
            	if (init) {
 					getRegFisCombo();
 				};        	
            }, "json"
        );  
    }

    $("#idregfis").on("change",function(event){
    	getRegFis();
    });

    function getRegFisCombo(){
       $("#preloaderPrincipal").show();
       $("#idregfis").empty();
        var nc = "u="+localStorage.nc+"&idfamilia="+IdFamilia;
        $.post(obj.getValue(0)+"data/", { o:1, t:30, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc;
               $.each(json, function(i, item) {
               		var pred = parseInt(item.predeterminado,0) == 1 ? ' selected ' : '';
                    $("#idregfis").append('<option value="'+item.data+'" '+pred+'> '+item.label+'</option>');
                });
            	$("#preloaderPrincipal").hide();
            	if (init){
                	getRegFis();
            	}
            }, "json"
        );  
    }

    function getRegFis(){
       $("#preloaderPrincipal").show();
        $.post(obj.getValue(0)+"data/", { o:28, t:28, p:10,c:$("#idregfis").val(),from:0,cantidad:0, s:"" },
            function(json){
            	if ( json.length > 0 ){
	            	$("#rf0").html(json[0].calle+" "+json[0].num_ext+' '+json[0].num_int+' '+json[0].colonia);
	            	$("#rf1").html(json[0].localidad+" "+json[0].cp+' '+json[0].estado);
	            	$("#email1").val(json[0].email1 + "; " + json[0].email2 );
	            	email1 = $("#email1").val();
	            	$("#preloaderPrincipal").hide();
	            	getFacDet();
            	}else{
			       $("#preloaderPrincipal").hide();
            		alert("Falta el Registro Fiscal de esta Familia...");
            		$("#btnTimFac0").prop('disabled', true);
            		closeWindow();
            	}
            }, "json"
        );  
    }

    function getFacDet(){
       $("#preloaderPrincipal").show();
       $("#tblDelFac > tbody").empty();


        var nc = "u="+localStorage.nc+"&idfactura="+IdFactura;
        $.post(obj.getValue(0)+"data/", { o:28, t:10014, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
            	var cad0, cad1, cad2;
            	var idedocta = json[0].idedocta;
            	cad2 = "";
               $.each(json, function(i, item) {
               		cad1 = json[i].nombre_completo_alumno+" - "+json[i].curp+" - "+json[i].rfc+" - "+json[i].matricula_oficial;
					cad0 = "<tr>";
						cad0 += "<td class='center'>"+json[i].idfacdet+"</td>";
						cad0 += "<td><span class='blue'>"+json[i].descrip_prod+"</span><br/><small  class='chikirimbita grey'>"+cad1+"</small></td>";
						cad0 += "<td class='hidden-480 textRight'>"+commaSeparateNumber(json[i].subtotal)+"</td>";
						cad0 += "<td class='hidden-480 textRight'>"+commaSeparateNumber(json[i].descto_becas)+"</td>";
						cad0 += "<td class='hidden-480 textRight'>"+commaSeparateNumber(json[i].importe)+"</td>";
						cad0 += "<td class='hidden-480 textRight'>"+commaSeparateNumber(json[i].descto)+"</td>";
						cad0 += "<td class='hidden-480 textRight'>"+commaSeparateNumber(json[i].recargo)+"</td>";
						cad0 += "<td class='hidden-480 textRight'>"+commaSeparateNumber(json[i].total)+"</td>";
					cad0 += "</tr>";
					cad2 += cad2!=""?";":"";
               		//cad2 +="1"+"|"+json[i].descrip_prod+"|"+json[i].total+"|"+json[i].total+"|"+json[i].nombre_completo_alumno+"|"+json[i].curp+"|"+json[i].clave_registro_nivel+"|"+json[i].nivel_fiscal+"|"+json[i].rfc;
               		cad2 +="1"+"|"+
               				json[i].descrip_prod+"|"+
               				json[i].importe+"|"+
               				json[i].importe+"|"+
               				json[i].nombre_completo_alumno+"|"+
               				json[i].curp+"|"+
               				json[i].clave_registro_nivel+"|"+
               				json[i].nivel_fiscal+"|"+
               				json[i].rfc+"|"+
               				json[i].idedocta+"|"+
               				json[i].iva+"|"+
               				json[i].importe2+"|"+
               				json[i].total+"|"+
               				json[i].subtotal+"|"+
               				json[i].claveprodserv+"|"+
               				json[i].claveunidadmedida+"|"+
               				json[i].claveunidadmedida_descripcion;
               				
					$("#tblDelFac > tbody").append(cad0);
                });
				$("#cadOrd").val(cad2);
				//alert( $("#cadOrd").val() );
            	$("#preloaderPrincipal").hide();
            	getFacEncab(idedocta);
            }, "json"
        );  
    }

    function getFacEncab(IdEdoCta){
       $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idfactura="+IdFactura;
        $.post(obj.getValue(0)+"data/", { o:28, t:10013, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
            	$("#importefactura").html( accounting.formatMoney(json[0].subtotal) );
            	$("#desctobecasfactura").html( accounting.formatMoney(json[0].descto_becas) );
            	$("#subtotalfactura").html( accounting.formatMoney(json[0].importe) );
            	$("#desctofactura").html( accounting.formatMoney(json[0].descto) );
            	$("#recargofactura").html( accounting.formatMoney(json[0].recargo) );
            	$("#importe2factura").html( accounting.formatMoney(json[0].importe2) );
            	$("#ivafactura").html( accounting.formatMoney(json[0].iva) );
            	$("#totalfactura").html( accounting.formatMoney(json[0].total) );

            	$("#subtotal").val( json[0].subtotal );
            	$("#iva").val( json[0].iva );
            	$("#total").val( json[0].total );

            	$("#spfactura").html(IdFactura);
            	$("#idfactura").val( IdFactura );

            	//alert(IdMetododePago);
            	
            	$("#idmetododepagoFE").val( IdMetododePago );
            	$("#referenciaFE").val( Referencia );

//idemisorfiscal,'-',serie
				getIdEmiFisfromIdDet(IdEdoCta);

            	$("#idcliente").val( json[0].idcliente );

            	init = false;

            	$("#preloaderPrincipal").hide();
			    $("#referenciaFE").focus();

            }, "json"
        );  
    }


    function getIdEmiFisfromIdDet(IdEdoCta){
       $("#preloaderPrincipal").show();
        $.post(obj.getValue(0)+"data/", { o:2, t:2, p:51, c:IdEdoCta, from:0, cantidad:0, s:"" },
            function(json){
            	$("#idemisorfiscal").val( json[0].idemisorfiscal+'-'+json[0].serie );
            	$("#serie").val( json[0].serie );
            	$("#preloaderPrincipal").hide();
			    $("#referenciaFE").focus();
            }, "json"
        );  
    }


    $("#idmetododepagoFE").on("change",function(event){
    	event.preventDefault();
	    $("#referenciaFE").focus();
    });


    $("#formTimFac0").on("submit",function(event){
    	event.preventDefault();
    	
    	var mp = $("#idmetododepagoFE option:selected").text();
    	$("#metodo_pago2").val(mp);
    	var xmp = mp.substring(0,2);
    	$("#metodo_pago").val(xmp);
    	
    	var queryString = $(this).serialize();

    	// alert(queryString);
    	// return false;
    	
		var isContinue = confirm("Desea TIMBRAR el documento actual?");

		if (!isContinue){
			return false;
		}
    	
    	 var nc = "u="+localStorage.nc+"&idfactura="+IdFactura;
        $.post(obj.getValue(0)+"data/", { o:28, t:10013, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
            	//alert(json[0].isfe);
            	if ( parseInt(json[0].isfe) == 1  ){
            		alert("Esta Factura ya Fue Timbrada");
            		closeWindow();
            		return false;
            	}else{


			        var PARAMS = {data:queryString};  
			        var url = obj.getValue(0)+"timbrar-fe-arji-0/";

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
			        closeWindow();
			        return temp;

            	}
            }, "json"
        );  

    });





    $("#btnTimFac1").on("click",function(event){
    	event.preventDefault();
    	
    	var mp = $("#idmetododepagoFE option:selected").text();
    	$("#metodo_pago2").val(mp);
    	var xmp = mp.substring(0,2);
    	$("#metodo_pago").val(xmp);
    	
    	var queryString = $("#formTimFac0").serialize();
    	
    	// alert(queryString);
    	// return false;
    	
		var isContinue = confirm("Desea TIMBRAR de Prueba el documento actual?");

		if (!isContinue){
			return false;
		}
    	
    	var nc = "u="+localStorage.nc+"&idfactura="+IdFactura;
        $.post(obj.getValue(0)+"data/", { o:28, t:10013, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
            	//alert(json[0].isfe);
            	if ( parseInt(json[0].isfe) == 1  ){
            		alert("Esta Factura ya Fue Timbrada");
            		closeWindow();
            		return false;
            	}else{


			        var PARAMS = {data:queryString};  
			        var url = obj.getValue(0)+"timbrar-fe-arji-1/";

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
			        closeWindow();
			        return temp;


            	}
            }, "json"
        );  

    	
    
    });


    getMetodoPago();
	


});

</script>
