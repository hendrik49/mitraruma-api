<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\WpUser;
use App\Models\WpUserExtensionAttribute;
use App\Http\Controllers\Controller;
use App\Models\WpCms;

class UserController extends Controller
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

        if ($user->user_type == WpUser::TYPE_ADMIN)
            $users = WpUser::whereNotNull('user_type')->orderByDesc('created_at')->get();
        else
            $users = WpUser::whereNotNull('user_type')->where('ID', $user->ID)->get();

        return view('users.index', compact('users', 'start_date', 'end_date'));
    }

    public function pembayaran()
    {
        $user = Auth::user();
        $start_date = $end_date = date('Y-m-d H:i:s');

        if ($user->user_type == WpUser::TYPE_CUSTOMER)
            $users = WpUser::where('user_id', $user->ID)->orderByDesc('created_at');
        else if ($user->user_type == WpUser::TYPE_VENDOR)
            $users = WpUser::where('user_vendor_id', $user->ID)->orderByDesc('created_at');
        else
            $users = WpUser::orderByDesc('created_at')->orderByDesc('created_at');

        $users = $users->get();

        return view('users.pembayaran', compact('users', 'start_date', 'end_date'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function userStatus($id, $status)
    {
        $user = Auth::user();

        $user = WpUser::findOrFail($id);
        if ($user) {
            $user->status = $status;
            $user->created_by = $user->id;
            $user->save();
        }

        return redirect()->route('users.index')->with('status', 'Item updated successfully.');
    }

    public function store(Request $request)
    {
        try {

            $this->validate($request, [
                'nik' => 'nullable|min:16',
                'file_nik' => 'nullable|file',
                'npwp' => 'nullable|min:16',
                'file_npwp' => 'nullable|file',
                'user_email' => 'required|email',
                'user_phone_number' => 'required',
                'display_name' => 'required|min:3',
                'user_picture_url' => 'required|file',
                'file_bank' => 'nullable|file',
                'bank_account' => 'nullable|min:6',
                'bank' => 'nullable|min:3'
            ]);


            DB::beginTransaction();

            $user = new WpUser;

            $user->fill($request->all());
            $foto_nik = $request->file('file_nik');
            if ($foto_nik) {
                $user_path = $foto_nik->store('file_ktp', 'public');
                $user->file_nik = $user_path;
            }
            $user_picture_url = $request->file('user_picture_url');
            if ($user_picture_url) {
                $user_path = $foto_nik->store('user_picture', 'public');
                $user->user_picture_url = $user_path;
            }
            $foto_npwp = $request->file('file_npwp');
            if ($foto_npwp) {
                $user_path = $foto_npwp->store('file_npwp', 'public');
                $user->file_npwp = $user_path;
            }
            $foto_bank = $request->file('file_bank');
            if ($foto_bank) {
                $user_path = $foto_nik->store('file_ktp', 'public');
                $user->file_bank = $user_path;
            }

            $user->save();

            DB::commit();

            return redirect()->route('users.index')->with('status', 'Data user berhasil disimpan');
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
        $user = WpUser::with('extension')->findOrfail($id);
        $masters = WpCms::get();
        return view('users.show', ['user' => $user, 'masters' => $masters]);
    }

    public function edit($id)
    {
        $user = WpUser::with('extension')->findOrfail($id);
        $masters = WpCms::get();

        return view('users.edit', ['user' => $user, 'masters' => $masters]);
    }

    public function update(Request $request, $id)
    {

        try {

            $this->validate($request, [
                'nik' => 'nullable|min:16',
                'file_nik' => 'nullable|file',
                'file_bank' => 'nullable|file',
                'npwp' => 'nullable|min:16',
                'bank_account' => 'nullable|min:6',
                'bank' => 'nullable|min:3',
                'file_npwp' => 'nullable|file',
                'user_email' => 'required|email',
                'user_phone_number' => 'required',
                'display_name' => 'required|min:3',
                'user_picture_url' => 'nullable|file',
                'portfolio' => 'nullable|file|mimes:jpeg,png,jpg|max:5024'
            ]);

            $user = WpUser::findOrfail($id);

            $user->fill($request->all());
            $foto_nik = $request->file('file_nik');
            if ($foto_nik) {
                $user_path = $foto_nik->store('file_ktp', 'public');
                $user->file_nik = $user_path;
            }
            $user_picture_url = $request->file('user_picture_url');
            if ($user_picture_url) {
                $user_path = $foto_nik->store('user_picture', 'public');
                $user->user_picture_url = $user_path;
            }
            $foto_npwp = $request->file('file_npwp');
            if ($foto_npwp) {
                $user_path = $foto_npwp->store('file_npwp', 'public');
                $user->file_npwp = $user_path;
            }
            $foto_bank = $request->file('file_bank');
            if ($foto_bank) {
                $user_path = $foto_bank->store('file_bank', 'public');
                $user->file_bank = $user_path;
            }

            $portfolio = $request->file('portfolio');
            if ($portfolio) {
                $user_path = $portfolio->store('portfolio', 'public');
                $user->portfolio = $user_path;
            }
            $user->save();


            if ($request->has('skill_set')) {
                $exs = WpUserExtensionAttribute::where('name', 'SKILLSET')->where('user_id', $id)->first();
                if ($exs) {
                    $exs->value = $request->skill_set;
                    $exs->save();
                } else {
                    $exs = new WpUserExtensionAttribute;
                    $exs->user_id = $id;
                    $exs->name = 'SKILLSET';
                    $exs->value = $request->skill_set;
                    $exs->save();
                }
            }

            if ($request->has('coverage')) {
                $exs = WpUserExtensionAttribute::where('name', 'Coverage')->where('user_id', $id)->first();
                if ($exs) {
                    $exs->value = $request->coverage;
                    $exs->save();
                } else {
                    $exs = new WpUserExtensionAttribute;
                    $exs->user_id = $id;
                    $exs->name = 'Coverage';
                    $exs->value = $request->coverage;
                    $exs->save();
                }
            }

            if ($request->has('segment')) {
                $exs = WpUserExtensionAttribute::where('name', 'segment')->where('user_id', $id)->first();
                if ($exs) {
                    $exs->value = $request->segment;
                    $exs->save();
                } else {
                    $exs = new WpUserExtensionAttribute;
                    $exs->user_id = $id;
                    $exs->name = 'segment';
                    $exs->value = $request->segment;
                    $exs->save();
                }
            }

            DB::commit();

            return redirect()->route('users.index')->with('status', 'Data user ID ' . $id . ' berhasil diubah');
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
