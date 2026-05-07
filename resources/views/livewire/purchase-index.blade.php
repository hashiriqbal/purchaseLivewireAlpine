<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="p-6">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Purchases</h1>

        @role('Admin')
            <a href="{{ route('purchase.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded">
                Create Purchase
            </a>
        @endrole
    </div>

    <table class="w-full border border-gray-300">

        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">ID</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Created</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($purchases as $purchase)
                <tr>
                    <td class="border p-2">{{ $purchase->id }}</td>
                    <td class="border p-2">{{ $purchase->total }}</td>
                    <td class="border p-2">{{ $purchase->created_at }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>

</div>