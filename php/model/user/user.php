<?php
namespace Model\User;
use Start\Db\Conn as DB;
/**
 * Description of user
 *
 * @author Bill Rocha <prbr@ymail.com at http://billrocha.tk>
 */
class User {
    
    function getAllUsers(){
        
        $db = new DB();        
        $db->query('SELECT * FROM USER, USERCAD
                        WHERE USERCAD.ID = USER.ID');
        $row = $db->getLine();
        $o = '';
        if($row){
            foreach($row as $r) {
            $o .= '<a href="'.URL.'user/'.$r->ID.'" class="users">'
                    . '<img src="'.URL.'asset/user/'.$r->ID.'.jpg"/>'
                    . '<div><h2>'.$r->NOME.'</h2>'
                    . '<p>Email: '.$r->EMAIL.' | Site: '.$r->SITE.'</p></div></a>';            
            }
        }
        return $o; 
        
    }
    
    function getUserById($id){
        //formatando
        $id = 0 + $id;
        
        $db = new DB();        
        $db->query('SELECT * FROM USER, USERCAD
                        WHERE USER.ID = :id
                          AND USERCAD.ID = USER.ID
                        LIMIT 1', array('id'=>$id));
        $row = $db->getLine(0);
        if($row){
            return '<img src="'.URL.'asset/user/'.$row->ID.'.jpg"/>'
                    . '<h1>'.$row->NOME.'</h1>'
                    . '<p>Email: '.$row->EMAIL.'</p>'
                    . '<p>Site: '.$row->SITE.'</p>'
                    . '<div class="sobre">'
                    . '<h3>Apresentação</h3>'.$row->SOBRE.'</div>';            
        }
        return false;        
    }
    
    //Loga um usuário
    function login($login, $senha){
        $db = new DB();
        $db->query('SELECT * FROM USER '
                . 'WHERE LOGIN = :login '
                . 'AND SENHA = :senha', array('login'=>$login, 'senha'=>md5($senha)));
        
        $row = $db->getLine(0);
        if($row){
            if(session_id() === '') session_start();
            //Gravando na session
            $_SESSION['user']['id'] = $row->ID;
            $_SESSION['user']['nivel'] = $row->NIVEL;
            $_SESSION['user']['nome'] = $row->NOME;
            return true;
        }
        return false;
        
    }
}
