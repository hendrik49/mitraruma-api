<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\WpProject;
use App\Models\WpUser;

class ProjectController extends Controller
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

    public function index()
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
        return view('project.create');
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

        return redirect()->route('project.index')->with('status', 'Item updated successfully.');
    }

    public function store(Request $request)
    {
        try {

            $this->validate($request, [
                'bank' => 'required|min:3',
                'account' => 'nullable|min:5',
                'label' => 'required|min:3',
                'tipe' => 'required|min:3',
                'owner' => 'required|min:3',
                'logo' => 'required|image|mimes:jpeg,png,jpg,svg|max:1024'
            ]);

            DB::beginTransaction();

            $project = new WpProject;
            $foto = $request->file('logo');
            if ($foto) {
                $project_path = $foto->store('fotoproject', 'public');
                $project->dokumentasi = $project_path;
            }
            $project->bank    = strtolower($request->bank);
            $project->account  = $request->account;
            $project->branch  = $request->label;
            $project->tipe  = $request->tipe;
            $project->owner  = $request->owner;
            $project->created_by = Auth::user()->id;
            $project->judul_panduan_pembayaran1 = $request->judul_panduan_pembayaran1;
            $project->judul_panduan_pembayaran2 = $request->judul_panduan_pembayaran2;
            $project->judul_panduan_pembayaran3 = $request->judul_panduan_pembayaran3;
            $project->panduan_pembayaran1 = $request->panduan_pembayaran1;
            $project->panduan_pembayaran2 = $request->panduan_pembayaran2;
            $project->panduan_pembayaran3 = $request->panduan_pembayaran3;

            $project->save();

            DB::commit();

            return redirect()->route('project.index')->with('status', 'Data project berhasil disimpan');
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
        return view('project.show', ['project' => $project]);
    }

    public function edit($id)
    {
        $project = WpProject::findOrfail($id);
        return view('project.edit', ['project' => $project]);
    }

    public function update(Request $request, $id)
    {

        try {

            $this->validate($request, [
                'amount_spk_customer_gross' => 'numeric',
                'amount_spk_customer' => 'numeric',
                'amount_spk_vendor' => 'numeric',
                'discount' => 'numeric',
                'commision' => 'numeric'
            ]);

            $project = WpProject::findOrfail($id);

            $project->fill($request->all());
            $project->save();

            DB::commit();

            return redirect()->route('proyek.index')->with('status', 'Data project berhasil diubah');
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
