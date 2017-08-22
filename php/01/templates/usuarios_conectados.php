<?php

include("includes/metas.php");

?>


<div  class="row-fluid">
<!-- 	<div class="span12 widget-container-span ui-sortable"> -->
	<div class="widget-box span6">

		<div  class="widget-header header-color-green2 widget-header-flat padtop05em">
			<h3>Usuarios Conectados</h3>	
		
		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">
					<div class="body">						
						<div class="clearfix"  id="memberListConnect">
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</div>

	<div class="widget-box span6">

		<div  class="widget-header header-color-blue widget-header-flat padtop05em">
			<h3>Mensajes</h3>	
		
		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">
				</div>
			</div>
		</div>	
	</div>

</div>


<script typy="text/javascript">        

jQuery(function($) {
	var ocupado = false;
	$("#preloaderPrincipal").hide();



	$.getEval = function (IdGrupo) {
		$("#preloaderPrincipal").show();
		$("#memberListConnect").empty();
		ocupado = true;
	    var nc = "u="+localStorage.nc;
	    $.post(obj.getValue(0)+"data/", { o:49, t:4, p:54, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	            if (json.length>0){
	            	var xs;
					$("#memberListConnect").empty();
	            	$.each(json, function(i, item) {

                        var strx = item.foto.split(".");
                        var imgPath;
                        if (item.foto!=""){
                            imgPath = obj.getValue(0) + "upload/"+strx[0]+"-36."+strx[1];
                        }else{
                            imgPath = obj.getValue(0) + "images/emoticons/user-36.jpg";
                        }


		            	xs = '<div class="itemdiv memberdiv">';
						xs += '<div class="user">';
						xs += '		<img alt="'+item.nombre_completo_usuario+'" src="'+imgPath+'">';
						xs += '	</div>';
						xs += '	<div class="body">';
						xs += '		<div class="name">';
						xs += '			<a href="#">'+item.nombre_completo_usuario+'</a>';
						xs += '		</div>';
						xs += '		<div class="time">';
						xs += '			<i class="icon-time"></i>';
						xs += '			<span class="green">'+item.fAgo+'</span>';
						xs += '		</div>';					
						xs += '	</div>';
						xs += '</div>';

						$("#memberListConnect").append(xs);

					});
					$("#preloaderPrincipal").hide();
					ocupado = false;

	           	}

	        }, "json"
	    );

	}

	$.getEval();

/*
    var stream = io.connect(obj.getValue(4));
    stream.on("servidor", jsNewAlumno);
    function jsNewAlumno(datosServer) {
        var ms = datosServer.mensaje.split("-");
        if ( ms[1]=='UCONNECT' || ms[1]=='UCONNECTDELL' )  {
        	//if (!ocupado){
				$.getEval();
			//}
        }
    }
*/


});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>