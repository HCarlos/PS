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

					<form class="form-horizontal" class="form" role="form" id="frmRepMaterialesProf0">

						<table class="tblReports">
							<tr>
								<td><label for="t_reporte">Tipo Reporte: </label></td>
								<td colspan="3">
									<select id="t_reporte" name="t_reporte">
										<option value="0">Seleccione un Tipo de Reporte</option>
										<option value="1" selected>Consumo por Profesor</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="lstProfDir">Profesores:</label></td>
								<td colspan="3">
	                				<select class="altoMoz add-on"  name="lstProfDir" id="lstProfDir" size="1"></select>
	                			</td>
							</tr>

							<tr>
								<td><label for="idproducto">Productos:</label></td>
								<td colspan="3">
	                				<select class="altoMoz add-on"  name="idproducto" id="idproducto" size="1"></select>
	                			</td>
							</tr>

							<tr>
								<td><label for="cmbStatus">Status:</label></td>
								<td colspan="3">
	                				<select class="altoMoz add-on"  name="cmbStatus" id="cmbStatus" size="1">
										<option value="0">Solicitado</option>
										<option value="1" >Autorizado</option>
										<option value="2" selected>Entregado</option>
	                				</select>
	                			</td>
							</tr>

	 						<tr>
								<td><label for="fi">Desde: </label></td>
								<td>
									
										<input class="date-picker altoMoz" id="fi" name="fi" data-date-format="dd-mm-yyyy" type="text">
										<span class="add-on">
											<i class="icon-calendar"></i>
										</span>
									
								</td>
								<td><label for="ff">Hasta: </label></td>
								<td>
										<input class="date-picker altoMoz" id="ff" name="ff" data-date-format="dd-mm-yyyy" type="text">
										<span class="add-on">
											<i class="icon-calendar"></i>
										</span>
									
								</td>
							</tr>

						</table>

						<div class="separate"></div>

						<div class="center">
							<button class="btn btn-success" type="submit">
								<i class="icon-ok bigger-110"></i>
								Consultar
							</button>
						</div>

						<input type="hidden" id="u" name="u" value=""/>
						<input type="hidden" id="element" name="element" value=""/> 
						<input type="hidden" id="logoEmp" name="logoEmp" value=""/> 

					</form>

				</div>
			</div>
		</div>	
	</div>
</div>


<div id="inline2"> </div>

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();

	$("#u").val( localStorage.nc );

    $("#frmRepMaterialesProf0").on("unsubmit");
    $("#frmRepMaterialesProf0").on("submit", function(event) {
        event.preventDefault();

        $("#element").val( $("#lstProfDir option:selected").text() );

        var logoEmp =obj.getConfig(100,0); 
        $("#logoEmp").val( logoEmp );

        var queryString = $("#frmRepMaterialesProf0").serialize();
		switch( parseInt( $("#t_reporte").val() ) ){
			case 1:
				cItem = "print-sol-mat-dir-0/";
				break;
			case 2:
				cItem = "print-sol-mat-dir-1/";
				break;
			case 3:
				cItem = "print-sol-mat-dir-2/";
				break;
			default:
				alert("Debe seleccionar un elemento de la lista");
				return false;
		}

		// alert(queryString);

		var url = obj.getValue(0)+cItem;
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

    function getProfDir(){
        var nc = "u="+localStorage.nc;
        var user = localStorage.IdUser;
        $("#lstProfDir").empty();
        $("#lstProfDir").append('<option value="0" selected>Todos los Profesores</option>');
        $.post(obj.getValue(0)+"data/", {o:52, t:59, p:55,c:nc,from:0,cantidad:0, s:user },
            function(json){
               $.each(json, function(i, item) {
                    $("#lstProfDir").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
            }, "json"
        );  
    }

    function getProductos(){
        $("#idproducto").empty();
        $("#idproducto").append('<option value="0" selected>Todos los Productos</option>');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:38, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#idproducto").append('<option value="'+item.data+'">'+item.label+'</option>');
                });
            }, "json"
        );  
    }

	$('.date-picker').datepicker({
    	format: 'dd-mm-yyyy',
		autoclose: true
	});

	$('.date-picker').on('changeDate', function(event){
	    $(this).datepicker('hide');
	    //validDate();
	});

	$('.date-picker').val(obj.getDateToday());

	getProfDir();
	getProductos();

});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>