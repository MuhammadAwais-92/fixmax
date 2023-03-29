<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CityRepository;


class CitiesController extends Controller
{

    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        parent::__construct();
        $this->cityRepository = $cityRepository;
    }

    public function cities(){
        $this->cityRepository->setPaginate(0);
        $this->cityRepository->setRelations([
            'areas',
        ]);
        $this->cityRepository->setSelect([
            'id',
            'name'
        ]);
        $cities =  $this->cityRepository->all(true);
        return responseBuilder()->success(__('Cities'), ['cities' => $cities]);
    }
}
