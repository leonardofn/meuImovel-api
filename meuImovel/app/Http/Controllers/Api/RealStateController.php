<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Models\RealState;
use App\Http\Requests\RealStateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RealStateController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        $realStates = auth()->user()->realState();

        return response()->json($realStates->paginate(10), 200);
    }

    public function show($id)
    {
        try {
            
            $realState = auth()->user()->realState()->with('photos')->findOrFail($id);

            return response()->json([
                'data' => $realState
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }


    public function store(RealStateRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {

            $realState = auth()->user()->realState()->create($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            if ($images) {
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }
                
                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel cadastrado com sucesso.'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update($id, RealStateRequest $request)
    {
        $data = $request->all();

        try {

            $realState = auth()->user()->realState()->findOrFail($id);
            $realState->update($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel atualizado com sucesso.'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try {

            $realState = $this->realState->findOrFail($id);
            $realState->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel removido com sucesso.'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
