<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $members = Member::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'prodi' => 'required|in:Pend. Teknologi Informasi,Sistem Informasi, Teknik Informatika',
            'email' => 'required|email|unique:members,email',
            'hp' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'prodi' => 'required|in:Pend. Teknologi Informasi,Sistem Informasi,Teknik Informatika',
            'hp' => 'required|string|max:15',
            'email' => 'required|email|unique:members,email,' . $member->id,
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
