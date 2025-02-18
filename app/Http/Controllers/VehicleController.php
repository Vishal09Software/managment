<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::query();

        if ($request->has('fields')) {
            $fields = $request->input('fields');
            foreach ($fields as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'LIKE', "%{$value}%");
                }
            }
        } else {
            $query->latest();
        }

        $vehicles = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($vehicles->isEmpty()) {
            return view('admin.vehicles.index', compact('vehicles'))->with('error', 'No vehicles found');
        }

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_name' => 'required|string|max:255|unique:vehicles,vehicle_name',
            'owner_name' => 'required|string|max:255',
            'vehicle_no' => 'nullable',
            'owner_phone' => 'required|string|max:255',
            'owner_address' => 'required|string|max:255',
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'required|string|max:255',
        ]);

        Vehicle::create([
            'vehicle_name' => $request->vehicle_name,
            'owner_name' => $request->owner_name,
            'vehicle_number' => $request->vehicle_no,
            'owner_phone' => $request->owner_phone,
            'owner_address' => $request->owner_address,
            'driver_name' => $request->driver_name,
            'driver_phone' => $request->driver_phone,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'vehicle_name' => 'required|string|max:255|unique:vehicles,vehicle_name',
            'vehicle_number' => 'nullable',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:255',
            'owner_address' => 'required|string|max:255',
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'required|string|max:255'
        ]);

        $vehicle->update([
            'vehicle_name' => $request->vehicle_name,
            'vehicle_number' => $request->vehicle_number,
            'owner_name' => $request->owner_name,
            'owner_phone' => $request->owner_phone,
            'owner_address' => $request->owner_address,
            'driver_name' => $request->driver_name,
            'driver_phone' => $request->driver_phone
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully');
    }

    public function vehicleSearch(Request $request)
    {
        $search = $request->get('search');

        $results = Vehicle::where(function($query) use ($search) {
                $query->Where('vehicle_number', 'LIKE', "%{$search}%")
                    ->orWhere('driver_name', 'LIKE', "%{$search}%")
                    ->orWhere('owner_name', 'LIKE', "%{$search}%");
            })
            ->limit(10)
            ->get();
        return response()->json($results);
    }
}
