<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\WpUser;
use App\Http\Controllers\Controller;

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

        $users = WpUser::whereNotNull('user_type')->orderByDesc('created_at');
        $users = $users->get();

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
                'bank' => 'required|min:3',
                'account' => 'nullable|min:5',
                'label' => 'required|min:3',
                'tipe' => 'required|min:3',
                'owner' => 'required|min:3',
                'logo' => 'required|image|mimes:jpeg,png,jpg,svg|max:1024'
            ]);

            DB::beginTransaction();

            $user = new WpUser;
            $foto = $request->file('logo');
            if ($foto) {
                $user_path = $foto->store('fotouser', 'public');
                $user->dokumentasi = $user_path;
            }
            $user->bank    = strtolower($request->bank);
            $user->account  = $request->account;
            $user->branch  = $request->label;
            $user->tipe  = $request->tipe;
            $user->owner  = $request->owner;
            $user->created_by = Auth::user()->id;
            $user->judul_panduan_pembayaran1 = $request->judul_panduan_pembayaran1;
            $user->judul_panduan_pembayaran2 = $request->judul_panduan_pembayaran2;
            $user->judul_panduan_pembayaran3 = $request->judul_panduan_pembayaran3;
            $user->panduan_pembayaran1 = $request->panduan_pembayaran1;
            $user->panduan_pembayaran2 = $request->panduan_pembayaran2;
            $user->panduan_pembayaran3 = $request->panduan_pembayaran3;

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
        $user = WpUser::findOrfail($id);
        return view('users.show', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = WpUser::findOrfail($id);
        return view('users.edit', ['user' => $user]);
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

            $user = WpUser::findOrfail($id);

            $user->fill($request->all());
            $user->save();

            DB::commit();

            return redirect()->route('users.index')->with('status', 'Data user berhasil diubah');
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
