<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}
            </h2>
            <span class="text-sm text-gray-500 uppercase tracking-widest">VIN: {{ $vehicle->vin }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Current Inventory</h3>
                    <p class="mt-1 text-sm text-gray-600">All parts currently assigned to this vehicle.</p>
                </header>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-3 px-2">Part Name</th>
                            <th class="py-3 px-2">Part Number</th>
                            <th class="py-3 px-2 text-center">In Stock</th>
                            <th class="py-3 px-2 text-right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicle->parts as $part)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-2">{{ $part->name }}</td>
                                <td class="py-4 px-2 font-mono text-sm text-blue-600">{{ $part->part_number }}</td>
                                <td class="py-4 px-2 text-center">
                                    <span class="px-3 py-1 rounded-full {{ $part->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $part->quantity }}
                                    </span>
                                </td>
                                <td class="py-4 px-2 text-right">${{ number_format($part->price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">No parts found. Add one below!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Add New Part</h3>
                    <p class="mt-1 text-sm text-gray-600">Manually add a part that wasn't auto-populated.</p>
                </header>

                <form action="{{ route('parts.store', $vehicle->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <div>
                        <x-input-label for="name" value="Part Name" />
                        <x-text-input name="name" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="part_number" value="Part Number" />
                        <x-text-input name="part_number" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="quantity" value="Initial Qty" />
                        <x-text-input name="quantity" type="number" class="mt-1 block w-full" value="1" />
                    </div>
                    <div class="flex items-end">
                        <x-primary-button class="w-full justify-center py-3">
                            Add Part
                        </x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>