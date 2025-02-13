<?php

namespace Modules\Book\Interfaces;

use Modules\Book\Http\Requests\CreateBookRequest;

interface BookRepositoryInterface
{
    public function allBooks();
    public function create($request);
    public function show(int $id);
    public function edit($request, int $id);
    public function softdelete(int $id);
    public function bookTrash();
    public function restoredBook(int $id);
    public function forceDeleteBook(int $id);
}//end of interface
