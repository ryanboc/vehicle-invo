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
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Current Inventory</h3>
                    <p class="mt-1 text-sm text-gray-600">All parts currently assigned to this vehicle. Click "Edit" to modify numbers, stock, or prices.</p>
                </header>

                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="border-b text-sm font-semibold text-gray-700 bg-gray-50">
                            <th class="py-3 px-4 w-1/4">Part Name</th>
                            <th class="py-3 px-4 w-1/4">Part Number</th>
                            <th class="py-3 px-4 text-center w-1/12">In Stock</th>
                            <th class="py-3 px-4 text-right w-1/12">Price</th>
                            <th class="py-3 px-4 text-center w-1/6">Installed On</th> 
                            <th class="py-3 px-4 text-center w-1/12">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicle->parts as $part)
                            <tr x-data="{ isEditing: false }" class="border-b hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4">
                                    <span x-show="!isEditing" class="text-gray-900 font-medium">{{ $part->name }}</span>
                                    <input x-show="isEditing" type="text" name="name" value="{{ $part->name }}" form="form-{{ $part->id }}" class="w-full text-sm py-1 border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required />
                                </td>

                                <td class="py-4 px-4">
                                    <span x-show="!isEditing" class="font-mono text-sm text-blue-600">{{ $part->part_number }}</span>
                                    <input x-show="isEditing" type="text" name="part_number" value="{{ $part->part_number }}" form="form-{{ $part->id }}" class="w-full font-mono text-sm py-1 border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required />
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span x-show="!isEditing" class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $part->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $part->quantity }}
                                    </span>
                                    <input x-show="isEditing" type="number" name="quantity" value="{{ $part->quantity }}" form="form-{{ $part->id }}" class="w-16 mx-auto text-center text-sm py-1 border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required />
                                </td>

                                <td class="py-4 px-4 text-right">
                                    <span x-show="!isEditing" class="text-sm font-medium text-gray-900">${{ number_format($part->price, 2) }}</span>
                                    <div x-show="isEditing" class="inline-flex items-center justify-end w-full">
                                        <span class="text-gray-500 mr-1 text-sm">$</span>
                                        <input type="number" name="price" step="0.01" value="{{ $part->price }}" form="form-{{ $part->id }}" class="w-20 text-right text-sm py-1 border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required />
                                    </div>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <div x-show="!isEditing">
                                        @if($part->installed_at)
                                            <span class="text-sm text-gray-700 bg-gray-100 px-2.5 py-1 rounded-md font-medium">
                                                {{ $part->installed_at->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Not fitted yet</span>
                                        @endif
                                    </div>
                                    <div x-show="isEditing">
                                        <input type="date" name="installed_at" value="{{ $part->installed_at ? $part->installed_at->format('Y-m-d') : '' }}" form="form-{{ $part->id }}" class="border-gray-300 rounded-md shadow-sm text-sm py-1 w-full focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <form id="form-{{ $part->id }}" action="{{ route('parts.update', $part->id) }}" method="POST" class="inline m-0">
                                        @csrf
                                        @method('PUT')
                                    </form>

                                    <div x-show="!isEditing">
                                        <button type="button" @click="isEditing = true" class="text-sm font-bold text-indigo-600 hover:text-indigo-900 transition-colors">
                                            Edit
                                        </button>
                                    </div>
                                    <div x-show="isEditing" class="flex items-center justify-center space-x-2">
                                        <button type="submit" form="form-{{ $part->id }}" class="text-sm font-bold text-green-600 hover:text-green-900 transition-colors">
                                            Save
                                        </button>
                                        <button type="button" @click="isEditing = false" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">No parts found. Add one below!</td>
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