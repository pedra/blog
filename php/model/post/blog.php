<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Post;
use Lib\Start\Db\Conn as DB;

/**
 * Description of blog
 *
 * @author Bill Rocha <prbr@ymail.com at http://billrocha.tk>
 */
class Blog {
    
        function listArticles(){
        $db = new DB();
        $db->query('SELECT *, USER.ID UID FROM POST, USER WHERE USER.ID = POST.AUTOR ORDER BY DATA DESC LIMIT 10');
        
        //Criando a listagem
        $o = '';
        foreach($db->getLine() as $v){            
            $o .= '<div title="'.$v->TITULO.'" class="posts">'
                    . '<h2><a href="'.URL.$v->ANO.'/'.$v->MES.'/'.$v->LINK.'">'.$v->TITULO.'</a></h2>'
                    . '<blockquote>'.$v->RESUMO.'</blockquote>'
                    . '<div class="info">Postado por <b><a href="'.URL.'user/'.$v->UID.'">'.$v->NOME.'</a></b> em '.date('d/m/Y - H:i', strtotime($v->DATA)).'hm</div>'
                    . '</div>';
        }
        return $o;
        
    }
    
    
    function getArticleList($ano = 0, $mes = 0){
        //formatando
        $ano = 0 + $ano;
        $mes = 0 + $mes;
        
        $db = new DB();
        $select = 'SELECT * FROM POST WHERE ';
        $by = ' ORDER BY DATA LIMIT 10';
        //somente ano informado ou válido
        if($ano > 0 && $mes == 0) 
            $db->query($select . 'ANO = :ano' . $by, array('ano'=>$ano));
        //Ano e mes
        if($ano > 0 && $mes > 0) 
            $db->query($select . 'ANO = :ano AND MES = :mes' . $by, array('ano'=>$ano, 'mes'=>$mes));        
        
        //Criando a listagem
        $o = '';
        foreach($db->getLine() as $v){            
            $o .= '<div title="'.$v->TITULO.'"><a href="'.URL.$v->ANO.'/'.$v->MES.'/'.$v->LINK.'">'
                    . '<h2>'.$v->TITULO.'</h2>'
                    . '<blockquote>'.$v->RESUMO.'</blockquote>'
                    . '</a></div>';
        }
        return $o;        
    }
    
    
    function getArticleByLink($ano, $mes, $link){
        //formatando
        $ano = 0 + $ano;
        $mes = 0 + $mes;
        $link = trim($link);
        
        $db = new DB();
        
        $db->query('SELECT *, USER.ID UID FROM POST, CONTEUDO, USER
                        WHERE ANO = :ano
                          AND MES = :mes
                          AND LINK = :link
                          AND CONTEUDO.ID = POST.ID                          
                          AND USER.ID = POST.AUTOR
                        LIMIT 1', array('ano'=>$ano, 'mes'=>$mes, 'link'=>$link));
        $row = $db->getLine(0);
        if($row){
            return '<h1>'.$row->TITULO.'</h1>'
                    . '<div class="info">Postado por <b><a href="'.URL.'user/'.$row->UID.'">'.$row->NOME.'</a></b> em '.date('d/m/Y - H:i', strtotime($row->DATA)).'hm</div>'                    
                    . '<blockquote>'.$row->RESUMO.'</blockquote>'
                    . '<div class="content">'.$row->TEXTO.'</div>';            
        }
        return false;
    }
    
    function getArticleById($id){
        //formatando
        $id = 0 + $id;
        
        $db = new DB();        
        $db->query('SELECT *, USER,ID UID FROM POST, CONTEUDO, USER
                        WHERE POST.ID = :id
                          AND CONTEUDO.ID = POST.ID
                          AND USER.ID = POST.AUTOR
                        LIMIT 1', array('id'=>$id));
        $row = $db->getLine(0);
        if($row){
            return '<h1>'.$row->TITULO.'</h1>'
                    . '<div class="info">Postado por <b><a href="'.URL.'user/'.$row->UID.'">'.$row->NOME.'</a></b> em '.date('d/m/Y - H:i', strtotime($row->DATA)).'hm</div>'                    
                    . '<blockquote>'.$row->RESUMO.'</blockquote>'
                    . '<div class="content">'.$row->TEXTO.'</div>';            
        }
        return false;        
    }
    
}
