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
        <div class="widget-toolbar no-border">

            <div class="widget-toolbar">
                <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " >
                        <i class="icon-angle-left icon-on-right"></i>
                        Regresar
                </button>
            </div>
            <div class="widget-toolbar">

                <a href="#tblFilesUp" class="ui-pg-div" id="btnComGpoMemberNew0">
                    <i class="ui-icon icon-plus-sign purple"></i>
                </a>

                <a href="#" class="ui-pg-div" data-action="reload" id="btnRefreshComGpoMem0" >
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
                                            <th aria-label="idcomuserasocgpo: to sort column ascending" style="width: 10px;" aria-controls="tableArchivosTarea" tabindex="0" role="columnheader" class="sorting" >ID</th>
                                            <th aria-label="usuarios: to sort column ascending" style="width: 50px;" aria-controls="tableArchivosTarea" tabindex="1" role="columnheader" class="sorting">USUARIO</th>
                                            <th aria-label="" style="width: 50px;" role="columnheader" class="sorting_disabled"></th>
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

    var idcomgrupo = <?php echo $idcomgrupo ?>;
    var grupo = "<?php echo $grupo ?>";

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
            "aoColumns": [ null, null, { "bSortable": false }],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "bRetrieve": true,
            "bDestroy": false
        });
    }

    function fillTable(){
                        
        var tB = "";

        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idcomgrupo="+idcomgrupo;
        var lei,resp;
        $.post(obj.getValue(0) + "data/", {o:41, t:30003, c:nc, p:10, from:0, cantidad:0,s:''},
            function(json){
                if (json.length){
                    $.each(json, function(i, item) {
                        lei = parseInt(item.isleida) == 1 ? '<i class="icon-ok green"></i>':'';
                        resp = parseInt(item.iteracciones) > 0 ? item.iteracciones:'';
                        tB +='          <tr>';
                        tB +=' ';
                        tB +='              <td class="center">'+padl(item.idcomuserasocgpo,4)+'</td>';
                        tB +='              <td >'+item.usuario+'</td>';
                        tB +='              <td class="center">';
                        tB +=' ';
                        tB +='                  <div class="action-buttons">';
                            tB +='                      <a class="red delComGpoDest0" href="#" id="delComGpoDest0-'+item.idcomuserasocgpo+'"  data-rel="tooltip" data-placement="top" title="Eliminar Usuario">';
                            tB +='                          <i class="icon-trash bigger-130"></i>';
                            tB +='                      </a>';
                        tB +='                  </div>';
                        tB +='              </td>';
                        tB +='          </tr>';
                    });
                    
                    //alert(tB);

                    $('#tableArchivosTarea > tbody').html(tB);

                    $("#preloaderPrincipal").hide();

                    $(".delComGpoDest0").on("click",function(event){
                        event.preventDefault();
                        $("#preloaderPrincipal").show();
                        var resp =  confirm("Desea eliminar este Archivo?");
                        if (resp){
                            var arr = event.currentTarget.id.split('-');
                                DelteMemberComGpo( arr[1] );                            
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


    $("#btnRefreshComGpoMem0").on("click",function(event){
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


    $("#btnComGpoMemberNew0").on("click",function(event){
        event.stopPropagation();
        addItemFileUpload(idcomgrupo,grupo);
    })


    function addItemFileUpload(IdComGrupo,Grupo){

        $("#contentLevel3").html("");
        $("#contentProfile").hide(function(){
            var nc = localStorage.nc; 
        $.post(obj.getValue(0) + "comunica-grupos-destinatarios-prop/", {
                    user: nc,
                    idcomgrupo: IdComGrupo,
                    grupo: Grupo
            },
            function(html) {
                    $("#contentLevel3").html(html).show('slow',function(){
                    });
            }, "html");
        });

    }

    function DelteMemberComGpo(IdComUserAsocGpo){

        $("#preloaderPrincipal").show();

        $.post(obj.getValue(0)+"data/", { o:41, c:IdComUserAsocGpo, t:3, p:2, s:'', from:0, cantidad:0 },
            function(json){
                //stream.emit("cliente", {mensaje: "PLATSOURCE-DELETE_DESTINATARIOS_TAREAS-PROP-"+IdTareaDestinatario});
                //alert(IdDestinatario);
                // stream.emit("cliente", {mensaje: "PLATSOURCE-DESTINATARIOS_COM_GPO-PROP-"+IdComUserAsocGpo+'-'+localStorage.nc});                
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
        if (ms[1]=='DESTINATARIOS_COM_GPO') {
            onClickFillTable();
        }
    }
*/


});

</script>