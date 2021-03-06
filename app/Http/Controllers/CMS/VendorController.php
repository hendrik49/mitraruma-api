<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\WpUser;
use App\Models\WpProject;
use App\Models\WpCms;
use App\Http\Controllers\Controller;
use App\Models\WpVendorExtensionAttribute;

class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function aplikatorDash(Request $request, $id=null)
    {
        $user = Auth::user();
        
        if ($user->user_type == "vendor") {
            $user = WpUser::where('ID',$user->ID)->first();
            $projects = WpProject::where('vendor_user_id', $user->ID)->get();
            $progres = WpProject::where('vendor_user_id', $user->ID)->where('status', '<>', WpProject::Project_Ended)->get();
            $progresVendor = WpProject::where('vendor_user_id', $user->ID)->where('status','=', WpProject::Project_Ended)->get();
            $pie = WpProject::where('vendor_user_id', $user->ID)->select(DB::raw('status as label'), DB::raw('count(*) as value'))->groupBy('status')->get();
            $pieStatus = WpProject::where('vendor_user_id', $user->ID)->whereNotNull('service_type')->select(DB::raw('service_type as label'), DB::raw('count(*) as value'))->groupBy('service_type')->get();

        } else {
            $user = WpUser::where('ID',$id)->first();
            $projects = WpProject::where('vendor_user_id', $id)->get();
            $progres = WpProject::where('vendor_user_id', $id)->where('status', '<>', WpProject::Project_Ended)->get();
            $progresVendor = WpProject::where('vendor_user_id', $id)->whereNotNull('vendor_user_id')->where('status', '=', WpProject::Project_Ended)->get();
            $pie = WpProject::where('vendor_user_id', $id)->select(DB::raw('status as label'), DB::raw('count(*) as value'))->groupBy('status')->get();
            $pieStatus = WpProject::where('vendor_user_id', $id)->whereNotNull('service_type')->select(DB::raw('service_type as label'), DB::raw('count(*) as value'))->groupBy('service_type')->get();
        }

        $masters = WpCms::get();

        if ($user->user_type != "vendor"){
            $aplikators = WpUser::with('projects', 'review')->where('ID', $id)->where('user_type', WpUser::TYPE_VENDOR)->get();
            $pf = WpVendorExtensionAttribute::where('user_id', $id)->first();
        }
        else{
            $aplikators = WpUser::with('projects', 'review')->where('ID', $user->ID)->where('user_type', WpUser::TYPE_VENDOR)->get();
            $pf = WpVendorExtensionAttribute::where('user_id', $user->ID)->first();
        }

        return view('aplikators.dashboard', compact('pf','user','projects','masters', 'aplikators', 'progresVendor', 'progres','pie','pieStatus'));
    }

    public function aplikatorDashIndex()
    {
        $user = Auth::user();
        if ($user->user_type == "vendor") {
            $projects = WpProject::where('vendor_user_id', $user->ID)->get();
            $progres = WpProject::where('vendor_user_id', $user->ID)->where('status', '<>', WpProject::Project_Ended)->get();
            $progresVendor = WpProject::where('vendor_user_id', $user->ID)->where('status','=', WpProject::Project_Ended)->get();
            $pie = WpProject::where('vendor_user_id', $user->ID)->select(DB::raw('status as label'), DB::raw('count(*) as value'))->groupBy('status')->get();
            $pieStatus = WpProject::where('vendor_user_id', $user->ID)->whereNotNull('service_type')->select(DB::raw('service_type as label'), DB::raw('count(*) as value'))->groupBy('service_type')->get();

        } else {
            $projects = WpProject::get();
            $progres = WpProject::where('status', '<>', WpProject::Project_Ended)->get();
            $progresVendor = WpProject::whereNotNull('vendor_user_id')->where('status', '=', WpProject::Project_Ended)->get();
            $pie = WpProject::where('vendor_user_id', $user->ID)->select(DB::raw('status as label'), DB::raw('count(*) as value'))->groupBy('status')->get();
            $pieStatus = WpProject::where('vendor_user_id', $user->ID)->whereNotNull('service_type')->select(DB::raw('service_type as label'), DB::raw('count(*) as value'))->groupBy('service_type')->get();
        }

        $masters = WpCms::get();

        if ($user->user_type == WpUser::TYPE_ADMIN){
            $aplikators = WpUser::with('projects', 'review')->where('user_type', WpUser::TYPE_VENDOR)->get();
            $pf = WpVendorExtensionAttribute::where('user_id', $user->ID)->first();
        }
        else{
            $aplikators = WpUser::with('projects', 'review')->where('ID', $user->ID)->where('user_type', WpUser::TYPE_VENDOR)->get();
            $pf = WpVendorExtensionAttribute::where('user_id', $user->ID)->first();
        }

        return view('aplikators.index-dashboard', compact('pf','user','projects','masters', 'aplikators', 'progresVendor', 'progres','pie','pieStatus'));
    }

    public function index()
    {

        $user = Auth::user();
        if ($user->user_type == WpUser::TYPE_ADMIN)
            $aplikators = WpUser::with('review')->where('user_type', WpUser::TYPE_VENDOR)->get();
        else
            $aplikators = WpUser::with('review')->where('ID', $user->ID)->where('user_type', WpUser::TYPE_VENDOR)->get();

        return view('aplikators.index', compact('aplikators'));
    }


    public function create()
    {
        $aplikators = WpUser::where('user_type', WpUser::TYPE_VENDOR)->get();

        return view('aplikators.create', compact('aplikators'));
    }

    public function aplikatorstatus($id, $status)
    {
        $user = Auth::user();

        $user = WpUser::findOrFail($id);
        if ($user) {
            $user->status = $status;
            $user->created_by = $user->id;
            $user->save();
        }

        return redirect()->route('aplikators.index')->with('status', 'Item updated successfully.');
    }

    public function store(Request $request)
    {
        try {

            $this->validate($request, [
                'quality' => 'required|numeric',
                'responsiveness_to_customer' => 'required|numeric',
                'responsiveness_to_mitraruma' => 'required|numeric',
                'behaviour' => 'required|numeric',
                'helpful' => 'required|numeric',
                'commitment' => 'required|numeric',
                'activeness' => 'required|numeric',
            ]);

            DB::beginTransaction();

            $user = new WpVendorExtensionAttribute;
            $user->fill($request->all());
            $user->save();

            DB::commit();

            return redirect()->route('aplikators.index')->with('status', 'Data Review berhasil disimpan');
        } catch (ValidationException $e) {
            DB::rollback();
            return redirect()->back()->with('errors', $e->validator->getMessageBag());
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('gagal', 'Simpan user gagal. ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = WpUser::with('review')->where('ID', $id)->first();

        return view('aplikators.show', compact('user'));
    }

    public function edit($id)
    {
        $user = WpUser::with('review')->where('ID', $id)->first();
        $reviews = [
            1 => "Kurang",
            2 => "Cukup",
            3 => "Baik",
            4 => "Sangat Baik",
            5 => "Terbaik"
        ];

        return view('aplikators.edit', compact('user', 'reviews'));
    }

    public function update(Request $request, $id)
    {

        try {

            $this->validate($request, [
                'quality' => 'required|numeric',
                'responsiveness_to_customer' => 'required|numeric',
                'responsiveness_to_mitraruma' => 'required|numeric',
                'behaviour' => 'required|numeric',
                'helpful' => 'required|numeric',
                'commitment' => 'required|numeric',
                'activeness' => 'required|numeric',
            ]);

            $project = WpUser::where('ID', $id)->first();
            if ($project) {
                $user = WpVendorExtensionAttribute::where('user_id', $project->ID)->first();
                if ($user == null) {
                    $user = new WpVendorExtensionAttribute;
                    $user->user_id = $project->ID;
                    $user->project_id = $id;
                }

                $user->fill($request->all());
                $user->overall_score =
                    ($user->quality +
                        $user->responsiveness_to_customer +
                        $user->responsiveness_to_mitraruma +
                        $user->behaviour +
                        $user->helpful +
                        $user->commitment +
                        $user->activeness) / 7;
                $user->save();

                DB::commit();
            } else {
                return redirect()->back()->with('gagal', 'Ubah Data gagal. ' . 'data aplikator tidak ditemukan');
            }

            return redirect()->route('aplikators.index')->with('status', 'Data Review berhasil diubah');
        } catch (ValidationException $e) {
            DB::rollback();
            return redirect()->back()->with('errors', $e->validator->getMessageBag());
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('gagal', 'Ubah Data gagal. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = WpUser::findOrfail($id);
        $user->delete();
        return redirect()->back()->with('status', 'Data Review Telah Dihapus');
    }
}
