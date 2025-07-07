<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('users/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $userModel = new UserModel();
            $userModel->insert($this->request->getPost());
            return redirect()->to('/users');
        }
        return view('users/create');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        if ($this->request->getMethod() === 'post') {
            $userModel->update($id, $this->request->getPost());
            return redirect()->to('/users');
        }
        $data['user'] = $userModel->find($id);
        return view('users/edit', $data);
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/users');
    }
}
