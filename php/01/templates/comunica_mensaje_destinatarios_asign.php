<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idcommensaje = $_POST['idcommensaje'];
$mensaje = $_POST['mensaje'];

?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <i class="icon-circle green"></i> <strong id="spIdtarea"><?php echo $idcommensaje ?></strong>: <b class="text-success"><?php echo $mensaje ?></b> 
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
                        <div class="panel-body" style="height: 33em !important; ">

                            <label for="lstMisGrupos0" class="lblH2cmb">Mis Grupos </label>
                            <select name="lstMisGrupos0" id="lstMisGrupos0" size="1" style="width:100% !important;" class="lstMisGrupos0"> 
                            </select>

                            <select class="alumno0 " name="alumno0" id="alumno0" size="10" style="width:100% !important; height: 85% !important;"  multiple="multiple"> 
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
                        <div class="panel-body" style="height: 33em !important; ">

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

    var idcommensaje = <?php echo $idcommensaje ?>;
    var mensaje = "<?php echo $mensaje ?>";




    function getEvalInTar(){
        $("#lstMisGrupos0").append('<option value="0" selected>Seleccione un Grupo</option>');
        var nc = "u="+localStorage.nc;
        $.post(obj.getValue(0)+"data/", { o:1, t:53, p:0,c:nc,from:0,cantidad:0, s:" order by idcomgrupo asc " },
            function(json){
                var vHMTL="";
                $.each(json, function(i, item) {
                    $("#lstMisGrupos0").append('<option value="'+item.data+'" > '+item.label+'</option>');
                });
               
                $("#preloaderPrincipal").hide();
            }, "json"
        ); 
    }

    if ($(".lstMisGrupos0").length) {
           $(".lstMisGrupos0").on("change", function(event) {
               event.preventDefault();
                var arr = event.currentTarget.value;
                IdComGrupo = arr;
                $("#preloaderPrincipal").show();
                $("#alumno0").empty();
                $("#selAll0").prop('checked', false);

                addAlumnosToTareas(IdComGrupo);

                return true;
           });
    }

    function addAlumnosToTareas(IdComGrupo){

        $("#preloaderPrincipal").show();
        $("#alumno0").empty();
        $("#selAll0").prop('checked', false);
        var idgm = $("#lstMatsTr0").val();
        var nc = "u="+localStorage.nc+"&idcomgrupo="+IdComGrupo;
        
        $.post(obj.getValue(0)+"data/", { o:1, t:54, p:0, c:nc, from:0, cantidad:0, s:"" },
            function(json){

                    var trs = "";
                    
                    $.each(json, function(i, item) {
                        $("#alumno0").append('<option value="'+item.data+'"> '+item.label+'</option>');
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
        var nc = "u="+localStorage.nc+"&idcommensaje="+idcommensaje;
        $.post(obj.getValue(0)+"data/", { o:42, t:31003, p:10, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                    var trs = "";

                    $.each(json, function(i, item) {
                        $("#alumno1").append('<option value="'+item.idcommensajedestinatario+'"> '+item.nombre_destinatario+'</option>');
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
        var idcomgrupo = $('.lstMisGrupos0 option:selected').val();  
        var idgrumat = $('.lstMatsTr0 option:selected').val();  

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

        var nc = "user="+localStorage.nc+"&idcomgrupo="+idcomgrupo+"&dests="+dest0+"&idcommensaje="+idcommensaje;

        $.post(obj.getValue(0)+"data/", { o:42, c:nc, t:3, p:2, s:nc, from:0, cantidad:0 },
            function(json){
                getAlumnosToTareas();
                // stream.emit("cliente", {mensaje: "PLATSOURCE-DESTINATARIOS_COM_MENSAJE-PROP-"+idcommensaje+'-'+dest0+'-'+localStorage.nc});                
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

        var nc = "user="+localStorage.nc+"&dests="+dest0+"&idcommensaje="+idcommensaje;

        $.post(obj.getValue(0)+"data/", { o:42, c:nc, t:4, p:2, s:nc, from:0, cantidad:0 },
            function(json){
                getAlumnosToTareas();
                // stream.emit("cliente", {mensaje: "PLATSOURCE-DESTINATARIOS_COM_MENSAJE-PROP-"+idcommensaje+'-'+dest0+'-'+localStorage.nc});                
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
            $("#contentLevel3").html("");
            $("#contentProfile").show();
        });        
        resizeScreen();
        return false;
    });

    // var stream = io.connect(obj.getValue(4));


});

</script>