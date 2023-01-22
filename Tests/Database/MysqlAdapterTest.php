<?php
use PHPUnit\Framework\TestCase;
use Niga\Framework\Application\App;
use GuzzleHttp\Psr7\ServerRequest as Request;
use Niga\Framework\Http\Response;
use Niga\Framework\Database\Adapter\MysqlAdapter;

class MysqlAdapterTest extends TestCase
{

  public function setUp(): void
  {
    $params = ["connection" => [
      'host' => 'localhost',
      'port' => '3306',
      'username' => 'root',
      'password' => '',
      'database' => 'test',
      'charset' => 'utf8',
    ]];
    
    $this->db = new MysqlAdapter($params);
  }

  /**
  * @test
  */
  public function mysqlConnection() {
    $this->assertInstanceOf(\PDO::class, $this->db->connect());
  }

}