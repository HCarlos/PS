<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idpsa = $_POST['idpsa'];
$referencia = $_POST['referencia'];
$param          = $_POST['param'];
$idgrupo        = $_POST['idgrupo'];
$clave_nivel    = $_POST['clave_nivel'];
$idciclo        = $_POST['idciclo'];

?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <i class="icon-circle green"></i> <strong id="spIdtarea"><?php echo $idpsa ?></strong>: <b class="text-success"><?php echo $referencia ?></b> 
        <div class="widget-toolbar">
            <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeAddItemsPSA005 " >
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

    var IdPSA = <?php echo $idpsa ?>;
    var Referencia = "<?php echo $referencia ?>";
    var Param = localStorage.Param1;
    var IdGrupo = <?= $idgrupo; ?>;
    var Clave_Nivel = <?= $clave_nivel; ?>;
    var IdCiclo = <?= $idciclo; ?>;


    function getEvalInTar(){
        // var nc = "u="+localStorage.nc;
        var nc = "u="+localStorage.nc+"&clavenivelacceso="+localStorage.ClaveNivelAcceso;
        
        $("#lstGruposTr0").html('<option value="0" >Seleccione un Grupo</option>');
        // $.post(obj.getValue(0)+"data/", { o:1, t:16, p:0,c:nc,from:0,cantidad:0, s:" order by idgrupo asc " },
        

        $.post(obj.getValue(0) + "data/", {o:51, t:13, c:nc, p:55, from:0, cantidad:0,s:Param},
            function(json){
                var vHMTL="";
                $.each(json, function(i, item) {
                    $("#lstGruposTr0").append('<option value="'+item.idgrupo+'" > '+item.grupo+'</option>');
                });
               
                if ($(".lstGruposTr0").length) {
                       $(".lstGruposTr0").on("change", function(event) {
                           event.preventDefault();
                            var arr = event.currentTarget.value;
                            IdGrupo = arr;
                            $("#preloaderPrincipal").show();
                            $("#alumno0").empty();
                            $("#selAll0").prop('checked', false);

                            addAlumnosToTareas();

                            return true;
                       });
                }
            $("#preloaderPrincipal").hide();
            }, "json"
        ); 
    }

    function addAlumnosToTareas(){

        $("#preloaderPrincipal").show();
        $("#alumno0").empty();
        $("#selAll0").prop('checked', false);
        var idgrupo = $("#lstGruposTr0").val();
        var nc = "u="+localStorage.nc+"&idgrupo="+idgrupo+"&idciclo="+IdCiclo;
        $.post(obj.getValue(0)+"data/", { o:51, t:14, p:55, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                    var trs = "";

                    $.each(json, function(i, item) {
                        $("#alumno0").append('<option value="'+item.idalumno+'"> '+item.alumno+'</option>');
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
        var nc = "u="+localStorage.nc+"&idpsa="+IdPSA;
        
        $.post(obj.getValue(0)+"data/", { o:51, t:12, p:54, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                    var trs = "";

                    $.each(json, function(i, item) {
                        $("#alumno1").append('<option value="'+item.idpsaalumno+'"> '+item.nombre_alumno+'</option>');
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

        var y = $('select[name="alumno0"] option:selected').val(); 
        
        var as, a0,dest0;

        dest0='';
        $("#alumno0 option:selected").each(function () {
                a0 = $(this).val();
                dest0 += dest0 == '' ?  a0  : "|" + a0;
          });

        if (dest0 == ''){
            alert("Seleccione por lo menos un elemento del Panel de la izquuerda");
            $("#preloaderPrincipal").hide();
            return false;
        } 

        var nc = "u="+localStorage.nc+"&idgrupo="+idgrupo+"&dests="+dest0+"&idpsa="+IdPSA+"&idciclo="+IdCiclo+"&clave_nivel="+Clave_Nivel;

        // alert(nc);

        $.post(obj.getValue(0)+"data/", { o:51, c:nc, t:10, p:53, s:nc, from:0, cantidad:0 },
            function(json){
                getAlumnosToTareas();
                stream.emit("cliente", {mensaje: "PLATSOURCE-LIST_ALUMNOS_PSA-PROP-"+IdPSA+'-'+dest0+'-'+localStorage.nc});                
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

        var nc = "user="+localStorage.nc+"&dests="+dest0+"&idpsa="+IdPSA;

        $.post(obj.getValue(0)+"data/", { o:51, c:nc, t:20, p:53, s:nc, from:0, cantidad:0 },
            function(json){
                getAlumnosToTareas();
                stream.emit("cliente", {mensaje: "PLATSOURCE-LIST_ALUMNOS_PSA-PROP-"+IdPSA+'-'+dest0+'-'+localStorage.nc});                
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
    $(".closeAddItemsPSA005").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel4").hide(function(){
            $("#contentLevel4").empty();
            $("#contentLevel3").show();
        });        
        resizeScreen();
        return false;
    });

    var stream = io.connect(obj.getValue(4));


});

</script>