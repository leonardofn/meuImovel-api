<?php

namespace App\Http\Controllers\Api;

use App\Repository\RealStateRepository;
use App\Models\RealState;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RealStateSearchController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $repository = new RealStateRepository($this->realState);

        if($request->has('conditions')) {
            $repository->selectCoditions($request->get('conditions'));
        }

        if($request->has('fields')) {
            $repository->selectFilter($request->get('fields'));
        }

        return response()->json([
            'data' => $repository->getResult()->paginate(10)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
