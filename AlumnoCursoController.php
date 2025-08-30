<?php
namespace App\Controllers;

use App\Models\AlumnoModel;
use App\Models\CursoModel;
use App\Models\DetalleAlumnoCursoModel;
use CodeIgniter\Controller;

class AlumnoCursoController extends Controller
{
    protected $alumnoModel;
    protected $cursoModel;
    protected $detalleModel;
    protected $helpers = ['url'];

    public function __construct()
    {
        $this->alumnoModel = new AlumnoModel();
        $this->cursoModel = new CursoModel();
        $this->detalleModel = new DetalleAlumnoCursoModel();
    }

    public function cursos()
    {
        return $this->response->setJSON($this->cursoModel->where('inactivo',0)->findAll());
    }

    public function asignados($alumnoId)
    {
        $db = \Config\Database::connect();
        $rows = $db->table('detalle_alumno_curso dac')
            ->select('c.curso, c.nombre, c.profesor')
            ->join('cursos c','c.curso = dac.curso')
            ->where('dac.alumno', $alumnoId)->get()->getResultArray();
        return $this->response->setJSON($rows);
    }

    public function guardar($alumnoId)
    {
        $ids = $this->request->getPost('cursos') ?? [];
        $this->detalleModel->where('alumno', $alumnoId)->delete();
        foreach ($ids as $cid) {
            $this->detalleModel->insert(['alumno' => $alumnoId, 'curso' => (int)$cid]);
        }
        return redirect()->to('/alumnos')->with('message', 'Cursos asignados');
    }

    public function count($alumnoId)
    {
        $cnt = $this->detalleModel->where('alumno', $alumnoId)->countAllResults();
        return $this->response->setJSON(['count' => $cnt]);
    }
}
