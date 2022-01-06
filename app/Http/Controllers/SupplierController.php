<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $all_suppliers = Supplier::orderByName()
            ->filter(\Illuminate\Support\Facades\Request::only(['search']))
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Supplier/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'suppliers' => $all_suppliers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Supplier/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_supplier' => 'required|string',
                'phone' => 'required|unique:suppliers',
                'deskripsi' => 'required',
                'email' => 'required|unique:suppliers',
                'alamat' => 'required',
            ]);

            $supplier = Supplier::create([
                'nama_supplier' => $request->nama_supplier,
                'phone' => $request->phone,
                'deskripsi' => $request->deskripsi,
                'email' => $request->email,
                'alamat' => $request->alamat,
            ]);

            return redirect()->route('suppliers.index')->with('success', 'Suplier berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Suplier gagal ditambahkan! Error : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $supplier = Supplier::where('id', $id)->first();
            return Inertia::render('Supplier/Edit', [
                'supplier' => $supplier,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Terjadi kesalahan! Error : ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $supplier = Supplier::where('id', $id)->first();
            $request->validate([
                'nama_supplier' => 'required|string',
                'phone' => 'required|unique:suppliers',
                'deskripsi' => 'required',
                'email' => 'required|unique:suppliers',
                'alamat' => 'required',
            ]);
            $supplier->update([
                'nama_supplier' => $request->nama_supplier,
                'phone' => $request->phone,
                'deskripsi' => $request->deskripsi,
                'email' => $request->email,
                'alamat' => $request->alamat,
            ]);
            return redirect()->route('suppliers.index')->with('success', 'Suplier berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Suplier gagal diupdate! Error : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::where('id', $id)->first();
            $supplier->delete();
            return redirect()->route('suppliers.index')->with('success', 'Suplier berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Terjadi kesalahan! Error : ' . $e->getMessage());
        }
    }
}
