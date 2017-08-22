<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idpdf  = $_POST['idpdf'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmDataPDF" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					Boletín
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
				<table>
					<tr>
						<td width="35%">
                    		<label for="idnivel" class="lblH2cmb">Nivel </label>
                    	</td>	
						<td width="300">
		                    <select name="idnivel" id="idnivel" size="1" style="width:100% !important;" > 
		                    </select>
                    	</td>	
					<tr>

					<tr>
						<td>
			    			<label for="pdf" class="control-label">Boletín</label>
                    	</td>	
						<td>
				    		<input type="text" class="form-control altoMoz" maxlength="20" id="pdf" name="pdf" required autofocus >
		      			</td>
					<tr>

					<tr>
						<td>
                    		<label for="file" class="control-label">Archivo</label>
                    	</td>	
						<td>
                        	<input type="file" class="ace ace-file-input file wd90prc" id="file" name="file" /> 
                    	</td>
					<tr>

					<tr>
						<td>
							<label for="status_pdf" class="control-label">
									Publicado
							</label>
						</td>
						<td>
							<input name="status_pdf" id="status_pdf" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</td>
					<tr>
				</table>			

			</div>

		</div>

	    <input type="hidden" name="idpdf" id="idpdf" value="<?= $idpdf; ?>">
	    <input type="hidden" name="categoria_pdf" id="categoria_pdf" value="0">
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

	// var stream = io.connect(obj.getValue(4));

	$("#preloaderPrincipal").hide();

	var idpdf = <?= $idpdf ?>;

	function getPDF(IdPDF){
		$.post(obj.getValue(0) + "data/", {o:57, t:35, c:IdPDF, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#pdf").val(json[0].pdf);
					$("#idnivel").val(json[0].idnivel);
					$("#status_pdf").val(json[0].status_pdf);
					$("#status_pdf").prop("checked",json[0].status_pdf==1?true:false);	
				}
		},'json');
	}

    $("#frmDataPDF").unbind("submit");
    $("#frmDataPDF").on("submit",function(event){
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
                    url:obj.getValue(0)+"uf-file-pdf/",
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
                            // stream.emit("cliente", {mensaje: "PLATSOURCE-UPLOAD_BOLETIN-PROP-"+idpdf});
							$("#preloaderPrincipal").hide();
							$("#divUploadImage").modal('hide');
                            
                        }else{
							$("#preloaderPrincipal").hide();
	        				alert(json[0].msg);	
                        }
                    }
                });

        }else{

            $("#preloaderPrincipal").hide();
            
        }

    });

	function getNiveles(){
	    var nc = "u="+localStorage.nc;
	    $("#idnivel").empty();
	    $("#idnivel").append('<option value="0">Todos</option>');
	    $.post(obj.getValue(0)+"data/", { o:1, t:3, p:0,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idnivel").append('<option value="'+item.data+'"> '+item.label+'</option>');
	            });

				if (idpdf<=0){
					$("#title").html("Nuevo registro");
				}else{
					$("#title").html("Editando el registro: "+idpdf);
					getPDF(idpdf);
				}

	        }, "json"
	    );  
	}

	$("#closeProp").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});

	function validForm(){

		if($("#pdf").val().length <= 0){
			alert("Faltan la PDF");
			$("#pdf").focus();
			return false;
		}

		if(parseInt($("#idnivel").val(),0) < 0){
			alert("Faltan el Nivel");
			$("#idnivel").focus();
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
        whitelist:'gif|png|jpg|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx|txt',
        blacklist:'exe|php|odt'
        //onchange:''
        //
    });

	getNiveles();

	$("#nivel").focus();




});

</script>