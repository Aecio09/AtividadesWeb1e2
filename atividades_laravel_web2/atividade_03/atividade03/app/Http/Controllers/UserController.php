<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        User::create($request->only('name', 'email', 'password'));
        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'nullable|in:admin,bibliotecario,cliente',
        ]);

        $data = $request->only('name', 'email');

        // somente admin pode alterar role
        if ($request->user()->role === 'admin' && $request->filled('role')) {
            $data['role'] = $request->role;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }

    /**
     * Exibir usuários com débitos (somente para bibliotecários e admin)
     */
    public function debits()
    {
        $this->authorize('viewAny', User::class);
        
        $usersWithDebits = User::where('debit', '>', 0)->orderBy('debit', 'desc')->get();
        return view('users.debits', compact('usersWithDebits'));
    }

    /**
     * Zerar o débito de um usuário (somente para bibliotecários e admin)
     */
    public function clearDebit(User $user)
    {
        $this->authorize('update', $user);
        
        $user->update(['debit' => 0]);
        return redirect()->back()->with('success', 'Débito de ' . $user->name . ' foi zerado com sucesso.');
    }
}
