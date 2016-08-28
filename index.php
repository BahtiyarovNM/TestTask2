<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);
/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 * php -S localhost:8888 -t example example/index.php
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
require 'composer/vendor/autoload.php';

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */

$app = new Slim\App();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 *
 */


$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome my to Test site!");
    return $response;
});

$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');

$app->get('/api/orders', 'test');
$app->get('/api', function () {
    first();

});

$app->post('/test', function () use ($app) {
    //   echo "Все норм";
    $d = $this->request->getBody();
    //$data=json_decode($d,true);
    $de = json_decode($d);
    /*$response = 'Получено параметров '.count($data);
    foreach ($data as $key=>$value) {
        $response .= 'Параметр: '.$key.'; Значение: '.$value;
    }*/
//    echo $response;
    addUser($de);

    // echo $de->firstName;


});


/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();


function first()
{
    echo "Включать в КРАЙНЕМ случае. Убьет все живое. Сам не понимаю что творится.Потому что аякс";
    include 'table.html';
    include 'test.php';
}

function test()
{
    //  include_once "action_ajax_form.php";
    include 'boottest.html';
}

function addUser($user)
{


    $sql = "REPLACE INTO users (firstname, lastname, middlename, date, inn, type) VALUES (:fn, :ln, :mn, :date, :inn, :type)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fn", $user->firstName);
        $stmt->bindParam("ln", $user->lastName);
        $stmt->bindParam("mn", $user->middleName);
        $stmt->bindParam("date", $user->date);
        $stmt->bindParam("inn", $user->inn);
        $stmt->bindParam("type", $user->type);
        $stmt->execute();

        $db = null;
//        echo json_encode($user);
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getConnection()
{
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "123";
    $dbname = "TestDB";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
