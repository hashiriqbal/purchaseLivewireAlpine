<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManager extends Component
{
    public $roles;
    public $permissions;

    public $roleName;
    public $permissionName;

    public $selectedRole;
    public $rolePermissions = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    public function createRole()
    {
        Role::create(['name' => $this->roleName]);
        $this->roleName = '';
        $this->roles = Role::all();
    }

    public function createPermission()
    {
        Permission::create(['name' => $this->permissionName]);
        $this->permissionName = '';
        $this->permissions = Permission::all();
    }

    public function selectRole($roleId)
    {
        $role = Role::findById($roleId);
        $this->selectedRole = $role;
        $this->rolePermissions = $role->permissions->pluck('name')->toArray();
    }

    public function updateRolePermissions()
    {
        $this->selectedRole->syncPermissions($this->rolePermissions);
        session()->flash('success', 'Permissions updated');
    }

    public function render()
    {
        return view('livewire.admin.role-manager');
    }
}