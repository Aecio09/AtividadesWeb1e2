<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->orderBy('borrowed_at', 'desc')->get();
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $books = Book::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        return view('borrowings.create', compact('books', 'users'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Verificar se o livro está disponível
        if (!$book->isAvailable()) {
            $currentBorrower = $book->currentBorrowing();
            return back()->withErrors([
                'book' => "Este livro já está emprestado para {$currentBorrower->name} desde " . 
                          \Carbon\Carbon::parse($currentBorrower->pivot->borrowed_at)->format('d/m/Y H:i') . 
                          ". Aguarde a devolução para realizar um novo empréstimo."
            ])->withInput();
        }

        // Verificar se o usuário já possui 5 empréstimos em aberto
        $user = User::findOrFail($request->user_id);
        if($user->borrowings()->whereNull('returned_at')->count() >= 5) {
            return back()->withErrors([
                'user' => "O usuário selecionado já possui 5 livros emprestados. Ele deve devolver algum livro antes de pegar outro."
            ])->withInput();
        }

        // Verificar se o usuário possui débitos pendentes
        if($user->debit > 0) {
            return back()->withErrors([
                'user' => "O usuário possui débito de R$ " . number_format($user->debit, 2, ',', '.') . ". O débito deve ser quitado antes de realizar novos empréstimos."
            ])->withInput();
        }

        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return redirect()->route('books.show', $book)->with('success', 'Empréstimo registrado com sucesso.');
    }

    public function show(Borrowing $borrowing)
    {
        return view('borrowings.show', compact('borrowing'));
    }

    public function edit(Borrowing $borrowing)
    {
        return view('borrowings.edit', compact('borrowing'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $borrowing->update($request->all());
        return redirect()->route('borrowings.show', $borrowing)->with('success', 'Empréstimo atualizado.');
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('borrowings.index')->with('success', 'Empréstimo removido.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $returnedAt = now();
        $borrowedAt = \Carbon\Carbon::parse($borrowing->borrowed_at);
        $daysLate = 0;
        $fine = 0;

        // Calcular dias de atraso (prazo é de 15 dias)
        $dueDate = $borrowedAt->copy()->addDays(15);
        
        // Corrigido: verificar se retornou DEPOIS do prazo
        if ($returnedAt->greaterThan($dueDate)) {
            // Calcular quantos dias passou do prazo
            $daysLate = $dueDate->diffInDays($returnedAt); // ordem correta: prazo -> data atual
            $fine = $daysLate * 0.50; // R$ 0,50 por dia de atraso

            // Adicionar multa ao débito do usuário
            $user = $borrowing->user;
            $user->debit += $fine;
            $user->save();
        }

        $borrowing->update([
            'returned_at' => $returnedAt,
        ]);

        // Redirecionar de volta para a página anterior
        if ($fine > 0) {
            return redirect()->back()
                ->with('warning', "Devolução registrada com {$daysLate} dia(s) de atraso. Multa de R$ " . number_format($fine, 2, ',', '.') . " adicionada ao débito do usuário.");
        }

        return redirect()->back()->with('success', 'Devolução registrada com sucesso.');
    }

    public function userBorrowings(User $user)
    {
        $borrowings = Borrowing::where('user_id', $user->id)->with('book')->orderBy('borrowed_at', 'desc')->get();
        return view('users.borrowings', compact('user', 'borrowings'));
    }
}
