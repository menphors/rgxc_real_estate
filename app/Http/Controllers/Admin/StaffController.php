<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Model\Office\Office;
use App\Model\Staff\Staff;
use App\Model\User\User;

use StaffRepository;
use UserRepository;
use RoleRepository;

class StaffController extends Controller
{

  protected $staff;

  protected $user;

  protected $role;

  function __construct(StaffRepository $staff, UserRepository $user, RoleRepository $role) 
  {
    $this->staff = $staff;
    $this->user = $user;
    $this->role = $role;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if(!\Auth::user()->can('staff.view')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $items = Staff::where('is_default', 0)->orderBy('created_at', 'desc');
    // $items = Staff::where('is_default', 0)->get()->filter(function($item) {
    //   return $item->user == NULL;
    // });
    // foreach($items as $item) {
    //   $staff = Staff::find($item->id) ?? new Staff;

    //   // create / update user
    //   $user = new User;
    //   $user->name       = $staff->name;
    //   $user->email      = $staff->email;
    //   $user->password   = 'rxgc.123';
    //   $user->phone      = $staff->phone1;
    //   $user->status     = 1;
    //   $user->is_admin   = 0;
    //   $user->is_default = 0;
    //   if($user->save()) {
    //     $permissions = $request->get('permission', []);
    //     $role = $this->role->find($staff->type);
    //     $user->assignRole($role->name);
    //     $user->syncPermissions($permissions);
    //   }

    //   $staff->user_id = $user->id;
    //   $staff->is_user = 1;
    //   $staff->save();
    // }

    $search = $request->get("search");
    if(!empty($search)) {
      $items->where(function ($query) use($search){
        $query->orWhere('name', "like", "%". $search. "%");
        $query->orWhere('email', "like", "%". $search. "%");
        $query->orWhere('phone1', "like", "%". $search. "%");
      });
    }
    $items = $items->paginate(\Constants::LIMIT);

    return view('backend.staff.index', compact('items'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    if(!\Auth::user()->can('staff.add')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $item = '';
    $list_role = $this->role->model()->where('name', '<>', 'administrator')->pluck('title', 'id')->toArray();
    $selected_role = $request->get('role', []);
    $offices = Office::orderBy("is_main", "DESC")->get();

    return view('backend.staff.form', compact('item', 'list_role', 'selected_role', "offices"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if(!\Auth::user()->can('staff.add')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $request->validate([
      'name' => 'required',
      'id_card' => 'required|unique:staffs,id_card',
      'phone1' => 'required',
      'office_id' => 'required',
    ]);

    $data['name'] = $request->name;
    $data['email'] = $request->email;
    $data['phone1'] = $request->phone1;
    $data['phone2'] = $request->phone2;
    $data['id_card'] = $request->id_card;
    $data['address'] = $request->address;
    $data['office_id'] = $request->office_id;
    $data['gender'] = $request->gender;
    $data['address'] = $request->address;
    $data['fb'] = $request->fb;
    $data['linkedin'] = $request->linkedin;
    $data['type'] = $request->staff_type;
    $data['dob'] = date("Y-m-d", strtotime($request->dob));
    $data['user_id'] = auth()->user()->id;
    $data['created_by'] = aut()->user()->id;

    if($request->hasFile('thumbnail')) {
      $profileImageName = time().'.'.request()->thumbnail->getClientOriginalExtension();
      request()->thumbnail->move(public_path('photos/account/'), $profileImageName);
      $data['thumbnail'] = $profileImageName;
      $data['image'] = $profileImageName;
    }

    if($request->is_user && $request->is_user==1) {
      $staffUser = Staff::find($id)->user();

      // create / update user
      $user = !empty($staffUser) ? User::find($staffUser->id) : new User;
      $user->name       = $request->name;
      $user->email      = $request->user_email;
      $user->password   = $request->user_password;
      $user->phone      = $request->phone1;
      $user->status     = 1;
      $user->is_admin   = 0;
      $user->is_default = 0;
      if($user->save()) {
        $permissions = $request->get('permission', []);
        $role = $this->role->find($request->staff_type);
        $user->assignRole($role->name);
        $user->syncPermissions($permissions);
      }

      $data['user_id'] = $user->id;
      $data['is_user'] = $request->is_user ? 1 : 0;
    }

    $save = Staff::create($data);
    if($save) {
      return redirect('administrator/staff')->with('successful', 'Save successful!');
    }

    return redirect()->back()->withErrors("Error: error!");
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, $id)
  {
    if(!\Auth::user()->can('staff.edit')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $list_role = $this->role->model()->where('name', '<>', 'administrator')->pluck('title', 'id')->toArray();
    $selected_role = $request->get('role', []);
    $item = $this->staff->find($id);
    $offices = Office::orderBy("is_main", "DESC")->get();
    // dd($selected_role);
    return view('backend.staff.form', compact('item', 'list_role', 'selected_role', 'offices'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    if(!\Auth::user()->can('staff.edit')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $request->validate([
      'name' => 'required',
      'id_card' => 'required|unique:staffs,id_card,'. $id,
      'phone1' => 'required'
    ]);

    $data['name'] = $request->name;
    $data['email'] = $request->email;
    $data['phone1'] = $request->phone1;
    $data['phone2'] = $request->phone2;
    $data['id_card'] = $request->id_card;
    $data['address'] = $request->address;
    $data['office_id'] = $request->office_id;
    $data['gender'] = $request->gender;
    $data['address'] = $request->address;
    $data['fb'] = $request->fb;
    $data['linkedin'] = $request->linkedin;
    $data['type'] = $request->staff_type;
    $data['dob'] = date("Y-m-d", strtotime($request->dob));
    $data['user_id'] = auth()->user()->id;
    $data['created_by'] = auth()->user()->id;

    if($request->hasFile('thumbnail')) {
      $profileImageName = time().'.'.request()->thumbnail->getClientOriginalExtension();
      request()->thumbnail->move(public_path('photos/account/'), $profileImageName);
      $data['thumbnail'] = $profileImageName;
      $data['image'] = $profileImageName;
    }

    if($request->is_user && $request->is_user==1) {
      $staffUser = Staff::find($id)->user()->first();

      // create / update user
      // dd(Hash::make($request->user_password));
      $user = !empty($staffUser) ? User::find($staffUser->id) : new User;
      $user->name       = $request->name;
      $user->email      = $request->user_email;
      $user->password   = $request->user_password;
      $user->phone      = $request->phone1;
      $user->status     = 1;
      $user->is_admin   = 0;
      $user->is_default = 0;
      if($user->save()) {
        $permissions = $request->get('permission', []);
        $role = $this->role->find($request->staff_type);
        $user->assignRole($role->name);
        $user->syncPermissions($permissions);
      }

      $data['user_id'] = $user->id;
      $data['is_user'] = $request->is_user ? 1 : 0;
    }

    $save = Staff::where("id", $id)->update($data);
    if($save) {
      return redirect('administrator/staff')->with('successful', 'Save successful!');
    }

    return redirect('administrator/staff', ['error' , 'Save fails!']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if(!\Auth::user()->can('staff.delete')) {
      return \Response::json([
        'success' => false,
        'message' => 'You have not permission!'
      ], 500);
    }

    $item = Staff::find($id);
    if(is_null($item)) {
      return \Response::json(['success' => false], 500);
    }

    if($item->delete()) {
      return \Response::json(['success' => true], 200);
    }

    return \Response::json(['success' => false], 500);
  }

  public function staffbyOffice($id)
  {
    $staffs = Staff::where('office_id', $id)->whereIn('type', [3,1,4])->get();

    return response()->json(['status' => 'ok', 'data' => $staffs]);
  }
}
