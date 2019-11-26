<?php

namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model
{

    public static function login($login, $password)
    {

        $sql = new Sql();

        $results = $sql->select("select * from tb_users where deslogin = :LOGIN", array(":LOGIN" => $login));


        if (count($results) === 0) {

            throw new \Exception("Usuário Inexistente ou Senha Inválida", 1);

        }

        $data = $results[0];

        if (password_verify($password, $data["despassword"]) === true) {

            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getValues();

        } else {

            throw new \Exception("Usuário Inexistente ou Senha Inválida", 1);

        }

    }
    public static function verifyLogin($inadmin = true)
    {
        if (!isset($_SESSION[User::SESSION])
            || !$_SESSION[User::SESSION]
            || !(int)$_SESSION[User::SESSION]["iduser"] > 0
            || (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin

        ){
            header("location: /admin/login");
            exit;
        }

    }

    public static function logout(){
        $_SESSION[User::SESSION] = null;
    }

    public static function listAll(){

        $sql = new Sql();

       return $sql->select("select * from tb_users a inner join tb_persons b using(idperson) order by b.desperson");

    }

//    public function get()
//    {
//        $sql = new Sql();
//
//        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser;", array(
//        ":iduser"=>$iduser
//    ));
//
//        $data = $results[0];
//
//        $this->setData($data);
//
//    }

}

?>