<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class EmployeeController extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\EmployeeModel';
    protected $format = 'json';

    // Registrasi karyawan
    public function create()
    {
        $model = new EmployeeModel();

        $data = [
            'nama' => $this->request->getVar('nama'),
            'jabatan' => $this->request->getVar('jabatan'),
            'gaji' => $this->request->getVar('gaji'),
            'penilaian' => $this->request->getVar('penilaian')
        ];

        if ($model->insert($data)) {
            // Berhasil membuat karyawan baru
            return $this->respondCreated($data);
        } else {
            // Gagal membuat karyawan baru
            return $this->fail($model->errors());
        }
    }

    // Menampilkan semua data karyawan
    public function index()
    {
        $model = new EmployeeModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    // Memperbarui penilaian karyawan
    public function update($id = null)
    {
        $model = new EmployeeModel();

        $data = [
            'penilaian' => $this->request->getVar('penilaian')
        ];

        // Memastikan karyawan dengan ID tertentu ada sebelum memperbarui
        if ($model->find($id) === null) {
            return $this->failNotFound('Karyawan tidak ditemukan');
        }

        // Melakukan update penilaian karyawan
        if ($model->update($id, $data)) {
            return $this->respondUpdated(['id' => $id, 'penilaian' => $data['penilaian']]);
        } else {
            return $this->failServerError('Gagal memperbarui penilaian karyawan');
        }
    }

    // Menghapus karyawan berdasarkan ID
    public function delete($id = null)
    {
        $model = new EmployeeModel();

        // Memastikan karyawan dengan ID tertentu ada sebelum menghapus
        if ($model->find($id) === null) {
            return $this->failNotFound('Karyawan tidak ditemukan');
        }

        // Melakukan penghapusan karyawan dari database
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->failServerError('Gagal menghapus karyawan');
        }
    }
}
