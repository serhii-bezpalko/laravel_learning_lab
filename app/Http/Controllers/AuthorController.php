<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $orderBy = $request->get("sort", "asc");
        $surname = $request->get("surname");
        $name = $request->get("name");
        $authors = Author::query()
            ->when($surname, fn($q, $surname) => $q->where("surname", $surname))
            ->when($name, fn($q, $name) => $q->where("name", $name))
            ->orderBy("surname", $orderBy)
            ->paginate(15)
            ->appends(["sort" => $orderBy, "surname" => $surname, "name" => $name]);
        if ($request->ajax()) {
            return response()->json([
                'list' => view('authors.list', compact('authors'))->render(),
                'pagination' => $authors->links()->render()
            ]);
        }
        return view("authors.index", compact("authors", "orderBy", "surname", "name"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request): JsonResponse
    {
        Author::create($request->validated());
        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author): View
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author): JsonResponse
    {
        $author->update($request->validated());
        return response()->json(['author' => view('authors._author', compact('author'))->render()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author): JsonResponse
    {
        $author->books()->detach();
        $author->delete();
        return response()->json();
    }
}
