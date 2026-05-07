<div class="p-6 grid grid-cols-2 gap-6">

    {{-- CREATE ROLE --}}
    <div class="p-4 border rounded">
        <h2 class="text-xl font-bold">Create Role</h2>

        <input type="text" wire:model="roleName" class="border p-2 w-full mt-2">

        <button wire:click="createRole" class="bg-blue-500 text-white px-4 py-2 mt-2">
            Create
        </button>

        <ul class="mt-4">
            @foreach($roles as $role)
                <li wire:click="selectRole({{ $role->id }})"
                    class="cursor-pointer p-2 hover:bg-gray-200">
                    {{ $role->name }}
                </li>
            @endforeach
        </ul>
    </div>

    {{-- CREATE PERMISSION --}}
    <div class="p-4 border rounded">
        <h2 class="text-xl font-bold">Create Permission</h2>

        <input type="text" wire:model="permissionName" class="border p-2 w-full mt-2">

        <button wire:click="createPermission" class="bg-green-500 text-white px-4 py-2 mt-2">
            Create
        </button>

        <ul class="mt-4">
            @foreach($permissions as $perm)
                <li>{{ $perm->name }}</li>
            @endforeach
        </ul>
    </div>

    {{-- ASSIGN PERMISSIONS --}}
    <div class="col-span-2 p-4 border rounded mt-6">

        <h2 class="text-xl font-bold">
            Assign Permissions to Role: {{ $selectedRole->name ?? '-' }}
        </h2>

        @if($selectedRole)

            @foreach($permissions as $perm)

                <label class="block">
                    <input type="checkbox"
                           wire:model="rolePermissions"
                           value="{{ $perm->name }}">
                    {{ $perm->name }}
                </label>

            @endforeach

            <button wire:click="updateRolePermissions"
                    class="bg-purple-500 text-white px-4 py-2 mt-4">
                Update
            </button>

        @endif

    </div>

</div>