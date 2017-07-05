<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idtarea = $_POST['idtarea'];

?>
<form id="frmTarea" role="form">

<div class="widget-box">
    <div class="widget-header widget-header-flat">

        <h4 id="tituloPanel"></h4>
        
        <div class="widget-toolbar no-border">
                <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " style="margin: 0 2em !important;" >
                        <i class="icon-angle-left icon-on-right"></i>
                        Regresar
                </button>

        </div>

    </div>

    <div class="widget-body">
        <div class="widget-main">
            

                                <table class="wd95prc ">
                                    
                                    <tr>
                                        <td>
                                            <label for="titulo">Título:</label>
                                        </td>
                                        <td colspan="3">
                                            <input class="marginLeft1em altoMoz wd100prc" type="text" name="titulo" id="titulo" value="" autofocus/>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>
                                            <label for="fecha_inicio">Inicio:</label>
                                        </td>
                                        <td>
                                            
                                            <input class="marginLeft1em date-picker altoMoz" id="fecha_inicio" name="fecha_inicio" data-date-format="dd-mm-yyyy" type="text" >
                                            <span class="add-on">
                                                    <i class="icon-calendar"></i>
                                            </span>

                                            <select class="altoMoz tbl50W add-on"  name="hora0" id="hora0" size="1">
                                                <option value="00" >00</option>
                                                <option value="01" >01</option>
                                                <option value="02" >02</option>
                                                <option value="03" >03</option>
                                                <option value="04" >04</option>
                                                <option value="05" >05</option>
                                                <option value="06" selected>06</option>
                                                <option value="07" >07</option>
                                                <option value="08" >08</option>
                                                <option value="09" >09</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" >23</option>                                            
                                            </select>
                                            <span class="add-on">:</span>
                                            <select class="altoMoz tbl50W add-on"  name="min0" id="min0" size="1">
                                                <option value="00" selected>00</option>
                                                <option value="01" >01</option>
                                                <option value="02" >02</option>
                                                <option value="03" >03</option>
                                                <option value="04" >04</option>
                                                <option value="05" >05</option>
                                                <option value="06" >06</option>
                                                <option value="07" >07</option>
                                                <option value="08" >08</option>
                                                <option value="09" >09</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" >23</option>
                                                <option value="24" >24</option>
                                                <option value="25" >25</option>
                                                <option value="26" >26</option>
                                                <option value="27" >27</option>
                                                <option value="28" >28</option>
                                                <option value="29" >29</option>
                                                <option value="30" >30</option>
                                                <option value="31" >31</option>
                                                <option value="32" >32</option>
                                                <option value="33" >33</option>
                                                <option value="34" >34</option>
                                                <option value="35" >35</option>
                                                <option value="36" >36</option>
                                                <option value="37" >37</option>
                                                <option value="38" >38</option>
                                                <option value="39" >39</option>
                                                <option value="40" >40</option>
                                                <option value="41" >41</option>
                                                <option value="42" >42</option>
                                                <option value="43" >43</option>
                                                <option value="44" >44</option>
                                                <option value="45" >45</option>
                                                <option value="46" >46</option>
                                                <option value="47" >47</option>
                                                <option value="48" >48</option>
                                                <option value="49" >49</option>
                                                <option value="50" >50</option>
                                                <option value="51" >51</option>
                                                <option value="52" >52</option>
                                                <option value="53" >53</option>
                                                <option value="54" >54</option>
                                                <option value="55" >55</option>
                                                <option value="56" >56</option>
                                                <option value="57" >57</option>
                                                <option value="58" >58</option>
                                                <option value="59" >59</option>
                                            </select>
                                            <span class="add-on">:</span>
                                            <select class="altoMoz tbl50W add-on"  name="seg0" id="seg0" size="1">
                                                <option value="00" selected>00</option>
                                                <option value="01" >01</option>
                                                <option value="02" >02</option>
                                                <option value="03" >03</option>
                                                <option value="04" >04</option>
                                                <option value="05" >05</option>
                                                <option value="06" >06</option>
                                                <option value="07" >07</option>
                                                <option value="08" >08</option>
                                                <option value="09" >09</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" >23</option>
                                                <option value="24" >24</option>
                                                <option value="25" >25</option>
                                                <option value="26" >26</option>
                                                <option value="27" >27</option>
                                                <option value="28" >28</option>
                                                <option value="29" >29</option>
                                                <option value="30" >30</option>
                                                <option value="31" >31</option>
                                                <option value="32" >32</option>
                                                <option value="33" >33</option>
                                                <option value="34" >34</option>
                                                <option value="35" >35</option>
                                                <option value="36" >36</option>
                                                <option value="37" >37</option>
                                                <option value="38" >38</option>
                                                <option value="39" >39</option>
                                                <option value="40" >40</option>
                                                <option value="41" >41</option>
                                                <option value="42" >42</option>
                                                <option value="43" >43</option>
                                                <option value="44" >44</option>
                                                <option value="45" >45</option>
                                                <option value="46" >46</option>
                                                <option value="47" >47</option>
                                                <option value="48" >48</option>
                                                <option value="49" >49</option>
                                                <option value="50" >50</option>
                                                <option value="51" >51</option>
                                                <option value="52" >52</option>
                                                <option value="53" >53</option>
                                                <option value="54" >54</option>
                                                <option value="55" >55</option>
                                                <option value="56" >56</option>
                                                <option value="57" >57</option>
                                                <option value="58" >58</option>
                                                <option value="59" >59</option>
                                            </select>

                                        </td>
                                        <td>
                                            <label for="fecha_fin">Entrega:</label>
                                        </td>
                                        <td>

                                            <input class="marginLeft1em date-picker altoMoz" id="fecha_fin" name="fecha_fin" data-date-format="dd-mm-yyyy" type="text" >
                                            <span class="add-on">
                                                    <i class="icon-calendar"></i>
                                            </span>

                                            <select class="altoMoz tbl50W add-on"  name="hora1" id="hora1" size="1">
                                                <option value="00" >00</option>
                                                <option value="01" >01</option>
                                                <option value="02" >02</option>
                                                <option value="03" >03</option>
                                                <option value="04" >04</option>
                                                <option value="05" >05</option>
                                                <option value="06" >06</option>
                                                <option value="07" >07</option>
                                                <option value="08" >08</option>
                                                <option value="09" >09</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" selected>23</option>                                            
                                            </select>
                                            <span class="add-on">:</span>
                                            <select class="altoMoz tbl50W add-on"  name="min1" id="min1" size="1">
                                                <option value="00" >00</option>
                                                <option value="01" >01</option>
                                                <option value="02" >02</option>
                                                <option value="03" >03</option>
                                                <option value="04" >04</option>
                                                <option value="05" >05</option>
                                                <option value="06" >06</option>
                                                <option value="07" >07</option>
                                                <option value="08" >08</option>
                                                <option value="09" >09</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" >23</option>
                                                <option value="24" >24</option>
                                                <option value="25" >25</option>
                                                <option value="26" >26</option>
                                                <option value="27" >27</option>
                                                <option value="28" >28</option>
                                                <option value="29" >29</option>
                                                <option value="30" >30</option>
                                                <option value="31" >31</option>
                                                <option value="32" >32</option>
                                                <option value="33" >33</option>
                                                <option value="34" >34</option>
                                                <option value="35" >35</option>
                                                <option value="36" >36</option>
                                                <option value="37" >37</option>
                                                <option value="38" >38</option>
                                                <option value="39" >39</option>
                                                <option value="40" >40</option>
                                                <option value="41" >41</option>
                                                <option value="42" >42</option>
                                                <option value="43" >43</option>
                                                <option value="44" >44</option>
                                                <option value="45" >45</option>
                                                <option value="46" >46</option>
                                                <option value="47" >47</option>
                                                <option value="48" >48</option>
                                                <option value="49" >49</option>
                                                <option value="50" >50</option>
                                                <option value="51" >51</option>
                                                <option value="52" >52</option>
                                                <option value="53" >53</option>
                                                <option value="54" >54</option>
                                                <option value="55" >55</option>
                                                <option value="56" >56</option>
                                                <option value="57" >57</option>
                                                <option value="58" >58</option>
                                                <option value="59" selected>59</option>
                                            </select>
                                            <span class="add-on">:</span>
                                            <select class="altoMoz tbl50W add-on"  name="seg1" id="seg1" size="1">
                                                <option value="00" >00</option>
                                                <option value="01" >01</option>
                                                <option value="02" >02</option>
                                                <option value="03" >03</option>
                                                <option value="04" >04</option>
                                                <option value="05" >05</option>
                                                <option value="06" >06</option>
                                                <option value="07" >07</option>
                                                <option value="08" >08</option>
                                                <option value="09" >09</option>
                                                <option value="10" >10</option>
                                                <option value="11" >11</option>
                                                <option value="12" >12</option>
                                                <option value="13" >13</option>
                                                <option value="14" >14</option>
                                                <option value="15" >15</option>
                                                <option value="16" >16</option>
                                                <option value="17" >17</option>
                                                <option value="18" >18</option>
                                                <option value="19" >19</option>
                                                <option value="20" >20</option>
                                                <option value="21" >21</option>
                                                <option value="22" >22</option>
                                                <option value="23" >23</option>
                                                <option value="24" >24</option>
                                                <option value="25" >25</option>
                                                <option value="26" >26</option>
                                                <option value="27" >27</option>
                                                <option value="28" >28</option>
                                                <option value="29" >29</option>
                                                <option value="30" >30</option>
                                                <option value="31" >31</option>
                                                <option value="32" >32</option>
                                                <option value="33" >33</option>
                                                <option value="34" >34</option>
                                                <option value="35" >35</option>
                                                <option value="36" >36</option>
                                                <option value="37" >37</option>
                                                <option value="38" >38</option>
                                                <option value="39" >39</option>
                                                <option value="40" >40</option>
                                                <option value="41" >41</option>
                                                <option value="42" >42</option>
                                                <option value="43" >43</option>
                                                <option value="44" >44</option>
                                                <option value="45" >45</option>
                                                <option value="46" >46</option>
                                                <option value="47" >47</option>
                                                <option value="48" >48</option>
                                                <option value="49" >49</option>
                                                <option value="50" >50</option>
                                                <option value="51" >51</option>
                                                <option value="52" >52</option>
                                                <option value="53" >53</option>
                                                <option value="54" >54</option>
                                                <option value="55" >55</option>
                                                <option value="56" >56</option>
                                                <option value="57" >57</option>
                                                <option value="58" >58</option>
                                                <option value="59" selected>59</option>
                                            </select>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="tarea" >Tarea:</label>
                                        </td>
                                        <td colspan="3">
                                            <textarea cols="40" rows="8" name="tarea" id="tarea" class="marginLeft1em wd100prc"></textarea>
                                        </td>

                                    </tr>

                                </table>



        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

            <input type="hidden" name="idtarea" id="idtarea" value="<?php echo $idtarea; ?>">
            <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
                <button type="button" class="btn btn-default pull-right closeFormUpload" data-dismiss="modal" ><i class="icon-signout "></i>Cerrar</button>
                <span class="muted"></span>
                <button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
            </div>

        </form>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {


	$("#preloaderPrincipal").hide();

	var idtarea = <?php echo $idtarea ?>;

    $("#frmTarea").unbind("submit");
    $("#frmTarea").on("submit",function(event){
        event.preventDefault();

        $("#preloaderPrincipal").show();

        var queryString = $(this).serialize();  
        
        var IdTarea = idtarea <= 0 ? 0 : 1;

        $.post(obj.getValue(0) + "data/", {o:40, t:IdTarea, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
                if (json[0].msg=="OK"){
                    alert("Datos guardados con éxito");
                    stream.emit("cliente", {mensaje: "PLATSOURCE-TAREA_EDIT-PROP-"+IdTarea});
                    $("#preloaderPrincipal").hide();
                    // if (is_fotos){
                        $("#contentProfile").hide(function(){
                            $("#contentProfile").html("");
                            $("#contentMain").show();
                        });
                    // }
                    
                }else{
                    $("#preloaderPrincipal").hide();
                    alert(json.msg);    
                }

        }, "json");

    });

    // ============================================================================================================
    // 
    // TAREA NUEVA ( INICIO )
    // 
    // ============================================================================================================


    function getTarea(IdTarea){
        
        $("#row0").hide();

        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idtarea="+IdTarea;
        $.post(obj.getValue(0)+"data/", { o:40, t:20001, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                
                $("#titulo").val ( json[0].titulo_tarea );
                $("#tarea").val ( json[0].tarea );

                $("#fecha_inicio").val ( json[0].fecha0 );
                $("#hora0").val ( json[0].hora0 );
                $("#min0").val ( json[0].min0 );
                $("#seg0").val ( json[0].seg0 );

                $("#fecha_fin").val ( json[0].fecha1 );
                $("#hora1").val ( json[0].hora1 );
                $("#min1").val ( json[0].min1 );
                $("#seg1").val ( json[0].seg1 );

                $('#fecha_inicio').mask('99-99-9999');

                $('#fecha_fin').mask('99-99-9999');

                $("#preloaderPrincipal").hide();
                
            }, "json"
        ); 
    }


    // ============================================================================================================
    // 
    // EDITAR TAREA ( FIN )
    // 
    // ============================================================================================================
 
	// close Form
	$(".closeFormUpload").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").html("");
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

    $('.date-picker').datepicker().next().on(ace.click_event, function(){
                    $(this).prev().focus();
    });

    $('#fecha_inicio').mask('99-99-9999');
    $('#fecha_inicio').val(obj.getDateToday());

    $('#fecha_fin').mask('99-99-9999');
    $('#fecha_fin').val(obj.getDateToday());


    if ( idtarea > 0 ) {
        $("#tituloPanel").html("Editando la Tarea: "+idtarea);
        getTarea(idtarea);
    }else{
        $("#tituloPanel").html("Tarea Nueva");
    }

   $("#titulo").focus();

    var stream = io.connect(obj.getValue(4));


});

</script>