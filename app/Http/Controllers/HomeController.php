<?php

namespace App\Http\Controllers;

use App\Models\WpProject;
use Illuminate\Http\Request;
use App\Models\WpUser;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->user_type == "customer") {
            $customer =  WpProject::where('user_id',$user->ID)->groupBy('user_id')->count();
            $vendor = WpProject::where('user_id',$user->ID)->whereNotNull('vendor_user_id')->groupBy('vendor_user_id')->count();
            $admin =  WpUser::where('user_type', WpUser::TYPE_ADMIN)->count();
            $projects = WpProject::where('user_id',$user->ID)->groupBy('user_id')->count();
            $progres = WpProject::where('user_id',$user->ID)->limit(5)->get();
            $progresVendor = WpProject::where('user_id',$user->ID)->whereNotNull('vendor_user_id')->limit(5)->get();

        } else if ($user->user_type == "vendor") {
            $customer =  WpProject::where('vendor_user_id',$user->ID)->groupBy('user_id')->count();
            $vendor =  WpProject::where('vendor_user_id',$user->ID)->whereNotNull('vendor_user_id')->groupBy('vendor_user_id')->count();
            $admin =  WpUser::where('user_type', WpUser::TYPE_ADMIN)->count();
            $projects = WpProject::where('vendor_user_id',$user->ID)->groupBy('vendor_user_id')->count();
            $progres = WpProject::where('user_id',$user->ID)->limit(5)->get();
            $progresVendor = WpProject::where('vendor_user_id',$user->ID)->whereNotNull('vendor_user_id')->limit(5)->get();

        } else {
            $customer =  WpUser::where('user_type', WpUser::TYPE_CUSTOMER)->count();
            $vendor =  WpUser::where('user_type', WpUser::TYPE_VENDOR)->count();
            $admin =  WpUser::where('user_type', WpUser::TYPE_ADMIN)->count();
            $projects = WpProject::where('admin_user_id',$user->ID)->count();
            $progres = WpProject::where('admin_user_id',$user->ID)->limit(5)->get();
            $progresVendor = WpProject::whereNotNull('vendor_user_id')->limit(5)->get();
        }

        $spk_customer = WpProject::sum('amount_spk_customer');
        $spk_vendor = WpProject::sum('amount_spk_vendor');
        $project_value = WpProject::sum('project_value');
        $total_expanse = WpProject::sum('total_expanse');
        $amount_spk_vendor_net = WpProject::sum('amount_spk_vendor_net');

        return view('home', compact('progresVendor','progres','amount_spk_vendor_net', 'total_expanse', 'project_value', 'spk_vendor', 'spk_customer', 'customer', 'admin', 'vendor', 'projects'));
    }

    public function aplikatorDash()
    {
        $user = Auth::user();

        $projects = WpProject::where('admin_user_id',$user->ID)->count();

        return view('aplikator.dashboard', compact('projects'));
    }

    public function aplikatorReview()
    {
        $users = WpUser::with('extensionvendor')->where('user_type', WpUser::TYPE_VENDOR)->get();

        return view('aplikator.index', compact('users'));
    }

    public function aplikatorReviewShow($id)
    {
        $user = WpUser::with('extensionvendor')->where('ID', $id)->first();

        return view('aplikator.edit', compact('user'));
    }
}
