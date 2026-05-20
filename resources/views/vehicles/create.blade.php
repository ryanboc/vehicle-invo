<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow rounded-lg border-t-4 border-blue-600">
                <h2 class="text-2xl font-bold mb-6">Add Vehicle to Workshop</h2>
                
                <form action="{{ route('vehicles.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Make (e.g. Toyota, Ford)" />
                            <x-text-input name="make" class="w-full mt-1" required />
                        </div>
                        <div>
                            <x-input-label value="Model (e.g. Hilux, Ranger)" />
                            <x-text-input name="model" class="w-full mt-1" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Year" />
                            <x-text-input name="year" type="number" value="2026" class="w-full mt-1" />
                        </div>
                        <div>
                            <x-input-label value="VIN (Optional)" />
                            <x-text-input name="vin" class="w-full mt-1" />
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-700 text-white font-bold py-4 rounded-lg shadow hover:bg-blue-800 transition">
                        Add Vehicle & Generate Stock
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>