<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StructureController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isPac = $user->organization_id == 1;

        $query = OrganizationStructure::orderBy('level', 'asc');

        // --- FILTER ---
        if (!$isPac) {
            $query->where('organization_id', $user->organization_id);
        }

        $structures = $query->get();
        return view('admin.structures.index', compact('structures'));
    }

    public function create()
    {
        return view('admin.structures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'level' => 'required|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['organization_id'] = Auth::user()->organization_id; // Simpan ID Organisasi

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('structures', 'public');
        }

        OrganizationStructure::create($data);

        return redirect()->route('admin.structures.index')->with('success', 'Pengurus berhasil ditambahkan!');
    }

    // Helper Cek Akses
    private function checkAccess(OrganizationStructure $structure) {
        $user = Auth::user();
        if ($user->organization_id != 1 && $structure->organization_id != $user->organization_id) {
            abort(403, 'Akses Ditolak: Ini bukan pengurus organisasi Anda.');
        }
    }

    public function edit(OrganizationStructure $structure)
    {
        $this->checkAccess($structure);
        return view('admin.structures.edit', compact('structure'));
    }

    public function update(Request $request, OrganizationStructure $structure)
    {
        $this->checkAccess($structure);

        $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'level' => 'required|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($structure->photo) Storage::delete('public/' . $structure->photo);
            $data['photo'] = $request->file('photo')->store('structures', 'public');
        }

        $structure->update($data);

        return redirect()->route('admin.structures.index')->with('success', 'Data pengurus diperbarui!');
    }

    public function destroy(OrganizationStructure $structure)
    {
        $this->checkAccess($structure);
        
        if ($structure->photo) Storage::delete('public/' . $structure->photo);
        $structure->delete();
        return back()->with('success', 'Data dihapus.');
    }
}