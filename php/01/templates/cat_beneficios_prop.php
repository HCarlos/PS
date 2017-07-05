<?php

include("includes/metas.php");

$user = $_POST['user'];
$idbeneficio  = $_POST['idbeneficio'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmDataBenAfil" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					Beneficio
				</a>
			</li>

			<li>
				<a data-toggle="tab" href="#especificos">
					<i class="red icon-home bigger-110"></i>
					Domicilio
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
				<table>
					<tr>
						<td width="25%">
                    		<label for="idgirobeneficio" class="lblH2cmb">Giro </label>
                    	</td>	
						<td width="400">
		                    <select name="idgirobeneficio" id="idgirobeneficio" size="1" style="width:100% !important;" > 
		                    </select>
                    	</td>	
					</tr>

					<tr>
						<td>
			    			<label for="empresa" class="control-label">Empresa</label>
                    	</td>	
						<td>
				    		<input type="text" class="form-control altoMoz" id="empresa" name="empresa" required autofocus >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="descuento" class="control-label">Descuento</label>
                    	</td>	
						<td>
				    		<input type="text" class="form-control altoMoz" id="descuento" name="descuento" required >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="telefonos" class="control-label">Telefonos</label>
                    	</td>	
						<td>
				    		<input type="text" class="form-control altoMoz" id="telefonos" name="telefonos" >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="emails" class="control-label">E-mails</label>
                    	</td>	
						<td>
				    		<input type="text" class="form-control altoMoz" id="emails" name="emails" >
		      			</td>
					</tr>

					<tr>
						<td>
                    		<label for="file" class="control-label">Imagen</label>
                    	</td>	
						<td>
                        	<input type="file" class="ace ace-file-input file wd90prc" id="file" name="file" /> 
                    	</td>
					</tr>

					<tr>
						<td>
							<label for="status_beneficio" class="control-label">
									Publicado
							</label>
						</td>
						<td>
							<input name="status_beneficio" id="status_beneficio" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</td>
					</tr>
				</table>			

			</div>

			<div id="especificos" class="tab-pane">
				<table>

					<tr>
						<td width="25%">
			    			<label for="web" class="control-label">Página Web</label>
                    	</td>	
						<td width="400">
				    		<input id="web" name="web" type="text" class="form-control altoMoz"  style="width:100% !important;"  autofocus >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="facebook" class="control-label">Facebook</label>
                    	</td>	
						<td>
				    		<input id="facebook" name="facebook" type="text" class="form-control altoMoz"   >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="twitter" class="control-label">Twitter</label>
                    	</td>	
						<td>
				    		<input id="twitter" name="twitter" type="text" class="form-control altoMoz"   >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="direccion1" class="control-label">Domicilio 1</label>
                    	</td>	
						<td>
				    		<input id="direccion1" name="direccion1" type="text" class="form-control altoMoz"   >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="direccion2" class="control-label">Domicilio 2</label>
                    	</td>	
						<td>
				    		<input id="direccion2" name="direccion2" type="text" class="form-control altoMoz"   >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="direccion3" class="control-label">Domicilio 3</label>
                    	</td>	
						<td>
				    		<input id="direccion3" name="direccion3" type="text" class="form-control altoMoz"   >
		      			</td>
					</tr>

					<tr>
						<td>
			    			<label for="direccion4" class="control-label">Domicilio 4</label>
                    	</td>	
						<td>
				    		<input id="direccion4" name="direccion4" type="text" class="form-control altoMoz"   >
		      			</td>
					</tr>

				</table>			

			</div>

		</div>

	    <input type="hidden" name="idbeneficio" id="idbeneficio" value="<?= $idbeneficio; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Cerrar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var stream = io.connect(obj.getValue(4));

	$("#preloaderPrincipal").hide();

	var idbeneficio = <?= $idbeneficio ?>;

	function getBeneficio(IdBeneficioAfiliado){
		$.post(obj.getValue(0) + "data/", {o:39, t:39, c:IdBeneficioAfiliado, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#empresa").val(json[0].empresa);
					$("#idgirobeneficio").val(json[0].idgirobeneficio);
					$("#descuento").val(json[0].descuento);
					$("#telefonos").val(json[0].telefonos);
					$("#emails").val(json[0].emails);
					$("#web").val(json[0].web);
					$("#facebook").val(json[0].facebook);
					$("#twitter").val(json[0].twitter);
					$("#direccion1").val(json[0].direccion1);
					$("#direccion2").val(json[0].direccion2);
					$("#direccion3").val(json[0].direccion3);
					$("#direccion4").val(json[0].direccion4);

					$("#status_beneficio").prop("checked",json[0].status_beneficio==1?true:false);	
				}
		},'json');
	}

    $("#frmDataBenAfil").unbind("submit");
    $("#frmDataBenAfil").on("submit",function(event){
        event.preventDefault();

        if ( validForm() ) {

            $("#preloaderPrincipal").show();

                var data = new FormData();
                
                jQuery.each($('input[type=file]')[0].files, function(i, file) {
                    data.append('file', file);
                    console.log('file');
                });

                var queryString = $(this).serialize();  

                data.append('data', queryString);

                $.ajax({
                    url:obj.getValue(0)+"uf-file-beneficio/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    type: 'POST',
                    success: function(json){
                        //alert(json.status+" => "+json.message);
                        if (json.status=="OK"){
                            alert( json.message );
                            stream.emit("cliente", {mensaje: "PLATSOURCE-BENEFICIO_AFILIADOS-PROP-"+idbeneficio});
							$("#preloaderPrincipal").hide();
							$("#divUploadImage").modal('hide');
                            
                        }else{
							$("#preloaderPrincipal").hide();
	        				alert(json.status);	
                        }
                    }
                });

        }else{

            $("#preloaderPrincipal").hide();
            
        }

    });

	function getGiroBeneficios(){
	    var nc = "u="+localStorage.nc;
	    $("#idgirobeneficio").empty();
	    // $("#idgirobeneficio").append('<option value="0">Todos</option>');
	    $.post(obj.getValue(0)+"data/", { o:59, t:59, p:51,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idgirobeneficio").append('<option value="'+item.idgirobeneficio+'"> '+item.girobeneficio+'</option>');
	            });

				if (idbeneficio<=0){
					$("#title").html("Nuevo registro");
				}else{
					$("#title").html("Editando el registro: "+idbeneficio);
					getBeneficio(idbeneficio);
				}

	        }, "json"
	    );  
	}

	$("#closeProp").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});

	function validForm(){

		if($("#empresa").val().length <= 0){
			alert("Faltan la Empresa");
			$("#empresa").focus();
			return false;
		}

		if(parseInt($("#idgirobeneficio").val(),0) < 0){
			alert("Faltan el Giro de la Empresa");
			$("#idgirobeneficio").focus();
			return false;
		}

		return true;

	}

    $('.file').ace_file_input({
        no_file:'Sin Archivo ...',
        btn_choose:'Seleccione un archivo',
        btn_change:'Cambiar',
        droppable:false,
        onchange:null,
        thumbnail:true, //| true | large
        whitelist:'gif|png|jpg|jpeg|empresa|doc|docx|xls|xlsx|ppt|pptx|txt',
        blacklist:'exe|php|odt'
        //onchange:''
        //
    });

	getGiroBeneficios();

	$("#nivel").focus();




});

</script>