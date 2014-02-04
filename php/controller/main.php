<?php

class Main{


	function index(){
		//Carrega o layout 
		$view = new View('layout');
        
        //Carrega a fatia superior do site
        $view->load('head')
                ->assign('title', 'Página Inicial');
        
        //carrega a página "/html/comingsoon.html"
        $view->load('comingsoon')
                ->assign('titulo', 'Coming Soon');
        
        //Carrega a fatia inferior do site
        $view->load('footer');
        
        //Renderiza com zTag & Razor e retorna o HTML composto 
        return $view->render(false);
	}

	function teste($arg = ''){
		//mostra a string na tela + argumento [ex.:  http://phps.tk/main/teste/argumento]
		return 'Main::teste('.$arg.')';
	}

	function erro(){
		//Mostra a view de ERRO 404
		return (new View('404'))->render(false);
	}

} 