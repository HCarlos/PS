<div id="rootwizard">
	<div class="navbar navbar-devch-1">
	  
	  <div class="navbar-inner">

	    <div class="container">
	<ul>
		<?php
		for ($i=1; $i <= 20; $i++) { 
	  	?>
	  	<li><a href="#tab<?= $i; ?>" data-toggle="tab" class="btn-devch-1"><?= $i; ?></a></li>
		<?php
		}
	  	?>
	</ul>
	 </div>
	  
	  </div>

	</div>
	<div id="bar" class="progress progress-striped active green">
	  <div class="bar"></div>
	</div>
	
	<form id="formQuizEmah">
		
		<div class="tab-content">
			<?php
			for ($i=1; $i <= 20; $i++) { 
		  	?>
			
				<div class="tab-pane" id="tab<?= $i; ?>">
					<div class="boxQuestion">
						<p><strong><?= $i; ?>.- Quén fue primero, el Huevo o la Gallina?</strong></p>
						
						<p>

							<div class="radio">
							  <label>
							    <input type="radio" name="optionsRadios<?= $i; ?>" id="optionsRadios<?= $i; ?>1" value="100">
							    100
							  </label>
							</div>
							<div class="radio">
							  <label>
							    <input type="radio" name="optionsRadios<?= $i; ?>" id="optionsRadios<?= $i; ?>2" value="75">
							    75
							  </label>
							</div>
							<div class="radio">
							  <label>
							    <input type="radio" name="optionsRadios<?= $i; ?>" id="optionsRadios<?= $i; ?>3" value="50">
							    50
							  </label>
							</div>
							<div class="radio">
							  <label>
							    <input type="radio" name="optionsRadios<?= $i; ?>" id="optionsRadios<?= $i; ?>4" value="25">
							    25
							  </label>
							</div>

						</p>

					</div>
			    </div>

			
			<?php
			}
		  	?>

			
			<ul class="pager wizard">
				<li class="previous first" style="display:none;"><a href="#">Primero</a></li>
				<li class="previous"><a href="#">Anterior</a></li>
				<li class="next last" style="display:none;"><a href="#">Último</a></li>
			  	<li class="next"><a href="#">Siguiente</a></li>
			</ul>
		</div>	

		<div class="form-actions center">
			<button type="submit" class="btn btn-lg btn-success">
				<i class="icon icon-ok bigger-150"></i>
				Guardar
			</button>
			<button type="button" class="btn btn-lg btn-default" id="cancelQuizEmah">
				<i class="fa fa-times bigger-150"></i>
				Cancelar
			</button>
		</div>

	</form>

</div>

<script type="text/javascript" src="/bootstrap/js/jquery.bootstrap.wizard.js"></script>

<script type="text/javascript">
	var indexAnt = 0;
    $('#rootwizard').bootstrapWizard({onNext: function(tab, navigation, index) {

/*            if(index==2) {
                // Make sure we entered the name
                if(!$('#name').val()) {
                    alert('You must enter your name');
                    $('#name').focus();
                    return false;
                }
            }
            // Set the name for the next tab
            $('#tab3').html('Hello, ' + $('#name').val());

*/          


/*
			
			var eval = $("input[name=optionsRadios"+index+"]:checked").val();
			if (eval == undefined){
				alert("Proporcione una valor para la Pregunta "+index);
                $("#optionsRadios"+index+"1").focus();
                return false;
			}

*/
  

        }, onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            $('#rootwizard').find('.bar').css({width:$percent+'%'});



/*            if (indexAnt==0){
            	indexAnt=$current;
            }else{
				var eval = $("input[name=optionsRadios"+indexAnt+"]:checked").val();
				if (eval == undefined){
					alert("Proporcione una valor para la Pregunta "+indexAnt);
	                $("#optionsRadios"+indexAnt+"1").focus();
	                $('#rootwizard').bootstrapWizard('show',indexAnt-1);
	                return false;
				}
            	indexAnt=$current;            	
            }
*/        


		
		}

	});
	
	$("#formQuizEmah").unbind("submit");
	$("#formQuizEmah").on("submit",function(event){
		event.preventDefault();
		alert("Save");
	});

	$("#cancelQuizEmah").on("click",function(event){
		event.preventDefault();
		alert("Cancelado");
	});

	$("#preloaderPrincipal").hide();

</script>
