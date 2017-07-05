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
        <div class="widget-toolbar no-border">

            <div class="widget-toolbar">
                <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " >
                        <i class="icon-angle-left icon-on-right"></i>
                        Regresar
                </button>
            </div>
            <div class="widget-toolbar">

                <a href="#tblFilesUp" class="ui-pg-div" id="btnUFComMenDest3">
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
            

                                <table aria-describedby="sample-table-2_info" id="tblDestComMen0" class="table table-striped table-bordered table-hover dataTable">
                                                    
                                    <thead>
                                        <tr role="row">
                                            <th aria-label="idcommensajedestinatario: to sort column ascending" style="width: 10px;" aria-controls="tblDestComMen0" tabindex="0" role="columnheader" class="sorting" >ID</th>
                                            <th aria-label="nombre_destinatario: to sort column ascending" style="width: 50px;" aria-controls="tblDestComMen0" tabindex="1" role="columnheader" class="sorting">DESTINATARIO</th>
                                            <th aria-label="lecturas: to sort column ascending" style="width: 10px;" aria-controls="tblDestComMen0" tabindex="3" role="columnheader" class="sorting center">LEIDA</th>
                                            <th aria-label="respuestas: to sort column ascending" style="width: 10px;" aria-controls="tblDestComMen0" tabindex="3" role="columnheader" class="sorting center">ITER</th>
                                            <th aria-label="archivos: to sort column ascending" style="width: 10px;" aria-controls="tblDestComMen0" tabindex="3" role="columnheader" class="sorting center">ARCH</th>
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


    var idcommensaje = <?php echo $idcommensaje ?>;
    var mensaje = "<?php echo $mensaje ?>";

    var oTable;

    function getTable(){

        oTable = $('#tblDestComMen0').dataTable({
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
            "aoColumns": [ null, null, null, null, null, { "bSortable": false }],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "bRetrieve": true,
            "bDestroy": false
        });
    }

    function fillTable(){
                        
        var tB = "";

        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idcommensaje="+idcommensaje;
        var lei, resp, arch;
        $.post(obj.getValue(0) + "data/", {o:42, t:31003, c:nc, p:10, from:0, cantidad:0,s:''},
            function(json){
                if (json.length){
                    $.each(json, function(i, item) {
                        lei = parseInt(item.isleida) == 1 ? '<i class="icon-ok green"></i>':'';
                        resp = parseInt(item.iteracciones) > 0 ? item.iteracciones:'';
                        arch = parseInt(item.archivos) > 0 ? item.archivos:'';
                        
                        tB +='          <tr>';
                        tB +=' ';
                        tB +='              <td class="tbl10W">';
                        tB +='                  <a class="modTarPro0" href="#" id="idprof0-'+item.idcommensajedestinatario+'"  data-rel="tooltip" data-placement="top" title="Editar Destinatario">'+padl(item.idcommensajedestinatario,4)+'</a>';
                        tB +='              </td>';
                        tB +='              <td class="tbl50W">'+item.nombre_destinatario+'</td>';
                        tB +='              <td class="tbl10W center"> '+lei+'</td>';
                        tB +='              <td class="tbl10W center"> '+resp+'</td>';
                        tB +='              <td class="tbl10W center"> '+arch+'</td>';
                        tB +='              <td class="tbl100W">';
                        tB +='                  <div class="action-buttons">';
                        tB +=' ';
                            tB +='                      <a class="blue modComMenDest2" href="#" id="modComMenDest2-'+item.idcommensaje+'-'+item.idcommensajedestinatario+'-'+item.iddestinatario+'-'+item.nombre_remitente+'"  data-rel="tooltip" data-placement="top" title="Abrir Mensaje">';
                            tB +='                          <i class="icon-folder-open-alt bigger-130"></i>';
                            tB +='                      </a>';
                        tB +=' ';
                            tB +='                      <a class="red delComMenDest2" href="#" id="delComMenDest2-'+item.idcommensajedestinatario+'-'+item.nombre_destinatario+'-'+item.iddestinatario+'"  data-rel="tooltip" data-placement="top" title="Eliminar Destinatario">';
                            tB +='                          <i class="icon-trash bigger-130"></i>';
                            tB +='                      </a>';
                        tB +='                  </div>';
                        tB +='              </td>';
                        tB +='          </tr>';
                    });
                    
                    //alert(tB);

                    $('#tblDestComMen0 > tbody').html(tB);

                    $("#preloaderPrincipal").hide();

                    $(".modComMenDest2").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        getModComMen2(arr[1],arr[2],arr[3],arr[4]);
                    });

                    $(".delComMenDest2").on("click",function(event){
                        event.preventDefault();
                        $("#preloaderPrincipal").show();
                        var resp =  confirm("Desea eliminar este Destinatario?");
                        if (resp){
                            var arr = event.currentTarget.id.split('-');
                                DelDestComMen2( arr[1] );                            
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
            $('#tblDestComMen0 > tbody').empty();
            init = true;
        }
        fillTable();
    }


    $("#btnUFComMenDest3").on("click",function(event){
        event.stopPropagation();
        addIFUComMen3(idcommensaje,mensaje);
    })

    function getModComMen2(IdComMensaje, IdComMensajeDestinatario, IdDestinatario, Remitente){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
            $("#preloaderPrincipal").show();
            obj.setIsTimeLine(false);
            var nc = localStorage.nc;

            $.post(obj.getValue(0) + "comunica-mensaje-destinatarios-prop/", {
                user: nc,
                idcommensaje: IdComMensaje,
                idcommensajedestinatario: IdComMensajeDestinatario,
                iddestinatario: IdDestinatario,
                origenacceso: 1,
                remitente: Remitente
                },
                function(html) {                    
                    $("#contentLevel3").html(html).show('slow',function(){
                        //$("#contentProfile"); 
                        $('#breadcrumb').html(getBar('Inicio, Mensaje '));
                    });
                }, "html");
        });
        return false;
    }


    function addIFUComMen3(IdComMensaje, Mensaje){

        $("#contentLevel3").html("");
        $("#contentProfile").hide(function(){
            var nc = localStorage.nc; 
        $.post(obj.getValue(0) + "comunica-mensaje-destinatarios-asign/", {
                    user: nc,
                    idcommensaje: IdComMensaje,
                    mensaje: Mensaje
            },
            function(html) {
                    $("#contentLevel3").html(html).show('slow',function(){
                    });
            }, "html");
        });

    }

    function DelDestComMen2(IdComMensajeDestinatario){

        $("#preloaderPrincipal").show();

        var nc = "u="+localStorage.nc+"&idcommensajedestinatario="+IdComMensajeDestinatario;

        $.post(obj.getValue(0)+"data/", { o:42, c:nc, t:5, p:2, s:nc, from:0, cantidad:0 },
            function(json){
                //stream.emit("cliente", {mensaje: "PLATSOURCE-DELETE_DESTINATARIOS_TAREAS-PROP-"+IdTareaDestinatario});
                //alert(IdDestinatario);
                stream.emit("cliente", {mensaje: "PLATSOURCE-DESTINATARIOS_COM_MENSAJE-PROP-"+idcommensaje+'-'+localStorage.nc});                
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

    var stream = io.connect(obj.getValue(4));
    stream.on("servidor", jsNewSolMatEnc0);
    function jsNewSolMatEnc0(datosServer) {
        var ms = datosServer.mensaje.split("-");
        if (ms[1]=='DESTINATARIOS_COM_MENSAJE') {
            onClickFillTable();
        }
    }



});

</script>