<?php


	require_once("../oCentura.php");
	$f = oCentura::getInstance();


	$user = $_POST["u"];
	if (isset($user) ){
	
	    $arr = $f->getQuerys(31009,"u=".$user."&sts=0"); 

		foreach($arr as $i=>$value){

/*
            $idnota  = $arr[$i]->idnota;
            $titulo = $arr[$i]->titulo;
            $seccion = $arr[$i]->seccion;
            $arr[$i]->url  = $Q->getDataURLNota03($idnota,$titulo,$seccion);
            $arr[$i]->urlSec = $Q->getDataURLOther($Q,"",0,$seccion,1);
            $arr[$i]->tituloSec = strtoupper($seccion);                        
            $arr[$i]->img = $arr[$i]->image; 
            $arr[$i]->fecha = $Q->getBFecha($arr[$i]->fecha,$arr[$i]->hora,6);
            $arr[$i]->comentarios = $f->getStatNote($idnota,1,1);
*/


		}

		$m = json_encode($arr);

		echo $m;
	}

?>
