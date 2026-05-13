<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('vehicles.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <h2 class="text-lg font-bold mb-4">Add New Vehicle to Inventory</h2>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="vin" placeholder="Enter VIN (Optional)" class="border p-2 rounded">
                <input type="text" name="make" placeholder="Make (e.g. Toyota)" required class="border p-2 rounded">
                <input type="text" name="model" placeholder="Model (e.g. Camry)" required class="border p-2 rounded">
                <input type="number" name="year" placeholder="Year" required class="border p-2 rounded">
            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                Add Vehicle & Auto-Populate Parts
            </button>
        </form>
    </div>
</x-app-layout>