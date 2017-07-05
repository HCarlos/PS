    <div class="row">

        <div class="span4">
            <div class="panel panel-success">
              <div class="panel-heading">Observaciones</div>
              <div class="panel-body" style="height: 30em !important; ">
                    <select class="lstObservaciones " name="lstObservaciones" id="lstObservaciones" multiple="multiple" style="width:100% !important; height: 95% !important;" > 
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
              <div class="panel-body" style="height: 30em !important; ">
                    <label for="selNiveles" class="lblH2cmb">Lista de Niveles </label>
                    <select name="selNiveles" id="selNiveles" size="1" style="width:100% !important;" > 
                    </select>
                   
                    <label for="lstObsNiv" class="lblH2">Observaciones Asignadas:</label>
                    <select class="lstObsNiv" name="lstObsNiv" id="lstObsNiv" multiple="multiple" style="width:100% !important; height: 69% !important;" >
                    </select>
                    <span class="label label-large label-yellow arrowed pull-right" id="lbl01"></span>

               </div>
            </div>
        </div>

    </div>

    <div id="divAddNewGroup" class="modal fade " style = "height:400px !important;">
    </div><!-- /.modal -->

<script type="text/javascript">


function getNiveles(){
    var nc = "u="+localStorage.nc;
    $("#selNiveles").html('');
    $.post(obj.getValue(0)+"data/", { o:1, t:3, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#selNiveles").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            getObservaciones();    
        }, "json"
    );  
}

function getObservaciones(){
    var nc = "u="+localStorage.nc;
    $.post(obj.getValue(0)+"data/", { o:1, t:23, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
            var nc;
           $.each(json, function(i, item) {
                //alert(item.label);
                nc = item.label.split("@");
                $("#lstObservaciones").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl02").html(commaSeparateNumber(json.length)+" observaciones")
            $("#preloaderPrincipal").hide();
            getObsNiv();

        }, "json"
    );  
}

function getObsNiv(){
    var nc = "u="+localStorage.nc;
    $("#lstObsNiv").html("");
    var y = $('select[name="selNiveles"] option:selected').val(); 
    $("#lstObsNiv").html("");
    $.post(obj.getValue(0)+"data/", {o:2, t:2, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
                $("#lstObsNiv").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl01").html(commaSeparateNumber(json.length)+" observaciones")

        }, "json"
    );  
}

$("#chkAllGru").on("click",function(event){
    var checked =$(this).is(":checked")
    if (checked) {
        $("#lstObservaciones option").each(function(){
            $(this).prop('selected', true);
        });
    } else {
        $("#lstObservaciones option").each(function(){
            $(this).prop('selected', false);
        });
    }
});


$("#selNiveles").on("change",function(event){
    event.preventDefault();
    getObsNiv();
});


$("#AddItem").on("click",function(event){
    $("#preloaderPrincipal").show();
    
    // Opciones asignadas a un determinado grupo
    var x = $('.lstObservaciones option:selected').val();  
    var y = $('select[name="selNiveles"] option:selected').val(); 

    if (isDefined(x)){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstObservaciones option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    if (isDefined(parseInt(y)) || y <= 0){
        $("#preloaderPrincipal").hide();
        alert("Seleccione un grupo");
        return false;
    }
    var d = x+'.'+y;
    
    //alert(d);

    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:2, c:d, t:10, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            //alert( json[0].msg);
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                getObsNiv();
                $("#preloaderPrincipal").hide();
    }, "json");
});

$("#DeleteItem").on("click",function(event){
    $("#preloaderPrincipal").show();

    var x = $('.lstObsNiv option:selected').val();  
    
    if (isDefined(parseInt(x))){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstObsNiv option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    
    //alert(x);
    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:2, c:x, t:20, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            //alert(json[0].msg)
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                //getNiveles();
                getObsNiv();
                $("#preloaderPrincipal").hide();
    }, "json");
});

getNiveles();

</script>



