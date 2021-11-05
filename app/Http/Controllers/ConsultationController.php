<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use  App\Services\ConsultationService;

class ConsultationController extends Controller
{
    /**
     * @var \App\Services\ConsultationService
     */
    private $consultation;

        /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\ConsultationService  $consultation
     * @return void
     */
    public function __construct(
        ConsultationService $consultation,
        ProjectService $projectService
    )
    {
        $this->consultation = $consultation;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $result = $this->consultation->index($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->consultation->show($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $params = $request->all();

        $result = $this->consultation->create($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePayment(Request $request)
    {

        $params = $request->all();

        $result = $this->consultation->updatePayment($params);

        return response()->json($result['data'], $result['status']);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeChat(Request $request)
    {

        $params = $request->all();

        $result =  $this->projectService->createChat($params);

        return response()->json($result['data'], $result['status']);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateChat(Request $request)
    {

        $params = $request->all();

        $result =  $this->projectService->updateChat($params);

        return response()->json($result['data'], $result['status']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();

        $result = $this->consultation->update($params, $id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        $result = $this->consultation->destroy($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showStatus($id)
    {
        $result = $this->consultation->showStatus($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showChatFiles($id)
    {
        $result = $this->consultation->showChatFiles($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $params = $request->all();

        return $this->consultation->export($params);

    }

}
