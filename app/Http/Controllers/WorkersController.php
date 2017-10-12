<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkerRequest;
use Illuminate\Http\Request;
use App\Worker;
use Illuminate\Http\Response;

class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = Worker::orderBy('id', 'desc')->paginate(10);

        return response()->handle('workers.index', ['workers' => $workers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('workers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WorkerRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkerRequest $request)
    {
        $worker = Worker::create($request->toArray());
        $uri = '/workers/' . $worker->id;

        return response()
            ->handle('workers.saved', ['worker' => $worker, 'uri' => $uri], Response::HTTP_CREATED)
            ->header('Location', $uri);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $worker = Worker::findOrFail($id);

        return response()->handle('workers.show', ['worker' => $worker]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $worker = Worker::findOrFail($id);

        return response()->handle('workers.edit', ['worker' => $worker]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WorkerRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(WorkerRequest $request, $id)
    {
        $worker = Worker::findOrFail($id);
        $worker->update($request->all());

        return response()->handle('workers.saved', ['worker' => $worker]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $worker = Worker::findOrFail($id);
        $worker->delete();

        return response()->handle('workers.removed', [], Response::HTTP_NO_CONTENT);
    }
}
