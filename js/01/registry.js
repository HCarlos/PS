// JavaScript Document Registry


$("#frmForgotPassword").on("submit", function(event) {
	event.preventDefault();
	var queryString = $(this).serialize();
	$.post(obj.getValue(0) + "setForgotPassword/", {
			data: queryString
		},
		function(json) {
			if (json[0].msg == "OK") {
				alert("Se ha enviado la instrucción para recuperar su password.\n\n Revise su correo incluyendo su bandeja de correo no deseado y siga las instrucciones.");
				window.location.href = obj.getValue(0);
			} else {
				alert(json[0].msg);
			}

		}, "json");
});

$("#frmLogin").on("submit", function(event) {
	event.preventDefault();
	var queryString = $(this).serialize();
	$.post(obj.getValue(0) + "getLoginUser/", {
			data: queryString
		},
		function(json) {
			//alert(json[0].msg);
			if (json[0].msg == "OK") {
				if (!sessionStorage.Id || (sessionStorage.Id !== json[0].data)) {
					sessionStorage.Id = json[0].data;
					sessionStorage.name = json[0].label;
					localStorage.nc = json[0].label;
					var xim = json[0].data.split('|');
					localStorage.IdUser = parseInt(xim[0]);

				    var stream = io.connect(obj.getValue(4));
				    stream.emit("cliente", {mensaje: "PLATSOURCE-CONECTADO-"+localStorage.IdUser+"-"+localStorage.nc });
					localStorage.IdEmp = parseInt(xim[2]);
					localStorage.Empresa = xim[3];
					localStorage.IdUserNivelAcceso = parseInt(xim[4]);
					localStorage.TRPP = parseInt(xim[5]); //registrosporpagina
					//alert(localStorage.IdUserNivelAcceso);
					if (parseInt(localStorage.IdUserNivelAcceso,0) <= 100){
						localStorage.ClaveNivelAcceso = parseInt(xim[6])==null?0:parseInt(xim[6]);
					}else{
						localStorage.ClaveNivelAcceso = 0;
					}
					localStorage.Param1 = xim[7] == ''?'0':xim[7]; //param1
					obj.setIdUser(localStorage.IdUser, localStorage.nc);
					// stream = null;
					
					$.getUserConnect();

				}else{
					
					$.getUserConnect();

				}
               


			} else {
				alert(json[0].msg);

			}
		}, "json");

		$.getUserConnect = function(){
			if ( parseInt(localStorage.IdUser,0) == 2 ){
				// alert("Claudia: Muchas Feliciades!!! que cumplas muchos años mas de feliz existencia rodeada siempre de tus seres queridos... @DevCH");
			}
			
			trackOutboundLink(localStorage.IdUser+'-'+localStorage.nc);

            $.post(obj.getValue(0) + "data/", {o:49, t:0, p:52, c:"u=" + localStorage.nc, from: 0, cantidad: 0, s: ""},
            function(json) {
            	if ( parseInt(localStorage.IdEmpresaHome) > 0  ){
	                window.location.href = obj.getValue(0) + "dashboard/"+localStorage.IdEmpresaHome+"/";
            	}else{
	                window.location.href = obj.getValue(0) + "dashboard/0/";
            	}
            }, "json");
		}


});



