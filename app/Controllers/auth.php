<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('usuario_id')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('login');
    }

    public function register()
    {
        if (session()->get('usuario_id')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('register');
    }

    public function guardarRegistro()
    {
        $reglas = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[190]',
            'password' => 'required|min_length[8]|max_length[72]'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $usuarios = new UsuarioModel();
        $email = strtolower(trim($this->request->getPost('email')));

        if ($usuarios->where('email', $email)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ese correo ya está registrado.');
        }

        $id = $usuarios->insert([
            'nombre' => trim($this->request->getPost('nombre')),
            'email' => $email,
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            )
        ]);

        if (!$id) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No se pudo crear la cuenta.');
        }

        // Iniciar sesión automáticamente después del registro.
        session()->regenerate(true);

        session()->set([
            'usuario_id' => $id,
            'usuario_nombre' => trim($this->request->getPost('nombre')),
            'usuario_email' => $email
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    public function iniciarSesion()
    {
        $reglas = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Introduce un correo y una contraseña válidos.');
        }

        $email = strtolower(trim($this->request->getPost('email')));
        $password = $this->request->getPost('password');

        $usuarios = new UsuarioModel();
        $usuario = $usuarios->where('email', $email)->first();

        if (
            !$usuario ||
            !password_verify($password, $usuario['password'])
        ) {
            return redirect()->back()
                ->with('error', 'Correo o contraseña incorrectos.');
        }

        // Regenerar el identificador de sesión tras autenticarse.
        session()->regenerate(true);

        session()->set([
            'usuario_id' => $usuario['id'],
            'usuario_nombre' => $usuario['nombre'],
            'usuario_email' => $usuario['email']
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'));
    }
}