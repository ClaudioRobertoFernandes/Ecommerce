<?php
namespace Hcode;

class Model
{
    private $values = [];

    /**
     * @return array
     */
    public function __call($name, $args)
    {

        $method = substr($name, 0, 3);

        $fieldName = substr($name, 3, strlen($name));

//        var_dump($method,$fieldName);
        switch ($method) {

            case "get":
                return $this->values[$fieldName];
                break;

            case "set":
                $this->values[$fieldName] = $args[0];
                break;
                /**
                 * Parei aos 22m da aula 104 admin login
                */
        }

    }
}

?>