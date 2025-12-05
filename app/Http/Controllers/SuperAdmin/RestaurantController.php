<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::withCount('tables')->latest()->get();
        return view('super-admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('super-admin.restaurants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:restaurants',
            'email' => 'required|email|unique:restaurants',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'number_of_tables' => 'required|integer|min:1|max:100',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|min:8|confirmed',
        ]);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Create restaurant
        $restaurant = Restaurant::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'logo' => $logoPath,
            'number_of_tables' => $validated['number_of_tables'],
        ]);

        // Create restaurant admin user
        $admin = User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'role' => 'restaurant_admin',
            'restaurant_id' => $restaurant->id,
        ]);

        // Create tables for the restaurant
        for ($i = 1; $i <= $validated['number_of_tables']; $i++) {
            Table::create([
                'restaurant_id' => $restaurant->id,
                'table_number' => $i,
                'unique_url' => Str::uuid(),
            ]);
        }

        return redirect()->route('super-admin.restaurants.index')
            ->with('success', 'Restaurant created successfully. Admin credentials sent to ' . $admin->email);
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load('tables', 'users');
        return view('super-admin.restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        return view('super-admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:restaurants,name,' . $restaurant->id,
            'email' => 'required|email|unique:restaurants,email,' . $restaurant->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'number_of_tables' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $restaurant->update($validated);

        // Update tables if number changed
        $currentCount = $restaurant->tables()->count();
        $newCount = $validated['number_of_tables'];

        if ($newCount > $currentCount) {
            for ($i = $currentCount + 1; $i <= $newCount; $i++) {
                Table::create([
                    'restaurant_id' => $restaurant->id,
                    'table_number' => $i,
                    'unique_url' => Str::uuid(),
                ]);
            }
        } elseif ($newCount < $currentCount) {
            $restaurant->tables()
                ->where('table_number', '>', $newCount)
                ->delete();
        }

        return redirect()->route('super-admin.restaurants.index')
            ->with('success', 'Restaurant updated successfully');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('super-admin.restaurants.index')
            ->with('success', 'Restaurant deleted successfully');
    }
}
