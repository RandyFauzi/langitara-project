<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Stats
        $totalPackages = Package::count();
        $activePackages = Package::where('status', 'active')->count();
        $inactivePackages = Package::where('status', 'inactive')->count();

        // Get all packages
        $packages = Package::latest()->get();

        return view('admin.packages.index', compact('packages', 'totalPackages', 'activePackages', 'inactivePackages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_invitations' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        Package::create($validated);

        return redirect()->back()->with('success', 'Paket berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_invitations' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $package->update($validated);

        return redirect()->back()->with('success', 'Paket berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->back()->with('success', 'Paket berhasil dihapus');
    }

    /**
     * Toggle the status of the specified package.
     */
    public function toggleStatus($id)
    {
        $package = Package::findOrFail($id);
        $package->status = $package->status === 'active' ? 'inactive' : 'active';
        $package->save();

        return redirect()->back()->with('success', 'Status paket berhasil diperbarui');
    }
}
