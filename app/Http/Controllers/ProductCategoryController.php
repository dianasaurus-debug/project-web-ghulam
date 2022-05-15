<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\KriteriaFuzzy;
use App\Models\LetakBarang;
use App\Models\ProductCategory;
use App\Models\SubCategory;
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
            ->with('sub_categories')
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
                'sub_category_list' => 'required'
            ]);

            $fuzzy_nums = config('constants.bobot');
            $kriteria_word = config('constants.kriteria_harga');
            $kategori = ProductCategory::create([
                'nama_kategori' => $request->nama_kategori,
            ]);
            foreach($request->sub_category_list as $subcategory_field){
                $subcategory = SubCategory::create([
                    'category_id' => $kategori->id,
                    'min_harga' => $subcategory_field['min_harga'],
                    'max_harga' => $subcategory_field['max_harga'],
                    'nama_kategori' => $subcategory_field['nama_kategori'],
                ]);
                $arr = range($subcategory->min_harga, $subcategory->max_harga);
                $new_arr = array_chunk($arr, ceil(count($arr) / 5));
                for ($i = 0; $i < count($new_arr); $i++) {
                    $kriteria = Kriteria::create([
                        'kode' => 'C3',
                        'nama' => 'Harga',
                        'satuan' => 'RP',
                        'keterangan' => 'cost',
                        'category_id' => $subcategory->id,
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
            $sub_categories = SubCategory::where('category_id', $kategori->id)
                ->select(['id','nama_kategori', 'min_harga', 'max_harga'])
                ->get();
            return Inertia::render('Categories/Edit', [
                'sub_categories' => $sub_categories,
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
//        try {
            $request->validate([
                'nama_kategori' => 'required|string',
                'sub_category_list' => 'required'
            ]);

            $fuzzy_nums = config('constants.bobot');
            $kriteria_word = config('constants.kriteria_harga');
            $kategori = ProductCategory::where('id', $id)
                ->with('sub_categories')->first();
            $list_of_sub_ids = [];
            $list_of_used_id = [];
            for ($i=0;$i<count($kategori->sub_categories);$i++){
                $list_of_sub_ids[$i] = $kategori->sub_categories[$i]->id;
            }
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            foreach($request->sub_category_list as $subcategory_field){
                if($subcategory_field['id']!=null){
                    if (in_array($subcategory_field['id'], $list_of_sub_ids)) {
                        array_push($list_of_used_id, $subcategory_field['id']);
                    }
                    $subcategory = SubCategory::where('id', $subcategory_field['id'])->first();
                    $subcategory->update([
                        'min_harga' => $subcategory_field['min_harga'],
                        'max_harga' => $subcategory_field['max_harga'],
                        'nama_kategori' => $subcategory_field['nama_kategori'],
                    ]);
                    $arr = range($subcategory->min_harga, $subcategory->max_harga);
                    $new_arr = array_chunk($arr, ceil(count($arr) / 5));
                    for ($i = 0; $i < count($new_arr); $i++) {
                        $kriteria = Kriteria::where('category_id', $subcategory->id)
                            ->where('himpunan', $kriteria_word[$i])
                            ->first();
                        $kriteria->update([
                            'interval_min' => min($new_arr[$i]),
                            'interval_max' => max($new_arr[$i]),
                        ]);
                    }
                } else {
                    $subcategory = SubCategory::create([
                        'category_id' => $kategori->id,
                        'min_harga' => $subcategory_field['min_harga'],
                        'max_harga' => $subcategory_field['max_harga'],
                        'nama_kategori' => $subcategory_field['nama_kategori'],
                    ]);
                    $arr = range($subcategory->min_harga, $subcategory->max_harga);
                    $new_arr = array_chunk($arr, ceil(count($arr) / 5));
                    for ($i = 0; $i < count($new_arr); $i++) {
                        $kriteria = Kriteria::create([
                            'kode' => 'C3',
                            'nama' => 'Harga',
                            'satuan' => 'RP',
                            'keterangan' => 'cost',
                            'category_id' => $subcategory->id,
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
                }
            }
            $array_not_used = $differenceArray = array_diff($list_of_sub_ids, $list_of_used_id);
            if(count($array_not_used)>0){
                foreach ($array_not_used as $key => $value) {
                    $subcategory = SubCategory::where('id', $value)->delete();
                    $kriteria = Kriteria::where('category_id', $value)->get();
                    foreach ($kriteria as $k){
                        $k->delete();
                        $kriteria_fuzzy = KriteriaFuzzy::where('id_kriteria', $k->id)->first();
                        $kriteria_fuzzy->delete();
                    }
                }
            }
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
//        } catch (\Exception $e) {
//            return redirect()->route('categories.index')->with('error', 'Kategori gagal ditambahkan! Error : ' . $e->getMessage());
//        }

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
