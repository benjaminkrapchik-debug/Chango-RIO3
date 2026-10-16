<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        if (session()->get('logueado')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('auth/login');
    }

    public function register()
    {
        if (session()->get('logueado')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('auth/register');
    }

    public function guardarRegistro()
    {
        $reglas = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[255]|is_unique[usuarios.email]',
            'password' => 'required|min_length[8]|max_length[72]'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $usuarios = new UserModel();

        $usuarios->insert([
            'nombre' => trim($this->request->getPost('nombre')),
            'email' => strtolower(trim($this->request->getPost('email'))),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            )
        ]);

        return redirect()->to(site_url('login'))
            ->with('error', 'Cuenta creada correctamente. Ahora podés iniciar sesión.');
    }

    public function iniciarSesion()
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        if ($email === '' || $password === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Completá el correo y la contraseña.');
        }

        $usuarios = new UserModel();

        $usuario = $usuarios->where('email', $email)->first();

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            return redirect()->back()
                ->with('error', 'El correo o la contraseña son incorrectos.');
        }

        session()->regenerate();

        session()->set([
            'usuario_id' => $usuario['id'],
            'usuario_nombre' => $usuario['nombre'],
            'usuario_email' => $usuario['email'],
            'logueado' => true
        ]);

        return redirect()->to(site_url('dashboard'));
    }

    public function dashboard()
    {
        if (!session()->get('logueado')) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Iniciá sesión para acceder a tu cuenta.');
        }

        return view('auth/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'))
            ->with('error', 'Cerraste sesión correctamente.');
    }
}