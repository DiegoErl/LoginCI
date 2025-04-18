<?php

namespace App\Controllers;
use App\Models\Usuarios;

class Home extends BaseController
{
    public function index(): string
    {
        $mensaje = session('mensaje');
        return view('login', ["mensaje" => $mensaje]);
    }

    public function inicio(): string
    {
        return view('inicio');
    }

    public function login()
    {
        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');
        $Usuario = new Usuarios();

        $datosUsuario = $Usuario->obtenerUsuarios(['usuario' => $usuario]);

        if (count($datosUsuario) > 0 && password_verify($password, $datosUsuario[0]['password'])) {
            
            $data = [
                "usuario" => $datosUsuario[0]['usuario'],
                "type" => $datosUsuario[0]['type']
            ];

            $session = session();
            $session->set($data);
            
            return redirect()->to(base_url('/inicio'))->with('mensaje', '1');

        }else {
            return redirect()->to(base_url('/'))->with('mensaje', '0');
        }

        // Example logic to handle login
        if ($usuario === 'admin' && $password === 'password') {
            return 'Login successful';
        }

        return 'Login failed';
    }

    public function salir()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }
    
}
