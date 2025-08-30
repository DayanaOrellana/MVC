<?php
namespace App\Controllers;

use App\Models\CursoModel;
use CodeIgniter\Controller;

class CursoController extends Controller
{
    protected $cursoModel;
    protected $helpers = ['form','url'];

    public function __construct()
    {
        $this->cursoModel = new CursoModel();
    }

    public function index()
    {
        $data['cursos'] = $this->cursoModel->orderBy('curso','DESC')->findAll();
        $data['titulo'] = "Listado de cursos";
        return view('cursos/index', $data);
    }

    public function create()
    {
        return view('cursos/create');
    }

    public function store()
    {
        $this->cursoModel->insert([
            'nombre'   => $this->request->getPost('nombre'),
            'profesor' => $this->request->getPost('profesor'),
            'inactivo' => $this->request->getPost('inactivo') ? 1 : 0,
        ]);
        return redirect()->to('/cursos')->with('message','Curso creado');
    }

    public function edit($id)
    {
        $curso = $this->cursoModel->find($id);
        if (!$curso) return redirect()->to('/cursos');
        return view('cursos/edit', ['curso'=>$curso]);
    }

    public function update($id)
    {
        $this->cursoModel->update($id, [
            'nombre'   => $this->request->getPost('nombre'),
            'profesor' => $this->request->getPost('profesor'),
            'inactivo' => $this->request->getPost('inactivo') ? 1 : 0,
        ]);
        return redirect()->to('/cursos')->with('message','Curso actualizado');
    }

    public function delete($id)
    {
        $this->cursoModel->delete($id);
        return redirect()->to('/cursos')->with('message','Curso eliminado');
    }
}
