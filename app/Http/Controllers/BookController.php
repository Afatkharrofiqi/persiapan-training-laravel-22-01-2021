<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data['books'] = Book::paginate(10);
        if(!empty($keyword)) {
            $data['books'] = Book::where('name','like','%'.$keyword.'%')->paginate(10);
        }
        return view('book.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create');
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
            'name'      => 'required|unique:category,name',
            'image'     => 'mimes:jpg|required|max:10000',
            'categories'=> 'required'
        ]);

        $book = new Book();
        $book->name = $request->name;
        $book->slug = Str::slug($request->name);
        if($request->file('image')){
            $image_path = $request->file('image')->store('book_images', 'public');
            $book->image = $image_path;
        }
        $book->created_by = Auth::user()->id;
        $book->save();

        $book->categories()->attach($request->categories);

        return redirect()->route('book.index')->with('status','Book '.$book->name.' berhasil ditambahkan.');
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
        $book = Book::findOrFail($id);
        return view('book.edit', ['book' => $book]);
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
            'name'      => 'unique:book,name,'.$id,
            'categories'=> 'required',
            'image'     => 'nullable|mimes:jpg|max:10000'
        ]);

        $book = Book::findOrFail($id);
        $book->name = $request->name;
        $book->slug = Str::slug($request->name);
        if($request->file('image')) {
            if($book->image && file_exists(storage_path('app/public/'. $book->image))){
                Storage::delete('public/'.$book->image);
            }
            $image_path = $request->file('image')->store('book_images', 'public');
            $book->image = $image_path;
        }
        $book->updated_by = Auth::user()->id;
        $book->save();

        $book->categories()->sync($request->categories);

        return redirect()->route('book.index')->with('status', 'Book '.$book->name.' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->categories()->detach();
        if($book->image && file_exists(storage_path('app/public/'. $book->image))){
            Storage::delete('public/'.$book->image);
        }
        $book->delete();

        return redirect()->route('book.index')->with('status', 'Book '.$book->name.' berhasil dihapus.');
    }
}
