<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];

?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">

        <i class="icon-circle green"></i> <strong >LISTADO DE TAREAS POR </strong>: <b class="text-success">PROFESOR(@)</b> 

            <div class="widget-toolbar">
                <i class="icon-user green"></i>
                <strong class="green">Profesor(@)</strong>: 
                <select class="altoMoz add-on marginLeft2em"  name="lstProfDir" id="lstProfDir" size="1"></select>
            </div>


    </div>


    <div class="widget-body">
        <div class="widget-main">
            

            <table aria-describedby="tblTarDir01_info" id="tblTarDir01" class="table table-striped table-bordered table-hover dataTable">
                                
                <thead>
                    <tr role="row">
                        <th aria-label="idtarea: to sort column ascending" style="width: 10px;" aria-controls="tblTarDir01" tabindex="0" role="columnheader" class="sorting" >ID</th>
                        <th aria-label="titulo: to sort column ascending" style="width: 150px;" aria-controls="tblTarDir01" tabindex="2" role="columnheader" class="sorting">TAREA</th>
                        <th aria-label="fecha_inicio: to sort column ascending" style="width: 10px;" aria-controls="tblTarDir01" tabindex="3" role="columnheader" class="sorting center">INICIA</th>
                        <th aria-label="fecha_fin: to sort column ascending" style="width: 10px;" aria-controls="tblTarDir01" tabindex="3" role="columnheader" class="sorting center">VENCE</th>
                        <th aria-label="lecturas: to sort column ascending" style="width: 5px;" aria-controls="tblTarDir01" tabindex="3" role="columnheader" class="sorting center">LEC</th>
                        <th aria-label="respuestas: to sort column ascending" style="width: 5px;" aria-controls="tblTarDir01" tabindex="4" role="columnheader" class="sorting center">RESP</th>
                        <th aria-label="archivos: to sort column ascending" style="width: 5px;" aria-controls="tblTarDir01" tabindex="3" role="columnheader" class="sorting center">ARCH</th>
                        <th aria-label="destinatarios: to sort column ascending" style="width: 5px;" aria-controls="tblTarDir01" tabindex="4" role="columnheader" class="sorting center">DEST</th>
                        <th aria-label="" style="width: 120px;" role="columnheader" class="sorting_disabled"></th>
                    </tr>
                </thead>
                <tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
            </table>

            <table aria-describedby="tblTarDir01_info" id="tblTarDir02" class="table table-striped table-bordered table-hover dataTable">
                <thead>
                    <tr role="row">
                        <th aria-label="idtarea: to sort column ascending" style="width: 10px;" aria-controls="tblTarDir01" tabindex="0" role="columnheader" class="sorting" >ID</th>
                        <th aria-label="profesor: to sort column ascending" style="width: 150px;" aria-controls="tblTarDir01" tabindex="2" role="columnheader" class="sorting">PROFESOR</th>
                        <th aria-label="titulo: to sort column ascending" style="width: 150px;" aria-controls="tblTarDir01" tabindex="2" role="columnheader" class="sorting">TITULO</th>
                        <th aria-label="materia: to sort column ascending" style="width: 150px;" aria-controls="tblTarDir01" tabindex="2" role="columnheader" class="sorting">MATERIA</th>
                        <th aria-label="grupo: to sort column ascending" style="width: 150px;" aria-controls="tblTarDir01" tabindex="2" role="columnheader" class="sorting">GRUPO</th>
                        <th aria-label="" style="width: 120px;" role="columnheader" class="sorting_disabled"></th>
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
    $("#tblTarDir02").hide();

    var oTable;
    var arrProfesores = [];

    function getTable(){

        oTable = $('#tblTarDir01').dataTable({
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
            "aoColumns": [ null, null, null, null, null, null, null, null, { "bSortable": false }],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "bRetrieve": true,
            "bDestroy": false
        });

    }

    function getTable2(){

        oTable = $('#tblTarDir02').dataTable({
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


    if (localStorage.TRPP){
        TRPP = parseInt(localStorage.TRPP,0);   
    }
    oPag = {init:true, totalRegistros:0, totalPaginas:0, currentPage:0, registrosPorPagina:TRPP, Limit:'', Query:'' };

    var IsRegistry = false;
    var IdGrupo;    


    function fillTable(){
                        
        var tB = "";

        $("#preloaderPrincipal").show();
        //var sts = $("#isnuevas").is(':checked') ? 0 : 1;
        var nc = "u="+localStorage.nc+"&idprofesor="+$("#lstProfDir").val()+"&profesores="+arrProfesores.toString();
        // alert(nc);
        $.post(obj.getValue(0) + "data/", {o:40, t:20011, c:nc, p:10, from:0, cantidad:0,s:''},
            function(json){
                if (json.length){
                    var lec,arc,res,des;
                    $.each(json, function(i, item) {
                        lec = item.lecturas>0?item.lecturas:'';
                        res = item.respuestas>0?item.respuestas:'';
                        arc = item.archivos>0?item.archivos:'';
                        des = item.destinatarios>0?item.destinatarios:'';

                        tB +='          <tr class="odd">';
                        tB +=' ';
                        tB +='              <td class=" ">';
                        tB +='                  <a class="modTarPro0" href="#" id="idprof0-'+item.idtarea+'"  data-rel="tooltip" data-placement="top" title="Editar la Solicitud">'+padl(item.idtarea,4)+'</a>';
                        tB +='              </td>';
                        tB +='              <td>'+item.titulo_tarea+'</td>';
                        tB +='              <td>'+item.fecha_inicio+'</td>';
                        tB +='              <td>'+item.fecha_fin+'</td>';
                        tB +='              <td class="center">'+lec +'</td>';
                        tB +='              <td class="center">'+res+'</td>';
                        tB +='              <td class="center">'+arc+'</td>';
                        tB +='              <td class="center">'+des+'</td>';
                        tB +='              <td>';
                        tB +='                  <div class="action-buttons">';
                        tB +=' ';
                        tB +='                      <a class="green modTarPro0" href="#" id="idtarea-'+item.idtarea+'" data-rel="tooltip" data-placement="top" title="Editar Tarea">';
                        tB +='                          <i class="icon-pencil bigger-130"></i>';
                        tB +='                      </a>';
                        tB +=' ';
                        tB +='                      <a class="cafe modTarFileAddProProf1" href="#" id="modTarFileAddProProf1-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Ver Archivos">';
                        tB +='                          <i class="fa fa-paperclip bigger-130"></i>';
                        tB +='                      </a>';
                        tB +=' ';
                        tB +='                      <a class="blue marginLeft1em modTarPro2" href="#" id="modTarPro2-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Ver Destinatarios" >';
                        tB +='                          <i class="icon-group bigger-130"></i>'
                        tB +='                      </a>';
                        tB +='                  </div>';
                        tB +=' ';
                        tB +='              </td>';
                        tB +='          </tr>';
                    });
                    
                    //alert(tB);

                    $('#tblTarDir01 > tbody').html(tB);

                    $("#preloaderPrincipal").hide();

                    $(".modTarPro0").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        getPropTar0(arr[1]);
                    });

                    $(".modTarFileAddProProf1").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        modTarFileAddProProf1(arr[1],arr[2]);
                    });

                    $(".modTarPro2").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        getDestinatariosTar1(arr[1],arr[2]);
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

    function fillTable2(){
                        
        var tB = "";

        $("#preloaderPrincipal").show();
        //var sts = $("#isnuevas").is(':checked') ? 0 : 1;
        var nc = "u="+localStorage.nc+"&idprofesor="+$("#lstProfDir").val()+"&profesores="+arrProfesores.toString();
        // alert(nc);
        $.post(obj.getValue(0) + "data/", {o:40, t:20011, c:nc, p:10, from:0, cantidad:0,s:''},
            function(json){
                if (json.length){
                    var lec,arc,res,des;
                    $.each(json, function(i, item) {
                        tB +='          <tr class="odd">';
                        tB +=' ';
                        tB +='              <td class=" ">';
                        tB +='                  <a class="modTarPro0" href="#" id="idprof0-'+item.idtarea+'"  data-rel="tooltip" data-placement="top" title="Editar la Solicitud">'+padl(item.idtarea,4)+'</a>';
                        tB +='              </td>';
                        tB +='              <td>'+item.profesor+'</td>';
                        tB +='              <td>'+item.titulo_tarea+'</td>';
                        tB +='              <td>'+item.grupo+'</td>';
                        tB +='              <td>'+item.materia+'</td>';
                        tB +='              <td>';
                        tB +='                  <div class="action-buttons">';
                        tB +=' ';
                        tB +='                      <a class="green modTarPro0" href="#" id="idtarea-'+item.idtarea+'" data-rel="tooltip" data-placement="top" title="Editar Tarea">';
                        tB +='                          <i class="icon-pencil bigger-130"></i>';
                        tB +='                      </a>';
                        tB +=' ';
                        tB +='                      <a class="cafe modTarFileAddProProf1" href="#" id="modTarFileAddProProf1-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Ver Archivos">';
                        tB +='                          <i class="fa fa-paperclip bigger-130"></i>';
                        tB +='                      </a>';
                        tB +=' ';
                        tB +='                      <a class="blue marginLeft1em modTarPro2" href="#" id="modTarPro2-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Ver Destinatarios" >';
                        tB +='                          <i class="icon-group bigger-130"></i>'
                        tB +='                      </a>';
                        tB +='                  </div>';
                        tB +=' ';
                        tB +='              </td>';
                        tB +='          </tr>';
                    });
                    
                    $('#tblTarDir02 > tbody').html(tB);

                    $("#preloaderPrincipal").hide();

                    $(".modTarPro0").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        getPropTar0(arr[1]);
                    });

                    $(".modTarFileAddProProf1").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        modTarFileAddProProf1(arr[1],arr[2]);
                    });

                    $(".modTarPro2").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        getDestinatariosTar1(arr[1],arr[2]);
                    });

                    $('[data-rel=tooltip]').tooltip();

                    if (init==true){
                        getTable2();
                        init = false;
                    }else{
                        oTable.fnClearTable();
                        oTable.fnDraw();
                    }

                }else{
                    
                    $("#preloaderPrincipal").hide();

                    if (init==true){
                        getTable2();
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

    function onClickFillTable(){
        if(oTable != null){
            oTable.fnDestroy();
            $('#tblTarDir01 > tbody').empty();
            init = true;
        }
        fillTable();
    }

    function onClickFillTable2(){
        if(oTable != null){
            oTable.fnDestroy();
            $('#tblTarDir02 > tbody').empty();
            init = true;
        }
        fillTable2();
    }



    function getProfDir(){
        var nc = "u="+localStorage.nc;
        $("#lstProfDir").empty();
        $("#lstProfDir").append('<option value="0">Seleccione un Profesor</option>');
        $.post(obj.getValue(0)+"data/", {o:59, t:44, p:54,c:nc,from:0,cantidad:0, s:'' },
            function(json){
               $.each(json, function(i, item) {
                    $("#lstProfDir").append('<option value="'+item.data+'"> '+item.label+'</option>');
                    arrProfesores[i]=item.data;
                });
                $("#lstProfDir").append('<option value="000"> Todos </option>');
            }, "json"
        );  
    }

    $("#lstProfDir").on("change",function(event){
        event.preventDefault();
        var valor = parseInt( $(this).val(), 0 );
        if ( valor > 0 ){
            $("#tblTarDir02").hide();
            $("#tblTarDir01").show();
            onClickFillTable();
        }else{
            $("#tblTarDir01").hide();
            $("#tblTarDir02").show();
            onClickFillTable2();
        }
    });


    function getPropTar0(IdTarea){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
            $("#preloaderPrincipal").show();
            obj.setIsTimeLine(false);
            var nc = $("#lstProfDir").val();
            $.post(obj.getValue(0) + "tareas-prop/", {
                user: nc,
                idtarea: IdTarea
                },
                function(html) {                    
                    $("#contentProfile").html(html).show('slow',function(){
                        //$("#contentProfile"); 
                        $('#breadcrumb').html(getBar('Inicio, Tarea '));
                    });
                }, "html");
        });
        return false;
    }

    function modTarFileAddProProf1(IdTarea,Tarea){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
            $("#preloaderPrincipal").show();
            obj.setIsTimeLine(false);
            var nc = $("#lstProfDir").val();
            $.post(obj.getValue(0) + "tareas-archivos-list/", {
                user: nc,
                idtarea: IdTarea,
                tarea: Tarea
                },
                function(html) {                    
                    $("#contentProfile").html(html).show('slow',function(){
                        $('#breadcrumb').html(getBar('Inicio, Archivos de la Tarea '));
                    });
                }, "html");
        });
        return false;
    }

    function getDestinatariosTar1(IdTarea,Tarea){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
            $("#preloaderPrincipal").show();
            obj.setIsTimeLine(false);
            var nc = $("#lstProfDir").val();
            $.post(obj.getValue(0) + "tareas-destinatarios-list/", {
                user: nc,
                idtarea: IdTarea,
                tarea: Tarea
                },
                function(html) {                    
                    $("#contentProfile").html(html).show('slow',function(){
                        $('#breadcrumb').html(getBar('Inicio, Listado de Tareas '));
                    });
                }, "html");
        });
        return false;
    }

    getProfDir();

    $("#preloaderPrincipal").hide();

});

</script>