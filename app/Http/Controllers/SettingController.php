<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use URL;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-restore', ['only' => ['restore']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::where('id', Auth::User()->setting_id)->first();
        //dd($setting);
        if(is_null($setting)){
            return redirect()->action([SettingController::class, 'create']);
        }else{
            return view('settings.index',compact('setting'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Setting $setting)
    {
        $form_type = 'create';
        return view('settings.create', compact('form_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {

            $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'web' => 'required',
            'avatar' => 'mimes:jpg,jpeg,gif,png,webp'
        ]);

        $input = $request->all();

        $setting = Setting::create($input);
        $user = User::findOrFail(Auth::User()->id);
        $user->setting_id = $setting->id;
        $user->save();

        Alert::toast('Clínica creada', 'success')->timerProgressBar();

        return redirect()->route('settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        $form_type = 'edit';
        if(Auth::User()->setting_id == $setting->id){
            return view('settings.create', compact('form_type','setting'));
        }else{
            return abort(403,"El usuario no puede realizar esta acción");
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
          $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'web' => 'required',
            'avatar' => 'mimes:jpg,jpeg,gif,png,webp'
        ]);

        $input = $request->all();

        $setting->update($input);
        Alert::toast('Clínica actualizada', 'success')->timerProgressBar();

        return redirect()->route('settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
