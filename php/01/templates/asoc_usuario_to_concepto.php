    <div class="row">

        <div class="span4">
            <div class="panel panel-success">
              <div class="panel-heading">Emisor Fiscal</div>
              <div class="panel-body" style="height: 35em !important; ">

                    <select name="selEmiFis01" id="selEmiFis01" size="1" style="width:100% !important;" > 
                    </select>

                    <select class="IdConcepto " name="IdConcepto" id="IdConcepto" multiple="multiple" style="width:100% !important; height: 92% !important; margin-bottom:1.5em !important;" > 
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
              <div class="panel-heading">Usuarios</div>
              <div class="panel-body" style="height: 35em !important; ">

                    <label for="IdUsuario" class="lblH2cmb">Usuarios </label>
                    <select name="IdUsuario" id="IdUsuario" size="1" style="width:100% !important;" > 
                    </select>
                   
                    <label for="escenario01" class="lblH2cmb">Escenario </label>
                    <select name="escenario01" id="escenario01" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="lstConceptUser01" class="lblH2">Conceptos Asignados:</label>
                    <select class="lstConceptUser01" name="lstConceptUser01" id="lstConceptUser01" multiple="multiple" style="width:100% !important; height: 64% !important; margin-bottom:1.5em !important;" >
                    </select>
                    <span class="label label-large label-yellow arrowed pull-right" id="lbl01"></span>

               </div>
            </div>
        </div>

    </div>

    <div id="divAddNewGroup" class="modal fade " style = "height:400px !important;"></div>

<script type="text/javascript">
var init = true;

function getEmiFis(){
    var nc = "u="+localStorage.nc;
    $("#selEmiFis01").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:26, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#selEmiFis01").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            getConceptos();    
        }, "json"
    );  
}

function getConceptos(){
    var idemifis = $("#selEmiFis01").val().split('-');
    var nc = "u="+localStorage.nc+"&idemisorfiscal="+idemifis[0];
    $("#IdConcepto").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:10020, p:11,c:nc,from:0,cantidad:0, s:"idconcepto" },
        function(json){
            var nc;
           $.each(json, function(i, item) {
                $("#IdConcepto").append('<option value="'+item.idconcepto+'"> '+item.concepto+'</option>');
            });
            $("#lbl02").html(commaSeparateNumber(json.length)+" Concepto(s)")
            $("#preloaderPrincipal").hide();
            
            // getUsuarios();

            // getConceptUsers();

        }, "json"
    );  
}

function getUsuarios(){
    var nc = "u="+localStorage.nc;
    $("#IdUsuario").empty();
    $("#lstConceptUser01").empty();

    $.post(obj.getValue(0)+"data/", { o:51, t:-6, p:55,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#IdUsuario").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });

            getEscenarios();
        
        }, "json"
    );  
}

function getEscenarios(){
    var nc = "u="+localStorage.nc;
    $("#escenario01").empty();

    $.post(obj.getValue(0)+"data/", { o:51, t:76, p:55,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                var cls = i == 0 ? ' selected ':'';
                $("#escenario01").append('<option value="'+item.iduserconceptoescenario+'" '+cls+'> '+item.escenario+'</option>');
            });

            getConceptUsers();
        
        }, "json"
    );  
}


function getConceptUsers(ciclo){
    var nc = "u="+localStorage.nc+"&idusuario="+$("#IdUsuario").val()+"&escenario="+$("#escenario01").val();
    $("#lstConceptUser01").empty();
    $.post(obj.getValue(0)+"data/", {o:51, t:77, p:54,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#lstConceptUser01").append('<option value="'+item.idusuarioconceptopago+'"> '+item.concepto+'</option>');
            });
            $("#lbl01").html(commaSeparateNumber(json.length)+" Concepto(s)")

        }, "json"
    );  
}

$("#chkAllAlu01").on("click",function(event){
    var checked =$(this).is(":checked")
    if (checked) {
        $("#IdConcepto option").each(function(){
            $(this).prop('selected', true);
        });
    } else {
        $("#IdConcepto option").each(function(){
            $(this).prop('selected', false);
        });
    }
});

$("#selEmiFis01").on("change",function(event){
    event.preventDefault();
    getConceptos();
});

$("#IdUsuario, #escenario01").on("change",function(event){
    event.preventDefault();
    getConceptUsers();
});


$("#AddItem").on("click",function(event){
    $("#preloaderPrincipal").show();
    
    // Opciones asignadas a un determinado alumno
    var x = $('.IdConcepto option:selected').val();  
    var y = $('select[name="IdUsuario"] option:selected').val(); 
    var z = $('select[name="escenario01"] option:selected').val(); 

    if (isDefined(x)){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".IdConcepto option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    if (isDefined(parseInt(y)) || y <= 0){
        $("#preloaderPrincipal").hide();
        alert("Seleccione un elemento");
        return false;
    }

    var nc = "u="+localStorage.nc+"&IdConceptos="+x+"&IdUsuario="+y+"&escenario="+z;


    $.post(obj.getValue(0)+"data/", { o:52, c:nc, t:10, p:53, s:nc, from:0, cantidad:0 },
        function(json){
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                getConceptUsers(  $("#ciclo1")  );
                $("#preloaderPrincipal").hide();
    }, "json");
});

$("#DeleteItem").on("click",function(event){
    $("#preloaderPrincipal").show();

    var x = $('.lstConceptUser01 option:selected').val();  
    
    if (isDefined(parseInt(x))){
        $("#preloaderPrincipal").hide();
        alert("Seleccione una opción disponible");
        return false;
    }else{
        x='';
        $(".lstConceptUser01 option:selected").each(function () {
                x += $(this).val() + "|";
          });

    }
    
    var nc = "u="+localStorage.nc+"&IdConceptos="+x;

    $.post(obj.getValue(0)+"data/", { o:52, c:nc, t:20, p:53, s:nc, from:0, cantidad:0 },
        function(json){
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                getConceptUsers( $("#ciclo1") );
                $("#preloaderPrincipal").hide();
    }, "json");
});

getEmiFis();
getUsuarios();

</script>



