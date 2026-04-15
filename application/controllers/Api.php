<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
    }

    public function index()
    {
        echo json_encode([
            'status' => 'success',
            'message' => 'API CodeIgniter + Vue funcionando',
            'version' => '1.0.0'
        ]);
    }

    public function usuarios()
    {
        $usuarios = [
            ['id' => 1, 'nombre' => 'Juan Pérez', 'email' => 'juan@ejemplo.com'],
            ['id' => 2, 'nombre' => 'María García', 'email' => 'maria@ejemplo.com'],
            ['id' => 3, 'nombre' => 'Carlos López', 'email' => 'carlos@ejemplo.com']
        ];
        
        echo json_encode([
            'status' => 'success',
            'data' => $usuarios
        ]);
    }
}
