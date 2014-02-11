<?php


class Main {

    function index($ano = 0, $mes = 0, $link = '') {
        $ano = 0 + $ano;
        if(trim($link) != '') return $this->post($ano, $mes, $link);
        
        //Sem argumentos?? Mostra página ComingSoon
        if($ano == 0) return (new View('comingsoon'))->render(false);
        
        //Pegando a lista de postagens
        $posts = (new Model\Post\Blog())->getArticleList($ano, $mes, $link);        
        if($posts == '') $posts = 'Nenhuma postagem encontrada.';
        
        //Renderiza com zTag & Razor e retorna o HTML composto 
        return (new View('post/layout'))
                ->assign('content', $posts)
                ->render(false);
    }

    function post($ano = 0, $mes = 0, $link = '') {
        //Pegando a postage, se existe
        $blog = new Model\Post\Blog();
        $post = $blog->getArticleByLink($ano, $mes, $link);
        if($post == false) $post = $blog->getArticleById($ano);
        
        return (new View('post/layout'))
                ->assign('content', $post)
                ->render(false);
    }

    function erro() {
        //Mostra a view de ERRO 404
        return (new View('404'))->render(false);
    }

}
