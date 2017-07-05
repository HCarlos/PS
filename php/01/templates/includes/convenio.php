<?php
$idfamilia = $_POST["idfamilia"];
$convenio = $_POST["convenio"];

?>
<div class="widget-box">
	<div class="widget-header">
		<h4>Convenio con la Familia <?= $idfamilia; ?></h4>
	</div>

	<div class="widget-body">
		<div class="widget-main no-padding">
			<form>
				<div style="padding:1em;">

					<?= nl2br($convenio); ?>

				</div>
				<div class="form-actions center">
					<button onclick="return false;" id="closeConvenio" class="btn btn-small btn-success">
						Cerrar
						<i class="icon-arrow-up icon-on-up bigger-110"></i>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>	

<script type="text/javascript">
		$("#closeConvenio").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});

</script>