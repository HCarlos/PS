    <div class="row">

        <div class="span4">
            <div class="panel panel-success">
              <div class="panel-heading">Grupos</div>
              <div class="panel-body" style="height: 35em !important; ">

                    <label for="ciclo0" class="lblH2cmb">Ciclo </label>
                    <select name="ciclo0" id="ciclo0" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="nivel0" class="lblH2cmb">Nivel </label>
                    <select name="nivel0" id="nivel0" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="grupo0" class="lblH2cmb">Grupo Origen </label>
                    <select name="grupo0" id="grupo0" size="1" style="width:100% !important;" > 
                    </select>

                    <select class="lstGrupos " name="alumno0" id="alumno0" size="10" style="width:100% !important; height: 53% !important;" multiple> 
                    </select>

               </div>

                <span class="label label-large label-yellow arrowed-right pull-left lbl00" id="lbl01" ></span>
        
            </div>
        </div>

        <div class="span2">
            <div class="panel panel-default"  style="height: 38em;">
                <div class="panel-body" style="padding-top: 12em;">
                        <button id="AddItem" name="btnAsig" class="btnAsig btn btn-primary btn-lg" >
                            Copiar a <span class="glyphicon glyphicon-chevron-right"></span></button><br/><br/>
                </div>
            </div>
             <div class="div1em"></div>
        </div>

        <div class="span4">
            <div class="panel panel-primary">
                <div class="panel-heading">Niveles</div>
                <div class="panel-body" style="height: 35em !important; ">

                    <label for="ciclo1" class="lblH2cmb">Ciclo </label>
                    <select name="ciclo1" id="ciclo1" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="nivel1" class="lblH2cmb">Nivel </label>
                    <select name="nivel1" id="nivel1" size="1" style="width:100% !important;" > 
                    </select>

                    <label for="grupo1" class="lblH2cmb">Grupo Destino </label>
                    <select name="grupo1" id="grupo1" size="1" style="width:100% !important;" > 
                    </select>

                    <select class="lstGrupos2 " name="alumno1" id="alumno1" size="10" style="width:100% !important; height: 53% !important;" multiple> 
                    </select>

                </div>
                <span class="label label-large label-yellow arrowed-right pull-left lbl00" id="lbl02"></span>
                
            </div>
        </div>

    </div>

    <div id="divAddNewGroup" class="modal fade " style = "height:400px !important;">
    </div><!-- /.modal -->

<script type="text/javascript">
var init = true;

function getCiclos(){
    var nc = "u="+localStorage.nc;
    $("#ciclo0").empty();
    $("#ciclo1").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:2, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
            var pred = "";
           $.each(json, function(i, item) {
                pred = item.predeterminado == 1 ? ' selected ': ' ';
                $("#ciclo0").append('<option value="'+item.data+'" ' + pred + '> '+item.label+'</option>');
                $("#ciclo1").append('<option value="'+item.data+'" ' + pred + '> '+item.label+'</option>');
            });

            getNiveles(); 

        }, "json"
    );  
}

function getNiveles(){
    var nc = "u="+localStorage.nc;
    $("#nivel0").empty();
    $("#nivel1").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:3, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
           $.each(json, function(i, item) {
                $("#nivel0").append('<option value="'+item.data+'"> '+item.label+'</option>');
                $("#nivel1").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            getGpoNiv( $('select[name="nivel0"] option:selected'),$("#grupo0"), $("#ciclo0"), 0 );
            getGpoNiv( $('select[name="nivel1"] option:selected'),$("#grupo1"), $("#ciclo1"), 1 );
        }, "json"
    );  
}

function getGpoNiv(obj0,obj1,ciclo,obj2){
    var nc = "u="+localStorage.nc+"&idciclo="+ciclo.val();
    obj1.empty();
    var y = obj0.val(); 
    obj1.empty();
    $.post(obj.getValue(0)+"data/", {o:1, t:6, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
               obj1.append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
           if (obj2==0){
                getAluGpo( $('select[name="grupo0"] option:selected'),$("#alumno0"), $("#ciclo0"), 0  );
            }
           if (obj2==1){
                getAluGpo( $('select[name="grupo1"] option:selected'),$("#alumno1"), $("#ciclo1"), 1  );
            }
                $("#preloaderPrincipal").hide();

        }, "json"
    );  
}


$("#nivel0").on("change",function(event){
    event.preventDefault();
    getGpoNiv( $('select[name="nivel0"] option:selected'),$("#grupo0"), $("#ciclo0"), 0 );
});

$("#nivel1").on("change",function(event){
    event.preventDefault();
    getGpoNiv( $('select[name="nivel1"] option:selected'),$("#grupo1"), $("#ciclo1"), 1 );
});

function getAluGpo(obj0,obj1,ciclo,oitem){
    var nc = "u="+localStorage.nc+"&idciclo="+ciclo.val();
    obj1.empty();
    var y = obj0.val(); 
    obj1.empty();

    if (oitem==0){ $("#lbl01").empty(); }
    else{ $("#lbl02").empty(); }

    $.post(obj.getValue(0)+"data/", {o:2, t:4, p:0,c:nc,from:0,cantidad:0, s:y },
        function(json){
           $.each(json, function(i, item) {
                obj1.append('<option value="'+item.data+'"> '+item.label+'</option>');
            });

           if (oitem==0){ $("#lbl01").html(commaSeparateNumber(json.length)+" alumnos"); }
           else{ $("#lbl02").html(commaSeparateNumber(json.length)+" alumnos"); }

        }, "json"
    );  
}

$("#grupo0, #ciclo0").on("change",function(event){
    event.preventDefault();
    getAluGpo( $('select[name="grupo0"] option:selected'), $("#alumno0"), $("#ciclo0"), 0 );
});

$("#grupo1, #ciclo1").on("change",function(event){
    event.preventDefault();
    getAluGpo( $('select[name="grupo1"] option:selected'), $("#alumno1"), $("#ciclo1"), 1 );
});



$("#AddItem").on("click",function(event){
    $("#preloaderPrincipal").show();
    
    // Opciones asignadas a un determinado grupo

    // var x = $('.lstGrupos option:selected').val();  

    var y = $('select[name="grupo0"] option:selected').val(); 
    var z = $('select[name="grupo1"] option:selected').val(); 

    if (isDefined(parseInt(y)) || y <= 0){
        $("#preloaderPrincipal").hide();
        alert("Seleccione un Grupo Origen");
        return false;
    }

    if (isDefined(parseInt(z)) || z <= 0){
        $("#preloaderPrincipal").hide();
        alert("Seleccione un Grupo Destino");
        return false;
    }

    // var d = x+'.'+y;
    var d = y;
    
    //alert(d);

    var nc = "u="+localStorage.nc+"&idgrupoorigen="+y+"&idgrupodestino="+z;

    // alert(nc);
    // return false;

    var o0 = $('.lstGrupos option:selected').text();
    
    var o1 = $('select[name="grupo0"] option:selected').val(); 
    var o2 = $('select[name="grupo1"] option:selected').val();

    var o3 = $('select[name="grupo0"] option:selected').text(); 
    var o4 = $('select[name="grupo1"] option:selected').text();

    // var r = confirm("Desea mover el alumno "+o0+" del grupo "+o3+" al grupo "+o4);
    var r = confirm("Desea copiar los alumnos del grupo "+o3+" al grupo "+o4+"?");
    
    if (!r){
        $("#preloaderPrincipal").hide();
        return false;
    }
    
    // alert(nc);
    // return false;
    
    $.post(obj.getValue(0)+"data/", { o:1, c:'', t:30, p:1, s:nc, from:0, cantidad:0 },
        function(json){
            //alert( json[0].msg);
            if (json.length<=0 && json[0].msg=="Error") { return false;}
                //getAluGpo( $('select[name="grupo0"] option:selected'),$("#alumno0") );
                getAluGpo( $('select[name="grupo1"] option:selected'), $("#alumno1"), $("#ciclo1"), 1 );
                $("#preloaderPrincipal").hide();
    }, "json");

});



getCiclos();

</script>



