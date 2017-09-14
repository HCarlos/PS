<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idtarea = $_POST['idtarea'];
$tarea = $_POST['tarea'];

if ( !isset($_POST['tfuete']) ){
    $tfuete = 1;
}else{
    $tfuete = intval($_POST['tfuete']);
}


?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <i class="icon-circle green"></i> <strong id="spIdtarea"><?php echo $idtarea ?></strong>: <b class="text-success"><?php echo $tarea ?></b> 
        <div class="widget-toolbar no-border">

            <div class="widget-toolbar">
                <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " >
                        <i class="icon-angle-left icon-on-right"></i>
                        Regresar
                </button>
            </div>
            <div class="widget-toolbar">

                <a href="#tblFilesUp" class="ui-pg-div" id="btnUploadFileNew">
                    <i class="ui-icon icon-plus-sign purple"></i>
                </a>

                <a href="#" class="ui-pg-div" data-action="reload" id="btnRefreshFilesUpload0" >
                    <i class="ui-icon icon-refresh green"></i>
                </a>

            </div>

        </div>

    </div>


    <div class="widget-body">
        <div class="widget-main">
            

                                <table aria-describedby="sample-table-2_info" id="tableArchivosTarea" class="table table-striped table-bordered table-hover dataTable">
                                                    
                                    <thead>
                                        <tr role="row">
                                            <th aria-label="idtareadestinatario: to sort column ascending" style="width: 10px;" aria-controls="tableArchivosTarea" tabindex="0" role="columnheader" class="sorting" >ID</th>
                                            <th aria-label="alumno: to sort column ascending" style="width: 50px;" aria-controls="tableArchivosTarea" tabindex="1" role="columnheader" class="sorting">ALUMNO</th>
                                            <th aria-label="materia_grupo: to sort column ascending" style="width: 150px;" aria-controls="tableArchivosTarea" tabindex="2" role="columnheader" class="sorting">MATERIA / GRUPO</th>
                                            <th aria-label="lecturas: to sort column ascending" style="width: 10px;" aria-controls="tableArchivosTarea" tabindex="3" role="columnheader" class="sorting center">LEIDA</th>
                                            <th aria-label="respuestas: to sort column ascending" style="width: 10px;" aria-controls="tableArchivosTarea" tabindex="3" role="columnheader" class="sorting center">ITER</th>
                                            <th aria-label="archivos: to sort column ascending" style="width: 10px;" aria-controls="tableArchivosTarea" tabindex="3" role="columnheader" class="sorting center">ARCH</th>
                                            <th aria-label="" style="width: 100px;" role="columnheader" class="sorting_disabled"></th>
                                        </tr>
                                    </thead>
                                                    
                                    <tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
                                </table>



        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {


	$("#preloaderPrincipal").hide();

    var idtarea = <?php echo $idtarea; ?>;
    var tarea   = "<?php echo $tarea; ?>";
    var tfuete  = <?php echo $tfuete; ?>;

    var oTable;

    function getTable(){

        oTable = $('#tableArchivosTarea').dataTable({
            "oLanguage": {
                            "sLengthMenu": "_MENU_ registros por página",
                            "oPaginate": {
                                            "sPrevious": "Prev",
                                            "sNext": "Next"
                                         },
                            "sSearch": "Buscar",
                            "sProcessing":"Procesando...",
                            "sLoadingRecords":"Cargando...",
                            "sZeroRecords": "No hay registros",
                            "sInfo": "_START_ - _END_ de _TOTAL_ registros",
                            "sInfoEmpty": "No existen datos",
                            "sInfoFiltered": "(De _MAX_ registros)"                                        
                        },  
            "aaSorting": [[ 1, "asc" ],[ 2, "asc" ]],           
            "aoColumns": [ null, null, null, null, null, null, { "bSortable": false }],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "bRetrieve": true,
            "bDestroy": false
        });
    }

    function fillTable(){
                        
        var tB = "";

        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idtarea="+idtarea;
        var lei,resp, arch;
        $.post(obj.getValue(0) + "data/", {o:40, t:20003, c:nc, p:10, from:0, cantidad:0,s:''},
            function(json){
                if (json.length){
                    $.each(json, function(i, item) {
                        lei = parseInt(item.isleida) == 1 ? '<i class="icon-ok green"></i>':'';
                        resp = parseInt(item.iteracciones) > 0 ? item.iteracciones:'';
                        arch = parseInt(item.archivos) > 0 ? item.archivos:'';
                        tB +='          <tr>';
                        tB +=' ';
                        tB +='              <td class="tbl10W">';
                        tB +='                  <a class="modTarPro0" href="#" id="idprof0-'+item.idtareadestinatario+'"  data-rel="tooltip" data-placement="top" title="Editar Alumno">'+padl(item.idtareadestinatario,4)+'</a>';
                        tB +='              </td>';
                        tB +='              <td class="tbl50W">'+item.alumno+'</td>';
                        tB +='              <td class="tbl150W">'+item.materia+' ('+item.grupo+')'+'</td>';
                        tB +='              <td class="tbl10W center"> '+lei+'</td>';
                        tB +='              <td class="tbl10W center"> '+resp+'</td>';
                        tB +='              <td class="tbl10W center"> '+arch+'</td>';
                        tB +='              <td class="tbl100W">';
                        tB +='                  <div class="action-buttons">';
                        tB +=' ';
                        tB +='                      <a class="blue modTarPro1" href="#" id="modTarPro1-'+item.idtarea+'-'+item.idtareadestinatario+'-'+item.iddestinatario+'-'+item.profesor_tarea+'"  data-rel="tooltip" data-placement="top" title="Abrir Tarea">';
                        tB +='                          <i class="icon-folder-open-alt bigger-130"></i>';
                        tB +='                      </a>';
                        if ( tfuete == 1 ){
                            tB +=' ';
                            tB +='                      <a class="red delTar0" href="#" id="delTar0-'+item.idtareadestinatario+'-'+item.alumno+'-'+item.iddestinatario+'"  data-rel="tooltip" data-placement="top" title="Eliminar Alumno">';
                            tB +='                          <i class="icon-trash bigger-130"></i>';
                            tB +='                      </a>';
                        }
                        tB +='                  </div>';
                        tB +='              </td>';
                        tB +='          </tr>';
                    });
                    
                    //alert(tB);

                    $('#tableArchivosTarea > tbody').html(tB);

                    $("#preloaderPrincipal").hide();

                    $(".modTarPro1").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        getPropTarAlu1FromProf(arr[1],arr[2],arr[3],arr[4]);
                    });

                    $(".delTar0").on("click",function(event){
                        event.preventDefault();
                        $("#preloaderPrincipal").show();
                        var resp =  confirm("Desea eliminar este Archivo?");
                        if (resp){
                            var arr = event.currentTarget.id.split('-');
                                DelteFileExistFromProf( arr[1], arr[2], arr[3] );                            
                        }
                    });

                    $('[data-rel=tooltip]').tooltip();

                    if (init==true){
                        getTable();
                        init = false;
                    }else{
                        oTable.fnClearTable();
                        oTable.fnDraw();
                    }
                }else{
                    $("#preloaderPrincipal").hide();

                    if (init==true){
                        getTable();
                        init = false;
                    }else{
                        oTable.fnClearTable();
                        oTable.fnDraw();
                    }

                    return false;
                }       
            },
        'json'
        );


                            
    }
    
    var init = true;            
    fillTable();


    $("#btnRefreshFilesUpload0").on("click",function(event){
        event.stopPropagation();
        onClickFillTable();
    })

    function onClickFillTable(){
        if(oTable != null){
            oTable.fnDestroy();
            $('#tableArchivosTarea > tbody').empty();
            init = true;
        }
        fillTable();
    }


    $("#btnUploadFileNew").on("click",function(event){
        event.stopPropagation();
        addItemFileUpload(idtarea,tarea);
    })

    function getPropTarAlu1FromProf(IdTarea, IdTareaDestinatario, IdDestinatario, Profesor){
        $("#contentLevel3").html("");
        $("#contentProfile").hide(function(){
            $("#preloaderPrincipal").show();
            obj.setIsTimeLine(false);
            var nc = localStorage.nc;

            $.post(obj.getValue(0) + "tareas-alu-prop/", {
                user: nc,
                idtarea: IdTarea,
                idtareadestinatario: IdTareaDestinatario,
                iddestinatario: IdDestinatario,
                origenacceso: 1,
                profesor: Profesor
                },
                function(html) {                    
                    $("#contentLevel3").html(html).show('slow',function(){
                        //$("#contentProfile"); 
                        $('#breadcrumb').html(getBar('Inicio, Tarea '));
                    });
                }, "html");
        });
        return false;
    }


    function addItemFileUpload(IdTarea,Tarea){

        $("#contentLevel3").html("");
        $("#contentProfile").hide(function(){
            var nc = localStorage.nc; 
        $.post(obj.getValue(0) + "tareas-destinatarios-prop/", {
                    user: nc,
                    idtarea: IdTarea,
                    tarea: Tarea
            },
            function(html) {
                    $("#contentLevel3").html(html).show('slow',function(){
                    });
            }, "html");
        });

    }

    function DelteFileExistFromProf(IdTareaDestinatario, Alumno, IdDestinatario){

        $("#preloaderPrincipal").show();

        var nc = "user="+localStorage.nc+"&idtareadestinatario="+IdTareaDestinatario;

        $.post(obj.getValue(0)+"data/", { o:40, c:nc, t:5, p:2, s:nc, from:0, cantidad:0 },
            function(json){
                //stream.emit("cliente", {mensaje: "PLATSOURCE-DELETE_DESTINATARIOS_TAREAS-PROP-"+IdTareaDestinatario});
                //alert(IdDestinatario);
                
                // stream.emit("cliente", {mensaje: "PLATSOURCE-DESTINATARIOS_TAREAS-PROP-"+idtarea+'-'+IdDestinatario+'-'+localStorage.nc});                
                onClickFillTable();
                $("#preloaderPrincipal").hide();
        }, "json");

    }

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

/*
    var stream = io.connect(obj.getValue(4));
    stream.on("servidor", jsNewSolMatEnc0);
    function jsNewSolMatEnc0(datosServer) {
        var ms = datosServer.mensaje.split("-");
        if (ms[1]=='DESTINATARIOS_TAREAS') {
            onClickFillTable();
        }
    }
*/


});

</script>