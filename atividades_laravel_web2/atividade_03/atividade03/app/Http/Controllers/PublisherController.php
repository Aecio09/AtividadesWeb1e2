<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Publisher::class, 'publisher');
    }

    public function index()
    {
        $publishers = Publisher::orderBy('name')->get();
        return view('publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('publishers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255|unique:publishers,name',
            'address' => 'nullable|string|max:255',
        ]);

        Publisher::create($data);

        return redirect()->route('publishers.index')->with('success', 'Editora criada com sucesso.');
    }

    public function show(Publisher $publisher)
    {
        return view('publishers.show', compact('publisher'));
    }

    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255|unique:publishers,name,' . $publisher->id,
            'address' => 'nullable|string|max:255',
        ]);

        $publisher->update($data);

        return redirect()->route('publishers.index')->with('success', 'Editora atualizada com sucesso.');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('publishers.index')->with('success', 'Editora excluída com sucesso.');
    }
}
