<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idcomgrupo = $_POST['idcomgrupo'];
$grupo = $_POST['grupo'];

?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <i class="icon-circle green"></i> <strong id="spIdtarea"><?php echo $idcomgrupo ?></strong>: <b class="text-success"><?php echo $grupo ?></b> 
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

                            <label for="nivel0" class="lblH2cmb">Nivel </label>
                            <select name="nivel0" id="nivel0" size="1" style="width:100% !important;" > 
                            </select>

                            <label for="grupo0" class="lblH2cmb">Grupo Origen </label>
                            <select name="grupo0" id="grupo0" size="1" style="width:100% !important;" > 
                            </select>

                            <label for="nivelusuario0" class="lblH2cmb">Tipo Usuario </label>
                            <select name="nivelusuario0" id="nivelusuario0" size="1" style="width:100% !important;" > 
                            </select>

                            <select class="alumno0 " name="alumno0" id="alumno0" size="10" style="width:100% !important; height: 55% !important;"  multiple="multiple"> 
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
                        <div class="panel-heading">Usuarios Asignados</div>
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

    var idcomgrupo = <?php echo $idcomgrupo ?>;
    var grupo = "<?php echo $grupo ?>";


    function getNiveles(){
        var nc = "u="+localStorage.nc;
        $("#nivel0").empty();
        $.post(obj.getValue(0)+"data/", { o:1, t:45, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#nivel0").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                getGpoNiv();
            }, "json"
        );  
    }

    $("#nivel0").on("change",function(event){
        event.stopPropagation();
        $("#alumno0").empty();
        addAlumnosToTareas();
        getGpoNiv();
    });

    function getGpoNiv(){
        var cveniv = $("#nivel0 option:selected").val();
        var nc = "u="+localStorage.nc+"&clave_nivel="+cveniv;
        $("#grupo0").empty();
        $.post(obj.getValue(0)+"data/", {o:1, t:46, p:0,c:nc,from:0,cantidad:0, s:'' },
            function(json){
               $.each(json, function(i, item) {
                   $("#grupo0").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                getTipoUsuario();
                $("#preloaderPrincipal").hide();

            }, "json"
        );  
    }

    $("#grupo0").on("change",function(event){
        event.stopPropagation();
        $("#alumno0").empty();
        addAlumnosToTareas();
        //getTipoUsuario();
    });

    function getTipoUsuario(){
        var cveniv = $("#nivel0 option:selected").val();
        var nc = "u="+localStorage.nc;
        $("#nivelusuario0").empty();
        $("#nivelusuario0").html('<option value="0-0" selected>Seleccione un Tipo de Usuario</option>');
        $.post(obj.getValue(0)+"data/", {o:1, t:47, p:0,c:nc,from:0,cantidad:0, s:'' },
            function(json){
               $.each(json, function(i, item) {
                   $("#nivelusuario0").append('<option value="'+item.data+'-'+item.clave+'"> '+item.label+'</option>');
                });
                $("#preloaderPrincipal").hide();

            }, "json"
        );  
    }

    $("#nivelusuario0").on("change",function(event){
        event.stopPropagation();
        $("#alumno0").empty();
        addAlumnosToTareas();
    });


    function addAlumnosToTareas(){
        $("#preloaderPrincipal").show();
        $("#alumno0").empty();
        $("#selAll0").prop('checked', false);
        var idgm = $("#lstMatsTr0").val();
        var nc = "";

        var tp=0;
        var xl = $("#nivelusuario0").val().split('-');

        if ( xl[0] == '0' ){
            //alert("Seleccione un Tipo de Usuario");
            return false;
        }
        var idTU = parseInt(xl[1],0);

        // alert(idTU);

        switch( idTU ){
            case 3:
                tp = 48; // Directores
                nc = "u="+localStorage.nc;
                break;
            case 5:
                tp = 50; // Alumnos
                nc = "u="+localStorage.nc+"&idgrupo="+$("#grupo0").val();
                break;
            case 6:
                tp = 49; // Profesores
                nc = "u="+localStorage.nc+"&idgrupo="+$("#grupo0").val();
                break;
            case 7:
                tp = 51; // Tutores
                nc = "u="+localStorage.nc+"&idgrupo="+$("#grupo0").val();
                break;
            case 28:
                tp = 76; // Familiares
                nc = "u="+localStorage.nc+"&idgrupo="+$("#grupo0").val()+"&idusernivelacceso="+xl[0];
                break;
            case 2:
            case 8:
            case 9:
            case 10:
            case 11:
            case 12:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:
            case 25:
            case 26:
            case 27:
            case 29:
            case 30:
                tp = 76;
                nc = "u="+localStorage.nc+"&idgrupo="+$("#grupo0").val()+"&idusernivelacceso="+xl[0];
                break;
        }

        $.post(obj.getValue(0)+"data/", { o:1, t:tp, p:0, c:nc, from:0, cantidad:0, s:"" },
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
        var nc = "u="+localStorage.nc+"&idcomgrupo="+idcomgrupo;
        $.post(obj.getValue(0)+"data/", { o:2, t:8, p:0, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                    var trs = "";

                    $.each(json, function(i, item) {
                        $("#alumno1").append('<option value="'+item.data+'"> '+item.label+'</option>');
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
        var bol0, as, a0, dest0;

        bol0='';
        $("#alumno0 option:selected").each(function () {
            a0 = $(this).val();
            bol0 += bol0 == '' ?  a0  : "|" + a0;
        });

        if (bol0 == ''){
            alert("Seleccione por lo menos un elemento del Panel de la Izquierda");
            $("#preloaderPrincipal").hide();
            return false;
        } 

        var nc = "u="+localStorage.nc+"&bols="+bol0+"&idcomgrupo="+idcomgrupo;

        $.post(obj.getValue(0)+"data/", { o:41, c:nc, t:10, p:1, s:nc, from:0, cantidad:0 },
            function(json){
                getAlumnosToTareas();
                // stream.emit("cliente", {mensaje: "PLATSOURCE-MIS_GRUPOS-PROP-"+idcomgrupo+'-'+localStorage.nc});                
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

        var nc = "u="+localStorage.nc+"&dests="+dest0+"&idcomgrupo="+idcomgrupo;

        $.post(obj.getValue(0)+"data/", { o:41, c:nc, t:20, p:1, s:nc, from:0, cantidad:0 },
            function(json){
                getAlumnosToTareas();
                // stream.emit("cliente", {mensaje: "PLATSOURCE-MIS_GRUPOS-PROP-"+idcomgrupo+'-'+localStorage.nc});                
                $("#preloaderPrincipal").hide();
        }, "json");
    
    });


    getNiveles();
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