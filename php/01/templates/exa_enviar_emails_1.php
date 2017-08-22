<?php

include("includes/metas.php");

$para 		 	   = $_POST['para'];
$idexalumnos 	   = $_POST['idexalumnos'];
$totalElementos    = $_POST['totalElementos'];
$objOrigen         = $_POST['objOrigen'];
$objDestino        = $_POST['objDestino'];
$titulo        	   = $_POST['titulo'];
$mensaje           = $_POST['mensaje'];
$idexaemailenviado = $_POST['idexaemailenviado'];

?>

<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-green">
			<h5 class="smaller">
				<i class="icon-print"></i>
				Envar email
			</h5>

			<div class="widget-toolbar border pull-right">
			    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeExaWinRep02 " style="margin: 0 1em !important;" >
			        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
			        Regresar
			    </button>
			</div>

		</div>

		<div class="widget-body">
			<div class="widget-main">
				<div class="content">

					<form class="form-horizontal" class="form wd100prc" id="frmExaPR1">

						<table class="tblReports wd100prc" >

							<tr>
								<td><label for="para">Para:</label></td>
								<td class="wd90prc">
				                    <textarea rows="4" name="para" id="para" class="wd100prc"><?= $para; ?></textarea>
				                    
								</td>
								<td class="wd10prc"><small class="orange" id="smlTotalCorreosPara"><?= $totalElementos; ?> correos</small></td>

							</tr>

							<tr>
								<td><label for="cco">Cco:</label></td>
								<td class="wd90prc">
				                    <textarea rows="4" name="cco" id="cco" class="wd100prc"><?= $cco; ?></textarea>
				                    
								</td>
								<td class="wd10prc"><small class="orange" id="smlTotalCorreosCco"><?= $totalElementos; ?> correos</small></td>

							</tr>

							<tr>
								<td><label for="titulo">Título:</label></td>
								<td class="wd100prc" colspan="2" >
							    	<input type="text" class="form-control altoMoz" id="titulo" name="titulo" value="<?= $titulo; ?>" autofocus >
								</td>
							</tr>

							<tr>
								<td><label for="mensaje">Mensaje:</label></td>
								<td class="wd100prc" colspan="2" >

									<textarea name="mensaje" id="mensaje" class="ckeditor wd100prc"><?= $mensaje; ?></textarea>

								</td>
							</tr>

							<tr>
								<td><label for="firma">Firma:</label></td>
								<td class="wd90prc" id="firma"></td>
								<td></td>

							</tr>

						</table>

						<div class="form-actions center" style="padding-left: 0;">
							
							<button class="btn btn-success radius-4" type="submit">
								<i class="icon-ok bigger-110"></i>
								Enviar Email
							</button>

							<button class="btn btn-inverse marginLeft2em" id="saveTempFormExa01">
								<i class="icon-save bigger-110"></i>
								Guardar borrador
							</button>

							<button class="btn btn-default marginLeft2em closeExaWinRep02">
								<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
								Regresar
							</button>

						</div>

						<input type="hidden" id="user" name="user" value="" />
		                <input type="hidden" id="cuerpo" name="cuerpo" value="">
		                <input type="hidden" id="idexafirma" name="idexafirma" value="0">
						<input type="hidden" id="iddestinatarios" name="iddestinatarios" value="<?= $idexalumnos; ?>" />
						<input type="hidden" id="idexaemailenviado" name="idexaemailenviado" value="<?= $idexaemailenviado; ?>" />

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

	var objOrigen  = "<?= $objOrigen; ?>";
	var objDestino = "<?= $objDestino; ?>";
	var IdExaEmailEnviado = <?= $idexaemailenviado; ?>;

	$(".closeExaWinRep02").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#"+objOrigen).hide(function(){
			$("#"+objOrigen).empty();
			$("#"+objDestino).show();
		});
		resizeScreen();
		return false;
	});

    $("#frmExaPR1").on("unsubmit");
    $("#frmExaPR1").on("submit", function(event) {
        event.preventDefault();
        event.stopPropagation();
        sendEmail1();

    });

	function sendEmail1(){

        var nt = CKEDITOR.instances['mensaje'].getData();
        $("#cuerpo").val( nt );
        $("#mensaje").val('');

        queryString = $("#frmExaPR1").serialize();		

        queryString += "&firma="+$("#firma").html();

		var PARAMS = {data:queryString};

		var x = confirm('Desea enviar estos correos ahora?');
		if (!x) return false;

        $("#preloaderPrincipal").show();
        obj.setIsTimeLine(false);
        $.post(obj.getValue(0) + "send-emails-exalumnos-1/", PARAMS,
            function(json) {	                
            	if (json[0].msg == "OK"){
            		alert("Correos enviados con exito.");
					$("#preloaderPrincipal").hide();
					$("#"+objOrigen).hide(function(){
						$("#"+objOrigen).empty();
						$("#"+objDestino).show();
					});
					resizeScreen();
					return false;
            	}
        }, "json");

	}

	$("#saveTempFormExa01").on("click",function(event){
		event.preventDefault();
		event.stopPropagation();
		
        var nt = CKEDITOR.instances['mensaje'].getData();
        $("#cuerpo").val( nt );
        $("#mensaje").val('');

        queryString = $("#frmExaPR1").serialize();			

        var IdExa = IdExaEmailEnviado == 0 ? 3 : 4;
        $.post(obj.getValue(0) + "data/", {o:60, t:IdExa, c:queryString, p:52, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-ADD_EXA_ALUMNOS-PROP"});
                    $("#preloaderPrincipal").hide();
					$("#"+objOrigen).hide(function(){
						$("#"+objOrigen).empty();
						$("#"+objDestino).show();
					});
					resizeScreen();
					return false;
    			}else{
					$("#preloaderPrincipal").hide();
    				alert(json[0].msg);	
    			}
    	}, "json");

	});


	$("#para").on("keyup blur",function(event){
		event.preventDefault();
		var tcor = $(this).val().split(',');
		contarEmails(tcor,"smlTotalCorreosPara");
	});

	$("#cco").on("keyup blur",function(event){
		event.preventDefault();
		var tcor = $(this).val().split(',');
		contarEmails(tcor,"smlTotalCorreosCco");
	});

	function contarEmails(arrEmails, Destino){
		if ( arrEmails.length > 1 ){
			$("#"+Destino).html(arrEmails.length+' correos');
		}else if ( arrEmails.length == 1 ){
			$("#"+Destino).html('1 correo');
		}else{
			$("#"+Destino).html('0 correos');
		}		
	}

	$("#mensaje").on("keyup blur",function(event){
		event.preventDefault();
		var tcor = $(this).val();
		$("#viewInWeb").html(tcor);

	});

	function getIdExaEmailEnviado(){
	    var nc = "u="+localStorage.nc+"&idexaemailenviado="+IdExaEmailEnviado;
		$.post(obj.getValue(0) + "data/", {o:60, t:65, c:nc, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#para").val(json[0].para);
					$("#cco").val(json[0].cco);
					$("#titulo").val(json[0].titulo);

					$("#iddestinatarios").val(json[0].iddestinatarios);
					$("#idexafirma").val(json[0].idexafirma);
					
					$("#viewInWeb").html(json[0].cuerpo);

					$("#firma").html(json[0].firma);


					contarEmails($("#para").val().split(','), "smlTotalCorreosPara");
					contarEmails($("#cco").val().split(','), "smlTotalCorreosCco");

                    CKEDITOR.instances['mensaje'].setData(json[0].cuerpo);


					$("#titulo").focus();
				}
		},'json');

	}

	function getfirma(){
	    var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:68, t:71, c:nc, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#idexafirma").val(json[0].idexafirma);
					$("#firma").html(json[0].firma);
					$("#titulo").focus();
				}
		},'json');

	}

   var editor = CKEDITOR.replace( 'mensaje', { height: '380px', startupFocus : true} );

    editor.on( 'change', function( evt ) {
        console.log( 'Total bytes: ' + evt.editor.getData().length );
    });


	function resizeScreen() {
		
	   $("#"+objOrigen).css("min-height", obj.getMinHeight());
	   $("#"+objDestino).css("min-height", obj.getMinHeight());

	}

	if (IdExaEmailEnviado > 0){
		getIdExaEmailEnviado();
	}else{
		getfirma();
	}



});


</script>