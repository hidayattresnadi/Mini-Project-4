<?php

namespace App\Controllers;

use App\Entities\Customer;
use App\Libraries\DataParamsUser;
use App\Models\CustomerModel;
use Myth\Auth\Models\UserModel;

class CustomerController extends BaseController
{
    protected $renderer;
    private CustomerModel $customerModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->renderer = service('renderer');
        $this->customerModel = new CustomerModel();
        $this->userModel = new UserModel();
    }
    public function showProfile(): string
    {
        $userId = user_id();
        $data = $this->customerModel->where('user_id', $userId)->first();
        $parser = \Config\Services::parser();
        $userProfile = array(
            "name" => $data->full_name,
            "email" => $data->email,
            "created_at" => $data->created_at,
            "account_status" => $data->status,
            "user_id" => $userId
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
        return view('customer/profile', $data);
    }

    public function index()
    {
        $params = new DataParamsUser([
            'search' => $this->request->getGet('search'),
            'role' => $this->request->getGet('role'),
            'status' => $this->request->getGet('status'),
            'sort' => $this->request->getGet('sort'),
            'order' => $this->request->getGet('order'),
            'page_customers' => $this->request->getGet('page_customers'),
            'perPage' => $this->request->getGet('perPage')
        ]);

        $result = $this->customerModel->getFilteredUsers($params);

        $data = [
            'customers' => $result['customers'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'statuses' => $this->customerModel->getAllStatuses(),
            'roles' => $this->customerModel->getAllRoles(),
            'baseUrl' => base_url('admin/users')
        ];
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

        return $this->renderer->render('customer/user_list');
    }

    public function detail($id)
    {
        $data['user'] = $this->customerModel->find($id);
        return view('customer/user_detail', $data);
    }

    public function addUserForm(): string
    {
        $data['users'] = $this->userModel->findAll();
        return view('customer/add_user', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if (! $this->customerModel->setValidationRules($this->customerModel->validationRulesCreate)->validate($data)) {
            return redirect()->back()
                ->with('errors', $this->customerModel->errors())
                ->withInput();
        }

        $user = new Customer($data);
        $this->customerModel->save($user);

        // clear cache
        $cacheKey = 'view__index.php_admin_users';
        cache()->delete($cacheKey);

        return redirect()->to(route_to('customers'))->with('message', 'Users added successfully');
    }

    public function updateUserForm($id): string
    {
        $data['user'] = $this->customerModel->find($id);
        return view('customer/edit_user', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        // Ganti `{id}` di aturan validasi dengan ID yang sedang diproses
        $rules = $this->customerModel->validationRules;
        $messages = $this->customerModel->getValidationMessages();
        foreach ($rules as &$rule) {
            $rule = str_replace('{id}', $id, $rule);
        }

        // Jalankan validasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $user = $this->customerModel->find($id);

        $user->fill($data);

        if ($this->customerModel->save($user)) {
            // delete cache at folder writable folder cache

            // clear cache
            $cacheKey = 'view__index.php_admin_users';
            cache()->delete($cacheKey);

            return redirect()->to('admin/customers')->with('message', 'Customers updated successfully');
        }

        // echo $this->customerModel->errors();

        return redirect()->back()
            ->with('errors', $this->customerModel->errors())
            ->withInput();
    }

    public function delete($id)
    {
        $this->customerModel->delete($id);

        // clear cache
        $cacheKey = 'view__index.php_admin_users';
        cache()->delete($cacheKey);

        return redirect()->to('admin/customers')->with('message', 'Customers deleted successfully');
    }
}
