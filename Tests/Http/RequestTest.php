<?php
use PHPUnit\Framework\TestCase;
use Niga\Framework\Application\App;
use GuzzleHttp\Psr7\ServerRequest as ServerRequest;
use Niga\Framework\Http\Response;
use Niga\Framework\Http\Request as HttpRequest;

class RequestTest extends TestCase
{
    
    public function setUp(): void
    {
        $this->app = new App(ServerRequest::fromGlobals(), dirname(__DIR__, 5), ["db" => []]);
    }
    
    /**
     * @test
     */
    public function requestMethods()
    {
        $this->isPost();
        $this->isGet();
    }
    
    public function isPost()
    {
        $request = new HttpRequest((new ServerRequest("POST", "/")));
        $this->assertTrue($request->isPost());
      
        $request = new HttpRequest((new ServerRequest("GET", "/")));
        $this->assertFalse($request->isPost());
    }
    
    public function isGet()
    {
        $request = new HttpRequest((new ServerRequest("GET", "/")));
        $this->assertTrue($request->isGet());
      
        $request = new HttpRequest((new ServerRequest("POST", "/")));
        $this->assertFalse($request->isGet());
    }
}
