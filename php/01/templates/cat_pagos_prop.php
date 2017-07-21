<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idpago  = $_POST['idpago'];

?>

<h3 class="header smaller lighter blue">
    <span id="title"></span>
    <a class="label label-info arrowed-in-right arrowed closeFormUpload pull-right">Regresar</a>
</h3>

<form id="frmData"  class="form">

        <ul class="nav nav-tabs" id="myTab">

            <li class="active">
                <a data-toggle="tab" href="#general">
                    <i class="red icon-home bigger-110"></i>
                    Generales
                </a>
            </li>

            <li >
                <a data-toggle="tab" href="#especificos">
                    <i class="blue icon-cog bigger-110"></i>
                    Específicos
                </a>
            </li>

            <li >
                <a data-toggle="tab" href="#sat">
                    <i class="blue icon-book bigger-110"></i>
                    SAT
                </a>
            </li>

        </ul>

        <div class="tab-content">

            <div id="general" class="tab-pane active">

                <table>

                    <tr>
                        <td class="wd15prc"><label for="clave_nivel" class="textRight">Nivel</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select name="clave_nivel" id="clave_nivel" size="1" style="width:80% !important;" > </select>
                        </td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td><label for="idemisorfiscal" class="textRight">Emisor Fiscal</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select name="idemisorfiscal" id="idemisorfiscal" size="1" style="width:80% !important;" > </select>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="idconcepto" class="textRight">Concepto</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select name="idconcepto" id="idconcepto" size="1" style="width:80% !important;" > </select>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="importe" class="textRight">Importe</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="importe" id="importe" type="text" pattern="[-+]?[0-9]*[.,]?[0-9]+" required>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="dia_limite" class="textRight">Día Límite</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="dia_limite" id="dia_limite" type="number" value="10" required>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="dia_de_pago" class="textRight">Día de Pago</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="dia_de_pago" id="dia_de_pago" type="number" value="0" required>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="aplica_a" class="textRight">Aplica a</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select name="aplica_a" id="aplica_a" size="1" style="width:50% !important;" >
                                <option value="0" Selected>Todos</option>
                                <option value="1" >Algunas Veces</option>
                                <option value="2" >Algunos Alumnos</option>
                                <option value="3" >Solo Externos</option>
                            </select>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="orden_prioridad" class="textRight">Orden Prioridad</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="orden_prioridad" id="orden_prioridad" type="number" value="0" required>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="idlistavencimiento" class="textRight">Lista de Vencimientos</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select name="idlistavencimiento" id="idlistavencimiento" size="1" style="width:50% !important;" >
                            </select>
                        </td>
                        <td colspan="4"></td>
                    </tr>


                </table>
            </div>


            <div id="especificos" class="tab-pane">

                <table>

                    <tr >
                        <td class="wd20prc"><label for="is_descto_beca" class="marginLeft2em textRight">Descuento por Beca</label></td>
                        <td>
                            <input name="is_descto_beca" id="is_descto_beca" class="ace ace-switch ace-switch-6 pull-left" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="is_pagos_diversos" class="marginLeft2em textRight">Varios Pagos</label></td>
                        <td>
                            <input name="is_pagos_diversos" id="is_pagos_diversos" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="is_siguiente_nivel" class="marginLeft2em textRight">Siguiente Nivel</label></td>
                        <td>
                            <input name="is_siguiente_nivel" id="is_siguiente_nivel" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="is_descto" class="marginLeft2em textRight">Permitir Descuento</label></td>
                        <td>
                            <input name="is_descto" id="is_descto" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="is_descto_promocion" class="marginLeft2em textRight">Descto por Promoción</label></td>
                        <td>
                            <input name="is_descto_promocion" id="is_descto_promocion" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="is_facturable" class="marginLeft2em textRight">Se Factura</label></td>
                        <td>
                            <input name="is_facturable" id="is_facturable" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="is_mostrable" class="marginLeft2em textRight">Ver en el Web</label></td>
                        <td>
                            <input name="is_mostrable" id="is_mostrable" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td><label for="status_pago" class="marginLeft2em textRight">Estatus</label></td>
                        <td>
                            <input name="status_pago" id="status_pago" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                </table>
            </div>

            <div id="sat" class="tab-pane">

                <table>

                    <tr>
                        <td class="wd25prc"><label for="idclaveprodservsat" class="textRight">Cve Prod Serv SAT</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select name="idclaveprodservsat" id="idclaveprodservsat" size="1" style="width:80% !important;" > </select>
                        </td>
                        <td colspan="4"></td>
                    </tr>

                </table>
            </div>

        </div>    

    <input type="hidden" name="idpago" id="idpago" value="<?php echo $idpago; ?>">
    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
	</div>

</form>

</div>
</div>

<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();

    $("#clave_nivel").focus();

	var idpago = <?php echo $idpago ?>;

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		if (validForm()){
		    
		    var queryString = $(this).serialize();	

            // alert(queryString);

			var IdPagos = (idpago==0?0:1)
            
            // alert(IdPagos); 

            $.post(obj.getValue(0) + "data/", {o:27, t:IdPagos, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-CAT_PAGOS-PROP-"+idpago});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").html("");
							$("#contentMain").show();
						});
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        			}
        	}, "json");
		}else{
			$("#preloaderPrincipal").hide();
		}
	});

    function getNiveles(){
        var nc = "u="+localStorage.nc;
        $("#clave_nivel").empty();
        $.post(obj.getValue(0)+"data/", { o:1, t:28, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#clave_nivel").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                getEmisoresFiscales();    
            }, "json"
        );  
    }

    function getEmisoresFiscales(){
        var nc = "u="+localStorage.nc;
        $("#idemisorfiscal").empty();
        $.post(obj.getValue(0)+"data/", { o:1, t:26, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#idemisorfiscal").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                getConceptos();    
            }, "json"
        );  
    }

    function getConceptos(){
        var nc = "u="+localStorage.nc;
        $("#idconcepto").empty();
        $.post(obj.getValue(0)+"data/", { o:1, t:27, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#idconcepto").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                getListaVencimientos();
            }, "json"
        );  
    }

    function getListaVencimientos(){
        var nc = "u="+localStorage.nc;
        $("#idlistavencimiento").empty();
        $("#idlistavencimiento").append('<option value="0">Seleccione una Lista de Vencimiento</option>');
        $.post(obj.getValue(0)+"data/", { o:3, t:0, p:51,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#idlistavencimiento").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                

                if (idpago<=0){ // Nuevo Registro
                    $("#title").html("Nuevo registro");
                    $("#clave_nivel").focus();
                }else{ // Editar Registro
                    $("#title").html("Editando el Pago: "+idpago);
                    getPagos(idpago);
                }


            }, "json"
        );  
    }


	function getPagos(IdPagos){
		$("#preloaderPrincipal").show();
		$.post(obj.getValue(0) + "data/", {o:27, t:10008, c:IdPagos, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					idpago = json[0].idpago;
					$("#clave_nivel").val(json[0].clave_nivel);
					$("#idemisorfiscal").val(json[0].idemisorfiscal+'-'+json[0].serie);
					$("#idconcepto").val(json[0].idconcepto);
					$("#importe").val(json[0].importe);

					$("#dia_limite").val(json[0].dia_limite);
					$("#dia_de_pago").val(json[0].dia_de_pago);
					$("#aplica_a").val(json[0].aplica_a);
                    $("#orden_prioridad").val(json[0].orden_prioridad);


                    $("#idlistavencimiento").val(json[0].idlistavencimiento);

                    $("#is_descto_beca").prop("checked",json[0].is_descto_beca==1?true:false);
                    $("#is_descto").prop("checked",json[0].is_descto==1?true:false);
                    $("#is_pagos_diversos").prop("checked",json[0].is_pagos_diversos==1?true:false);
                    $("#is_siguiente_nivel").prop("checked",json[0].is_siguiente_nivel==1?true:false);
                    $("#status_pago").prop("checked",json[0].status_pago==1?true:false);
                    $("#is_descto_promocion").prop("checked",json[0].is_descto_promocion==1?true:false);
                    $("#is_facturable").prop("checked",json[0].is_facturable==1?true:false);
                    $("#is_mostrable").prop("checked",json[0].is_mostrable==1?true:false);
  
                    $("#title").html("Reg: " + json[0].idpago);

					$("#preloaderPrincipal").hide();

                    $("#clave_nivel").focus();

				}
		},'json');

	}

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

	function validForm(){

		if($("#clave_nivel").val().length <= 0){
			alert("Faltan el Nivel");
			$("#clave_nivel").focus();
			return false;
		}

        if($("#idemisorfiscal").val().length <= 0){
            alert("Faltan el Emisor Fiscal");
            $("#idemisorfiscal").focus();
            return false;
        }

        if($("#idconcepto").val().length <= 0){
            alert("Faltan el Concepto");
            $("#idconcepto").focus();
            return false;
        }

        if( parseInt($("#importe").val(),0) <= 0){
            alert("Faltan el Importe");
            $("#importe").focus();
            return false;
        }

        if( parseInt( $("#idlistavencimiento").val() ) <= 0 ){
            alert("Seleccione una Lista de Vencimientos");
            $("#idlistavencimiento").focus();
            return false;
        }


		return true;

	}


    function getCveProdServSAT(){
        var nc = "u="+localStorage.nc;
        $("#idclaveprodservsat").empty();
        $.post(obj.getValue(0)+"data/", { o:1, t:68, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#idclaveprodservsat").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                getNiveles();    
            }, "json"
        );  
    }



    getCveProdServSAT();

	var stream = io.connect(obj.getValue(4));


});

</script>