<?php 
session_start();

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
    User::verifyLogin();
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

$app->get('/admin/logout', function() {

    User::logout();

    header("Location: /admin/login");
    exit;
});
/**
 * Rota padrão para login admin via post
 */
$app->post('/admin/login', function() {

    User::login($_POST["login"],$_POST["password"]);
    header("Location: /admin");
    exit;

});
/**
 * A funcionalidade de Criptografia ainda nã esta funcionando
 * até este momento mas nas proximas aulas será implementada
*/
$app->get("/admin/users/create", function () {

    User::verifyLogin();

    $user = new User();

    $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

    $_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

        "cost"=>12

    ]);

    $user->setData($_POST);

    $user->save();

    header("Location: /admin/users");
    exit;

});

$app->get("/admin/users", function () {

    User::verifyLogin();

    $users = User::listAll();

    $page = new PageAdmin();

    $page->setTpl("users", array("users"=>$users));

});

$app->get("/admin/users/:iduser", function ($iduser) {

    User::verifyLogin();

//    $user = new User();

//    $user->get((int)$iduser);

    $page = new PageAdmin();

//    $page->setTpl("users-update",array("user"=>$user->getValues()));

});

$app->post("/admin/users/create", function () {

    User::verifyLogin();

});

$app->get("/admin/users/:iduser/delete", function ($iduser) {

    User::verifyLogin();

});

$app->post("/admin/users/:iduser", function ($iduser) {

    User::verifyLogin();

});

$app->run();

?>