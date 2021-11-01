<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\WpProject;
use App\Models\WpUser;
use App\Http\Controllers\Controller;
use App\Helpers\OrderStatus;

class ProjectController extends Controller
{
    /**
     * @var OrderStatusService
     */
    private $orderStatusService;

    /**
     * @var OrderStatus
     */
    private $orderStatusHelper;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        \App\Services\OrderStatusService $orderStatusService,
        OrderStatus $orderStatusHelper
    ) {
        $this->orderStatusService = $orderStatusService;
        $this->orderStatusHelper = $orderStatusHelper;
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $start_date = $end_date = date('Y-m-d H:i:s');

        if ($user->user_type == WpUser::TYPE_CUSTOMER)
            $projects = WpProject::where('user_id', $user->ID)->orderByDesc('created_at');
        else if ($user->user_type == WpUser::TYPE_VENDOR)
            $projects = WpProject::where('vendor_user_id', $user->ID)->orderByDesc('created_at');
        else
            $projects = WpProject::orderByDesc('created_at')->orderByDesc('created_at');

        $projects = $projects->get();

        return view('project.index', compact('projects', 'start_date', 'end_date'));
    }

    public function pembayaran()
    {
        $user = Auth::user();
        $start_date = $end_date = date('Y-m-d H:i:s');

        if ($user->user_type == WpUser::TYPE_CUSTOMER)
            $projects = WpProject::where('user_id', $user->ID)->orderByDesc('created_at');
        else if ($user->user_type == WpUser::TYPE_VENDOR)
            $projects = WpProject::where('user_vendor_id', $user->ID)->orderByDesc('created_at');
        else
            $projects = WpProject::orderByDesc('created_at')->orderByDesc('created_at');

        $projects = $projects->get();

        return view('project.pembayaran', compact('projects', 'start_date', 'end_date'));
    }

    public function create()
    {
        $orderStatus = new OrderStatus;
        $subStatus = json_decode($orderStatus->data);
        $aplikators = WpUser::where('user_type', WpUser::TYPE_VENDOR)->get();
        $customers = WpUser::where('user_type', WpUser::TYPE_CUSTOMER)->get();

        return view('project.create', compact('aplikators', 'customers','subStatus'));
    }

    public function projectStatus($id, $status)
    {
        $user = Auth::user();

        $project = WpProject::findOrFail($id);
        if ($project) {
            $project->status = $status;
            $project->created_by = $user->id;
            $project->save();
        }

        return redirect()->route('proyek.index')->with('status', 'Item updated successfully.');
    }

    public function store(Request $request)
    {
        try {

            $this->validate($request, [
                'user_id' => 'required|exists:wp_users,ID',
                'vendor_user_id' => 'required|exists:wp_users,ID',
                'vendor_contact' => 'required|min:6',
                'description' => 'required|min:3',
                'service_type' => 'required|min:3',
                'street' => 'required|min:3',
                'status' => 'required',
                'sub_status' => 'required',
                'order_number' => 'required|min:6',
                'customer_name' => 'nullable|min:3',
                'vendor_name' => 'nullable|min:3',
                'customer_contact' => 'required|min:6',
                'estimated_budget' => 'required|numeric',
                'dokumentasi' => 'required|image|mimes:jpeg,png,jpg,svg|max:1024'
            ]);

            DB::beginTransaction();

            $project = new WpProject;
            $cust = WpUser::findOrfail($request->user_id);
            if ($cust)
                $project->customer_name = $cust->display_name;
            $vendor = WpUser::findOrfail($request->vendor_user_id);
            if ($vendor)
                $project->vendor_name = $vendor->display_name;

            $foto = $request->file('foto');
            if ($foto) {
                $project_path = $foto->store('fotoproject', 'public');
                $project->images = $project_path;
            }

            $project->fill($request->all());
            $project->save();

            DB::commit();

            return redirect()->route('proyek.index')->with('status', 'Data konsultasi no. '.$project->order_number.' berhasil disimpan');
        } catch (ValidationException $e) {
            DB::rollback();
            return redirect()->back()->with('errors', $e->validator->getMessageBag());
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('gagal', 'Simpan project gagal. ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $project = WpProject::findOrfail($id);

        $orderStatus = $this->orderStatusService->show($project->room_id);

        if ($orderStatus['status'] == 404) {
            $status = [];
        } else {
            $status = $orderStatus['data'];
        }
        return view('project.show', ['status' => $status, 'project' => $project]);
    }

    public function edit($id)
    {
        $orderStatus = new OrderStatus;
        $subStatus = json_decode($orderStatus->data);
        $project = WpProject::findOrfail($id);
        return view('project.edit', ['project' => $project,'subStatus'=>$subStatus]);
    }

    public function editRate($id)
    {
        $project = WpProject::findOrfail($id);
        return view('project.edit', ['project' => $project]);
    }

    public function update(Request $request, $id)
    {

        try {

            $this->validate($request, [
                'vendor_contact' => 'required|min:6',
                'description' => 'required|min:3',
                'service_type' => 'required|min:3',
                'street' => 'required|min:3',
                'status' => 'required',
                'sub_status' => 'required',
                'order_number' => 'required|min:6',
                'customer_name' => 'nullable|min:3',
                'vendor_name' => 'nullable|min:3',
                'customer_contact' => 'required|min:6',
                'estimated_budget' => 'required|numeric',
                'dokumentasi' => 'image|mimes:jpeg,png,jpg,svg|max:1024'
            ]);

            $project = WpProject::findOrfail($id);

            $foto = $request->file('foto');
            if ($foto) {
                $project_path = $foto->store('fotoproject', 'public');
                $project->images = $project_path;
            }

            $project->fill($request->all());
            $project->save();

            DB::commit();

            return redirect()->route('proyek.index')->with('status', 'Data proyek ' . $project->order_number . ' berhasil diubah');
        } catch (ValidationException $e) {
            DB::rollback();
            return redirect()->back()->with('errors', $e->validator->getMessageBag());
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('gagal', 'Ubah project gagal. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $project = WpProject::findOrfail($id);
        $project->delete();
        return redirect()->back()->with('status', 'Data project Telah Dihapus');
    }
}
