<?php

namespace Modules\Publisher\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Modules\Publisher\Http\Requests\EditPublisherRequest;
use Modules\Publisher\Interfaces\PublisherRepositoryInterface;

class PublisherController extends Controller implements HasMiddleware
{
    protected PublisherRepositoryInterface $publisherRepository;

    public function __construct(PublisherRepositoryInterface $publisherRepository)
    {
        $this->publisherRepository = $publisherRepository;
    } // end of construct

    public static function middleware(): array
    {
        return [
            new Middleware('role:super-admin|publisher', except: ['showPublisher']),
        ];
    } // end of middleware

    public function getPublisher()
    {
        $id = Auth::user()->id;
        return $this->publisherRepository->publisherDetails($id);
    } // end of getPublisher

    public function getPublisherBooks()
    {
        $id = Auth::user()->id;
        return $this->publisherRepository->publisherBooks($id);
    } // end of getPublisherBooks

    public function getPublisherOrders()
    {
        $id = Auth::user()->id;
        return $this->publisherRepository->orders($id);
    }
    public function getOrdersInfo(int $orderID)
    {
        $id = Auth::user()->id;
        return $this->publisherRepository->orderItemInfo($id, $orderID);
    }

    public function showPublisher(int $id)
    {
        return $this->publisherRepository->show($id);
    } // end of show publisher

    public function editPublisher(EditPublisherRequest $request, int $id)
    {
        return $this->publisherRepository->edit($request, $id);
    } // end of editPublisher

    public function delete(int $id)
    {
        return $this->publisherRepository->softDeleted($id);
    } // end of delete

}// end of controller
