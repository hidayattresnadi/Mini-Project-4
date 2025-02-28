<?php

namespace App\Controllers;

use App\Entities\User;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $renderer;
    private UserModel $userModel;

    public function __construct()
    {
        $this->renderer = service('renderer');
        $this->userModel = new UserModel();
    }
    public function showProfile(): string
    {
        $parser = \Config\Services::parser();
        $userProfile = array(
            "name" => "John Doe",
            "email" => "johndoe@example.com",
            "birthdate" => date("d M Y", strtotime("1990-05-15")),
            "account_status" => "Active",
        );

        $data = [
            'user_information' => view_cell('ProfileCell', ['userData' => $userProfile], 300),
            // 'activity_history' => array(
            //     array("date" => date("d M Y H:i", strtotime("-2 days")), "action" => "Logged in"),
            //     array("date" => date("d M Y H:i", strtotime("-5 days")), "action" => "Updated profile"),
            //     array("date" => date("d M Y H:i", strtotime("-10 days")), "action" => "Changed password"),
            // )
        ];

        $data['content'] = $parser->setData($data)->render('components/profile');
        return view('user/profile', $data);
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        $this->renderer->setData($data);

        // Warming cache -> Memperbarui cache ketika hampir kadaluarsa
        $cacheKey = 'view_' . str_replace('/', '_', $this->request->getUri()->getPath());
        $cacheDuration = 900;

        // Cek apakah cache masih ada
        // $data = cache()->get($cacheKey);

        // if ($data) {
        //     $metadata = cache()->getMetadata($cacheKey);
        //     // ttl = masa berlaku cache
        //     $ttl = $metadata['ttl'] ?? 0;

        //     // Jika cache akan kedaluwarsa dalam 1 menit, perbarui cache
        //     if ($ttl < 60) {
        //         cache()->save($cacheKey, $this->renderer->render('user/user_list'), $cacheDuration);
        //     }

        //     return $data;
        // }

        // Jika cache tidak ada, buat cache baru
        // return cache()->remember($cacheKey, $cacheDuration, function () {
        //     return $this->renderer->render('user/user_list');
        // });

        return $this->renderer->render('user/user_list');
    }

    public function detail($id)
    {
        $data['user'] = $this->userModel->find($id);
        return view('user/user_detail', $data);
    }

    public function addUserForm(): string
    {
        return view('user/add_user');
    }

    public function create()
    {
        $data = $this->request->getPost();

        if (! $this->userModel->validate($data)) {
            return redirect()->back()
                ->with('errors', $this->userModel->errors())
                ->withInput();
        }

        $user = new User($data);
        $this->userModel->save($user);

        // clear cache
        $cacheKey = 'view__index.php_admin_users';
        cache()->delete($cacheKey);

        return redirect()->to(route_to('users'))->with('success', 'Users added successfully');
    }

    public function updateUserForm($id): string
    {
        $data['user'] = $this->userModel->find($id);
        return view('user/edit_user', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        // Ganti `{id}` di aturan validasi dengan ID yang sedang diproses
        $rules = $this->userModel->validationRules;
        $messages = $this->userModel->getValidationMessages();
        foreach ($rules as &$rule) {
            $rule = str_replace('{id}', $id, $rule);
        }

        // Jalankan validasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $user = $this->userModel->find($id);

        $user->fill($data);

        if ($this->userModel->save($user)) {
            session()->setFlashdata('success', 'User berhasil diupdate');
            // delete cache at folder writable folder cache

            // clear cache
            $cacheKey = 'view__index.php_admin_users';
            cache()->delete($cacheKey);

            return redirect()->to('admin/users')->with('success', 'Users updated successfully');
        }

        // echo $this->userModel->errors();

        return redirect()->back()
            ->with('errors', $this->userModel->errors())
            ->withInput();
    }

    public function delete($id)
    {
        $this->userModel->delete($id);

        // clear cache
        $cacheKey = 'view__index.php_admin_users';
        cache()->delete($cacheKey);

        return redirect()->to('admin/users')->with('success', 'Users deleted successfully');
    }
}
