<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\WpUser;
use App\Models\WpProject;
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

    public function aplikatorDash()
    {
        $user = Auth::user();

        $projects = WpProject::where('admin_user_id', $user->ID)->count();

        return view('aplikators.dashboard', compact('projects'));
    }

    public function index()
    {
        $aplikators = WpProject::with('review', 'vendor', 'customer')->where('status', WpProject::Project_Ended)->get();

        return view('aplikators.index', compact('aplikators'));
    }


    public function create()
    {
        return view('aplikators.create');
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

            return redirect()->route('aplikators.index')->with('status', 'Data user berhasil disimpan');
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
        $user = WpProject::with('review', 'vendor', 'customer')->where('ID', $id)->first();

        return view('aplikators.show', compact('user'));
    }

    public function edit($id)
    {
        $user = WpProject::with('review', 'vendor', 'customer')->where('ID', $id)->first();

        return view('aplikators.edit', compact('user'));
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

            $project = WpProject::where('ID', $id)->first();
            if ($project->vendor_user_id) {
                $user = WpVendorExtensionAttribute::where('project_id', $id)->where('user_id', $project->vendor_user_id)->first();
                if ($user == null) {
                    $user = new WpVendorExtensionAttribute;
                    $user->user_id = $id;
                }

                $user->fill($request->all());
                $user->save();

                DB::commit();
            } else {
                return redirect()->back()->with('gagal', 'Ubah user gagal. ' . 'data aplikator tidak ditemukan');
            }

            return redirect()->route('aplikators.index')->with('status', 'Data user berhasil diubah');
        } catch (ValidationException $e) {
            DB::rollback();
            return redirect()->back()->with('errors', $e->validator->getMessageBag());
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('gagal', 'Ubah user gagal. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = WpUser::findOrfail($id);
        $user->delete();
        return redirect()->back()->with('status', 'Data user Telah Dihapus');
    }
}
