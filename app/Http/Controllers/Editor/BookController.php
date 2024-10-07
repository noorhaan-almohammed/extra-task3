<?php

namespace App\Http\Controllers\Editor;

use App\Models\Book;
use App\Http\Services\BookService;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;
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
     * Store a newly created resource in storage.
     */
    public function store(storeBookRequest $bookRequest)
    {
        $this->authorize('create_book', Book::class);
        $book = $bookRequest->validated();
        $response = $this->bookService->createBook($book);
        return parent::successResponse('books', new BookResource($response), "Book created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return parent::successResponse('book', new BookResource($book), "Book retrieved successfully", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $bookRequest, Book $book)
    {
        $this->authorize('edit_book', Book::class);
        $data = $bookRequest->validated();
        $response = $this->bookService->updateBook($data, $book);
        return parent::successResponse('books', new BookResource($response), "Book updated successfully", 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->bookService->destroy($book);
        return parent::successResponse('book', new BookResource($book), "Book Deleted successfully", 200);
    }
}
