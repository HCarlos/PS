<?php

include("includes/metas.php");

$de       = $_POST['user'];
$idgrumat  = $_POST['idgrumat'];
$idgrupo  = $_POST['idgrupo'];
$idciclo =  $_POST['idciclo'];

?>
 
    <div class="row-fluid">

        <div class="span5">
            <div class="panel panel-success">
              <div class="panel-heading">Materias</div>
              <div class="panel-body" style="height: 30em !important; ">
                    <select class="lstMaterias " name="lstMaterias" id="lstMaterias" multiple="multiple" style="width:100% !important; height: 95% !important;" > 
                    </select>
                    <span class="label label-large label-yellow arrowed-right pull-left" id="lbl02"></span>
                    <div class="span3 pull-right">
                        <label>
                            <input name="chkAllMat" id="chkAllMat" class="ace ace-switch" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </div>                    
               </div>
            </div>
        </div>

        <div class="span2">
            <div class="panel panel-default"  style="height: 33em;">
                <div class="panel-body" style="padding-top: 12em;">
                        <button id="AddItem" name="btnAsig" class="btnAsig btn btn-primary btn-lg" >
                            Asignar <span class="glyphicon glyphicon-chevron-right"></span></button><br/><br/>
                        <button id="DeleteItem" name="DeleteItem" class="btnDel btn btn-primary btn-lg" >
                            <span class="glyphicon glyphicon-chevron-left"></span>Quitar</button>
                </div>
            </div>
             <div class="div1em"></div>
        </div>

        <div class="span5">
            <div class="panel panel-primary">
              <div class="panel-heading">Agrupadoras</div>
              <div class="panel-body" style="height: 30em !important; ">
                    <label for="selAgrupadoras" class="lblH2cmb">Lista de Agrupadoras </label>
                    <select name="selAgrupadoras" id="selAgrupadoras" size="1" style="width:100% !important;" > 
                    </select>
                   
                    <label for="lstAgrumat" class="lblH2">Materias Asignadas:</label>
                    <select class="lstAgrumat" name="lstAgrumat" id="lstAgrumat" multiple="multiple" style="width:100% !important; height: 69% !important;" >
                    </select>
                    <span class="label label-large label-yellow arrowed pull-right" id="lbl01"></span>

               </div>
            </div>
        </div>
        <div class="row " >
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormLevel03AgruGruMat"><i class="icon-close"></i>Regresar</button>
        </div>        

    </div>
    

<script type="text/javascript">

    var IdGrupo = <?php echo $idgrupo ?>;
    var IdGruMat = <?php echo $idgrumat ?>;
    var IdCiclo = <?php echo $idciclo ?>;

    $("#closeFormLevel03AgruGruMat").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").html("");
            $("#contentProfile").show();
        });
        resizeScreen();
        return false;
    });

function getAgrupadoras(){
    var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;
    $("#selAgrupadoras").html('');
    $.post(obj.getValue(0)+"data/", { o:1, t:18, p:0,c:nc,from:0,cantidad:0, s:''},
        function(json){
           $.each(json, function(i, item) {
                $("#selAgrupadoras").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            //getMaterias();    
        }, "json"
    );  
}

function getMaterias(){
    var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;
    //alert(nc);
    $.post(obj.getValue(0)+"data/", { o:1, t:19, p:0, c:nc, from:0, cantidad:0, s:''},
        function(json){
            var nc;
           $.each(json, function(i, item) {
                $("#lstMaterias").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl02").html(commaSeparateNumber(json.length)+" materias")
            $("#preloaderPrincipal").hide();
            getAgruMat();

        }, "json"
    );  
}

function getAgruMat(){
    $("#lstAgrumat").html("");
    var y = $('select[name="selAgrupadoras"] option:selected').val(); 
    $("#lstAgrumat").html("");
    var nc = "u="+localStorage.nc+"&idgrumat="+y+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;
    $.post(obj.getValue(0)+"data/", {o:1, t:20, p:0,c:nc,from:0,cantidad:0, s:'' },
        function(json){
           $.each(json, function(i, item) {
                $("#lstAgrumat").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl01").html(commaSeparateNumber(json.length)+" materias")

        }, "json"
    );  
}

$("#chkAllMat").on("click",function(event){
    var checked =$(this).is(":checked")
    if (checked) {
        $("#lstMaterias option").each(function(){
            $(this).prop('selected', true);
        });
    } else {
        $("#lstMaterias option").each(function(){
            $(this).prop('selected', false);
        });
    }
});


$("#selAgrupadoras").on("change",function(event){
    event.preventDefault();
    getAgruMat();
});


$("#AddItem").on("click",function(event){
    $("#preloaderPrincipal").show();
    
    // Opciones asignadas a un determinado grupo
    var x = $('.lstMaterias option:selected').val();  
    var y = $('select[name="selAgrupadoras"] option:selected').val(); 

    if (isDefined(x)){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstMaterias option:selected").each(function () {
                x += x=='' ? $(this).val() : "|" + $(this).val() ;
          });

    }

    if (isDefined(parseInt(y)) || y <= 0){
        $("#preloaderPrincipal").hide();
        alert("Seleccione un grupo");
        return false;
    }

    var d = x+'.'+y;
    
    //alert(d);

    var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;

    $.post(obj.getValue(0)+"data/", { o:16, c:d, t:3, p:12, s:nc, from:0, cantidad:0 },
        function(json){
            //alert( json[0].msg);
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                getAgruMat();
                $("#preloaderPrincipal").hide();
    }, "json");
});

$("#DeleteItem").on("click",function(event){
    $("#preloaderPrincipal").show();

    var x = $('.lstAgrumat option:selected').val();  
    
    if (isDefined(parseInt(x))){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstAgrumat option:selected").each(function () {
                 x += x=='' ? $(this).val() : "|" + $(this).val() ;
          });

    }
    
    //alert(x);
    var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;

    $.post(obj.getValue(0)+"data/", { o:16, c:x, t:4, p:12, s:nc, from:0, cantidad:0 },
        function(json){
            //alert(json[0].msg)
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                //getAgrupadoras();
                getAgruMat();
                $("#preloaderPrincipal").hide();
    }, "json");
});

getAgrupadoras();
getMaterias();

</script>



