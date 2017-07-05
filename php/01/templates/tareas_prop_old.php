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
    <div class="widget-header widget-header-blue widget-header-flat">

        <div class="widget-toolbar no-border">

                <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " style="margin: 0 2em !important;" >
                        <i class="icon-angle-left icon-on-right"></i>
                        Regresar
                </button>

        </div>

    </div>

    <div class="widget-body">
        <div class="widget-main">
            <div class="row-fluid" id="row0">

                <small class="green">
                    <b>Grupos</b>
                </small>

                <select name="lstGruposTr0" id="lstGruposTr0" size="1" class="lstGruposTr0 " style="margin: 0 !important;"></select> 
                <span class="separatorSpan"></span>
                <small class="green">
                    <b>Materias</b>
                </small>

                <select name="lstMatsTr0" id="lstMatsTr0" size="1" class="lstMatsTr0" style="margin: 0 !important; "></select> 

                <span class="separatorSpan"></span>

                <button type="button" class="btn btn-minier btn-success arrowed-in-right arrowed addAlumns " style="margin: 0 2em !important;" id="btnAddAluTareas0">
                       <i class="fa fa-plus"></i>
                        Agregar Alumnos
                </button>

     
            </div>
            
            <div class="hr hr-dotted"></div>
            
            <!-- Lista de Alumnos -->
            <div class="row-fluid">

                <div class="widget-box transparent">

                    <div class="widget-header widget-header-flat">
                        <h4 class="lighter">
                            <i class="icon-star orange"></i>
                            <span id="cantAluSel">0</span> Alumnos Agregados
                        </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="icon-chevron-up"></i>
                            </a>
                        </div>

                        <div class="widget-toolbar">
                            <a href="#" id="btnClearTableAlumnosTar">
                                <i class="icon-trash red"></i>
                            </a>                            
                        </div>

                    </div>

                    <div class="widget-body">
                        <div class="widget-main no-padding">

                            <table class="bordered" id="tblTarAlumnos" >
                                
                                <thead>
                                    <tr>
                                        <th class="tbl10W">ID</th>
                                        <th class="tbl300W">A  L  U  M  N  O</th>
                                        <th class="tbl500W">MATERIA / GRUPO</th>
                                        <th class="tbl50W">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>                                    
                                <tfoot>
                                    <tr>
                                        <th colspan="4"></th>
                                    </tr>
                                </tfoot>

                            </table>

                        </div><!--/widget-main-->
                    </div><!--/widget-body-->

                </div><!--  widget-box -->
            </div> <!-- row-fluid -->

            <div class="hr hr-dotted "></div>

            
            <!-- Redactar Tarea -->
            <div class="row-fluid">

                <div class="widget-box transparent ">

                    <div class="widget-header widget-header-flat">
                        <h4 class="lighter">
                            <i class="icon-star orange"></i>
                            Redactar Tarea
                        </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="icon-chevron-up"></i>
                            </a>
                        </div>

                    </div>

                    <div class="widget-body">
                        <div class="widget-main no-padding">




                                <table class="wd100prc borderTopContainer">
                                    
                                    <tr>
                                        <td>
                                            <label for="titulo">Título:</label>
                                        </td>
                                        <td colspan="3">
                                            <input class="altoMoz wd94prc" type="text" name="titulo" id="titulo" value="" />
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>
                                            <label for="fecha_inicio">Inicio:</label>
                                        </td>
                                        <td>
                                            
                                            <input class="date-picker altoMoz" id="fecha_inicio" name="fecha_inicio" data-date-format="dd-mm-yyyy" type="text" >
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

                                            <input class="date-picker altoMoz" id="fecha_fin" name="fecha_fin" data-date-format="dd-mm-yyyy" type="text" >
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
                                            <textarea cols="40" rows="8" name="tarea" id="tarea" class=" wd94prc"></textarea>
                                        </td>

                                    </tr>

                                </table>



                        </div><!--/widget-main-->
                    </div><!--/widget-body-->

                </div><!--  widget-box -->

            </div> <!-- row-fluid Redactar Tarea-->


            <!--Subir Archivos -->
            <div class="row-fluid">

                <div class="widget-box transparent ">

                    <div class="widget-header widget-header-flat">
                        <h4 class="lighter">
                            <i class="icon-star orange"></i>
                            Subir Archivos
                        </h4>

                        <div class="widget-toolbar">

                            <a href="#tblFilesUp" class="ui-pg-div" id="btnUploadFileNew">
                                <i class="ui-icon icon-plus-sign purple"></i>
                            </a>

                            <a href="#" data-action="collapse">
                                <i class="icon-chevron-up"></i>
                            </a>
                        </div>

                    </div>

                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <table id="tblFilesUp" class="borderTopContainer wd100prc">
                                <tbody>
                                </tbody>
                            </table>
                        </div><!--/widget-main-->
                    </div><!--/widget-body-->

                </div><!--  widget-box -->

            </div> <!-- row-fluid Subir Arhivos-->




        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

            <input type="hidden" name="idtarea" id="idtarea" value="<?php echo $idtarea; ?>">
            <input type="hidden" name="tipo" id="tipo" value="0">
            <input type="hidden" name="destinatarios" id="destinatarios" value="">
            <input type="hidden" name="idgrumat" id="idgrumat" value="0">
            <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
                <button type="button" class="btn btn-default pull-right closeFormUpload" data-dismiss="modal" ><i class="icon-signout "></i>Cerrar</button>
                <span class="muted"></span>
                <button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Enviar</button>
            </div>

        </form>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {

    var arrItems = new Array();
    var nrow = 0;

	$("#preloaderPrincipal").hide();

    $("#rfc").focus();

	var idtarea = <?php echo $idtarea ?>;

    $("#frmTarea").unbind("submit");
    $("#frmTarea").on("submit",function(event){
        event.preventDefault();

        $("#preloaderPrincipal").show();

                var destin = "";

                $("#tblTarAlumnos tbody tr").each( function(){
                       var sx = this.id.split('-');
                       var sz = sx[1]+'°'+sx[3];
                        destin += destin == '' ? sz : '|'+sz;
                });

                $("#idgrumat").val( $("#lstMatsTr0").val() );

                console.log(destin);

                $("#destinatarios").val(destin);
                
                var data = new FormData();

                for (j=0;j < $('input[type=file]').length; j++   ){
                    jQuery.each($('input[type=file]')[j].files, function(i, file) {
                        data.append('file_'+j, file);
                        console.log('file_'+j);
                    });
                }

                var queryString = $(this).serialize();  

                data.append('data', queryString);

                alert(queryString);
                // alert(data);

                // return false;

                $.ajax({
                    url:obj.getValue(0)+"fu-ucf/",
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
                            stream.emit("cliente", {mensaje: "PLATSOURCE-UPLOAD_FILES_TAREAS-PROP-"+idtarea});
                            $("#preloaderPrincipal").hide();
                            // if (is_fotos){
                                $("#contentProfile").hide(function(){
                                    $("#contentProfile").html("");
                                    $("#contentMain").show();
                                });
                            // }
                            
                        }else{
                            $("#preloaderPrincipal").hide();
                            alert(json.message);    
                        }
                    }
                });
    });

    // ============================================================================================================
    // 
    // TAREA NUEVA ( INICIO )
    // 
    // ============================================================================================================

    function getEvalInTar(){
        var nc = "u="+localStorage.nc;
        $("#lstGruposTr0").html('<option value="0" >Seleccione un Grupo</option>');
        $.post(obj.getValue(0)+"data/", { o:1, t:16, p:0,c:nc,from:0,cantidad:0, s:" order by idgrupo asc " },
            function(json){
                var vHMTL="";
                $.each(json, function(i, item) {
                    $("#lstGruposTr0").append('<option value="'+item.data+'" > '+item.label+'</option>');
                });
               
                if ($(".lstGruposTr0").length) {
                       $(".lstGruposTr0").on("change", function(event) {
                           event.preventDefault();
                            var arr = event.currentTarget.value;
                            IdGrupo = arr;
                            $("#preloaderPrincipal").show();
                            getEvaluacionActiva(IdGrupo);
                            return true;
                       });
                }
            $("#preloaderPrincipal").hide();
            }, "json"
        ); 
    }

    function getEvaluacionActiva(IdGrupo){
        var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;
        $.post(obj.getValue(0)+"data/", { o:1, t:37, p:11, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                if (json.length>0){
                    
                    obj.getConfig(parseInt(json[0].idnivel,0),1);
                    evalMod = localStorage.eval0;

                    obj.getConfig(parseInt(json[0].idnivel,0),0);
                    
                    if (!localStorage.eval0){
                        localStorage.eval0 = 1;
                    }
                    evalDef = localStorage.eval0; 

                    $("#lstNoEval").html("");
                    
                    if (evalMod!=evalDef){
                        $("#lstNoEval").append('<option value="'+evalMod+'">Eval. Mod: '+evalMod+'</option>')
                        $("#lstNoEval").append('<option value="'+evalDef+'" selected>Eval. Default: '+evalDef+'</option>')
                    }else{
                        $("#lstNoEval").hide();
                    }

                    getMaterias(IdGrupo);
                    
                }

               $("#preloaderPrincipal").hide();

            }, "json"
        );
    }     

    function getMaterias(IdGrupo){
        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;
        $("#lstMatsTr0").html('<option value="0" >Seleccione una Materia</option>');
        $.post(obj.getValue(0)+"data/", { o:1, t:17, p:0, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                if (json.length>0){
                   $.each(json, function(i, item) {
                        $("#lstMatsTr0").append('<option value="'+item.data+'" > '+item.label+'</option>');
                    });
                    $("#preloaderPrincipal").hide();
                }else{
                    $("#preloaderPrincipal").hide();
                }

            }, "json"
        );
    }

    $("#btnUploadFileNew").on("click",function(event){
        event.stopPropagation();
        addItemFileUpload(0)
    })

    function addItemFileUpload(ID){

        var it = $("#tblFilesUp tbody tr").length;

        var st = '';

        st += '<tr id="tr1-'+it+'" style="border-bottom:#CCC 1px dotted;">';
        st += '        <td class="wd10prc">Archivo '+(it+1)+' </td>';
        st += '        <td class="wd50prc" >'; 
        st += '             <div class="ace-file-in-div">';
        st += '                 <input type="file" class="ace ace-file-input files wd100prc pull-right " id="file-'+it+'" name="file-'+it+'" /> ';
        st += '             </div>';
        st += '        </td>   ';
        st += '        <td class="wd20prc center">';
        st += '             <button type="button" class="btn btn-link view">Preview</button>';
        st += '        </td>';
        st += '        <td class="wd20prc">';
        st += '            <a class="red removeItemTarFile" href="#tblFilesUp"  id="removeItemTar-'+it+'-'+ID+'" >';
        st += '                <i class="icon-trash bigger-130"></i>';
        st += '            </a>';
        st += '        </td>';
        st += '    </tr>';

        $("#tblFilesUp tbody").append(st);

        $(".removeItemTarFile").on("click",function(event){
            event.stopPropagation();
            var ids = event.currentTarget.id.split('-');
            $( "#tblFilesUp tbody tr" ).each( function(){
                var sx = this.id.split('-');
                if (sx[1]==ids[1]){
                    console.log(ids[2]);
                    this.parentNode.removeChild( this ); 
                    if ( parseInt(ids[2],0) > 0 ){
                        // Eliminalo de la DB
                    }
                }
            });                        
        });

        $('.files').ace_file_input({
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

       
    }

    $("#btnClearTableAlumnosTar").on("click",function(event){
        event.stopPropagation();
        var q = confirm("Esta seguro que desea todos los alumnos agregados?");
        if (!q) return false;
        arrItems = [];
        nrow = 0;
        $("#tblTarAlumnos > tbody").empty();
        $("#cantAluSel").html( 0 );

    })



    $("#btnAddAluTareas0").on("click",function(event){
        event.stopPropagation();
        addAlumnosToTareas();
    });

    function addAlumnosToTareas(){
        var idtxt = $("#lstMatsTr0 option:selected").text();
        var q = confirm("Esta seguro que desea agregar todos los alumnos de la materia seleccionada: "+idtxt+"?");
        if (!q) return false;

        $("#preloaderPrincipal").show();
        var idgm = $("#lstMatsTr0").val();
        var nc = "u="+localStorage.nc+"&idgrumat="+idgm+"&numval="+localStorage.eval0;
        $.post(obj.getValue(0)+"data/", { o:40, t:90, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                    var trs = "";

                    $.each(json, function(i, item) {

                        var isExist = arrItems.filter(function (person) { return person.idboleta == item.idboleta });
                        
                        if (isExist.length <= 0){                       

                            arrItems[nrow] = {idboleta:item.idboleta};
                            trs = '<tr class="hover" id="tr0-'+item.idboleta+'-'+nrow+'-'+item.iduseralu+'">'; 
                            trs += '    <td>'+item.idboleta+'</td>';
                            trs += '    <td>'+item.alumno+'</td>';
                            trs += '    <td>'+item.materia+' ( '+item.grupo+' )</td>';
                            trs += '    <td>';
                            trs +='             <a class="red removeAluFromListaDestinatarios" href="#tblTarAlumnos"  id="removeAluFromListaDestinatarios-'+item.idboleta+'-'+item.alumno+' :: '+item.materia+' ( '+item.grupo+' )" >';
                            trs +='                 <i class="icon-trash bigger-130"></i>';
                            trs +='             </a>';
                            trs += '    </td>';
                            trs += '</tr>';
                            $("#tblTarAlumnos > tbody").append(trs);
                            nrow++;
                        }

                    });
                    $("#preloaderPrincipal").hide();

                    $(".removeAluFromListaDestinatarios").on("click",function(event){
                        event.stopPropagation();
                        var ids = event.currentTarget.id.split('-');
                        var q = confirm("Esta seguro que desea eliminar el alumn@: "+ids[2]+" ?")
                        if (!q) return false;
                        $( "#tblTarAlumnos tbody tr" ).each( function(){
                            var sx = this.id.split('-');
                            if (sx[1]==ids[1]){
                                delete arrItems[ parseInt(sx[2]) ];
                                this.parentNode.removeChild( this ); 
                                $("#cantAluSel").html( $( "#tblTarAlumnos tbody tr" ).length );
                            }
                        });                        
                    });

                    $("#cantAluSel").html( $( "#tblTarAlumnos tbody tr" ).length );

            }, "json"
        );    
    }

    // ============================================================================================================
    // 
    // TAREA NUEVA ( FIN )
    // 
    // ============================================================================================================

    // ============================================================================================================
    // 
    // EDITAR TAREA ( INICIO )
    // 
    // ============================================================================================================

    function getTarea(IdTarea){
        
        $("#row0").hide();

        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idtarea="+IdTarea;
        $.post(obj.getValue(0)+"data/", { o:40, t:20001, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                
                getFiles(IdTarea);

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

    function getFiles(IdTarea){
        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idtarea="+IdTarea;
        $.post(obj.getValue(0)+"data/", { o:40, t:20002, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){

                var st = "";

                $.each(json, function(i, item) {
                    
                    var it = $("#tblFilesUp tbody tr").length;

                    st = '<tr id="tr1-'+it+'" style="border-bottom:#CCC 1px dotted;">';
                    st += '        <td class="wd10prc">Archivo '+(it+1)+' </td>';
                    st += '        <td class="wd50prc ">';
                    st += '            <span class="marginLeft2em text-success">'+item.archivo+'</span> ';
                    st += '        </td>   ';
                    st += '        <td class="wd20prc center">';
                    st += '             <a type="button" href="'+obj.getValue(0)+item.directorio+item.archivo+'" target="_blank" class="btn btn-link view">Preview</a>';
                    st += '        </td>';
                    st += '        <td class="wd20prc">';
                    st += '            <a class="red removeItemTarFileExist" href="#tblFilesUp"  id="removeItemTar-'+it+'-'+item.idtareaarchivo+'-'+item.archivo+'" >';
                    st += '                <i class="icon-trash bigger-130"></i>';
                    st += '            </a>';
                    st += '        </td>';
                    st += '    </tr>';
                    $("#tblFilesUp tbody").append(st);


                });

                $(".removeItemTarFileExist").on("click",function(event){
                    event.stopPropagation();
                    var ids = event.currentTarget.id.split('-');
                    $( "#tblFilesUp tbody tr" ).each( function(){
                        var sx = this.id.split('-');
                        if (sx[1]==ids[1]){
                            console.log(ids[2]);
                            this.parentNode.removeChild( this ); 
                            if ( parseInt(ids[2],0) > 0 ){
                                DelteFileExist(ids[2],ids[3]);
                            }
                        }
                    });                        
                });


            $("#preloaderPrincipal").hide();
            }, "json"
        ); 
    }

    function DelteFileExist(IdTareaArchivo,Archivo){



                $("#preloaderPrincipal").show();

                var queryString = "idtareaarchivo="+IdTareaArchivo+"&archivo="+Archivo;

                var data = new FormData();

                data.append('data', queryString);

                alert(queryString);

                // return false;

                $.ajax({
                    url:obj.getValue(0)+"fu-ufdfe/",
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
                            stream.emit("cliente", {mensaje: "PLATSOURCE-DELETE_FILES_TAREAS-PROP-"+IdTareaArchivo});
                            $("#preloaderPrincipal").hide();
                            
                        }else{
                            $("#preloaderPrincipal").hide();
                            alert(json.message);    
                        }
                    }
                });


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

    var stream = io.connect(obj.getValue(4));

    if ( idtarea > 0 ) {
        getTarea(idtarea);
    }else{
        getEvalInTar();
    }


});

</script>