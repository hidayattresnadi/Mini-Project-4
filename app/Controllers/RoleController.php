<?php

namespace App\Controllers;

use Myth\Auth\Entities\Group;
use Myth\Auth\Models\GroupModel;

class RoleController extends BaseController
{
    protected GroupModel $groupModel;

    public function __construct()
    {
        $this->groupModel = new GroupModel();
    }

    public function showRoles()
    {
        $data['roles'] =  $this->groupModel->findAll();
        $data['title'] =  'List Roles';
        return view('role/role_list', $data);
    }

    public function create()
    {
        return view('role/add');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $group = new Group($data);
        if (! $this->groupModel->save($group)) {
            return redirect()->back()
                ->with('errors', $this->groupModel->errors())
                ->withInput();
        }
        return redirect()->to('admin/roles')->with('message', 'Rolesadded successfully');
    }

    public function delete($id)
    {
        $this->groupModel->delete($id);
        return redirect()->to('admin/roles')->with('message', 'Roles deleted successfully');
    }

    public function edit($id)
    {
        $data['role'] = $this->groupModel->find($id);
        return view('role/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        $role = $this->groupModel->find($id);

        $role->fill($data);

        if ($this->groupModel->save($role)) {
            session()->setFlashdata('success', 'Role berhasil diupdate');
            return redirect()->to('/admin/roles')->with('message', 'Role berhasil diupdate');
        }

        return redirect()->back()
            ->with('errors', $this->groupModel->errors())
            ->withInput();
    }
}
