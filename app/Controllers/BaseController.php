<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['url', 'form', 'html'];
    protected $data = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Set data umum untuk semua view
        $this->data['title'] = 'WebGIS Kriminalitas';
        $this->data['user'] = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'avatar' => 'assets/img/undraw_profile.svg'
        ];
    }
}