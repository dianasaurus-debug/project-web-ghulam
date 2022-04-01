<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\KriteriaFuzzy;
use App\Models\LetakBarang;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_kategori' => 'required|string',
                'min_harga' => 'required',
                'max_harga' => 'required'
            ]);

            $arr = range($request->min_harga, $request->max_harga);
            $new_arr = array_chunk($arr, ceil(count($arr) / 5));
            $arr_replace = array();
            $fuzzy_nums = config('constants.bobot');
            $kriteria_word = config('constants.kriteria_harga');
            $kategori = ProductCategory::create([
                'min_harga' => $request->min_harga,
                'max_harga' => $request->max_harga,
                'nama_kategori' => $request->nama_kategori,
            ]);
            for ($i = 0; $i < count($new_arr); $i++) {
                $kriteria = Kriteria::create([
                    'kode' => 'C3',
                    'nama' => 'Harga',
                    'satuan' => 'RP',
                    'keterangan' => 'cost',
                    'category_id' => $kategori->id,
                    'himpunan' => $kriteria_word[$i],
                    'interval_min' => min($new_arr[$i]),
                    'interval_max' => max($new_arr[$i]),
                ]);
                KriteriaFuzzy::create(
                    [
                        'id_kriteria' => $kriteria->id,
                        'fuzzy_num_a' => $fuzzy_nums[$i][0],
                        'fuzzy_num_b' => $fuzzy_nums[$i][1],
                        'fuzzy_num_c' => $fuzzy_nums[$i][2],
                    ]);
            }
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Kategori gagal ditambahkan! Error : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $kategori = ProductCategory::where('id', $id)->first();
            $request->validate([
                'nama_kategori' => 'required|string',
                'min_harga' => 'required',
                'max_harga' => 'required'
            ]);
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'max_harga' => $request->max_harga,
                'min_harga' => $request->min_harga,
            ]);
            $arr = range($request->min_harga, $request->max_harga);
            $new_arr = array_chunk($arr, ceil(count($arr) / 5));
            for ($i = 0; $i < count($new_arr); $i++) {
                $kriteria = Kriteria::where('category_id', $kategori->id)->get();
                $kriteria[$i]->update([
                    'interval_min' => min($new_arr[$i]),
                    'interval_max' => max($new_arr[$i]),
                ]);
            }
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Kategori gagal diupdate! Error : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $kategori = ProductCategory::where('id', $id)->first();
            $kriteria = Kriteria::where('category_id', $kategori->id)->get();
            foreach ($kriteria as $k){
                $kriteria_fuzzy = KriteriaFuzzy::where('id_kriteria', $k->id)->delete();
                $k->delete();
            }
            $kategori->delete();
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Terjadi kesalahan! Error : ' . $e->getMessage());
        }
    }
}
