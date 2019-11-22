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

            $user->setiduser($data["iduser"]);

        } else {

            throw new \Exception("Usuário Inexistente ou Senha Inválida", 1);

        }

    }

}

?>