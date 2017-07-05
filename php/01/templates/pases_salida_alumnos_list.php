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
        <i class="icon-circle green"></i> <strong id="spIdPSA"><?php echo $idpsa ?></strong>: <b class="text-success"><?php echo $referencia ?></b> 
        <div class="widget-toolbar no-border">

            <div class="widget-toolbar">
                <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeAllAlumnsPSADest000 " >
                        <i class="icon-angle-left icon-on-right"></i>
                        Regresar
                </button>
            </div>
            <div class="widget-toolbar">

                <a href="#tblFilesUp" class="ui-pg-div" id="btnAddAluToPSA02">
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
            

                                <table aria-describedby="sample-table-2" id="tblPSA01Dest" class="table table-striped table-bordered table-hover dataTable">
                                                    
                                    <thead>
                                        <tr role="row">
                                            <th aria-label="idpsaalumno: to sort column ascending" style="width: 10px;" aria-controls="tblPSA01Dest" tabindex="0" role="columnheader" class="sorting" >ID</th>
                                            <th aria-label="alumno: to sort column ascending" style="width: 50px;" aria-controls="tblPSA01Dest" tabindex="1" role="columnheader" class="sorting">ALUMNO</th>
                                            <th aria-label="pases: to sort column ascending" style="width: 10px;" aria-controls="tblPSA01Dest" tabindex="3" role="columnheader" class="sorting center">PASES</th>
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

    var IdPSA = <?php echo $idpsa ?>;
    var Referencia = "<?php echo $referencia ?>";
    var Param = "<?= $param; ?>";
    var IdGrupo = <?= $idgrupo; ?>;
    var Clave_Nivel = <?= $clave_nivel; ?>;
    var IdCiclo = <?= $idciclo; ?>;

    var oTable;

    function getTable(){

        oTable = $('#tblPSA01Dest').dataTable({
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
            "aoColumns": [ null, null, null, { "bSortable": false }],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "bRetrieve": true,
            "bDestroy": false
        });
    }

    function fillTable(){
                        
        var tB = "";

        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idpsa="+IdPSA;
        var lei,resp, arch;
        $.post(obj.getValue(0) + "data/", {o:51, t:12, c:nc, p:54, from:0, cantidad:0,s:''},
            function(json){
                if (json.length){
                    $.each(json, function(i, item) {
                        tB +='          <tr>';
                        tB +=' ';
                        tB +='              <td class="tbl10W">';
                        tB +='                  <a class="modTarPro0" href="#" id="idprof0-'+item.idpsaalumno+'"  data-rel="tooltip" data-placement="top" title="Editar Alumno">'+padl(item.idpsaalumno,4)+'</a>';
                        tB +='              </td>';
                        tB +='              <td class="tbl50W">'+item.nombre_alumno+'</td>';
                        tB +='              <td class="tbl50W">'+item.num_pases+'</td>';
                        tB +='              <td class="tbl100W">';
                        tB +='                  <div class="action-buttons">';
                        tB +=' ';
                        tB +='                      <a class="red delTar0" href="#" id="delTar0-'+item.idpsaalumno+'-'+item.idalumno+'-'+item.alumno+' "  data-rel="tooltip" data-placement="top" title="Eliminar Alumno">';
                        tB +='                          <i class="icon-trash bigger-130"></i>';
                        tB +='                      </a>';
                        tB +=' ';
                        tB +='                      <a class="cafe marginLeft1em printPSA02" href="#" id="printPSA02-'+item.idpsa+'-'+item.idalumno+ '" data-rel="tooltip" data-placement="top" title="Imprimir Pase de Salida" >';
                        tB +='                          <i class="icon-print bigger-130"></i>'
                        tB +='                      </a>';
                        tB +=' ';
                        tB +='                  </div>';
                        tB +='              </td>';
                        tB +='          </tr>';
                    });
                    
                    //alert(tB);

                    $('#tblPSA01Dest > tbody').html(tB);

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
                                DelteAlumnoFromPSA00( arr[1],arr[2],arr[3] );                            
                        }
                    });

                    $(".printPSA02").on("click",function(event){
                        event.preventDefault();
                        var arr = event.currentTarget.id.split('-');
                        obj.setIsTimeLine(false);
                        printAlumnosPSA01(IdPSA,arr[2]);
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
            $('#tblPSA01Dest > tbody').empty();
            init = true;
        }
        fillTable();
    }


    $("#btnAddAluToPSA02").on("click",function(event){
        event.stopPropagation();
        addAlumnosToPSA004(IdPSA,Referencia);
    })

    function addAlumnosToPSA004(IdPSA,Referencia){

        $("#contentLevel4").empty();
        $("#contentLevel3").hide(function(){
            var nc = localStorage.nc; 
        $.post(obj.getValue(0) + "psa-alumnos-asign/", {
                    user: nc,
                    idpsa: IdPSA,
                    referencia: Referencia,
                    param: Param,
                    idgrupo: IdGrupo,
                    idciclo: IdCiclo,
                    clave_nivel: Clave_Nivel
            },
            function(html) {
                    $("#contentLevel4").html(html).show('slow',function(){
                    });
            }, "html");
        });

    }

    function DelteAlumnoFromPSA00(IdPSAAlumno, IdAlumno, Alumno){

        $("#preloaderPrincipal").show();
        var nc = "user="+localStorage.nc+"&dests="+IdPSAAlumno+"&idpsa="+IdPSA;
        $.post(obj.getValue(0)+"data/", { o:51, c:nc, t:20, p:53, s:nc, from:0, cantidad:0 },
            function(json){
                stream.emit("cliente", {mensaje: "PLATSOURCE-LIST_ALUMNOS_PSA-PROP-"+IdPSAAlumno+'-'+IdAlumno+'-'+Alumno+'-'+localStorage.nc});                
                onClickFillTable();
                $("#preloaderPrincipal").hide();
        }, "json");

    }

    function printAlumnosPSA01(IdPSA,IdAlumno){

        var logoEmp =obj.getConfig(100,0); 
        var logoIbo =obj.getConfig(100,1); 
        var a0;
        var idalumnos = IdAlumno;

        var nc = "u="+localStorage.nc+"&idalumnos="+idalumnos+
                "&logoEmp="+logoEmp+
                "&logoIbo="+logoIbo+
                "&idciclo="+IdCiclo+
                "&idpsas="+IdPSA;
        

        var PARAMS = {o:51, t:12, c:nc, p:54, from:0, cantidad:0,s:''};

        url = obj.getValue(0)+"psa-alumnos-print/";

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


    // close Form
    $(".closeAllAlumnsPSADest000").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").empty();
            $("#contentProfile").show();
        });
        resizeScreen();
        return false;
    });

    var stream = io.connect(obj.getValue(4));
    stream.on("servidor", jsNewSolMatEnc0);
    function jsNewSolMatEnc0(datosServer) {
        var ms = datosServer.mensaje.split("-");
        if (ms[1]=='LIST_ALUMNOS_PSA') {
            onClickFillTable();
        }
    }


});

</script>