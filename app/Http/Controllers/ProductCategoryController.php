<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_categories = ProductCategory::orderById()
            ->filter(\Illuminate\Support\Facades\Request::only(['search']))
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Categories/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'categories' => $all_categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Categories/Create');
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
                'nama_kategori' => 'required|string',
            ]);

            $kategori = ProductCategory::create([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Kategori gagal ditambahkan! Error : ' . $e->getMessage());
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
            $kategori = ProductCategory::where('id', $id)->first();
            return Inertia::render('Categories/Edit', [
                'categories' => $kategori,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Terjadi kesalahan! Error : ' . $e->getMessage());
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
            $kategori = ProductCategory::where('id', $id)->first();
            $request->validate([
                'nama_kategori' => 'required|string',
            ]);
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Kategori gagal diupdate! Error : ' . $e->getMessage());
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
            $kategori = ProductCategory::where('id', $id)->first();
            $kategori->delete();
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Terjadi kesalahan! Error : ' . $e->getMessage());
        }
    }
}
