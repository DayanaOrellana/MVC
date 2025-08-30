<?php

namespace App\Controllers;

use App\Models\AlumnoModel;
use CodeIgniter\Controller;

class AlumnoController extends Controller
{
    protected $alumnoModel;

    public function __construct()
    {
        $this->alumnoModel = new AlumnoModel();
    }

    public function index()
    {
        $data['alumnos'] = $this->alumnoModel->findAll();
        return view('alumnos/index', $data);
    }

    public function create()
    {
        return view('alumnos/create');
    }

    public function store()
    {
        $datos = [
            'nombre'         => $this->request->getPost('nombre'),
            'apellido'       => $this->request->getPost('apellido'),
            'direccion'      => $this->request->getPost('direccion'),
            'movil'          => $this->request->getPost('movil'),
            'email'          => $this->request->getPost('email'),
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'user'           => 'admin', 
            'inactivo'       => 0,
        ];
        $this->alumnoModel->save($datos);

        return redirect()->to('/alumnos');
    }

    public function edit($id)
    {
        $data['alumno'] = $this->alumnoModel->find($id);
        return view('alumnos/edit', $data);
    }

    public function update($id)
    {
        $this->alumnoModel->update($id, [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'direccion' => $this->request->getPost('direccion'),
            'movil'     => $this->request->getPost('movil'),
            'email'     => $this->request->getPost('email'),
            'user'      => 'admin', 
            'inactivo'  => $this->request->getPost('inactivo') ?? 0,
        ]);

        return redirect()->to('/alumnos');
    }

    public function delete($id)
    {
        $this->alumnoModel->delete($id);
        return redirect()->to('/alumnos');
    }
}
