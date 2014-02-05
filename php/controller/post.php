<?php
/**
 * Description of post
 *
 * @author Bill Rocha <prbr@ymail.com at http://billrocha.tk>
 */
class post {
    
    function index($id = 0){
        $id = 0 + $id;
        
        $blog = new Model\Post\Blog();
        
        if($id > 0) $post = $blog->getArticleById($id);
        else $post = $blog->listArticles();
        
        return (new View('post/layout'))
                ->assign('content', $post)
                ->render(false);
    }
}
