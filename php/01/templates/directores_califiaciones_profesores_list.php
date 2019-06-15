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

        <i class="icon-circle green"></i> <strong >CAPTURA DE CALIFICACIONES POR </strong>: <b class="text-success">PROFESOR(@)</b> 



    </div>


    <div class="widget-body">
        <div class="widget-main">            
            <div class="row-fluid">
                <table>
                    <tr>
                        <td>
                            <i class="icon-user green"></i>
                            <strong class="green">Profesor(a)</strong>: 
                            <select class="altoMoz wd100prc"  name="lstProfDir" id="lstProfDir" size="1"></select>
                        </td>
                        <td>
                            <div class="marginLeft2em">
                                <strong class="green marginLeft1em">Grupo</strong>: 
                                <select class="altoMoz wd100prc marginLeft1em" name="lstGposProf" id="lstGposProf" size="1">
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="marginLeft2em">
                                <strong class="green marginLeft1em">Materia</strong>: 
                                <select class="altoMoz wd100prc marginLeft1em"  name="lstMateria" id="lstMateria" size="1"></select>
                            </div>
                        </td>
                        <td>
                            <div class="marginLeft2em">
                                <strong class="green marginLeft1em">Evaluación</strong>: 
                                <select class="altoMoz wd75prc  marginLeft1em" name="lstEval" id="lstEval" size="1">
                                    <option value="1"> 1 </option>
                                    <option value="2"> 2 </option>
                                    <option value="3"> 3 </option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <div class="marginLeft2em">
                                <a href="#" class="altoMoz wd75prc  marginLeft1em" id="btnPrintListaAsistencia01" >Lista de Asistencia</a>
                            </div>
                        </td>
                        <td>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>


            <table aria-describedby="tblCalDir01_info" id="tblCalDir01" class="table table-striped table-bordered table-hover dataTable">
                                
                <thead>
                    <tr role="row">
                        <th aria-label="username: to sort column ascending" style="width: 10px;" aria-controls="tblCalDir01" tabindex="0" role="columnheader" class="sorting" >Username</th>
                        <th aria-label="alumno: to sort column ascending" style="width: 150px;" aria-controls="tblCalDir01" tabindex="2" role="columnheader" class="sorting">Alumno</th>
                        <th aria-label="boleta: to sort column ascending" style="width: 10px;" aria-controls="tblCalDir01" tabindex="3" role="columnheader" class="sorting center">Boleta Impresa</th>
                        <th aria-label="detalle_boleta: to sort column ascending" style="width: 10px;" aria-controls="tblCalDir01" tabindex="3" role="columnheader" class="sorting center">Detalle Calificaciones</th>
                        <th aria-label="kardex: to sort column ascending" style="width: 10px;" aria-controls="tblCalDir01" tabindex="3" role="columnheader" class="sorting center">Kardex</th>
                    </tr>
                </thead>
                <tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
            </table>
    </div><!--/widget-body-->

</div>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {


    $("#preloaderPrincipal").hide();
    $("#btnPrintListaAsistencia01").hide();
    
    $("#lstProfDir").empty();

    var IdProfesor = 0;
    var IdGrupo    = 0;
    var IdGruMat   = 0;
    var IdAlumno   = 0;
    var NumEval    = 0;
    var oTable;

    function getTable(){

        oTable = $('#tblCalDir01').dataTable({
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
            "aoColumns": [ null, null, null, null, null],
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
        var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+NumEval;
        $.post(obj.getValue(0)+"data/", { o:1, t:122, p:11, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                if (json.length){
                    var lec,arc,res,des;
                    $.each(json, function(i, item) {

                        tB +='          <tr class="odd">';
                        tB +=' ';
                        tB +='              <td>'+item.num_lista+'</td>';
                        tB +='              <td>'+item.alumno+'</td>';
                        tB +='              <td class="center"><a class="blue printBolCalAluFromTutores1" href="#" id="l1-'+item.idgrualu+'-'+item.clave_nivel+'-0'+'-'+item.grado+'-0"  data-rel="tooltip" data-placement="top" title="Ver Boleta de Calificaciones" ><i class="icon-print bigger-130"></i></a></td>';
                        tB +='              <td class="center"><a class="red detailBolCalAluFromTutores1" href="#" id="l2|'+item.idgrualu+'|'+item.clave_nivel+'|'+item.grupo+'|'+item.alumno+'|'+item.grado+'"  data-rel="tooltip" data-placement="top" title="Ver Detalle de Calificaciones" ><i class="icon-list bigger-130"></i></a></td>';
                        tB +='              <td class="center">';
                        if ( parseInt(item.genero,0) == 0 ){
                            tB += '         <a class="pink modGruMatProKRDX02 tooltip-info " href="#" id="idgrualu2two-'+item.idalumno+'-'+item.iduseralu+'" data-rel="tooltip" data-placement="top" data-original-title="Ver Kardex" title="Ver Kardex" >';
                            tB += '             <i class="fa fa-female bigger-150"></i>';
                        }else{
                            tB += '         <a class="blue modGruMatProKRDX02 tooltip-info " href="#" id="idgrualu2two-'+item.idalumno+'-'+item.iduseralu+'" data-rel="tooltip" data-placement="top" data-original-title="Ver Kardex" title="Ver Kardex" >';
                            tB += '             <i class="fa fa-male bigger-150"></i>';
                        }
                        tB +='              </td>';
                        tB +='          </tr>';
                    });
                    
                    $('#tblCalDir01 > tbody').html(tB);

                    $("#preloaderPrincipal").hide();

                    $(".printBolCalAluFromTutores1").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        var cveNivel = parseInt(arr[2],0);
                        var Grado = parseInt(arr[3],0);
                        var tDocto = parseInt(arr[5],0);
                        getBolCalFromTutores(arr[1],cveNivel, Grado, tDocto);
                    });

                    $(".detailBolCalAluFromTutores1").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('|');
                        var cveNivel = parseInt(arr[2],0);
                        getDetailCalFromTutores(arr[1],cveNivel,arr[3],arr[4]);
                    });

                    $(".modGruMatProKRDX02").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        if (arr[2] != 'null'){
                            modGruMatProKRDX02(arr[1],arr[2]);
                        }else{
                            alert("Aún no se ha generado un Usuario a este alumno");
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


    function onClickFillTable(){
        if(oTable != null){
            oTable.fnDestroy();
            $('#tblCalDir01 > tbody').empty();
            init = true;
        }
        fillTable();
    }


    function getProfDir(){
        var nc = "u="+localStorage.nc;
        $("#lstProfDir").empty();
        $("#lstProfDir").append('<option value="0">Seleccione un Profesor</option>');
        $.post(obj.getValue(0)+"data/", {o:59, t:44, p:54,c:nc,from:0,cantidad:0, s:'' },
            function(json){
               $.each(json, function(i, item) {
                    $("#lstProfDir").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                $("#lstProfDir").append('<option value="000"> Todos </option>');
            }, "json"
        );  
    }

    $("#lstProfDir").on("change",function(event){
        event.preventDefault();
        IdProfesor = parseInt( $(this).val(), 0 );
        $("#lstGposProf").empty();
        if (IdProfesor > 0){
            getGposProf(IdProfesor);
        }
    });

    function getGposProf(IdProfesor){
        var idemp = localStorage.IdEmp;
        var nc = "idprofesor="+IdProfesor+"&idemp="+idemp;
        $("#lstGposProf").html("<option value='0' selected>Seleccione un Grupo</option>");
        $.post(obj.getValue(0)+"data/", { o:1, t:74, p:0,c:nc,from:0,cantidad:0, s:" order by idgrupo asc " },
            function(json){
               $.each(json, function(i, item) {
                    $("#lstGposProf").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
            }, "json"
        );
    }

    $("#lstGposProf").on("change",function(event){
        event.preventDefault();
        IdGrupo = parseInt( $(this).val(), 0 );
        $("#lstMateria").empty();
        if (IdGrupo > 0){
            getMatGpo(IdProfesor,IdGrupo);
        }
    });

    function getMatGpo(IdProfesor,IdGrupo){
        var idemp = localStorage.IdEmp;
        var nc = "idprofesor="+IdProfesor+"&idgrupo="+IdGrupo+"&idemp="+idemp;
        $("#lstMateria").html("<option value='0|0' selected>Seleccione una Materia</option>");
        $.post(obj.getValue(0)+"data/", { o:1, t:75, p:0, c:nc, from:0, cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#lstMateria").append('<option value="'+item.data+'|'+item.eval_default+'"> '+item.label+'</option>');
                });
            }, "json"
        );  
    }

    $("#lstMateria").on("change",function(event){
        event.preventDefault();
        var arrMat = $(this).val().split('|');
        IdGruMat = parseInt( arrMat[0], 0 );
        NumEval  = parseInt( arrMat[1], 0 );
        $("#lstEval").val(NumEval);
        if (IdGruMat > 0){
            $("#btnPrintListaAsistencia01").show();
            onClickFillTable();
        }


    $("#lstEval").on("change",function(event){
        event.preventDefault();
        NumEval = $(this).val();
    });


    function getBolCalFromTutores(IdGruAlu, ClaveNivel, Grado, TDocto){

        var logoEmp =obj.getConfig(100,0); 
        var logoIbo =obj.getConfig(100,1); 
        var url;

        var nc = "user="+localStorage.nc+
                "&strgrualu="+IdGruAlu+
                "&grado="+Grado+
                "&logoEmp="+logoEmp+
                "&logoIbo="+logoIbo;

        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};
        if (ClaveNivel==5){
            url = obj.getValue(0)+"print-calif-prepa-interna-arji/";
        }else if (ClaveNivel==4){
            url = obj.getValue(0)+"print-calif-secundaria-interna-arji/";
        }else if (ClaveNivel==2){
            url = obj.getValue(0)+"print-calif-primaria-interna-arji/";
        }else if (ClaveNivel==3){
            url = obj.getValue(0)+"print-calif-primaria-interna-arji/";
        }else if (ClaveNivel==1){
            // url = obj.getValue(0)+"print-calif-kinder-interna-arji-esp/";
            url = TDocto == 0 ? obj.getValue(0)+"print-calif-kinder-interna-arji-esp/" : obj.getValue(0)+"print-calif-kinder-interna-arji-ing/";
        }else{
            alert("Boleta en Construcción");
            return false;
        }

        var tit = "Alumno-Boleta-Impresa-"+localStorage.nc+'-'+IdGruAlu;
        trackOutboundLink(url,tit);

        var temp=document.createElement("form");
        temp.action=url;
        temp.method="POST";
        temp.target="_blank";
        temp.style.display="none";
        for(var x in PARAMS) {
            var opt=document.createElement("textarea");
            opt.name=x;
            opt.value=PARAMS[x];
            temp.appendChild(opt);
        }
        document.body.appendChild(temp);
        temp.submit();
        return temp;
    };


    function getDetailCalFromTutores(IdGruAlu,ClaveNivel,Grupo,Alumno){

        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
            $("#preloaderPrincipal").show();
            obj.setIsTimeLine(false);
            var nc = localStorage.nc;

            var url = obj.getValue(0) + "tutores-boletas-detail-list/";
            var tit = "Alumno-Boleta-Detalle-"+nc+'-'+IdGruAlu;

            trackOutboundLink(url,tit);

            $.post(url, {
                user: nc,
                idgrualu: IdGruAlu,
                clave_nivel: ClaveNivel,
                grupo: Grupo,
                alumno: Alumno,
                screenOrigen: "contentMain",
                screenDestino: "contentProfile"
                },
                function(html) {                    
                    $("#contentProfile").html(html).show('slow',function(){
                        $('#breadcrumb').html(getBar('Inicio, Detalle de Calificaciones '));
                    });
                }, "html");
        });
        return false;
    };


    function modGruMatProKRDX02(IdAlumno,IdUserAlu){

        var nc = "u="+localStorage.nc+"&idalumno="+IdAlumno+'&idgrupo=0&iduseralu='+IdUserAlu;        
        
        // alert(nc);
        // return false;

        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
        var url = obj.getValue(0)+"kardex-alumno-arji/";

        var temp=document.createElement("form");
        temp.action=url;
        temp.method="POST";
        temp.target="_blank";
        temp.style.display="none";
        for(var x in PARAMS) {
            var opt=document.createElement("textarea");
            opt.name=x;
            opt.value=PARAMS[x];
            temp.appendChild(opt);
        }
        document.body.appendChild(temp);
        temp.submit();
        return temp;
    }

    $("#btnPrintListaAsistencia01").on("click",function(event){
        event.preventDefault();
            var logoEmp =obj.getConfig(100,0); 
            var nc = "u=" + localStorage.nc+
                    "&grupo=" + $("#lstGposProf option:selected").text() + 
                    "&idgrupo=" + IdGrupo + 
                    "&idgrumat=" + IdGruMat+
                    "&materia=" + $("#lstMateria option:selected").text() +
                    "&profesor=" + $("#lstProfDir option:selected").text() +
                    "&eval=" + NumEval+
                    "&logoEmp=" + logoEmp;
                                
            var PARAMS = {o:50, t:7, c:nc, p:54, from:0, cantidad:0, s:''};  
            var url = obj.getValue(0)+"lista-asistencias-profesor-1/";

            var temp=document.createElement("form");
            temp.action=url;
            temp.method="POST";
            temp.target="_blank";
            temp.style.display="none";
            for(var x in PARAMS) {
                var opt=document.createElement("textarea");
                opt.name=x;
                opt.value=PARAMS[x];
                temp.appendChild(opt);
            }
            document.body.appendChild(temp);
            temp.submit();
            return temp;

    }); 


    getProfDir();

    $("#preloaderPrincipal").hide();

});

</script>