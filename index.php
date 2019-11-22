<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

/**
 * Rota padrão para index
*/
$app->get('/', function() {

    $page = new Page();

    $page->setTpl("index");

});
/**
 * Rota padrão para admin
 */

$app->get('/admin', function() {

    $page = new PageAdmin();

    $page->setTpl("index");

});

/**
 * Rota padrão para login admin
 */
$app->get('/admin/login', function() {

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("login");

});
/**
 * Rota padrão para login admin via post
 */
$app->post('/admin/login', function() {

    User::login($_POST["login"],$_POST["password"]);
    header("Location: /admin");
    exit;

});
$app->run();

 ?>