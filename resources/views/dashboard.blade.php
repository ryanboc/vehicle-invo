<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Shop Inventory Dashboard') }}
            </h2>
            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Add New Vehicle
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Registered Vehicles</h3>

                    @if($vehicles->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">No vehicles in the system yet.</p>
                            <a href="{{ route('vehicles.create') }}" class="text-blue-600 underline">Add your first car to get started.</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b bg-gray-50">
                                        <th class="py-3 px-4">Year/Make/Model</th>
                                        <th class="py-3 px-4">VIN</th>
                                        <th class="py-3 px-4">Total Parts</th>
                                        <th class="py-3 px-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vehicles as $vehicle)
                                        <tr class="border-b hover:bg-gray-50 transition">
                                            <td class="py-4 px-4 font-semibold">
                                                {{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}
                                            </td>
                                            <td class="py-4 px-4 font-mono text-sm text-gray-600">
                                                {{ $vehicle->vin ?? 'N/A' }}
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                    {{ $vehicle->parts_count }} Parts
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-right">
                                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">
                                                    Manage Inventory →
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>