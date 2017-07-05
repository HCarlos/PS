<?php

include("includes/metas.php");

?>

<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-green">
			<h5 class="smaller">
				<i class="icon-print"></i>
				Exalumnos Panel de Reportes
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				<div class="content">

					<form class="form-horizontal" class="form" id="frmExaPR0">

						<table class="tblReports wd100prc">

							<tr>
								<td><label for="desdegen">Generación Desde:</label></td>
								<td colspan="3">
									<select id="desdegen" name="desdegen" size="1"></select>							
								</td>
								<td><label for="hastagen">Hasta:</label></td>
								<td colspan="3">
									<select id="hastagen" name="hastagen" size="1"></select>							
								</td>
							</tr>

						</table>

						<div class="form-actions center" style="padding-left: 0;">
							<button class="btn btn-success" type="submit">
								<i class="icon-ok bigger-110"></i>
								Consultar
							</button>
						</div>

						<input type="hidden" id="u" name="u" />

					</form>

				</div>
			</div>
		</div>	
	</div>
</div>

<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var arrItemGen =  [];
	$("#preloaderPrincipal").hide();

	$("#u").val(localStorage.nc);


	function getGeneraciones(){
	    var nc = "u="+localStorage.nc;
	 	$("#desdegen").empty();
	 	$("#desdegen").html("<option value='0'>Seleccione una Generación </option>");
	    $.post(obj.getValue(0)+"data/", { o:16, t:16, p:51,c:nc,from:0,cantidad:0, s:'' },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#desdegen").append('<option value="'+item.data+'"> '+item.label+'</option>');
	                arrItemGen[i] = {data:parseInt( item.data, 0), label:item.label};
	            });
	        }, "json"
	    );  
	}

	$("#desdegen").on("change",function(event){
		event.preventDefault();
		var valor = parseInt( $(this).val(), 0);
	 	$("#hastagen").empty();
	 	
	 	if ( valor==0 ) return false;

		$(arrItemGen).each(function(i,item){
			if ( item.data >= valor){
	            $("#hastagen").append('<option value="'+item.data+'"> '+item.label+'</option>');

			}
		});

	});

	 function showFormQuery(){

        var PARAMS, queryString;
        
        queryString = $("#frmExaPR0").serialize();			
		PARAMS = {data:queryString};

        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        $.post(obj.getValue(0) + "exa-report-detalle-html-1/", PARAMS,
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Listado de Exalumnos '));
	                });
	            }, "html");
        });
        return false;


	 }


    $("#frmExaPR0").on("unsubmit");
    $("#frmExaPR0").on("submit", function(event) {
        event.preventDefault();
        if ( !ValidateForm() ){
        	return false;
        }

        showFormQuery();

    });

	function ValidateForm(){
		if ( parseInt( $("#desdegen").val(), 0) <= 0  ){
			alert("Selecciona una Generación de Origen");
			$("#desdegen").focus();
			return false;
		}
		if ( parseInt( $("#hastagen").val(), 0) <= 0  ){
			alert("Selecciona una Generación de Final");
			$("#hastagen").focus();
			return false;
		}
		return true;
	}


	getGeneraciones();
	// getNivel();
	//getFechasVencimientos();
	
});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>