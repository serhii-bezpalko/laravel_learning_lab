<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $orderBy = $request->get("sort", "asc");
        $title = $request->get("title");
        $author = $request->get("author");
        $books = Book::query()
            ->when($title, fn ($q, $title) => $q->where("title", $title))
            ->when($author, fn ($q, $author) => $q->whereHas('authors', fn($q) => $q->where("surname", $author)))
            ->orderBy("title", $orderBy)
            ->paginate(15)
            ->appends(["sort" => $orderBy,
                "title" => $title,
                "author" => $author]);
        $authors = Author::all();

        if ($request->ajax()) {
            return response()->json([
                'list' => view('books.list', compact('books'))->render(),
                'pagination' => $books->links()->render()
            ]);
        }

        return view("books.index", compact("books", "orderBy", "title", "author", "authors"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $authors = Author::query()->paginate(1);
        return view("books.create", compact("authors"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());
        if ($request->hasFile('cover')) {
            $this->saveImage($request, $book);
        } else {
            $book->cover = 'default.jpg';
        }
        $book->authors()->attach($request["authors"]);
        $book->save();
        return response()->json();
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
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        $book->update($request->safe()->except(["cover"]));
        if ($request->hasFile("cover")) {
            $this->saveImage($request, $book);
        }
        $book->save();
        $book->authors()->sync($request["authors"]);
        return response()->json(['book' => view('books._book', compact('book'))->render()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): JsonResponse
    {
        $book->authors()->detach();
        if ($book->cover != "default.jpg") {
            Storage::disk("public")->delete("images/" . $book->cover);
        }
        $book->delete();
        return response()->json();
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
