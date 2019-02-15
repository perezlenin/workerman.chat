<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;

require_once __DIR__ . '/../../vendor/autoload.php';

/*WORKER DB*/
// use Workerman\Worker;
$task_worker = new Worker('Text://0.0.0.0:12345');
// Many processes.
$task_worker->count = 100;
$task_worker->name = 'dbWorker';
$task_worker->onMessage = function($connection, $task_data) {
	// var_dump("conectado a la base de datos");
    $task_data = json_decode($task_data);
    // var_dump($task_data);
    // Simulate sending mail or mysql operation etc.
    // sleep(1);
    // Send result.
	$host = '127.0.0.1';
    $db   = 'socketh';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    try {
         $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
         throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
    $stmt = $pdo->prepare($task_data->query);
    $stmt->execute();
    $data = $stmt->fetchAll();
    // var_dump($data);
    $connection->send(json_encode($data));
};
/** END WORKER DB*/


// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = 'ChatBusinessWorker';
// bussinessWorker进程数量
$worker->count = 4;
// 服务注册地址
$worker->registerAddress = '127.0.0.1:1236';

$worker->onWorkerStart = function($worker)
{

    // global $db;
    // $db = new \Workerman\MySQL\Connection('localhost', '3306', 'root', '', 'socketh');
    // $connection->send(json_encode($all_tables));


 //    try {
	//     $async_mysql = new \Jenner\Mysql\Async();
	//     $promise_1 = $async_mysql->attach(
 //            ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'socketh','port' => 3306],
 //            'call sandbox();'
 //        );
 //        $promise_1->then(
 //            function ($data) {
 //                echo 'sucess:' . var_export($data, true) . PHP_EOL;
 //            },
 //            function ($info) {
 //                echo "error:" . var_export($info, true);
 //            }
 //        );
 //        $promise_2 = $async_mysql->attach(
 //            ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'socketh'],
 //            'select * from read1 limit 0, 3'
 //        );
 //        $promise_2->then(
 //            function ($data) {
 //                echo 'sucess:' . var_export($data, true) . PHP_EOL;
 //            },
 //            function ($info) {
 //                echo "error:" . var_export($info, true);
 //            }
 //        );
 //        $async_mysql->execute();
	// } catch (Exception $e) {
	//     echo $e->getMessage();
	// }


	// global $pdo;

	// $host = '127.0.0.1';
	// $db   = 'socketh';
	// $user = 'root';
	// $pass = '';
	// $charset = 'utf8mb4';

	// $options = [
	//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	//     PDO::ATTR_EMULATE_PREPARES   => false,
	// ];
	// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	// try {
	//      $pdo = new PDO($dsn, $user, $pass, $options);
	// } catch (\PDOException $e) {
	//      throw new \PDOException($e->getMessage(), (int)$e->getCode());
	// }

};
// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}

