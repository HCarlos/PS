<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idtarea = $_POST['idtarea'];
$tarea = $_POST['tarea'];

?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <i class="icon-circle green"></i> <strong id="spIdtarea"><?php echo $idtarea ?></strong>: <b class="text-success"><?php echo $tarea ?></b> 
        <div class="widget-toolbar">
            <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " >
                    <i class="icon-angle-left icon-on-right"></i>
                    Regresar
            </button>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-main">
            
            <div class="row-fluid">

                <div class="span4">
                    <div class="panel panel-success">
            
                        <div class="panel-heading">Seleccionar Destinatarios</div>
                        <div class="panel-body" style="height: 35em !important; ">

                            <label for="lstGruposTr0" class="lblH2cmb">Grupos Asignados </label>
                            <select name="lstGruposTr0" id="lstGruposTr0" size="1" style="width:100% !important;" class="lstGruposTr0"> 
                            </select>

                            <label for="lstMatsTr0" class="lblH2cmb">Materias: </label>
                            <select name="lstMatsTr0" id="lstMatsTr0" size="1" class="lstMatsTr0" style="width:100% !important;" > 
                            </select>

                            <select class="alumno0 " name="alumno0" id="alumno0" size="10" style="width:100% !important; height: 70% !important;"  multiple="multiple"> 
                            </select>

                       </div>

                        <span class="label label-large label-yellow arrowed-right pull-left marginTop1em" id="lbl0" ></span>

                        <div class="marginTop1em pull-right ">
                            <label>
                                <input name="selAll0" id="selAll0" class="ace ace-switch" type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </div>                    
                
                    </div>
                </div>

                <div class="span2">
                    <div class="panel panel-default no-border" style="height: 38em !important; padding-top: 100% !important;" >

                        <div class="panel-body" >
                                <button id="AddItem" name="btnAsig" class="btnAsig btn btn-primary btn-lg wd100prc" >
                                    Asignar <span class="glyphicon glyphicon-chevron-right"></span></button><br/><br/>
                                <button id="DeleteItem" name="DeleteItem" class="btnDel btn btn-primary btn-lg wd100prc" >
                                    <span class="glyphicon glyphicon-chevron-left"></span>Quitar</button>
                        </div>
                    </div>
                     <div class="div1em"></div>
                </div>

                <div class="span6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Alumnos Destinatarios</div>
                        <div class="panel-body" style="height: 35em !important; ">

                            <select class="alumno1 " name="alumno1" id="alumno1" size="10" style="width:100% !important; height: 100% !important;"  multiple="multiple"> 
                            </select>

                        </div>
                        <span class="label label-large label-yellow arrowed-right pull-left marginTop1em" id="lbl1"></span>
                        <div class="marginTop1em pull-right">
                            <label>
                                <input name="selAll1" id="selAll1" class="ace ace-switch" type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </div>                    
                        
                    </div>
                </div>


            </div> <!-- row-fluid  -->

        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {

    var idtarea = <?php echo $idtarea ?>;
    var tarea = "<?php echo $tarea ?>";




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
                            $("#alumno0").empty();
                            $("#selAll0").prop('checked', false);

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
        // alert(nc);
        $.post(obj.getValue(0)+"data/", { o:1, t:37, p:11, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                if (json.length>0){

                    // alert(json[0].clave_nivel);
                    
                    obj.getConfig(parseInt(json[0].clave_nivel,0),1);
                    evalMod = localStorage.eval0;

                    obj.getConfig(parseInt(json[0].clave_nivel,0),0);
                    
                    if (!localStorage.eval0){
                        localStorage.eval0 = 1;
                    }


                    evalDef = localStorage.eval0; 

                    $("#lstNoEval").empty();
                    
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

                   $("#lstMatsTr0").on("change",function(event){
                        event.stopPropagation();
                        addAlumnosToTareas();
                   });

                    $("#preloaderPrincipal").hide();
                }else{
                    $("#preloaderPrincipal").hide();
                }

            }, "json"
        );
    }

    function addAlumnosToTareas(){

        $("#preloaderPrincipal").show();
        $("#alumno0").empty();
        $("#selAll0").prop('checked', false);
        var idgm = $("#lstMatsTr0").val();
        var nc = "u="+localStorage.nc+"&idgrumat="+idgm+"&numval="+localStorage.eval0;
        $.post(obj.getValue(0)+"data/", { o:40, t:90, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                    var trs = "";

                    $.each(json, function(i, item) {
                        $("#alumno0").append('<option value="'+item.idboleta+'°'+item.iduseralu+'"> '+item.alumno+'</option>');
                    });
                    $("#preloaderPrincipal").hide();

                    $("#lbl0").html( json.length + " items");

            }, "json"
        );    
    }

    function getAlumnosToTareas(){

        $("#preloaderPrincipal").show();
        $("#alumno1").empty();
        $("#selAll1").prop('checked', false);
        var nc = "u="+localStorage.nc+"&idtarea="+idtarea;
        
        $.post(obj.getValue(0)+"data/", { o:40, t:20003, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                    var trs = "";

                    $.each(json, function(i, item) {
                        $("#alumno1").append('<option value="'+item.idtareadestinatario+'"> '+item.alumno+' - '+item.abreviatura+' ('+item.grupo+')'+'</option>');
                    });
                    $("#preloaderPrincipal").hide();

                    $("#lbl1").html( json.length + " items");

            }, "json"
        );    
    }


    $("#AddItem").on("click",function(event){
        event.stopPropagation();
        $("#preloaderPrincipal").show();
        
        // Opciones asignadas a un determinado alumno
        var idgrupo = $('.lstGruposTr0 option:selected').val();  
        var idgrumat = $('.lstMatsTr0 option:selected').val();  

        var y = $('select[name="alumno0"] option:selected').val(); 
        
        var bol0, as, a0,dest0;

            bol0='';
            dest0='';
            $("#alumno0 option:selected").each(function () {
                    a0 = $(this).val().split('°');
                    bol0 += bol0 == '' ?  a0[0]  : "|" + a0[0];
                    dest0 += dest0 == '' ?  a0[1]  : "|" + a0[1];
              });
        if (bol0 == ''){
            alert("Seleccione por lo menos un elemento del Panel de la izquuerda");
            $("#preloaderPrincipal").hide();
            return false;
        } 

        var nc = "user="+localStorage.nc+"&idgrupo="+idgrupo+"&idgrumat="+idgrumat+"&bols="+bol0+"&dests="+dest0+"&idtarea="+idtarea;

        $.post(obj.getValue(0)+"data/", { o:40, c:nc, t:3, p:2, s:nc, from:0, cantidad:0 },
            function(json){
                getAlumnosToTareas();
                // stream.emit("cliente", {mensaje: "PLATSOURCE-DESTINATARIOS_TAREAS-PROP-"+idtarea+'-'+dest0+'-'+localStorage.nc});                
                $("#preloaderPrincipal").hide();
        }, "json");
    
    });


    $("#DeleteItem").on("click",function(event){
        event.stopPropagation();
        $("#preloaderPrincipal").show();
        
        var a0,dest0;

        dest0='';
        $("#alumno1 option:selected").each(function () {
                a0 = $(this).val();
                dest0 += dest0 == '' ?  a0  : "|" + a0;
          });

        if (dest0 == ''){
            alert("Seleccione por lo menos un elemento del Panel de la derecha");
            $("#preloaderPrincipal").hide();
            return false;
        } 

        var nc = "user="+localStorage.nc+"&dests="+dest0+"&idtarea="+idtarea;

        $.post(obj.getValue(0)+"data/", { o:40, c:nc, t:4, p:2, s:nc, from:0, cantidad:0 },
            function(json){
                getAlumnosToTareas();
                // stream.emit("cliente", {mensaje: "PLATSOURCE-DESTINATARIOS_TAREAS-PROP-"+idtarea+'-'+dest0+'-'+localStorage.nc});                
                $("#preloaderPrincipal").hide();
        }, "json");
    
    });


    getEvalInTar();
    getAlumnosToTareas();


    $("#selAll0").on("click",function(event){
        
        var checked = $(this).is(":checked");
        if (checked) {
            $("#alumno0 option").each(function(){
                $(this).prop('selected', true);
            });
        } else {
            $("#alumno0 option").each(function(){
                $(this).prop('selected', false);
            });
        }
    });

    $("#selAll1").on("click",function(event){
        event.stopPropagation();
        var checked = $(this).is(":checked");
        if (checked) {
            $("#alumno1 option").each(function(){
                $(this).prop('selected', true);
            });
        } else {
            $("#alumno1 option").each(function(){
                $(this).prop('selected', false);
            });
        }
    });

    // close Form
    $(".closeFormUpload").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").empty();
            $("#contentProfile").show();
        });        
        resizeScreen();
        return false;
    });

    // var stream = io.connect(obj.getValue(4));


});

</script>