<?php
namespace application\dao;

use dao\Connection;
use PDO;


final class Login
{

    function  getLogin($email,$password){
        $sql= ("SELECT * FROM user WHERE userEmail = :email AND userSenha = :password;");
        $result= Connection::getInstance(); 
        $stmt = $result->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':email'=>$email,':password'=>md5($password)));
        $select = $stmt->fetchAll( PDO::FETCH_ASSOC );
        return $select;
    }
}

