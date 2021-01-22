<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        if(!empty($keyword)) {
            $data['categories'] = Category::where('name', 'like', '%'.$keyword.'%')->orWhere('slug_name', 'like', '%'.$keyword.'%')->paginate(10);
        } else {
            $data['categories'] = Category::paginate(10);
        }
        return view('category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:category'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug_name = Str::slug($request->name);
        $category->save();

        return redirect()->route('category.index')->with('status', 'Category '.$category->name.' berhasil ditambahkan.');
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
        $category = Category::findOrFail($id);
        return view('category.edit', ['category' => $category]);
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
        $request->validate([
            'name'  => 'unique:category,name,'.$id
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug_name = Str::slug($request->name);
        $category->save();

        return redirect()->route('category.index')->with('status', 'Category '.$category->name.' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('status', 'Category '.$category->name.' berhasil dihapus.');
    }

    public function getSelect2Data(){
        return Category::all();
    }
}
