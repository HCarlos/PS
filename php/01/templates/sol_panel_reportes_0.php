<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-green">
			<h5 class="smaller">
				<i class="icon-print"></i>
				Panel de Reportes
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

				<form class="form-horizontal" class="form" role="form" id="frmSolPanelReports0">

					<table class="tblReports">
						<tr>
							<td><label for="tiporeporte">Tipo Reporte: </label></td>
							<td colspan="3">
								<select id="tiporeporte" name="tiporeporte">
									<option value="0" selected>Seleccione un tipo</option>
									<option value="1">Por Proveedor</option>
									<option value="2" >Por Director</option>
									<option value="3" >Por Usuario</option>
								</select>							
							</td>
						</tr>
						<tr>
							<td><label for="idlista">Elementos:</label></td>
							<td colspan="3">
								<select id="idlista" name="idlista">
									<option value="0" selected>Seleccione un elemento</option>
								</select>							
							</td>
						</tr>
					</table>

					<div class="form-actions center">
						<button class="btn btn-success" type="submit">
							<i class="icon-ok bigger-110"></i>
							Consultar
						</button>
					</div>

					<input type="hidden" id="u" name="u" value=""/>
					<input type="hidden" id="element" name="element" value=""/> 

				</form>











				</div>
			</div>
		</div>	
	</div>
</div>


<div id="inline2">
	
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();

	$("#u").val( localStorage.nc );

    $("#frmSolPanelReports0").on("unsubmit");
    $("#frmSolPanelReports0").on("submit", function(event) {
        event.preventDefault();

        $("#element").val( $("#idlista option:selected").text() );

        var queryString = $("#frmSolPanelReports0").serialize();

        // alert(queryString);

        var cItem;
		switch( parseInt( $("#tiporeporte").val() ) ){
			case 1:
				item = 35;
				cItem = "prov";
				break;
			case 2:
				item = 37;
				cItem = "dir";
				break;
			case 3:
				item = 39;
				cItem = "usuario";
				break;
			default:
				alert("Debe seleccionar un elemento de la lista");
				return false;
		}


		// alert(queryString);

		var url = obj.getValue(0)+"print-sol-mat-"+cItem+"-arji/";
			PARAMS = {data:queryString};

		var temp=document.createElement("form");
		temp.action=url;
		temp.method="POST";
		temp.target="_blan";
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

	$("#tiporeporte").on("change",function(event){
		event.preventDefault();
		var item;
		console.log($(this).val());
        $("#idlista").html('<option value="0">No hay elementos</option>');
        var cItem;
		switch( parseInt( $(this).val() ) ){
			case 1:
				item = 35;
				cItem = "Proveedor";
				break;
			case 2:
				item = 37;
				cItem = "Director";
				break;
			case 3:
				item = 39;
				cItem = "Usuario";
				break;
			default:
				alert("Debe seleccionar un elemento de la lista");
				return false;
		}
        $("#idlista").html('<option value="0">Seleccione un '+cItem+'</option>');

		console.log( item );
	    var nc = "u="+localStorage.nc;
	    $.post(obj.getValue(0)+"data/", { o:1, t:item, p:0,c:nc,from:0,cantidad:0, s:'' },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idlista").append('<option value="'+item.data+'"> '+item.label+'</option>');
	            });
	        }, "json"
	    );  
	});

	
});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>