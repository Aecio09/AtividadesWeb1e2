<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookApiController extends Controller
{
    /**
     * Display a listing of books.
     * GET /api/books
     */
    public function index(): JsonResponse
    {
        $books = Book::with(['author', 'category', 'publisher'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $books
        ], 200);
    }

    /**
     * Store a newly created book in storage.
     * POST /api/books
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['title', 'publisher_id', 'author_id', 'category_id', 'published_year']);

        // Handle cover image upload
        if ($file = $request->file('cover_image')) {
            $filename = Str::slug($request->title ?: 'cover') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('books', $filename, 'public');
            $data['cover_image'] = $path;
        }

        $book = Book::create($data);
        $book->load(['author', 'category', 'publisher']);

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Display the specified book.
     * GET /api/books/{id}
     */
    public function show(string $id): JsonResponse
    {
        $book = Book::with(['author', 'category', 'publisher'])->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $book
        ], 200);
    }

    /**
     * Update the specified book in storage.
     * PUT/PATCH /api/books/{id}
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'publisher_id' => 'sometimes|required|exists:publishers,id',
            'author_id' => 'sometimes|required|exists:authors,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'published_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['title', 'publisher_id', 'author_id', 'category_id', 'published_year']);

        // Handle cover image upload
        if ($file = $request->file('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $filename = Str::slug($request->title ?: 'cover') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('books', $filename, 'public');
            $data['cover_image'] = $path;
        }

        $book->update($data);
        $book->load(['author', 'category', 'publisher']);

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully',
            'data' => $book
        ], 200);
    }

    /**
     * Remove the specified book from storage.
     * DELETE /api/books/{id}
     */
    public function destroy(string $id): JsonResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        }

        // Delete cover image if exists
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully'
        ], 200);
    }
}
