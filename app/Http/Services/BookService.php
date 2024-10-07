<?php
namespace App\Http\Services;

use Exception;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookService
{

    public function listBooks()
    {
        try {
            return Book::simplePaginate(5);
        } catch (Exception $e) {
            Log::error('Error Founding Books' . $e->getMessage());
            throw new Exception('There is something wrong with server');
        }
    }
    public function indexByCategory($categoryId){
        try {
            return Book::byCategory($categoryId)->simplePaginate(5);
        } catch (Exception $e) {
            Log::error('Error Founding Books' . $e->getMessage());
            throw new Exception('There is something wrong with server');
        }
    }
    public function createBook(array $book)
    {
        try {
            $book['is_active'] ??= true;
            $book['created_by'] = Auth::id();
            return Book::create($book);
        } catch (Exception $e) {
            Log::error('Error Creating Book' . $e->getMessage(), ['book' => $book]);
            throw new Exception('There is something wrong with server');
        }
    }
    public function updateBook(array $data, Book $book)
    {
        try {
            $book->title = $data['title'] ?? $book->title;
            $book->author = $data['author'] ?? $book->author;
            $book->published_at = $data['published_at'] ?? $book->published_at;
            $book->is_active = $data['is_active'] ?? $book->is_active;
            $book->category_id = $data['category_id'] ?? $book->category_id;
            $book->save();
            return $book;
        } catch (Exception $e) {
            Log::error('Error Updating Book' . $e->getMessage(), ['book' => $book]);
            throw new Exception('There is something wrong with server');
        }
    }
    public function destroy(Book $book)
    {
        try {
            return $book->delete();
        } catch (Exception $e) {
            Log::error('Error Deleting Book' . $e->getMessage());
            throw new Exception('There is something wrong with server');
        }
    }
    public function borrowBook(Book $book)
    {
        try {
            if ($book->borrow_to) {
                throw new Exception('This book is already borrowed.');
            }
            $user = Auth::user();
            $book->borrow_to = $user->id;
            $book->is_active = 0; // Mark book as inactive (borrowed)
            $book->save();

            return $book;
        } catch (Exception $e) {
            Log::error('Error Borrowing Book: ' . $e->getMessage(), [
                'book_id' => $book->id,
                'user_id' => $user->id,
            ]);
            throw new Exception('There is something wrong with the server.');
        }
    }

    public function returnBook(Book $book)
    {
        try {
            $user = Auth::user(); // Get the authenticated user

            if ($book->borrow_to != $user->id) {
                throw new Exception('This book is not borrowed by you.');
            }

            // Reset the book's status
            $book->borrow_to = null;
            $book->is_active = 1; // Mark the book as available
            $book->save();

            return $book;
        } catch (Exception $e) {
            Log::error('Error Returning Book: ' . $e->getMessage(), [
                'book_id' => $book->id,
                'user_id' => $user->id, // Optionally log the user ID for better traceability
            ]);
            throw new Exception('There is something wrong with the server.');
        }
    }

}

