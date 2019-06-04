<?php

namespace App\Http\Controllers\Dashboard\Address;

use App\Http\Controllers\Controller;
use App\Services\AddressStateService;

class StateController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'Estados',
            'resources' => AddressStateService::getAll()
        ];

        return view('dashboard.address.state.index', $data);
    }
}
