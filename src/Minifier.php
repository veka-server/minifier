<?php

namespace VekaServer\Minifier;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Minifier implements MiddlewareInterface
{

    private $css_directory ;
    private $js_directory ;
    private $cacheTime ;

    public function __construct(String|array $css_directory, String|array $js_directory, int $cacheTime = 0) {
        $this->css_directory = is_array($css_directory) ? $css_directory : [$css_directory] ;
        $this->js_directory = is_array($js_directory) ? $js_directory : [$js_directory] ;
        $this->cacheTime = $cacheTime ;
    }

    public function getCss(){

        if($this->cacheTime > 0 ){
            header('Pragma: cache');
            header('Cache-Control: max-age='.$this->cacheTime);
        }
        
        header('Content-type: text/css');
        foreach ($this->css_directory as $path){
            if(empty($path)){
                continue;
            }
            $path = realpath($path);
            $fileList = glob($path.'/*.css');
            $str = '';
            foreach($fileList as $filename){
                $str .= file_get_contents($filename).PHP_EOL.PHP_EOL;
            }
            
            if(isset($_GET['version']) && !empty($_GET['version'])){
                $str=str_replace('--version--', $_GET['version'], $str);
            }
            
            echo $str;
        }
    }

    public function getJs(){

        if($this->cacheTime > 0 ){
            header('Pragma: cache');
            header('Cache-Control: max-age='.$this->cacheTime);
        }
        
        header('Content-type: text/plain');
        foreach ($this->js_directory as $path){
            if(empty($path)){
                continue;
            }
            $path = realpath($path);
            $fileList = glob($path.'/*.js');
            $str = '';
            foreach($fileList as $filename){
                $str .= file_get_contents($filename).PHP_EOL.PHP_EOL;
            }
            echo $str;
        }
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        switch($request->getUri()->getPath()){
            case '/css':
                $this->getCss();
                die();
            case '/js':
                $this->getJs();
                die();
        }

        $response = $handler->handle($request);

        return $response;
    }
}
