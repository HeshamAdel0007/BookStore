<?php

namespace Modules\Book\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Book\Http\Requests\CreateBookRequest;
use Modules\Book\Http\Requests\EditBookRequest;
use Modules\Book\Interfaces\BookRepositoryInterface;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class BookController extends Controller implements HasMiddleware
{
    protected BookRepositoryInterface $bookRepository;
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    } // end of construct


    public static function middleware(): array
    {
        return [
            new Middleware('role:super-admin|publisher', except: ['books']),
        ];
    } // end of middleware


    /**
     * retrieves a list of all books.
     */
    public function books()
    {
        return $this->bookRepository->allBooks();
    } // end of books

    /**
     * Creates a new book
     * @param \Modules\Book\Http\Requests\CreateBookRequest $request
     */
    public function store(CreateBookRequest $request)
    {
        return $this->bookRepository->create($request);
    } //end of store

    /**
     *  Retrieves details of a specific book by its ID.
     * @param int $id
     */
    public function show(int $id)
    {
        return $this->bookRepository->show($id);
    } //end of show

    /**
     * Updates an existing book.
     * @param \Modules\Book\Http\Requests\EditBookRequest $request
     * @param int $id
     */
    public function edit(EditBookRequest $request, int $id)
    {
        return $this->bookRepository->edit($request, $id);
    } //end of edit

    /**
     * Soft deletes a book (marks it as deleted without removing it from the database).
     * @param int $id
     */
    public function softDelete(int $id)
    {
        return $this->bookRepository->softdelete($id);
    } //end of softDelete

    /**
     *  Retrieves a list of soft-deleted books.
     */
    public function trash()
    {
        return $this->bookRepository->bookTrash();
    } //end of trash

    /**
     * Restores a soft-deleted book
     * @param int $id
     */
    public function restore(int $id)
    {
        return $this->bookRepository->restoredBook($id);
    } // end of restore

    /**
     * Permanently deletes a book from the database.
     * @param int $id
     */
    public function destroy(int $id)
    {
        return $this->bookRepository->forceDeleteBook($id);
    } // end of destroy

}//end of controller
