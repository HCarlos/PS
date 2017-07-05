<?php

include("includes/metas.php");

$para 		 	   = $_POST['para'];
$idexafirma 	   = $_POST['idexafirma'];

?>

<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">

		<div class="widget-body">
			<div class="widget-main">
				<div class="content">

					<form class="form-horizontal" class="form wd100prc" id="frmExaFir01">

						<table class="tblReports wd100prc" >

							<tr>
								<td><label for="descripcion_firma">Título:</label></td>
								<td class="wd100prc" colspan="2" >
							    	<input type="text" class="form-control altoMoz" id="descripcion_firma" name="descripcion_firma" value="" autofocus >
								</td>
							</tr>

							<tr>
								<td><label for="firma">Firma:</label></td>
								<td class="wd100prc" colspan="2" >

									<textarea name="firma" id="firma" class="ckeditor wd100prc"></textarea>

								</td>
							</tr>

							<tr>
								<td>
									<label class="green" for="is_default_firma">
										<b>Default</b>
									</label>
								</td>
								<td>
									<input name="is_default_firma" id="is_default_firma" class="ace ace-switch ace-switch-6" type="checkbox">
									<span class="lbl"></span>
								</td>
							</tr>

							<tr>
								<td>
									<label class="green" for="status_exa_firma">
										<b>Status</b>
									</label>
								</td>
								<td>
									<input name="status_exa_firma" id="status_exa_firma" class="ace ace-switch ace-switch-6" type="checkbox" checked>
									<span class="lbl"></span>
								</td>
							</tr>

						</table>

						<div class="form-actions center" style="padding-left: 0;">

							<button class="btn btn-success" id="saveFirmExa01" type="submit">
								<i class="icon-save bigger-110"></i>
								Guardar
							</button>

					    	<button type="button" class="btn btn-default marginLeft2em" data-dismiss="modal" id="closeExaWinRep03">
					    		<i class="icon-signout"></i>
					    		Cerrar
					    	</button>
							
						</div>

						<input type="hidden" id="user" name="user" value="" />
						<input type="hidden" id="idexafirma" name="idexafirma" value="<?= $idexafirma; ?>" />
		                <input type="hidden" id="cuerpo" name="cuerpo" value="">

					</form>

				</div>
			</div>
		</div>	
	</div>
</div>

<!--PAGE CONTENT ENDS-->

<?= '<script src="/ckeditor/ckeditor.js"></script>'; ?>

<script type="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();

	$("#user").val(localStorage.nc);

	var IdExaFirma = <?= $idexafirma; ?>;

	$("#closeExaWinRep03").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

	$("#saveFirmExa01").on("click",function(event){
		event.preventDefault();
		event.stopPropagation();

        var nt = CKEDITOR.instances['firma'].getData();
        $("#cuerpo").val( nt );
        $("#firma").empty();

        var queryString = $("#frmExaFir01").serialize();	

        // alert(queryString);		

		if (validForm()){
			var IdEF = (IdExaFirma==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:68, t:IdEF, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-ADD_EXA_FIRMA-PROP-"+IdExaFirma});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").empty();
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

	$("#firma").on("keyup blur",function(event){
		event.preventDefault();
		var tcor = $(this).val();
		$("#viewInWeb").html(tcor);
	});

	function getIdExaFirma(){
	    var nc = "u="+localStorage.nc+"&idexafirma="+IdExaFirma;
		$.post(obj.getValue(0) + "data/", {o:68, t:70, c:nc, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#descripcion_firma").val(json[0].descripcion_firma);
					$("#is_default_firma").prop("checked",json[0].is_default_firma==1?true:false);	
					$("#status_exa_firma").prop("checked",json[0].status_exa_firma==1?true:false);	

                    CKEDITOR.instances['firma'].setData(json[0].firma);

					$("#descripcion_firma").focus();
				}
		},'json');

	}

	function validForm(){

		if ($("#descripcion_firma").val().length <= 0){
			alert("Faltan el título de la firma");
			$("#nombre").focus();
			return false;
		}
		return true;

	}

   var editor = CKEDITOR.replace( 'firma', { height: '180px', startupFocus : true} );

    editor.on( 'change', function( evt ) {
        // console.log( 'Total bytes: ' + evt.editor.getData().length );
    });


	function resizeScreen() {
		
	   $("#contentProfile").css("min-height", obj.getMinHeight());
	   $("#contentMain").css("min-height", obj.getMinHeight());

	}

	if (IdExaFirma > 0){
		getIdExaFirma();
	}



});


</script>