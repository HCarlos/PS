    <div class="row">

        <div class="span4">
            <div class="panel panel-success">
              <div class="panel-heading">Profesores</div>
              <div class="panel-body" style="height: 30em !important; ">
                    <select class="lstProfesores " name="lstProfesores" id="lstProfesores" multiple="multiple" style="width:100% !important; height: 95% !important;" > 
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
              <div class="panel-heading">Directores</div>
              <div class="panel-body" style="height: 30em !important; ">
                    <label for="selDirectores" class="lblH2cmb">Lista de Directores </label>
                    <select name="selDirectores" id="selDirectores" size="1" style="width:100% !important;" > 
                    </select>
                   
                    <label for="lstProfDir" class="lblH2">Profesores Asignadas:</label>
                    <select class="lstProfDir" name="lstProfDir" id="lstProfDir" multiple="multiple" style="width:100% !important; height: 69% !important;" >
                    </select>
                    <span class="label label-large label-yellow arrowed pull-right" id="lbl01"></span>

               </div>
            </div>
        </div>

    </div>

    <div id="divAddNewGroup" class="modal fade " style = "height:400px !important;">
    </div><!-- /.modal -->

<script type="text/javascript">


function getDirectores(){
    var nc = "u="+localStorage.nc;
    $("#selDirectores").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:25, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#selDirectores").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            getProfesores();    
        }, "json"
    );  
}

function getProfesores(){
    var nc = "u="+localStorage.nc;
    $.post(obj.getValue(0)+"data/", { o:1, t:12, p:0,c:nc,from:0,cantidad:0, s:" order by nombre_profesor asc" },
        function(json){
            var nc;
           $.each(json, function(i, item) {
                //alert(item.label);
                nc = item.label.split("@");
                $("#lstProfesores").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl02").html(commaSeparateNumber(json.length)+" Profesores")
            $("#preloaderPrincipal").hide();
            getProfDir();

        }, "json"
    );  
}

function getProfDir(){
    var nc = "u="+localStorage.nc;
    $("#lstProfDir").empty();
    var y = $('select[name="selDirectores"] option:selected').val(); 
    $("#lstProfDir").empty();
    $.post(obj.getValue(0)+"data/", {o:2, t:3, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
                $("#lstProfDir").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl01").html(commaSeparateNumber(json.length)+" Profesores");
        }, "json"
    );  
}

$("#chkAllGru").on("click",function(event){
    var checked =$(this).is(":checked")
    if (checked) {
        $("#lstProfesores option").each(function(){
            $(this).prop('selected', true);
        });
    } else {
        $("#lstProfesores option").each(function(){
            $(this).prop('selected', false);
        });
    }
});


$("#selDirectores").on("change",function(event){
    event.preventDefault();
    getProfDir();
});


$("#AddItem").on("click",function(event){
    $("#preloaderPrincipal").show();
    
    // Opciones asignadas a un determinado Profesore
    var x = $('.lstProfesores option:selected').val();  
    var y = $('select[name="selDirectores"] option:selected').val(); 

    if (isDefined(x)){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstProfesores option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    if (isDefined(parseInt(y)) || y <= 0){
        $("#preloaderPrincipal").hide();
        alert("Seleccione un Profesore");
        return false;
    }
    var d = x+'.'+y;
    
    //alert(d);

    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:3, c:d, t:10, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            //alert( json[0].msg);
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                getProfDir();
                $("#preloaderPrincipal").hide();
    }, "json");
});

$("#DeleteItem").on("click",function(event){
    $("#preloaderPrincipal").show();

    var x = $('.lstProfDir option:selected').val();  
    
    if (isDefined(parseInt(x))){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstProfDir option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    
    //alert(x);
    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:3, c:x, t:20, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            //alert(json[0].msg)
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                //getDirectores();
                getProfDir();
                $("#preloaderPrincipal").hide();
    }, "json");
});

getDirectores();

</script>



