<?php
namespace Model;
/**
 * Description of session
 *
 * @author Bill
 */
class Session {
    
    static function setUser(User $user){
        
        exit('<pre>'.print_r($user, true).'</pre>');
        
    }
    
    
}
