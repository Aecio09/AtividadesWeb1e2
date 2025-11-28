<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Book::class, 'book');
    }

   
    public function createWithId()
    {
        $this->authorize('create', Book::class);
        return view('books.create-id');
    }

    public function storeWithId(Request $request)
    {
        $this->authorize('create', Book::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['title', 'publisher_id', 'author_id', 'category_id', 'published_year']);

        if ($file = $request->file('cover_image')) {
            $filename = Str::slug($request->title ?: 'cover') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('books', $filename, 'public');
            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    public function createWithSelect()
    {
        $this->authorize('create', Book::class);
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.create-select', compact('publishers', 'authors', 'categories'));
    }

    public function storeWithSelect(Request $request)
    {
        $this->authorize('create', Book::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['title', 'publisher_id', 'author_id', 'category_id', 'published_year']);

        if ($file = $request->file('cover_image')) {
            $filename = Str::slug($request->title ?: 'cover') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('books', $filename, 'public');
            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }
    public function edit(Book $book)
    {
    $publishers = Publisher::all();
    $authors = Author::all();
    $categories = Category::all();

    return view('books.edit', compact('book', 'publishers', 'authors', 'categories'));
    }
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'nullable|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['title', 'publisher_id', 'author_id', 'category_id', 'published_year']);

        if ($file = $request->file('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $filename = Str::slug($request->title ?: 'cover') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('books', $filename, 'public');
            $data['cover_image'] = $path;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
    }
    public function show(Book $book)
    {
        $book->load(['author', 'publisher', 'category']);
        $users = User::orderBy('name')->get();
        return view('books.show', compact('book', 'users'));
    }
    public function index() {
        $books = Book::with('author')->paginate(20);

        return view('books.index', compact('books'));
    }
    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso.');
    }
}



