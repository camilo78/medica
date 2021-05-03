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
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return datatables(User::with('roles')->get())->addIndexColumn()
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
                ->rawColumns(['role', 'name', 'email', 'phone', 'choose','edit','address'])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $countries= DB::table("countries")->get();
        return view('users.create', compact('roles','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name1' => 'required',
            'surname1' => 'required',
            'phone1' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        Alert::toast('Usuario creado', 'success')->timerProgressBar();

        return redirect()->route('users.index');
    }

    public function fileupload(Request $request, User $user)
    {

        if ($request->hasFile('file')) {

            // Upload path
            $destinationPath = 'files/';

            // Get file extension
            $extension = $request->file('file')->getClientOriginalExtension();

            // Valid extensions
            $validextensions = array("jpeg", "jpg", "png", "pdf");

            // Name of User

            // Check extension
            if (in_array(strtolower($extension), $validextensions)) {

                // Rename file
                $fileName = $request->file('file')->getClientOriginalName() . time() . '.' . $extension;
                // Uploading file to given path
                $request->file('file')->move($destinationPath, $fileName);

            }

        }
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
        return view('users.show', compact('user'));
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
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $countries= DB::table("countries")->get();
        $states= DB::table("states")->where('country_id','=',$user->country['id'])->get();
        $cities= DB::table("cities")->where('state_id','=',$user->state['id'])->get();
        return view('users.edit', compact('user', 'roles', 'userRole','countries','states','cities'));
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
        $this->validate($request, [
            'name1' => 'required',
            'surname1' => 'required',
            'phone1' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
//dd($input);
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        Alert::toast('Datos actualizados', 'success')->timerProgressBar();
        return redirect()->route('users.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->ids;

        User::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['status' => true, 'message' => "Category deleted successfully."]);

    }

    public function search(Request $request)
    {

        $users = User::like($request->get('searchQuest'))->get();
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
