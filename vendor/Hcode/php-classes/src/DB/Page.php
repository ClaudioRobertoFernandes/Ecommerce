<?php

namespace Hcode;

use Rain\Tpl;

class Page
{
    private $tpl;
    private $options = [];
    private $defaults = ["data"=>[]];

    public function __construct($opts = array())
    {
        // TODO: Implement __destruct() method.

        $this->options = array_merge($this->defaults,$opts);

        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false // set to false to improve the speed
        );

        Tpl::configure( $config );
        $this->tpl  = new Tpl;

       $this->setData($this->options["data"]);

        $this->tpl->draw("header");

//        if ($this->options['data']) $this->setData($this->options['data']);
//        if ($this->options['header'] === true) $this->tpl->draw("header", false);

    }

    /**
     * Dados do Conteudo da pagina
    */
    private function setData($data = array())
    {
        foreach ($data as $key => $value){

            $this->tpl->assign($key,$value);

        }
    }

    public function setTpl($name, $data = array(),$returnHTML = false)
    {

        $this->setData($data);

        return $this->tpl->draw($name, $returnHTML);

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.

        $this->tpl->draw("footer");

    }

}

?>