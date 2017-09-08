    <div class="row">

        <div class="span4">
            <div class="panel panel-success">
              <div class="panel-heading">Grupos</div>
              <div class="panel-body" style="height: 40em !important; ">
                    <label for="gpoAses0" class="lblH2cmb">Grupos del Ciclo </label>
                    <select class="gpoAses0 " name="gpoAses0" id="gpoAses0" multiple="multiple" style="width:100% !important; height: 90% !important;" > 
                    </select>
                    <span class="label label-large label-yellow arrowed-right pull-left" id="lbl02"></span>
                    <div class="span3 pull-right">
                        <label>
                            <input name="chkAllGru" id="chkAllGru" class="ace ace-switch" type="checkbox">
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

        <div class="span4">
            <div class="panel panel-primary">
              <div class="panel-heading">Niveles</div>
              <div class="panel-body" style="height: 40em !important; ">

                    <label for="selDirAses" class="lblH2cmb">Directores </label>
                    <select name="selDirAses" id="selDirAses" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="selAsesores" class="lblH2cmb">Asesor </label>
                    <select name="selAsesores" id="selAsesores" size="1" style="width:100% !important;" > 
                    </select>
                   
                    <label for="grupoAs1" class="lblH2">Grupos Asignadas:</label>
                    <select class="grupoAs1" name="grupoAs1" id="grupoAs1" multiple="multiple" style="width:100% !important; height: 62% !important;" >
                    </select>
                    <span class="label label-large label-yellow arrowed pull-right" id="lbl01"></span>

               </div>
            </div>
        </div>

    </div>

    <div id="divAddNewGroup" class="modal fade " style = "height:400px !important;">
    </div><!-- /.modal -->

<script type="text/javascript">

function getGrupos(){
    var nc = "u="+localStorage.nc;
    $.post(obj.getValue(0)+"data/", { o:1, t:72, p:0, c:nc, from:0, cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#gpoAses0").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl02").html(commaSeparateNumber(json.length)+" grupos")
            $("#preloaderPrincipal").hide();

            

        }, "json"
    );  
}


function getDirectores(){
    var nc = "u="+localStorage.nc;
    $("#selDirAses").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:25, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#selDirAses").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            getAsesores();    
        }, "json"
    );  
}

function getAsesores(){
    var nc = "u="+localStorage.nc;
    $("#selAsesores").empty();
    var y = $('select[name="selDirAses"] option:selected').val(); 
    $("#selAsesores").empty();
    $.post(obj.getValue(0)+"data/", {o:2, t:12, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
                $("#selAsesores").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl01").html(commaSeparateNumber(json.length)+" Asesores");
            getGpoAsesor();
        }, "json"
    );  
}

$("#selDirAses").on("change",function(event){
    event.preventDefault();
    getAsesores();
});

$("#selAsesores").on("change",function(event){
    event.preventDefault();
    getGpoAsesor();
});



function getGpoAsesor(){
    var nc = "u="+localStorage.nc;
    $("#grupoAs1").empty();
    var y = $('select[name="selAsesores"] option:selected').val(); 
    $("#grupoAs1").empty();
    $.post(obj.getValue(0)+"data/", {o:2, t:13, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
               $("#grupoAs1").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl01").html(commaSeparateNumber(json.length)+" grupos")

        }, "json"
    );  
}

$("#chkAllGru").on("click",function(event){
    var checked =$(this).is(":checked")
    if (checked) {
        $("#gpoAses0 option").each(function(){
            $(this).prop('selected', true);
        });
    } else {
        $("#gpoAses0 option").each(function(){
            $(this).prop('selected', false);
        });
    }
});


$("#AddItem").on("click",function(event){
    $("#preloaderPrincipal").show();
    
    // Opciones asignadas a un determinado grupo
    var x = $('.gpoAses0 option:selected').val();  
    var y = $('select[name="selAsesores"] option:selected').val(); 

    if (isDefined(x)){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".gpoAses0 option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    if (isDefined(parseInt(y)) || y <= 0){
        $("#preloaderPrincipal").hide();
        alert("Seleccione un grupo");
        return false;
    }
    var d = x+'.'+y;
    
    // alert(d);

    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:6, c:d, t:10, p:1, s:nc, from:0, cantidad:0 },
        function(json){
                $("#preloaderPrincipal").hide();
                getGpoAsesor();
            if (json.length<=0 && json[0].msg=="Error") { return false;}
    }, "json");
});

$("#DeleteItem").on("click",function(event){
    $("#preloaderPrincipal").show();

    var x = $('.grupoAs1 option:selected').val();  
    
    if (isDefined(parseInt(x))){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".grupoAs1 option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    
    //alert(x);
    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:6, c:x, t:20, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            //alert(json[0].msg)
            $("#preloaderPrincipal").hide();
            getGpoAsesor();
            if (json.length<=0 && json[0].msg=="Error") { return false;}
    }, "json");
});

getGrupos();
getDirectores();

</script>



