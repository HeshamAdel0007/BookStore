<?php

namespace Modules\Book\Repositories;

use App\Helper\Helpers;
use Modules\Book\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Modules\Book\Transformers\BookResource;
use Symfony\Component\HttpFoundation\Response;
use Modules\Book\Interfaces\BookRepositoryInterface;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Modules\Book\Transformers\ShowPublisherBooksResource;


class BookRepository implements BookRepositoryInterface
{
    public function allBooks(): JsonResponse
    {
        try {
            $books = Book::with('publisher:id,name', 'discount:id,discount_value,discount_type')
                ->latest()
                ->paginate(20);
            return Helpers::successResponse('Book retrieved successfully.', $books);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('Failed to retrieved book. Please try again.', $ex->getMessage());
        }
    } //end of allBooks

    public function create($request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $book                 = new Book;
            $book->publisher_id   = Auth::user()->id;
            $book->name           = $request->name;
            $book->price          = $request->price;
            $book->stock_quantity = $request->stock_quantity;
            $book->isbn           = $request->isbn;
            $book->published_date = $request->published_date;
            $book->category_id    = $request->category_id;
            $book->description    = $request->description;
            $book->save();

            if ($request->hasFile('book_cover')) {
                $book->addMediaFromRequest('book_cover')
                    ->toMediaCollection('bookCover', 'media');
            }
            DB::commit();

            return Helpers::successResponse('create books successfully.', null, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            DB::rollBack(); // Rollback if validation fails
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('Failed to create book. Please try again.');
        }
    } //end of create

    /**
     * retrieve a specific book by its ID
     */
    public function show(int $id): JsonResponse
    {
        try {
            $book = $this->findBook($id);
            $bookResource = new ShowPublisherBooksResource($book);
            return Helpers::successResponse('book found', $bookResource);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // End Of show

    public function edit($request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $book = Book::findOrFail($id);

            if ($book->publisher_id !== Auth::user()->id) {
                return Helpers::notFoundResponse('You are not authorized to update this book.');
            }


            $book->name           = $request->name;
            $book->price          = $request->price;
            $book->stock_quantity = $request->stock_quantity;
            $book->isbn           = $request->isbn;
            $book->published_date = $request->published_date;
            $book->category_id    = $request->category_id;
            $book->description    = $request->description;
            $book->save();


            if ($request->hasFile('book_cover')) {
                $oldCover = $book->getFirstMedia('bookCover');
                if ($oldCover) {
                    $oldCover->delete();
                }
                $book->addMediaFromRequest('book_cover')
                    ->toMediaCollection('bookCover', 'media');
            }

            DB::commit();

            return Helpers::successResponse('Book updated successfully.', null, Response::HTTP_OK);
        } catch (\Exception $ex) {
            DB::rollBack(); // Rollback in case of an error
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('Failed to update book. Please try again.');
        }
    } // end of edit

    /**
     *  book is not permanently removed but marked as deleted (trashed)
     */
    public function softdelete(int $id): JsonResponse
    {
        try {
            $book = $this->findBook($id);
            $book->delete();
            return Helpers::successResponse('book deleted successfully.');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of softdelete

    /**
     * retrieves all soft-deleted books (those in the "trashed" state).
     */
    public function bookTrash(): JsonResponse
    {

        try {
            // authenticated user
            $publisher = Auth::user()->id;
            // Retrieve only trashed books for the authenticated user
            $books = Book::where('publisher_id', $publisher)
                ->onlyTrashed()
                ->paginate(25);

            if ($books->isEmpty()) {
                return Helpers::successResponse('No trashed books found.');
            }

            return Helpers::successResponse('Trashed books retrieved successfully.', $books);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } // end of bookTrash

    /**
     * Restore a soft-deleted book.
     */
    public function restoredBook(int $id): JsonResponse
    {
        try {
            $book = Book::withTrashed()->find($id);

            if (!$book || !$book->trashed()) {
                return Helpers::notFoundResponse('book not found or not trashed.');
            }
            // Restore the book
            $book->restore();
            return Helpers::successResponse('book restored successfully.');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of restoredBook

    /**
     * Permanently delete a book, including soft-deleted ones.
     */
    public function forceDeleteBook(int $id): JsonResponse
    {
        try {
            $book = Book::withTrashed()->find($id);

            if (!$book) {
                return Helpers::notFoundResponse('book not found.');
            }
            // Permanently delete the publisher
            $book->forceDelete();
            return Helpers::successResponse('book permanently deleted successfully.');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of forceDeleteBook

    private function findBook(int $id)
    {
        $book = Book::find($id);
        if (!$book) {
            throw new \Exception('Book not found with the given ID.');
        }
        return $book;
    } //end of findBook

}// end of BookRepository
