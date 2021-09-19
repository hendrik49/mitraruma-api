<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CmsManagmentController extends Controller
{
    /**
     * @var \App\Services\CmsService
     */
    private $cms;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\CmsService  $cms
     * @return void
     */
    public function __construct(
        \App\Services\CmsService $cms
    ) {
        $this->cms = $cms;
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

        $result = $this->cms->index($params);

        return view('seting.index', ['result' =>  $result['data']]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->cms->show($id);
        if ($result['data']['name'] == 'skill-set')
            return view('seting.show', ['cms' =>  $result['data']]);
        else if($result['data']['name'] == 'category-list')
            return view('seting.show-category', ['cms' =>  $result['data']]);
        else if($result['data']['name'] == 'benefit-video')
            return view('seting.show-video', ['cms' =>  $result['data']]);
        else 
            return view('seting.show', ['cms' =>  $result['data']]);

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByName($name)
    {

        $params['name'] = $name;
        $result = $this->cms->showByName($params);

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

        $result = $this->cms->create($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();

        $result = $this->cms->update($params, $id);

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

        $result = $this->cms->destroy($id);

        return response()->json($result['data'], $result['status']);
    }
}
