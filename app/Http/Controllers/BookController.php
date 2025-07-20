<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view("books.index", ["books" => Book::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $authors = Author::all();
        return view("books.create", compact("authors"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {
        $book = Book::create($request->validated());
        if ($request->hasFile('cover')) {
            $this->saveImage($request, $book);
        } else {
            $book->cover = 'default.jpg';
        }

        $book->authors()->attach($request["authors"]);
        $book->save();
        return to_route("books.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book): View
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $book->update($request->safe()->except(["cover"]));
        if ($request->hasFile("cover")) {
            $this->saveImage($request, $book);
        }
        $book->save();
        $book->authors()->sync($request["authors"]);
        return to_route("books.index");
        // вынести в отдельную функцию блок иф, заменить update и сохранять 1 раз в конце
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->authors()->detach();
        if ($book->cover != "default.jpg") {
            Storage::disk("public")->delete("images/" . $book->cover);
        }
        $book->delete();
        return to_route("books.index");
    }

    public function saveImage(FormRequest $request, Book $book): void
    {
        $cover = $request->cover;
        $extension = $cover->extension();
        $fileName = uniqid() . "." . $extension;
        $request->file('cover')->storePubliclyAs('images/', $fileName, 'public');
        $book->cover = $fileName;
    }
}
