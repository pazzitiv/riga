<?php

namespace App\Http\Controllers;

use App\Repositories\CommandsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommandsController extends Controller
{
    public function initRepo(): void
    {
        $this->setRepository(new CommandsRepository());
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function list()
    {
        return \response()->json($this->repository->listCommands());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        throw_if($validator->fails(), new \Exception('Wrong command name', 400));

        return $this->repository->createCommand($request->get('name'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function generate(): JsonResponse
    {
        $commands = $this->repository->generateCommands();

        return \response()->json($commands);
    }
}
