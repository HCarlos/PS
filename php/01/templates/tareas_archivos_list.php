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
                                            <th aria-label="idtareaarchivo: to sort column ascending" style="width: 10px;" aria-controls="tableArchivosTarea" tabindex="0" role="columnheader" class="sorting" >ID</th>
                                            <th aria-label="archivos: to sort column ascending" style="width: 50px;" aria-controls="tableArchivosTarea" tabindex="1" role="columnheader" class="sorting">ARCHIVO</th>
                                            <th aria-label="descripcion_archivo: to sort column ascending" style="width: 150px;" aria-controls="tableArchivosTarea" tabindex="2" role="columnheader" class="sorting">DESCRIPCION</th>
                                            <th aria-label="link: to sort column ascending" style="width: 10px;" aria-controls="tableArchivosTarea" tabindex="3" role="columnheader" class="sorting center">PREVIEW</th>
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

    var idtarea = <?php echo $idtarea ?>;
    var tarea = "<?php echo $tarea ?>";

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
            "aaSorting": [[ 0, "desc" ]],           
            "aoColumns": [ null, null, null, null, { "bSortable": false }],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "bRetrieve": true,
            "bDestroy": false
        });
    }

    function fillTable(){
                        
        var tB = "";

        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idtarea="+idtarea;
        $.post(obj.getValue(0) + "data/", {o:40, t:20002, c:nc, p:10, from:0, cantidad:0,s:''},
            function(json){
                if (json.length){
                    $.each(json, function(i, item) {

                        tB +='          <tr>';
                        tB +=' ';
                        tB +='              <td class="tbl10W">';
                        tB +='                  <a class="modTarPro0" href="#" id="idprof0-'+item.idtareaarchivo+'"  data-rel="tooltip" data-placement="top" title="Editar el Archivo">'+padl(item.idtareaarchivo,4)+'</a>';
                        tB +='              </td>';
                        tB +='              <td class="tbl50W">'+item.archivo+'</td>';
                        tB +='              <td class="tbl150W">'+item.descripcion_archivo+'</td>';
                        tB +='              <td class="tbl10W center"> <a href="'+obj.getValue(0)+item.directorio+item.archivo+'" target="_blank" data-rel="tooltip" data-placement="top" title="Ver Archivo"><i class="fa fa-file"></i></a></td>';
                        tB +='              <td class="tbl100W">';
                        tB +='                  <div class="action-buttons">';
                        tB +=' ';
                            tB +='                      <a class="red delTar0" href="#" id="delTar0-'+item.idtareaarchivo+'-'+item.archivo+'"  data-rel="tooltip" data-placement="top" title="Eliminar Archivo">';
                            tB +='                          <i class="icon-trash bigger-130"></i>';
                            tB +='                      </a>';
                        tB +='                  </div>';
                        tB +='              </td>';
                        tB +='          </tr>';
                    });
                    
                    //alert(tB);

                    $('#tableArchivosTarea > tbody').html(tB);

                    $("#preloaderPrincipal").hide();

                    $(".delTar0").on("click",function(event){
                        event.preventDefault();
                        $("#preloaderPrincipal").show();
                        var resp =  confirm("Desea eliminar este Archivo?");
                        if (resp){
                            var arr = event.currentTarget.id.split('-');
                                DelteFileExist(arr[1],arr[2]);                            
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
        event.preventDefault();
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

    function addItemFileUpload(IdTarea,Tarea){

        $("#contentLevel3").html("");
        $("#contentProfile").hide(function(){
            var nc = localStorage.nc; 
        $.post(obj.getValue(0) + "tareas-archivos-prop/", {
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

    function DelteFileExist(IdTareaArchivo,Archivo){



                $("#preloaderPrincipal").show();

                var queryString = "idtareaarchivo="+IdTareaArchivo+"&archivo="+Archivo;

                var data = new FormData();

                data.append('data', queryString);


                $.ajax({
                    url:obj.getValue(0)+"fu-ufdfe/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    type: 'POST',
                    success: function(json){
                        if (json.status=="OK"){
                            alert( json.message );
                            // stream.emit("cliente", {mensaje: "PLATSOURCE-DELETE_FILES_TAREAS-PROP-"+IdTareaArchivo});
                            onClickFillTable();
                            
                        }else{
                            $("#preloaderPrincipal").hide();
                            alert("Error: "+json.message);    
                        }
                    }
                });


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
        if (ms[1]=='UPLOAD_FILES_TAREAS') {
            onClickFillTable();
        }
    }
*/


});

</script>