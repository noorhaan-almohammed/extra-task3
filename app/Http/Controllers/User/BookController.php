<?php

namespace App\Http\Controllers\Editor;

use App\Models\Book;
use App\Models\User;
use App\Http\Services\BookService;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Requests\Book\storeBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = $this->bookService->listBooks();
        if ($books->isEmpty()) {
            return parent::errorResponse( "No Bookk Found", 404);
        }
        return parent::successResponse('books',
                                               BookResource::collection($books)->response()->getData(true),  // response with Metadata
                                               "Books retrieved successfully",
                                               200);
    }
    public function indexByCategory($category_id){
        $books = $this->bookService->indexByCategory($category_id);
        if ($books->isEmpty()) {
            return parent::errorResponse("No Bookk Found", 404);
        }
        return parent::successResponse('books',
                                               BookResource::collection($books)->response()->getData(true),  // response with Metadata
                                               "Books retrieved successfully",
                                               200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return parent::successResponse('book', new BookResource($book), "Book retrieved successfully", 200);
    }
    public function borrowBook(Book $book){
        $book = $this->bookService->borrowBook($book);
        return parent::successResponse('book', new BookResource($book), "Book borrowed successfully", 200);
    }
    public function returnBook(Book $book)
    {
        $book = $this->bookService->returnBook($book);
        return parent::successResponse('book', new BookResource($book), "Book returned successfully", 200);

    }
}
