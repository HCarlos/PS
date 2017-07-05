<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idproveedor  = $_POST['idproveedor'];

?>

<h3 class="header smaller lighter blue">
    <span id="title"></span>
    <a class="label label-info arrowed-in-right arrowed closeFormUpload pull-right">Regresar</a>
</h3>

<form id="frmData"  class="form">

<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">

                <table>

                    <tr>
                        <td><label for="rfc" class="textRight">RFC</label></td>
                        <td>
                             <span class="add-on"><i class="icon-asterisk red"></i></span>
<!--                             <input class="altoMoz" name="rfc" id="rfc" type="text" pattern="^[A-Za-zñ&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9]([A-Za-z0-9]{3})?" required>
 -->
                            <input class="altoMoz" name="rfc" id="rfc" type="text" autofocus>

                      </td>

                        <td><label for="contacto" class="marginLeft2em textRight">Contacto</label></td>
                        <td>
                            <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
                            <input class="altoMoz" name="contacto" id="contacto" type="text" >
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="proveedor" class="textRight">Proveedor</label></td>
                        <td colspan="5">
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz wd90prc" name="proveedor" id="proveedor" type="text" required>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="direccion" class="textRight">Dirección</label></td>
                        <td colspan="5">
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz wd90prc" name="direccion" id="direccion" type="text" required>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="localidad" class=" textRight">Localidad</label></td>
                        <td colspan="5">
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz wd90prc" name="localidad" id="localidad" type="text" required>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="idestado" class="textRight">Estado</label></td>
                        <td >
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <select class="form-control  wd40prc altoMoz"  name="idestado" id="idestado" size="1">
                        </td>
                        <td><label for="idmunicipio" class="marginLeft2em textRight">Municipio</label></td>
                        <td >
                            <select class="form-control  wd42prc altoMoz"  name="idmunicipio" id="idmunicipio" size="1">
                        </td>
                    </tr>

                    <tr>
                        <td><label for="pais" class="marginLeft2em textRight">Pais</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="pais" id="pais" value="México" type="text" required>
                        </td>
                        <td><label for="codpos" class="marginLeft2em textRight">CP</label></td>
                        <td>
                            <input class="altoMoz" name="codpos" id="codpos" type="text" >
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="email1" class="textRight">EMail 1</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="email1" id="email1" type="email" >
                        </td>
                        <td><label for="email2" class="marginLeft2em textRight">Email 2</label></td>
                        <td>
                            <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
                            <input class="altoMoz" name="email2" id="email2" type="email" >
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="tel1" class="textRight">Tel 1</label></td>
                        <td>
                            <span class="add-on"><i class="icon-asterisk red"></i></span>
                            <input class="altoMoz" name="tel1" id="tel1" type="text" >
                        </td>
                        <td><label for="tel2" class="marginLeft2em textRight">Tel 2</label></td>
                        <td>
                            <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
                            <input class="altoMoz" name="tel2" id="tel2" type="text" >
                        </td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="status_proveedor" class="marginLeft2em textRight">Estatus</label></td>
                        <td>
                            <input name="status_proveedor" id="status_proveedor" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                     </tr>


                </table>


    <input type="hidden" name="idproveedor" id="idproveedor" value="<?php echo $idproveedor; ?>">
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
    var init = true;

	$("#preloaderPrincipal").hide();

    $("#rfc").focus();

	var idproveedor = <?php echo $idproveedor ?>;

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		if (validForm()){
		    
		    var queryString = $(this).serialize();	

			var IdProveedor = (idproveedor==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:33, t:IdProveedor, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-PROVEEDORES-PROP-"+idproveedor});
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

	function getProveedor(IdProveedor){
		$("#preloaderPrincipal").show();
		$.post(obj.getValue(0) + "data/", {o:33, t:83, c:IdProveedor, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					idproveedor = json[0].idproveedor;
					$("#rfc").val(json[0].rfc);
					$("#contacto").val(json[0].contacto);
					$("#proveedor").val(json[0].proveedor);
					$("#direccion").val(json[0].direccion);
					$("#localidad").val(json[0].localidad);
                    $("#idestado").val(json[0].idestado);
					// $("#idmunicipio").val(json[0].idmunicipio);
                    
                    getMunicipios( parseInt(json[0].idmunicipio,0) );

					$("#pais").val(json[0].pais);
                    $("#codpos").val(json[0].codpos);
					$("#email1").val(json[0].email1);
					$("#email2").val(json[0].email2);
                    $("#tel1").val(json[0].tel1);
                    $("#tel2").val(json[0].tel2);
                    $("#status_proveedor").prop("checked",json[0].status_proveedor==1?true:false);

                    $("#title").html("Reg: " + json[0].idproveedor);

					$("#preloaderPrincipal").hide();

                    $("#rfc").focus();

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

		if($("#rfc").val().length <= 0){
			alert("Faltan el RFC");
			$("#rfc").focus();
			return false;
		}

		return true;

	}

    function getEstados(){
       $("#preloaderPrincipal").show();
       $("#idestado").html('');
       // $("#idmedida").html('<option value="0" > Seleccione un Color </option>');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:1, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                var nc,it;
               $.each(json, function(i, item) {
                    $("#idestado").append('<option value="'+item.data+'" > '+item.label+'</option>');
                });
                $("#preloaderPrincipal").hide();
               getMunicipios(0);
            }, "json"
        );  
    }

    $("#idestado").on("change",function(event){
        event.preventDefault();
        getMunicipios(0);        
    });

    function getMunicipios(oMun){
       $("#preloaderPrincipal").show();
       $("#idmunicipio").html('');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:0, p:0,c:nc,from:0,cantidad:0, s:$("#idestado").val() },
            function(json){
                var nc,it;
               $.each(json, function(i, item) {
                    $("#idmunicipio").append('<option value="'+item.data+'" > '+item.label+'</option>');
                });
                $("#preloaderPrincipal").hide();
                if (init){
                    if (idproveedor<=0){ // Nuevo Registro
                        $("#title").html("Nuevo registro");
                        $("#rfc").focus();
                    }else{ // Editar Registro
                        $("#title").html("Editando la Proveedor: "+idproveedor);
                        getProveedor(idproveedor);
                    }
                    init = false;
                }

                if (oMun!=0){
                    $("#idmunicipio").val(oMun);
                }

            }, "json"
        );  
    }

    getEstados();

	var stream = io.connect(obj.getValue(4));


});

</script>