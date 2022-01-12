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

    public function __construct(String $css_directory, String $js_directory) {
        $this->css_directory = $css_directory ;
        $this->js_directory = $js_directory ;
    }

    public function getCss(){
        $path = realpath($this->css_directory);
        $fileList = glob($path.'/*');
        header('Content-type: text/css');
        $str = '';
        foreach($fileList as $filename){
            $str .= file_get_contents($filename);
        }
        echo $str;
    }

    public function getJs(){
        $path = realpath($this->js_directory);
        $fileList = glob($path.'/*');
        header('Content-type: text/plain');
        $str = '';
        foreach($fileList as $filename){
            $str .= file_get_contents($filename);
        }
        echo $str;
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