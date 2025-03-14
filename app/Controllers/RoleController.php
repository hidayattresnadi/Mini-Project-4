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
        $role = $this->request->getPost();
        if (! $this->groupModel->save($role)) {
            return redirect()->back()
                ->with('errors', $this->groupModel->errors())
                ->withInput();
        }
        return redirect()->to('admin/roles')->with('success', 'Rolesadded successfully');
    }
}
