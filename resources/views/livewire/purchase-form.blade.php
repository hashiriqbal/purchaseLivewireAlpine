

<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Create Purchase</h1>

    @if (session()->has('success'))
        <div class="bg-green-200 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @error('duplicate')
        <div class="bg-red-200 p-3 rounded mb-4">
            {{ $message }}
        </div>
    @enderror

    <div>

        <table class="w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Item</th>
                    <th class="p-2 border">Brand</th>
                    <th class="p-2 border">Qty</th>
                    <th class="p-2 border">Price</th>
                    <th class="p-2 border">Total</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($rows as $index => $row)
                    <tr>

                        <td class="border p-2">
                            <select wire:model.live="rows.{{ $index }}.item_id" class="w-full border p-2">
                                <option value="">Select Item</option>

                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td class="border p-2">
                            <select wire:model.live="rows.{{ $index }}.brand_id" class="w-full border p-2">
                                <option value="">Select Brand</option>

                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td class="border p-2">
                            <input type="number"
                                   wire:model.live.debounce.500ms="rows.{{ $index }}.qty"
                                   class="w-full border p-2">
                        </td>

                        <td class="border p-2">
                            <input type="number"
                                   wire:model.live.debounce.500ms="rows.{{ $index }}.price"
                                   class="w-full border p-2">
                        </td>

                        <td class="border p-2">
                            {{ ($row['qty'] ?? 0) * ($row['price'] ?? 0) }}
                        </td>

                        <td class="border p-2">
                            <button wire:click="removeRow({{ $index }})"
                                    class="bg-red-500 text-white px-3 py-1 rounded">
                                Remove
                            </button>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="mt-4 flex gap-4">

            <button wire:click="addRow"
                    class="bg-blue-500 text-white px-4 py-2 rounded">
                Add Row
            </button>

            <button wire:click="save"
                    class="bg-green-500 text-white px-4 py-2 rounded">
                Save Purchase
            </button>

        </div>

        <div class="mt-6 text-xl font-bold">
            Grand Total: {{ $total }}
        </div>

    </div>
</div>