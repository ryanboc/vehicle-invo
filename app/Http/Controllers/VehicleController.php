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
            // 1. We let the client type the car in. It's faster than a broken API.
            $validated = $request->validate([
                'make'  => 'required|string',
                'model' => 'required|string',
                'year'  => 'required|integer',
                'vin'   => 'nullable|string',
            ]);

            // 2. Create the vehicle immediately
            $vehicle = Vehicle::create($validated);

            // 3. Instead of an API, we use a "Smart Matcher" for AU common parts
            $this->autoPopulateAussieParts($vehicle);

            return redirect()->route('dashboard')->with('success', "{$vehicle->make} added to inventory!");
        }

        private function autoPopulateAussieParts($vehicle)
        {
            $make = strtoupper($vehicle->make);
            $model = strtoupper($vehicle->model);
            
            // Multi-level catalog: Make -> Model -> Parts
            $catalog = [
                'TOYOTA' => [
                    'HILUX' => ['Oil' => 'Z148A', 'Air' => 'A1798'],
                    'PRADO' => ['Oil' => 'Z418', 'Air' => 'A1634'],
                    'LANDCRUISER' => ['Oil' => 'Z9', 'Air' => 'A1487'],
                    'DEFAULT' => ['Oil' => 'Z418', 'Air' => 'A1574']
                ],
                'FORD' => [
                    'RANGER' => ['Oil' => 'Z932', 'Air' => 'A1843'],
                    'DEFAULT' => ['Oil' => 'Z160', 'Air' => 'A1500']
                ],
                'HOLDEN' => [
                    'COMMODORE' => [
                        'Oil' => 'R2605P', // Standard for Alloytec V6 (VE, VF)
                        'Air' => 'A1544',
                    ],
                    'COLORADO' => [
                        'Oil' => 'R2719P', // Common Duramax Diesel filter
                        'Air' => 'A1841',
                    ],
                    'DEFAULT' => [
                        'Oil' => 'Z160',   // Generic older Holden spin-on
                        'Air' => 'A1400',
                    ]
                ],
                'MAZDA' => [
                    'MAZDA3' => [
                        'Oil' => 'Z436',   // Common SkyActiv petrol spin-on
                        'Air' => 'A1823',
                    ],
                    'CX5' => [
                        'Oil' => 'Z1035',  // SkyActiv Diesel / Petrol variant filter
                        'Air' => 'A1916',
                    ],
                    'BT50' => [
                        'Oil' => 'Z932',   // Shares filters with its sibling Ford Ranger
                        'Air' => 'A1843',
                    ],
                    'DEFAULT' => [
                        'Oil' => 'Z436',
                        'Air' => 'A1300',
                    ]
                ],
            ];

            // 1. Find the Make data
            $makeData = $catalog[$make] ?? null;

            if ($makeData) {
                // 2. If the specific model exists, use it. Otherwise, use that Make's default.
                $spec = $makeData[$model] ?? $makeData['DEFAULT'];
            } else {
                // 3. If it's a completely unknown brand (e.g., Chery, Great Wall)
                $spec = ['Oil' => 'Z-GENERIC', 'Air' => 'A-GENERIC'];
            }

            $parts = [
                ['name' => 'Oil Filter', 'part_number' => $spec['Oil']],
                ['name' => 'Air Filter', 'part_number' => $spec['Air']],
                ['name' => 'Standard Tyres', 'part_number' => 'CHECK-SIDEWALL'],
            ];

            $vehicle->parts()->createMany($parts);
        }

        public function updatePart(Request $request, Part $part)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'part_number' => 'required|string|max:100',
                'quantity' => 'required|integer|min:0',
                'price' => 'required|numeric|min:0',
                'installed_at' => 'nullable|date',
            ]);

            $part->update($validated);

            return redirect()->back()->with('success', 'Part updated successfully!');
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
