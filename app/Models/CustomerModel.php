<?php

namespace App\Models;

use App\Libraries\DataParamsUser;
use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Customer::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password', 'full_name', 'role', 'status', 'last_login', 'user_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username'  => "required|min_length[3]|is_unique[customers.username,id,{id}]",
        'email'     => "required|valid_email|is_unique[customers.email,id,{id}]",
        'password' => 'required|min_length[8]',
        'full_name' => 'required|min_length[8]',
        'role' => 'required|min_length[3]',
        'status' => 'required|min_length[3]'
    ];

    protected $validationRulesCreate = [
        'username' => "required|min_length[3]|is_unique[customers.username]",
        'email'    => "required|valid_email|is_unique[customers.email]",
    ];
    protected $validationMessages   = [
        'username' => [
            'required'    => 'Username is required.',
            'min_length'  => 'Username must be at least 3 characters long.',
            'is_unique'   => 'Username is already taken.'
        ],
        'email' => [
            'required'    => 'Email is required.',
            'valid_email' => 'Please enter a valid email address.',
            'is_unique'   => 'Email is already registered.'
        ],
        'password' => [
            'required'    => 'Password is required.',
            'min_length'  => 'Password must be at least 8 characters long.'
        ],
        'full_name' => [
            'required'    => 'Fullname is required.',
            'min_length'  => 'Fullname must be at least 8 characters long.'
        ],
        'role' => [
            'required'    => 'Role is required.',
            'min_length'  => 'Role must be at least 3 characters long.'
        ],
        'status' => [
            'required'    => 'Status is required.',
            'min_length'  => 'Password must be at least 3 characters long.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findActiveUsers()
    {
        return $this->where('status', 'active')->countAllResults();
    }

    public function getTotalUsers(): int
    {
        return $this->countAll();
    }

    public function getNewUsersThisMonth(): int
    {
        return $this->where('created_at >=', date('Y-m-01'))
            ->where('created_at <=', date('Y-m-t'))
            ->countAllResults();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }


    public function getFilteredUsers(DataParamsUser $params)
    {
        if (!empty($params->search)) {
            $this->groupStart()
                ->like('username', $params->search)
                ->orLike('email', $params->search)
                ->orlike("full_name", $params->search)
                ->orlike("role", $params->search)
                ->orlike("status", $params->search)
                ->groupEnd();
        }

        // Apply filter status
        if (!empty($params->status)) {
            $this->where('status', $params->status);
        }

        // Apply filter role

        if (!empty($params->role)) {
            $this->where('role', $params->role);
        }


        // Apply sort
        $allowedSortColumns = ['last_login', 'email', 'username'];
        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'desc' : 'asc';

        $this->orderBy($sort, $order);

        $result = [
            'customers' => $this->paginate($params->perPage, 'customers', $params->page_customers),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false)
        ];
        return $result;
    }

    public function getAllStatuses()
    {
        $statuses = $this->select('status')->distinct()->findAll();
        $statuses = array_column($statuses, 'status');
        return $statuses;
    }

    public function getAllRoles()
    {
        $roles = $this->select('role')->distinct()->findAll();
        $roles = array_column($roles, 'role');
        return $roles;
    }
}
