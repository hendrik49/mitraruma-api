<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserConsultationController extends Controller
{
    /**
     * @var \App\Services\ConsultationService
     */
    private $consultation;

    /**
     * @var \App\Services\ChatroomManagementService
     */
    private $chatroomManagementService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\ConsultationService $consultation
     * @param \App\Services\ChatroomManagementService $chatroomManagementService
     */
    public function __construct(
        \App\Services\ConsultationService $consultation,
        \App\Services\ChatroomManagementService $chatroomManagementService
    )
    {
        $this->consultation = $consultation;
        $this->chatroomManagementService = $chatroomManagementService;
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
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $params = $request->all();

        $params['vendor_user_id'] = $params['user_id'];
        $params['user_id'] = null;
        return $this->consultation->export($params);

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
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve($id)
    {

        $result = $this->chatroomManagementService->createRoomVendorCustomer($id);

        return response()->json($result['data'], $result['status']);
    }


}
