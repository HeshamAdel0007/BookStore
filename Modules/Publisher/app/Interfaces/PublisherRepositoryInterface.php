<?php

namespace Modules\Publisher\Interfaces;

interface PublisherRepositoryInterface
{
    public function publisherDetails(int $id);
    public function publisherBooks(int $id);
    public function orders(int $id);
    public function orderItemInfo(int $id, int $orderID);
    public function show(int $id);
    public function edit($request, int $id);
    public function softDeleted(int $id);
} // end of interface
