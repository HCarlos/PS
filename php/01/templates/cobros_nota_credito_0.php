<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idfactura = $_POST['idfactura'];
$idfamilia = $_POST['idfamilia'];
$isfe = $_POST['isfe'];
$tutor = $_POST['tutor'];

?>
<style type="text/css">

	.anchoConcepto{width: 100% !important;}
	.itemNC{width: 7em !important;}
	.td1{width: 7em !important; height: 1em !important; text-align: right !important;}

</style>

<div class="row-fluid">
	<div class="span12 ">
		<form id="formTimFac1" role="form">
			<div class="widget-box transparent invoice-box">
				<div class="widget-header widget-header-large">
					<h3 class="grey lighter pull-left position-relative">
						<i class="icon-leaf green"></i>
						Nota de Crédito
					</h3>

					<div class="widget-toolbar no-border hidden-480">
						<h3 class="label label-info arrowed-in-right arrowed lighter closeFE0 pull-right" style="cursor:pointer !important;" >Regresar</h3>
					</div>

					<div class="widget-toolbar no-border invoice-info">
						<span class="invoice-info-label">NC:</span>
						<span class="red" id="spfactura"></span>

						<br>
						<span class="invoice-info-label">Fecha:</span>
						<span class="blue"><?php echo date('d-m-Y'); ?></span>
					</div>

				</div>


				<div class="widget-body">
					<div class="widget-main padding-24">
						<div class="row-fluid">
							<div class="row-fluid">
								<div class="span6">
									<div class="row-fluid">
										<div class="wd100prc label label-large label-info arrowed-in arrowed-right">
											<b>Datos del Emisor (Empresa) y del Receptor (Cliente) </b>
										</div>
									</div>

									<div class="row-fluid">
										<ul class="unstyled spaced">
											<li>
												<i class="icon-caret-right blue"></i>
												<select id="idemisorfiscal" name="idemisorfiscal" size="1" class='altoMoz wd94prc' readonly></select>
											</li>

											<li>
												<i class="icon-caret-right blue"></i>
												<select id="idregfis" name="idregfis" size="1" class='altoMoz wd94prc' ></select>
											</li>

											<li>
												<i class="icon-caret-right blue" ></i> 
												<span id="rf0"></span>
											</li>

											<li>
												<i class="icon-caret-right blue" ></i>
												<span id="rf1"></span>
											</li>


										</ul>
									</div>
								</div><!--/span-->

								<div class="span6">
									<div class="row-fluid">
										<div class="wd100prc label label-large label-success arrowed-in arrowed-right">
											<b>Datos Complementarios</b>
										</div>
									</div>

									<div class="row-fluid">
									
									<table class="marginTop1em spaced">
										<tr>
											<td class="wd20prc">Método de Pago</td>
											<td class="wd80prc">
												<select id="idmetododepago" name="idmetododepago" sieze="1" class="marginLeft1em altoMoz wd80prc">
												</select> 
											</td>
										<tr>	
										<tr>
											<td class="wd20prc">Referencia</td>
											<td class="wd80prc">
												<input type="text" id="referencia" name="referencia" class="marginLeft1em altoMoz wd80prc" autofocus/>
											</td>
										<tr>	
										<tr>
											<td class="wd20prc">Email</td>
											<td class="wd80prc">
												<input type="email" id="email1" name="email1" class="marginLeft1em altoMoz wd80prc"/>
											</td>
										<tr>	
										<tr>
											<td class="wd20prc">Uso CFDi </td>
											<td class="wd80prc">
												<select id="slUsoCFDi" name="slUsoCFDi" size="1" class='marginLeft1em altoMoz wd80prc'>
													<option value="G03">G03 - Gastos generales</option>
													<option value="D10" selected>D10 - Pago de colegiatura</option>
													<option value="P01">P01 - No definido</option>
												</select>
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
											<th class="td1 textRight">Importe</th>
											<th class="td1 textRight">Descto Becas</th>
											<th class="td1 textRight">Subtotal</th>
											<th class="td1 textRight">Descuento</th>
											<th class="td1 textRight">Recargo</th>
											<th class="td1 textRight">Total</th>
											<th class="center"></th>
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
										SubTotal : $ 
										<span class="grey pull-right" id="importe2factura"></span><br/>
										IVA : $ 
										<span class="grey pull-right" id="ivafactura"></span><br/>
										Total : $ 
										<span class="red pull-right" id="totalfactura"></span>
									</h4>
									<button class="btn btn-info" id="createNotaCredito">Guardar</button>
									<button class="btn btn-default" id="calcularTotal">Calcular</button>

										<input type="hidden" id="serie" name="serie" value=""/>
										<input type="hidden" id="subtotal" name="subtotal" value="0"/>
										<input type="hidden" id="descto_becas" name="descto_becas" value="0"/>
										<input type="hidden" id="importe" name="importe" value="0" />
										<input type="hidden" id="descto" name="descto" value="0"/>
										<input type="hidden" id="recargo" name="recargo" value="0"/>
										<input type="hidden" id="importe2" name="importe2" value="0"/>
										<input type="hidden" id="iva" name="iva" value="0"/>
										<input type="hidden" id="total" name="total" value="0"/>
										<input type="hidden" id="idfactura" name="idfactura" value="0"/>
										<input type="hidden" id="padre" name="padre" value="0"/>
										<input type="hidden" id="idemp" name="idemp" value="0"/>
										<input type="hidden" id="metodo_pago" name="metodo_pago"  value=""/>
										<input type="hidden" id="metodo_pago2" name="metodo_pago2"  value=""/>
										<input type="hidden" id="tutor" name="tutor" value="<?= $tutor; ?>"  />
										<input type="hidden" id="u" name="u" value=""/>
										<input type="hidden" id="idcliente" name="idcliente" value="0"/>
										<input type="hidden" id="cadOrd" name="cadOrd" value=""/>

								</div>
								<button class="btn btn-primary pull-left" id="timbrarNotaCredito">Timbrar Nota de Crédito</button>

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

	// var stream = io.connect(obj.getValue(4));
	var IdFamilia = <?php echo $idfamilia; ?>;
	var IdFactura = <?php echo $idfactura; ?>;
	var Tutor = "<?php echo $tutor; ?>";
	var init = true;
	var IsFE = <?php echo $isfe; ?>;


	$("#idemp").val( localStorage.IdEmp );
	$("#tutor").val( Tutor );

	if (IsFE){
		$("#timbrarNotaCredito").hide();
	}
		
	$("#preloaderPrincipal").show();

	$(".closeFE0").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        closeWindow();
	});

	function closeWindow(){
        $("#contentProfile").hide(function(){
            $("#contentProfile").empty();
            $('#breadcrumb').html(getBar('Inicio, Facturas por Familia '));
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
       $("#idmetododepago").empty();
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:31, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc,it,df;
               $.each(json, function(i, item) {
               		df = parseInt(item.isdefault,0);
               		df = df==1?' selected':'';
                    $("#idmetododepago").append('<option value="'+item.data+'" '+df+'>'+item.clave+' '+item.label+'</option>');
                });
            	$("#preloaderPrincipal").hide();
               getEmiFisCombo();
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
               		var it = item.data.split("-");
                    $("#idemisorfiscal").append('<option value="'+it[0]+'"> '+item.label+'</option>');
                });
            	$("#preloaderPrincipal").hide();
               getEmiFis();
            }, "json"
        );  
    }

    function getEmiFis(){
       $("#preloaderPrincipal").show();
       var it = $("#idemisorfiscal").val();
        $.post(obj.getValue(0)+"data/", { o:28, t:10006, p:10,c:it,from:0,cantidad:0, s:"" },
            function(json){
            	$("#preloaderPrincipal").hide();
            	if (init) {
 					getRegFisCombo();
 				};        	
            }, "json"
        );  
    }

    $("#idregfis").on("change",function(event){
    	getRegFis(1);
    });

    function getRegFisCombo(){
       $("#preloaderPrincipal").show();
       $("#idregfis").empty();
        var nc = "u="+localStorage.nc+"&idfamilia="+IdFamilia;
        $.post(obj.getValue(0)+"data/", { o:1, t:30, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc;
               $.each(json, function(i, item) {
                    $("#idregfis").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
            	$("#preloaderPrincipal").hide();
            	if (init){
                	getRegFis(0);
            	}
            }, "json"
        );  
    }

    function getRegFis(TipoConsulta){
       	$("#preloaderPrincipal").show();
        $.post(obj.getValue(0)+"data/", { o:28, t:28, p:10,c:$("#idregfis").val(),from:0,cantidad:0, s:"" },
            function(json){
            	$("#rf0").html(json[0].calle+" "+json[0].num_ext+' '+json[0].num_int+' '+json[0].colonia);
            	$("#rf1").html(json[0].localidad+" "+json[0].cp+' '+json[0].estado);
            	// $("#email1").val(json[0].email1);
	            $("#email1").val(json[0].email1 + "; " + json[0].email2 );
            	$("#preloaderPrincipal").hide();
            	if (TipoConsulta==0){
	            	getFacDet();
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
            	cad2 = "";
               $.each(json, function(i, item) {
               		cad1 = json[i].nombre_completo_alumno+" - "+json[i].curp+" - "+json[i].rfc+" - "+json[i].matricula_oficial;
               		var descto = parseFloat(json[i].descto_becas).toFixed(2) + parseFloat(json[i].descto).toFixed(2);
					cad0 = "<tr>";
						cad0 += "<td class='center'>"+parseInt(json[i].idfacdet)+"</td>";
						cad0 += "<td class='anchoConcepto'><span class='blue'>"+json[i].descrip_prod+"</span><br/><small  class='chikirimbita grey'>"+cad1+"</small></td>";
						cad0 += "<td class='td1'><input type='text' name='subtotal_"+i+"' id='subtotal_"+i+"' value='"+json[i].subtotal+"' class='textRight altoMoz itemNC' /> </td>";
						cad0 += "<td class='td1'><input type='text' name='descto_becas_"+i+"' id='descto_becas_"+i+"' value='"+json[i].descto_becas+"' class='textRight altoMoz itemNC' /> </td>";
						cad0 += "<td class='td1'><input type='text' name='importe_"+i+"' id='importe_"+i+"' value='"+json[i].importe+"' class='textRight altoMoz itemNC' readonly /> </td>";
						cad0 += "<td class='td1'><input type='text' name='descto_"+i+"' id='descto_"+i+"' value='"+json[i].descto+"' class='textRight altoMoz itemNC' /> </td>";
						cad0 += "<td class='td1'><input type='text' name='recargo_"+i+"' id='recargo_"+i+"' value='"+json[i].recargo+"' class='textRight altoMoz itemNC' /> </td>";
						cad0 += "<td class='td1'>";
						cad0 += "<input type='text' name='total_"+i+"' id='total_"+i+"' value='"+json[i].total+"' class='textRight altoMoz itemNC' readonly />";
						cad0 += "<input type='hidden' id='idfacdet_"+i+"' name='idfacdet_"+i+"' value='"+json[i].idfacdet+"' />";
						cad0 += "<input type='hidden' id='idedocta_"+i+"' name='idedocta_"+i+"' value='"+json[i].idedocta+"' />";
						cad0 += "<input type='hidden' id='idproducto_"+i+"' name='idproducto_"+i+"' value='"+json[i].idproducto+"' />";
						cad0 += "<input type='hidden' id='producto_"+i+"' name='producto_"+i+"' value='"+json[i].descrip_prod+"' />";
						cad0 += "</td>";
						cad0 += "<td class='td1'>";
						cad0 +='	<div class="hidden-phone visible-desktop action-buttons">';
						cad0 +='		<a class="red delIdFacDet1" href="#"  id="delIdFacDet1-'+item.idfacdet+'" >';
						cad0 +='				<i class="icon-trash bigger-130"></i>';
						cad0 +='		</a>';
						cad0 +='	</div>';
						cad0 += "</td>";
					cad0 += "</tr>";
					cad2 += cad2!=""?";":"";
 
     				// cad2 +="1"+"|"+json[i].descrip_prod+"|"+json[i].importe+"|"+json[i].importe+"|"+json[i].nombre_completo_alumno+"|"+json[i].curp+"|"+json[i].clave_registro_nivel+"|"+json[i].nivel_fiscal+"|"+json[i].rfc;
/*
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
*/
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

			    $(".itemNC").on("change",function(event){
			    	event.preventDefault();
			    	calcularTotales();
			    });

			    $(".delIdFacDet1").on("click",function(event){
			    	event.preventDefault();
			    	var ar = event.currentTarget.id.split('-');
					var resp =  confirm("Desea eliminar este registro "+ar[1]+"?");
					if (resp){
			    		$(this).parent().parent().parent().remove();
				        var nc = "u="+localStorage.nc+"&idfacdet="+ar[1];
				        $.post(obj.getValue(0) + "data/", {o:28, t:15, c:nc, p:12, from:0, cantidad:0, s:''},
				            function(json){

				            	if (json[0].msg=="OK"){

							    		alert("Registro Eliminado");
								    	calcularTotales();

				            	}else{

				            		alert("No fue posible eliminar el registro:\n\n"+json[0].msg);

				            	}
								
				            }, "json"
				        );  
			    	}
			    });


            	$("#preloaderPrincipal").hide();
            	
            	getFacEncab();

            }, "json"
        );

    }

    function getFacEncab(){
       $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idfactura="+IdFactura;
        $.post(obj.getValue(0)+"data/", { o:28, t:10013, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
            	var descto = parseFloat(json[0].descto_becas).toFixed(2) + parseFloat(json[0].descto).toFixed(2);
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

            	$("#idemisorfiscal").val( json[0].idemisorfiscal );

            	$("#idregfis").val( json[0].idregfis );

            	$("#idmetododepago").val( json[0].idmetododepago );
            	$("#referencia").val( json[0].referencia );

            	$("#spfactura").html(IdFactura);
            	$("#idfactura").val( IdFactura );
            	
            	$("#padre").val( IdFactura );

            	$("#serie").val( json[0].idre);

            	$("#idcliente").val( json[0].idcliente );
            	$("#u").val( localStorage.nc );

            	init = false;
            	//IsFE = parseInt(json[0].isfe,0)==1?true:false;

            	$("#preloaderPrincipal").hide();
			    $("#referencia").focus();

            }, "json"
        );  
    }

    function calcularTotales(){

    	var nSubtotal = 0;
    	var nDescto = 0;
    	var nImporte = 0;
    	var nRec = 0;
    	var nImporte2 = 0;
    	var nDescto_Becas = 0;
    	var nIva = 0;
    	var nTotal = 0;

    	for (var i = 0; i <= 100; i++) {
    	
    		if (  parseInt( $("#idfacdet_"+i).val() ,0) > 0 ) {

				// alert("0");
/*
    			var n0 = parseFloat( $("#subtotal_"+i).val() );
    			var db1 = parseFloat( $("#descto_becas_"+i).val() );
    			var n1 = parseFloat( $("#descto_"+i).val() );

		    	$("#importe_"+i).val( n0 - db1 );

    			var n2 = parseFloat( $("#importe_"+i).val() );
    			var n3 = parseFloat( $("#recargo_"+i).val() );


		    	$("#total_"+i).val( ( (n2 - n1) + n3) );

    			var n4 = parseFloat( $("#total_"+i).val() ) ;

		    	nImporte += n0;
		    	
		    	nDescto_Becas += db1;		    	
		    	
		    	nSubtotal += n0 - db1;

		    	nDescto += n1;		    	

		    	nRec += n3;

		    	nImporte2 += ( (n0 - db1) + n3 );

	    		nIva = 0;

		    	nTotal += n4;
				
				// alert("1");

*/

    			var subtotal = parseFloat( $("#subtotal_"+i).val() );
    			var descto_becas = parseFloat( $("#descto_becas_"+i).val() );
    			var descto = parseFloat( $("#descto_"+i).val() );
    			var recargo = parseFloat( $("#recargo_"+i).val() );

    			var xImporte =  subtotal - descto_becas;
		    	$("#importe_"+i).val( xImporte );

		    	var xTotal = ( (xImporte - descto) + recargo);
		    	$("#total_"+i).val( xTotal );

		    	nImporte += subtotal;
		    	nDescto_Becas += descto_becas;
		    	nSubtotal += xImporte;

		    	nDescto +=  descto;
		    	nRec += recargo;
		    	nImporte2 += xTotal;
		    	nIva = 0;
		    	nTotal += xTotal;


				
            	$("#importefactura").html( accounting.formatMoney(nImporte) );
            	$("#desctobecasfactura").html( accounting.formatMoney(nDescto_Becas) );
            	$("#subtotalfactura").html( accounting.formatMoney(nSubtotal) );
            	$("#desctofactura").html( accounting.formatMoney(nDescto) );

            	$("#recargofactura").html( accounting.formatMoney(nRec) );
            	$("#importe2factura").html( accounting.formatMoney(nImporte2) );
            	$("#ivafactura").html( accounting.formatMoney(nIva) );
            	$("#totalfactura").html( accounting.formatMoney(nTotal) );

		    	$("#importe").val( nImporte );
		    	$("#descto_becas").val( nDescto_Becas );
		    	$("#subtotal").val( nSubtotal );
		    	$("#descto").val( nDescto );
		    	$("#recargo").val( nRec );
		    	$("#importe2").val( nImporte2 );
		    	$("#iva").val( nIva );
		    	$("#total").val( nTotal );
				
				// alert("Intro");

    		} else {

    			break;

    		}	

    	}

    }

    $("#idmetododepago").on("change",function(event){
    	event.preventDefault();
	    $("#referencia").focus();
    });

    $("#createNotaCredito").on("click",function(event){
    	event.preventDefault();
    	
    	var mp = $("#idmetododepago option:selected").text();
    	$("#metodo_pago2").val(mp);
    	var xmp = mp.substring(0,2);
    	$("#metodo_pago").val(xmp);
    	
        var nc = "u="+localStorage.nc+"&idfactura="+IdFactura;
    	var queryString = $("#formTimFac1").serialize();
		
		var isef = IsFE==true?11:12;

		calcularTotales();

		var isContinue = confirm("Desea guardar la información actual?");

		if (!isContinue){
			return false;
		}

		// alert(queryString);

        $.post(obj.getValue(0) + "data/", {o:28, t:isef, c:queryString, p:12, from:0, cantidad:0, s:''},
            function(json){

            	if (json[0].msg=="OK"){

            		if (isef == 12) {
            			alert("Nota modificada con éxito");
            		}else{
            			alert("Nota creada con éxito");
            		}

					closeWindow();            		

            	}else{

            		alert("No fue posible crear la nota de crédito:\n\n"+json[0].msg);

            	}
				
            }, "json"
        );  
 
    });


    $("#calcularTotal").on("click",function(event){
    	event.preventDefault();
    	calcularTotales();
    });	


    $("#timbrarNotaCredito").on("click",function(event){
    	event.preventDefault();
    	
        var nc = "u="+localStorage.nc+"&idfactura="+IdFactura;

    	var mp = $("#idmetododepago option:selected").text();
    	var xmp = mp.substring(0,2);
    	$("#metodo_pago").val(xmp);

    	var queryString = $("#formTimFac1").serialize();
		
		var isef = IsFE==true?11:12;

		calcularTotales();

		var isContinue = confirm("Desea TIMBRAR la información actual?");

		if (!isContinue){
			return false;
		}

		// alert(queryString);
		// return false;

        $.post(obj.getValue(0)+"data/", { o:28, t:10013, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
            	//alert(json[0].isfe);
            	if ( parseInt(json[0].isfe) == 1  ){
            		alert("Esta Factura ya Fue Timbrada");
            		closeWindow();
            		return false;
            	}else{


			        var PARAMS = {data:queryString};  
			        var IdEmp = localStorage.IdEmp;
			        var url = obj.getValue(0)+"timbrar-nc-33-"+IdEmp+"-0/";

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
