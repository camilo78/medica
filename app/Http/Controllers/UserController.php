<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Contracts\DataTable;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
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
    public function index(Request $request)
    {
        $role = Auth::user()->getRoleNames()->first();
        $setting = Auth::User()->setting_id;

        if ($request->ajax()) {
            if ($role == 'Médico'){
                if(Auth::User()->setting_id == null){
                    $table = datatables(User::with('roles')->where( 'setting_id', $setting)->where( 'id', Auth::User()->id)->get());
                }else{
                    $table = datatables(User::with('roles')->where( 'setting_id', $setting)->get());
                }

            }elseif ($role == 'Asistente'){
                $table = datatables(User::with('roles')->where( 'setting_id', $setting)->whereHas("roles", function($q){ $q->where("name", "Paciente"); })->get());
            }else{
                $table = datatables(User::with('roles')->get());
            }
            return $table->addIndexColumn()
                ->addColumn('role', function (User $user) {
                    return $user->getRoleNames()->first();
                })
                ->addColumn('name', function (User $user) {
                    return '<a href="' . route('users.show',$user->id). '"  data-toggle="tooltip" title="Haz click para ver detalles del usuario">' . $user->name1 . ' ' . $user->name2 . ' ' . $user->surname1 . ' ' . $user->surname2 . '</a>';
                })
                ->addColumn('email', function (User $user) {
                    return '<a href="mailto:' . $user->email . '"  data-toggle="tooltip" title="Haz click para enviar un correo a este usuario">' . $user->email . '</a>';
                })
                ->addColumn('phone', function (User $user) {
                    return '<a href="tel:' . $user->phone1 . '"  data-toggle="tooltip" title="Haz click para hacer una llamada a este número">' . $user->phone1 . '</a>';
                })
                ->addColumn('choose', function (User $user) {
                    Auth::id() == $user->id ? $status = 'disabled' : $status = '';
                    return '<input class="col align-self-center checkbox" ' . $status . ' type="checkbox"  name="inputs[]" value="' . $user->id . '" aria-label="Checkbox for following text input" data-toggle="tooltip" title="Selecciona para eliminar este usuario">';
                })
                ->addColumn('edit', function (User $user) {
                    return '<a class="h4 col align-self-center" href="'.route('users.edit',$user->id). '"  data-toggle="tooltip" title="Haz click para editar este usuario"><i class="mdi mdi-account-edit"></i></a>';
                })
                ->addColumn('address', function (User $user) {
                    return $user->address.', '.$user->city['name'].' '.str_replace('Department','',$user->state['name']).', '.$user->country['name'];
                })
                ->addColumn('setting', function (User $user) {
                    return  ($user->setting_id  == '') ? 'Sin Clínica' : $user->setting['name'];
                })
                ->rawColumns(['role', 'name', 'email', 'phone', 'choose','edit','address','setting'])
                ->make(true);
        }

        return view('users.index');
    }
    public function trash(Request $request)
    {
        $role = Auth::user()->getRoleNames()->first();
        $setting = Auth::User()->setting_id;
        if ($request->ajax()) {
            if ($role == 'Médico'){
                if(Auth::User()->setting_id == null){
                    $table = datatables(User::onlyTrashed()->with('roles')->where( 'setting_id', $setting)->where( 'id', Auth::User()->id)->get());
                }else{
                    $table = datatables(User::onlyTrashed()->with('roles')->where( 'setting_id', $setting)->get());
                }
            }elseif ($role == 'Asistente'){
                $table = datatables(User::onlyTrashed()->with('roles')->where( 'setting_id', $setting)->whereHas("roles", function($q){ $q->where("name", "Asistente"); })->get());
            }else{
                $table = datatables(User::onlyTrashed()->with('roles')->get());
            }
            return $table->addIndexColumn()
                ->addColumn('role', function (User $user) {
                    return $user->getRoleNames()->first();
                })
                ->addColumn('name', function (User $user) {
                    return  $user->name1 . ' ' . $user->name2 . ' ' . $user->surname1 . ' ' . $user->surname2;
                })
                ->addColumn('email', function (User $user) {
                    return '<a href="mailto:' . $user->email . '"  data-toggle="tooltip" title="Haz click para enviar un correo a este usuario">' . $user->email . '</a>';
                })
                ->addColumn('phone', function (User $user) {
                    return '<a href="tel:' . $user->phone1 . '"  data-toggle="tooltip" title="Haz click para hacer una llamada a este número">' . $user->phone1 . '</a>';
                })
                ->addColumn('choose', function (User $user) {
                    Auth::id() == $user->id ? $status = 'disabled' : $status = '';
                    return '<input class="col align-self-center checkbox" ' . $status . ' type="checkbox"  name="inputs[]" value="' . $user->id . '" aria-label="Checkbox for following text input" data-toggle="tooltip" title="Selecciona para eliminar este usuario">';
                })
                ->rawColumns(['role', 'name', 'email', 'phone','choose'])
                ->make(true);
        }

        return view('users.trash');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(is_null(Auth::User()->setting_id) && Auth::user()->roles->first()->id != 1){
            Alert::toast('Debes completar la información de la Clínica para poder crear usuarios', 'warning')->timerProgressBar();
            return back();
        }else{

        $role = Auth::user()->roles->first()->id;

        $setting = Auth::User()->setting_id;
        $now = new \DateTime();
        if (!is_null(User::get()->last())) {
            $ido = User::get()->last()->id + 1;
        } else {
            $ido = '1';
        }
        $count_asistent = User::whereHas('roles', function ($q) {
            $q->where('id', '3');
        })->where( 'setting_id', $setting)->get()->count();

        if ($role == 2){
            if($count_asistent < 2){
                $roles = Role::where('id','>',2)->pluck('name', 'name')->all();
            }else{
                $roles = Role::where('id','>',3)->pluck('name', 'name')->all();
            }
        }elseif ($role == 3){
                $roles = Role::where('id','=',4)->pluck('name', 'name')->all();
        }else{
            $roles = Role::where('id','=',2)->pluck('name', 'name')->all();
        }
        //dd($id);
        $countries= DB::table("countries")->where('phonecode','>',502)->where('phonecode','<',508)->get();
        return view('users.create', compact('ido','roles','countries','now'));

        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->roles == "Médico" || $request->roles == "Asistente" ){
            $this->validate($request, [
                'name1'         => 'required|max:25',
                'name2'         => 'max:25',
                'surname1'      => 'required|max:25',
                'surname2'      => 'max:25',
                'married_name'  => 'max:25',
                'avatar'        => 'mimes:jpg,jpeg,gif,png,webp',
                'email'         => 'max:50|unique:users,email',
                'phone1'        => 'required|max:25',
                'phone2'        => 'max:25',
                'gender'        => 'required|in:M,F',
                'civil'         => 'nullable|in:Single,Married',
                'birth'         => 'nullable|before_or_equal:now',
                'patient_code'  => 'required|max:25|unique:users',
                'document_type' => 'in:No document,ID number,Passport',
                'document'      => 'max:25',
                'status'        => 'in:active,disabled',
                'name_relation' => 'max:50',
                'kinship'       => 'in:No responsible,Spouse,Mother,Father,Partner,Son or Daughter  Aunt or Uncle,Cousin,Other',
                'address'       => 'required|max:255',
                'password'      => 'same:confirm-password',
                'roles'         => 'required',
                'country_id'    => 'required',
                'state_id'      => 'required',
                'city_id'       => 'required',
                'setting_id'    => 'nullable',
            ]);
        }else{
            $this->validate($request, [
                'name1'         => 'required|max:25',
                'name2'         => 'max:25',
                'surname1'      => 'required|max:25',
                'surname2'      => 'max:25',
                'married_name'  => 'max:25',
                'avatar'        => 'mimes:jpg,jpeg,gif,png,webp',
                'email'         => 'max:50|unique:users',
                'phone1'        => 'max:25',
                'phone2'        => 'max:25',
                'gender'        => 'required|in:M,F',
                'civil'         => 'in:Single,Married',
                'birth'         => 'required|before_or_equal:now',
                'patient_code'  => 'required|max:25|unique:users',
                'document_type' => 'in:No document,ID number,Passport',
                'document'      => 'max:25',
                'status'        => 'in:active,disabled',
                'name_relation' => 'max:50',
                'kinship'       => 'in:No responsible,Spouse,Mother,Father,Partner,Son or Daughter  Aunt or Uncle,Cousin,Other',
                'address'       => 'max:255',
                'password'      => 'same:confirm-password',
                'roles'         => 'required',
                'country_id'    => 'required',
                'state_id'      => 'required',
                'city_id'       => 'required',
                'setting_id'    => 'nullable',
            ]);
        }

        $request['setting_id'] = Auth::User()->setting_id;

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        //dd($input);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        Alert::toast('Usuario creado', 'success')->timerProgressBar();
        return redirect()->route('users.index');
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $users = User::withTrashed()->get();
        $activities = Activity::where('causer_id', $id)->orderBy('id','DESC')->paginate('5');
        if (Auth::User()->roles->first()->id == 4){
            if(Auth::User()->id == $user->id){
                return view('users.show', compact('user','activities','users'));
            }else{
                return abort(403,"El usuario no puede realizar esta acción");
            }
        }else{
            if(Auth::User()->setting_id == $user->setting_id or Auth::User()->roles->first()->id == 1){
                return view('users.show', compact('user','activities','users'));
            }else{
                return abort(403,"El usuario no puede realizar esta acción");
            }
        }

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $role = Auth::user()->roles->first()->id;
        $setting = Auth::User()->setting_id;
        $now = new \DateTime();
        $count_asistent = User::whereHas('roles', function ($q) {
            $q->where('id', '3');
        })->where( 'setting_id', $setting)->get()->count();

        if ($role == 2){
            if($count_asistent < 2){
                $roles = Role::where('id','>',2)->pluck('name', 'name')->all();
            }else{
                $roles = Role::where('id','>',2)->pluck('name', 'name')->all();
            }
        }elseif ($role == 3){
            $roles = Role::where('id','=',4)->pluck('name', 'name')->all();
        }else{
            $roles = Role::where('id','=',2)->pluck('name', 'name')->all();
        }
        $userRole = $user->roles->pluck('name', 'name')->all();
        $countries= DB::table("countries")->where('phonecode','>',502)->where('phonecode','<',508)->get();
        $states= DB::table("states")->where('country_id','=',$user->country['id'])->get();
        $cities= DB::table("cities")->where('state_id','=',$user->state['id'])->get();

        if (Auth::User()->roles->first()->id == 4){
            if(Auth::User()->id == $user->id){
                return view('users.edit', compact('user', 'roles', 'userRole','countries','states','cities','now'));
            }else{
                return abort(403,"El usuario no puede realizar esta acción");
            }
        }else{
            if(Auth::User()->setting_id == $user->setting_id or Auth::User()->roles->first()->id == 1){
                return view('users.edit', compact('user', 'roles', 'userRole','countries','states','cities','now'));
            }else{
                return abort(403,"El usuario no puede realizar esta acción");
            }
        }

    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->roles == "Médico" || $request->roles == "Asistente" ){
            $this->validate($request, [
                'name1'         => 'required|max:25',
                'name2'         => 'max:25',
                'surname1'      => 'required|max:25',
                'surname2'      => 'max:25',
                'married_name'  => 'max:25',
                'avatar'        => 'mimes:jpg,jpeg,gif,png,webp',
                'email'         => 'email|max:50|unique:users,email,' . $id,
                'phone1'        => 'required|max:25',
                'phone2'        => 'max:25',
                'gender'        => 'required|in:M,F',
                'civil'         => 'nullable|in:Single,Married',
                'birth'         => 'nullable|before_or_equal:now',
                'patient_code'  => 'required|max:25|unique:users,patient_code,' . $id,
                'document_type' => 'in:No document,ID number,Passport',
                'document'      => 'max:25',
                'status'        => 'in:active,disabled',
                'name_relation' => 'max:50',
                'kinship'       => 'in:No responsible,Spouse,Mother,Father,Partner,Son or Daughter  Aunt or Uncle,Cousin,Other',
                'address'       => 'required|max:255',
                'password'      => 'same:confirm-password',
                'roles'         => 'required',
                'country_id'    => 'required',
                'state_id'      => 'required',
                'city_id'       => 'required',
                'setting_id'    => 'nullable',
            ]);
        }else{
            $this->validate($request, [
                'name1'         => 'required|max:25',
                'name2'         => 'max:25',
                'surname1'      => 'required|max:25',
                'surname2'      => 'max:25',
                'married_name'  => 'max:25',
                'avatar'        => 'mimes:jpg,jpeg,gif,png,webp',
                'email'         => 'email|max:50|unique:users,email,' . $id,
                'phone1'        => 'max:25',
                'phone2'        => 'max:25',
                'gender'        => 'required|in:M,F',
                'civil'         => 'in:Single,Married',
                'birth'         => 'required|before_or_equal:now',
                'patient_code'  => 'required|max:25|unique:users,patient_code,' . $id,
                'document_type' => 'in:No document,ID number,Passport',
                'document'      => 'max:25',
                'status'        => 'in:active,disabled',
                'name_relation' => 'max:50',
                'kinship'       => 'in:No responsible,Spouse,Mother,Father,Partner,Son or Daughter  Aunt or Uncle,Cousin,Other',
                'address'       => 'max:255',
                'password'      => 'same:confirm-password',
                'roles'         => 'required',
                'country_id'    => 'required',
                'state_id'      => 'required',
                'city_id'       => 'required',
                'setting_id'    => 'nullable',
            ]);
        }

        $request['setting_id'] = Auth::User()->setting_id;

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        Alert::toast('Datos actualizados', 'success')->timerProgressBar();
        return back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = explode(",", $request->ids);
        if (is_array($ids))
        {
            User::destroy($ids);
        }
        else
        {
            User::findOrFail($ids)->delete();
        }
        return response()->json();
    }

    public function restore(Request $request, User $user)
    {
       $ids = explode(",", $request->ids);

            foreach ($ids as $id) {
                $u =  User::withTrashed()->find($id);
                $u->restore();
            }
        return response()->json();
    }
    public function search(Request $request)
    {
        $role = Auth::user()->getRoleNames()->first();
        $setting = Auth::User()->setting_id;
        if ($role == 'Médico' or $role == 'Asistente'){
            $user = User::where( 'setting_id', $setting)->whereHas("roles", function($q){ $q->where("name", "Paciente"); });
        }else{
            $user = User::select( '*')->whereHas("roles", function($q){ $q->where("name", "Paciente"); });
        }
        $users = $user->like($request->get('searchQuest'))->get();
        return json_encode($users);
    }
    //For fetching all countries
    //For fetching states
    public function getStates($id)
    {
        $states = DB::table("states")
            ->where("country_id",$id)
            ->pluck("name","id");
        return response()->json($states);
    }
    //For fetching cities
    public function getCities($id)
    {
        $cities= DB::table("cities")
            ->where("state_id",$id)
            ->pluck("name","id");
        return response()->json($cities);
    }
}
