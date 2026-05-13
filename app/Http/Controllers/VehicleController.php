<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VehicleController extends Controller
{   
        public function index()
    {
        // Get all vehicles with their parts count
        $vehicles = Vehicle::withCount('parts')->latest()->get();
        return view('dashboard', compact('vehicles'));
    }

        public function create()
    {
        return view('vehicles.create');
    }

        public function show(Vehicle $vehicle)
    {
        // Load parts so we can see the auto-populated list
        $vehicle->load('parts');
        return view('vehicles.show', compact('vehicle'));
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
        'make' => 'required', 
        'model' => 'required', 
        'year' => 'required', 
        'vin' => 'nullable'
        ]);

        $vehicle = Vehicle::create($validated);

        // This creates the relationship links automatically
        $vehicle->parts()->createMany($this->getSuggestedParts($vehicle));

        return redirect()->route('dashboard')->with('success', 'Vehicle and parts inventory synced!');

    }

    private function getSuggestedParts($vehicle)
    {
        // This is where the "Beauty of the API" happens. 
        // For now, we return a standard set of "Service" parts.
        return [
            ['name' => 'Oil Filter', 'part_number' => "OF-{$vehicle->make}-01"],
            ['name' => 'Air Filter', 'part_number' => "AF-{$vehicle->make}-02"],
            ['name' => 'Brake Pads (Front)', 'part_number' => "BP-{$vehicle->model}-F"],
        ];
    }

    public function addPart(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'part_number' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        $vehicle->parts()->create($validated);

        return redirect()->back()->with('success', 'Part added!');
    }

    public function updateStock(Request $request, Part $part)
    {
        // Simple logic to increment/decrement or set stock
        $part->update($request->validate(['quantity' => 'required|integer']));
        
        return redirect()->back();
    }
}
