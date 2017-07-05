    <div class="row">

        <div class="span4">
            <div class="panel panel-success">
              <div class="panel-heading">Grupos</div>
              <div class="panel-body" style="height: 40em !important; ">
<!--                     
                    <label for="ciclo0" class="lblH2cmb">Ciclo </label>
                    <select name="ciclo0" id="ciclo0" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="nivel0" class="lblH2cmb">Lista de Niveles </label>
                    <select name="nivel0" id="nivel0" size="1" style="width:100% !important;" > 
                    </select>

 -->                <label for="grupo0" class="lblH2cmb">Grupos del Ciclo </label>
                    <select class="grupo0 " name="grupo0" id="grupo0" multiple="multiple" style="width:100% !important; height: 90% !important;" > 
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

                    <label for="ciclo1" class="lblH2cmb">Ciclo </label>
                    <select name="ciclo1" id="ciclo1" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="nivel1" class="lblH2cmb">Lista de Niveles </label>
                    <select name="nivel1" id="nivel1" size="1" style="width:100% !important;" > 
                    </select>
                   
                    <label for="grupo1" class="lblH2">Grupos Asignadas:</label>
                    <select class="grupo1" name="grupo1" id="grupo1" multiple="multiple" style="width:100% !important; height: 62% !important;" >
                    </select>
                    <span class="label label-large label-yellow arrowed pull-right" id="lbl01"></span>

               </div>
            </div>
        </div>

    </div>

    <div id="divAddNewGroup" class="modal fade " style = "height:400px !important;">
    </div><!-- /.modal -->

<script type="text/javascript">

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

            getNiveles( $("#nivel1"), $("#ciclo1") ); 

        }, "json"
    );  
}

function getNiveles(nivel,ciclo){
    var nc = "u="+localStorage.nc;
    nivel.empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:3, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                nivel.append('<option value="'+item.data+'"> '+item.label+'</option>');
            });

            getGpoNiv($("#grupo1"), ciclo );    

            getGrupos(ciclo );    

            
        }, "json"
    );  
}

function getGrupos(ciclo){
    var nc = "u="+localStorage.nc+"&idciclo="+ciclo.val();
    $.post(obj.getValue(0)+"data/", { o:1, t:4, p:0, c:nc, from:0, cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#grupo0").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl02").html(commaSeparateNumber(json.length)+" grupos")
            $("#preloaderPrincipal").hide();

            getGpoNiv( ciclo );

        }, "json"
    );  
}

$("#ciclo1").on("change",function(event){
    event.preventDefault();
    getGpoNiv( $("#grupo1"), $("#ciclo1") );
});


function getGpoNiv(grupo,ciclo){
    var nc = "u="+localStorage.nc+"&idciclo="+ciclo.val();
    grupo.empty();
    var y = $('select[name="nivel1"] option:selected').val(); 
    grupo.empty();
    $.post(obj.getValue(0)+"data/", {o:2, t:0, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
               grupo.append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            $("#lbl01").html(commaSeparateNumber(json.length)+" grupos")

        }, "json"
    );  
}

$("#chkAllGru").on("click",function(event){
    var checked =$(this).is(":checked")
    if (checked) {
        $("#grupo0 option").each(function(){
            $(this).prop('selected', true);
        });
    } else {
        $("#grupo0 option").each(function(){
            $(this).prop('selected', false);
        });
    }
});

$("#nivel1").on("change",function(event){
    event.preventDefault();
    getGpoNiv( $("#grupo1"), $("#ciclo1") );
});


$("#AddItem").on("click",function(event){
    $("#preloaderPrincipal").show();
    
    // Opciones asignadas a un determinado grupo
    var x = $('.grupo0 option:selected').val();  
    var y = $('select[name="nivel1"] option:selected').val(); 

    if (isDefined(x)){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".grupo0 option:selected").each(function () {
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

    $.post(obj.getValue(0)+"data/", { o:0, c:d, t:10, p:1, s:nc, from:0, cantidad:0 },
        function(json){
                $("#preloaderPrincipal").hide();
                getGpoNiv( $("#grupo1"), $("#ciclo1") );
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                // getGpoNiv( $("#ciclo1") );
                // $("#preloaderPrincipal").hide();
    }, "json");
});

$("#DeleteItem").on("click",function(event){
    $("#preloaderPrincipal").show();

    var x = $('.grupo1 option:selected').val();  
    
    if (isDefined(parseInt(x))){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".grupo1 option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    
    //alert(x);
    var nc = "u="+localStorage.nc;

    $.post(obj.getValue(0)+"data/", { o:0, c:x, t:20, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            //alert(json[0].msg)
            $("#preloaderPrincipal").hide();
            getGpoNiv( $("#grupo1"),$("#ciclo1") );
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                // getGpoNiv( $("#ciclo1") );
                // $("#preloaderPrincipal").hide();
    }, "json");
});

getCiclos();

</script>



