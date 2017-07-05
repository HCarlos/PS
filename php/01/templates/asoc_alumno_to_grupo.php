    <div class="row">

        <div class="span4">
            <div class="panel panel-success">
              <div class="panel-heading">Alumnos</div>
              <div class="panel-body" style="height: 40em !important; ">

                    <select class="lstAlumnos " name="lstAlumnos" id="lstAlumnos" multiple="multiple" style="width:100% !important; height: 95% !important;" > 
                    </select>
                    <span class="label label-large label-yellow arrowed-right pull-left" id="lbl02"></span>
                    <div class="span3 pull-right">
                        <label>
                            <input name="chkAllAlu01" id="chkAllAlu01" class="ace ace-switch" type="checkbox">
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
              <div class="panel-heading">Grupos</div>
              <div class="panel-body" style="height: 40em !important; ">

                    <label for="ciclo1" class="lblH2cmb">Ciclo </label>
                    <select name="ciclo1" id="ciclo1" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="selNiveles" class="lblH2cmb">Lista de Niveles </label>
                    <select name="selNiveles" id="selNiveles" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="selGrupos" class="lblH2cmb">Lista de Grupos </label>
                    <select name="selGrupos" id="selGrupos" size="1" style="width:100% !important;" > 
                    </select>
                   
                    <label for="lstAluGpo" class="lblH2">Alumnos Asignados:</label>
                    <select class="lstAluGpo" name="lstAluGpo" id="lstAluGpo" multiple="multiple" style="width:100% !important; height: 50% !important;" >
                    </select>
                    <span class="label label-large label-yellow arrowed pull-right" id="lbl01"></span>

               </div>
            </div>
        </div>

    </div>

    <div id="divAddNewGroup" class="modal fade " style = "height:400px !important;">
    </div><!-- /.modal -->

<script type="text/javascript">
var init = true;

function getCiclos(){
    var nc = "u="+localStorage.nc;
    $("#ciclo1").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:2, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
            var pred = "";
           $.each(json, function(i, item) {
                pred = item.predeterminado == 1 ? ' selected ': ' ';
                $("#ciclo1").append('<option value="'+item.data+'" ' + pred + '> '+item.label+'</option>');
            });

            getNiveles(); 

        }, "json"
    );  
}

function getAlumnos(){
    var nc = "u="+localStorage.nc;
    $("#lstAluGpo").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:5, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
            var nc;
           $.each(json, function(i, item) {
                //alert(item.label);
                nc = item.label.split("@");
                $("#lstAlumnos").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl02").html(commaSeparateNumber(json.length)+" alumnos")
            $("#preloaderPrincipal").hide();
            //getAluGpo();

        }, "json"
    );  
}


function getNiveles(){
    var nc = "u="+localStorage.nc;
    $("#selNiveles").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:3, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#selNiveles").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            getGrupos( $("#ciclo1") );    
        }, "json"
    );  
}

function getGrupos(ciclo){
    var nc = "u="+localStorage.nc+"&idciclo="+ciclo.val();
    $("#selGrupos").empty();
    $("#lstAluGpo").empty();
    var y = $('select[name="selNiveles"] option:selected').val(); 

    $.post(obj.getValue(0)+"data/", { o:1, t:6, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
                $("#selGrupos").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });

            if (init){
                getAlumnos();
                init = false;    
            }
            getAluGpo(  $("#ciclo1")  );
        }, "json"
    );  
}


function getAluGpo(ciclo){
    var nc = "u="+localStorage.nc+"&idciclo="+ciclo.val();
    var y = $('select[name="selGrupos"] option:selected').val(); 
    $("#lstAluGpo").empty();
    $.post(obj.getValue(0)+"data/", {o:2, t:1, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
                $("#lstAluGpo").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl01").html(commaSeparateNumber(json.length)+" alumnos")

        }, "json"
    );  
}

$("#chkAllAlu01").on("click",function(event){
    var checked =$(this).is(":checked")
    if (checked) {
        $("#lstAlumnos option").each(function(){
            $(this).prop('selected', true);
        });
    } else {
        $("#lstAlumnos option").each(function(){
            $(this).prop('selected', false);
        });
    }
});

$("#ciclo1").on("change",function(event){
    event.preventDefault();
    getGrupos( $("#ciclo1") );
});

$("#selNiveles").on("change",function(event){
    event.preventDefault();
    getGrupos( $("#ciclo1") );
});

$("#selGrupos").on("change",function(event){
    event.preventDefault();
    getAluGpo( $("#ciclo1") );
});


$("#AddItem").on("click",function(event){
    $("#preloaderPrincipal").show();
    
    // Opciones asignadas a un determinado alumno
    var x = $('.lstAlumnos option:selected').val();  
    var y = $('select[name="selGrupos"] option:selected').val(); 

    if (isDefined(x)){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstAlumnos option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    if (isDefined(parseInt(y)) || y <= 0){
        $("#preloaderPrincipal").hide();
        alert("Seleccione un elemento");
        return false;
    }
    var d = x+'.'+y;
    
    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:1, c:d, t:10, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            //alert( json[0].msg);
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                getAluGpo(  $("#ciclo1")  );
                $("#preloaderPrincipal").hide();
    }, "json");
});

$("#DeleteItem").on("click",function(event){
    $("#preloaderPrincipal").show();

    var x = $('.lstAluGpo option:selected').val();  
    
    if (isDefined(parseInt(x))){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstAluGpo option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    
    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:1, c:x, t:20, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                getAluGpo( $("#ciclo1") );
                $("#preloaderPrincipal").hide();
    }, "json");
});

getCiclos();

</script>



