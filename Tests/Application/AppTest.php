<?php
use PHPUnit\Framework\TestCase;
use Nigatedev\FrameworkBundle\Application\App;
use GuzzleHttp\Psr7\ServerRequest as Request;
use Nigatedev\FrameworkBundle\Http\Response;

class AppTest extends TestCase
{
    
    public function setUp(): void
    {
        $this->app = new App(Request::fromGlobals(), dirname(__DIR__, 5), ["db" => []]);
    }
    
    /**
     * @test
     */
    public function resolvePath()
    {
        $this->error404();
        $this->slash();
    }
    
    public function error404()
    {
        $req = new Request("GET", "/notfound404_");
        $res = $this->app->router->pathResolver($req);
        $this->assertEquals(404, $res->getStatusCode());
    }
    
    public function slash()
    {
        $req = new Request("GET", "/withslash_/");
        $res = $this->app->router->pathResolver($req);
        
        $this->assertEquals(301, $res->getStatusCode());
        $this->assertContains("/withslash_", $res->getHeader("Location"));
    }
}
