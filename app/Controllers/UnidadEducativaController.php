<?php

namespace App\Controllers;

use App\Models\UnidadEducativaModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class UnidadEducativaController extends Controller
{
    protected $unidadEducativaModel;
    

    public function __construct()
    {
        $this->unidadEducativaModel = new UnidadEducativaModel();
        
    }

    public function index()
    {
        $data['title'] = 'Gestión de Unidades Educativas'; // Título de la página
        $data['unidades'] = $this->unidadEducativaModel->findAll();
        return view('unidad_educativa/index', $data);
    }
    
    public function store()
    {
        // Obtén el código RUE del request
        $codigoRue = $this->request->getPost('codigo_rue');
    
        // Verifica si ya existe una unidad educativa con el mismo código RUE
        $unidadExistente = $this->unidadEducativaModel->where('codigo_rue', $codigoRue)->first();
    
        if ($unidadExistente) {
            // Si ya existe, retorna un error
            return $this->response->setJSON(['status' => 'error', 'message' => 'El código RUE ya está registrado.']);
        }
    
        // Si no existe, procede a guardar
        $this->unidadEducativaModel->save([
            'codigo_rue' => $codigoRue,
            'nombre' => $this->request->getPost('nombre'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'dependencia' => $this->request->getPost('dependencia'),
            'area_geografica' => $this->request->getPost('area_geografica'),
            'estado' => $this->request->getPost('estado'),
        ]);
    
        return $this->response->setJSON(['status' => 'success']);
    }
    
    public function update($id)
    {
        $this->unidadEducativaModel->update($id, [
            'codigo_rue' => $this->request->getPost('codigo_rue'),
            'nombre' => $this->request->getPost('nombre'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'dependencia' => $this->request->getPost('dependencia'),
            'area_geografica' => $this->request->getPost('area_geografica'),
            'estado' => $this->request->getPost('estado'),
            
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $this->unidadEducativaModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function getUnidadEducativa($id)
    {
        $unidad = $this->unidadEducativaModel->find($id);
        return $this->response->setJSON($unidad);
    }
        
    // Método para generar el PDF
    public function generatePDF($id)
    {
        // Obtener los datos de la unidad educativa por ID
        $unidad = $this->unidadEducativaModel->find($id);

        // Verificar si los datos existen
        if (!$unidad) {
            return redirect()->to('/unidades-educativas')->with('error', 'Unidad educativa no encontrada');
        }

        // Crear el contenido del PDF
        $html = view('unidad_educativa/pdf', ['unidad' => $unidad]);

        // Configurar DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Configurar el tamaño de página y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF (en este caso lo guarda en un archivo)
        $dompdf->render();

        // Descargar el PDF generado
        $dompdf->stream("unidad_educativa_{$unidad['codigo_rue']}.pdf", array("Attachment" => 0));
    }    
    
}
