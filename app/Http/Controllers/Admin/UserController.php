<?php

namespace App\Http\Controllers\Admin;

use App\Model\User\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User\UserRepository;
use App\Model\Role\RoleRepository;
use App\Model\Permission\PermissionRepository;
use App\Model\User\UserRequest;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    public function __construct(UserRepository $user, RoleRepository $role, PermissionRepository $permission) {
        $this->repos = $user;
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index(Request $request)
    {
        if(!\Auth::user()->can('user.view'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $limit = $request->get('limit', 10);
        $role  = $request->get('role', '');
        $items = $this->repos->getUserPerPage($role, $limit);
        $list_role = $this->role->model()->pluck('name', 'id')->toArray();
        return view('backend.user.index', compact('items', 'list_role', 'role', 'limit'));
    }

    public function changePassword($id)
    {
      if(!\Auth::user()->can('user.edit')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $user = User::find($id);

        if(is_null($user)){
            return redirect()->back();
        }

        return view("backend.user.change-password", compact("user"));
    }

    public function storeChangePassword(Request $request, $id)
    {
      if(!\Auth::user()->can('user.edit')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }
        $request->validate([
            "old_password" => "required",
            'new_password' => 'required',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = User::find($id);
        if(is_null($user)){
            return redirect()->back()->withErrors(__("Error: not found user!"));
        }

        $old_password = $request->get("old_password");
        if(!Hash::check($old_password, $user->password)){
            return redirect()->back()->withErrors(__("Error: old password incorrect!"));
        }

        $user->password = $request->new_password;
        $save = $user->save();
        if($save){
            return redirect(route("administrator.user.index"))->with("success", __("Success: password has been reset."));
        }

        return redirect()->back()->withErrors(__("Error: unable to update password!"));

    }

    public function create(Request $request)
    {
        if(!\Auth::user()->can('user.add'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $list_role = $this->role->model()->pluck('name', 'id')->toArray();
        $list_permission = $this->permission->listPermissions();
        $selected_permission = [];
        $selected_role = $request->get('role', '-1');

        if ($selected_role !== '-1') {
            $role = $this->role->find($selected_role);
            $selected_permission = $role->permissions()->pluck('name','id')->toArray();
        }
        return view('backend.user.form', compact('list_role', 'list_permission', 'selected_permission', 'selected_role'));
    }

    public function store(Request $request)
    { 
      if(!\Auth::user()->can('user.add')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $request->validate([
            "email" => "required|unique:users,email",
            'password' => 'required',
            'role' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $data = [
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'phone' =>  $request->phone,
            'password'  =>  $request->password,
            'status'    =>  $request->status,
            'is_admin' => true
        ];

        $permissions = $request->get('permission', []);
        $user = User::create($data);
        if($user) {
            $role = $this->role->find($request->role);
            $user->assignRole($role->name);
            $user->syncPermissions($permissions);
            return redirect('administrator/user')->with('success', 'Save successful!');
        }

        return redirect('administrator/user')->withErrors(['Save fails!']);
    }

    public function edit($id, Request $request)
    {
        if(!\Auth::user()->can('user.edit'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $item = $this->repos->find($id);
        if(!$item){
            return redirect('administrator/user')->with(['error' , 'User Not found!']);
        }
        $list_role = $this->role->model()->pluck('name', 'id')->toArray();

        $list_permission = $this->permission->listPermissions();
        $selected_role = $request->get('role', '0');
        
        if ($selected_role === '0') {
            $selected_role = $item->roles->first()->id ?? '-1';
            $selected_permission = $item->permissions()->pluck('name','id')->toArray();
        } else if ($selected_role !== '-1' && $selected_role !== '0') {
            $role = $this->role->find($selected_role);
            $selected_permission = $role->permissions()->pluck('name','id')->toArray();
        } else {
            $selected_permission = $item->permissions()->pluck('name','id')->toArray();
        }

        return view('backend.user.form', compact('list_role', 'item', 'list_permission', 'selected_permission', 'selected_role'));

    }

    public function update(Request $request, $id)
    {
      if(!\Auth::user()->can('user.edit')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

         try {
             $request->validate([
                 "email" => "required|unique:users,email,". $id,
                 'role' => 'required'
             ]);


            $data = [
                'name'  =>  $request->name,
                'phone'  =>  $request->phone,
                'email' =>  $request->email,
                'status'    =>  $request->status,
            ];


            $updated = $this->repos->update($data + ['id' => $id]);
            $permissions = $request->get('permission', []);
            if($updated) {
                if ($request->role !== '-1') {
                    $updated->syncRoles([$this->role->find($request->role)->name]);
                } else {
                    $updated->syncRoles([]);
                }
                $updated->syncPermissions($permissions);
                return redirect('administrator/user')->with('successful', __('Update successfully!'));
            }

        } catch (Exception $e) {
            die();
        }
        return redirect('administrator/user')->with('error', __('Update Fails!'));
    }

    public function destroy($id)
    {
      if(!\Auth::user()->can('user.delete')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $item = $this->repos->find($id);
        if(!$item) {
            return \Response::json(['success' => false], 500);
        }
        if($item->delete()){
            return \Response::json(['success' => true], 200);
        }
        return \Response::json(['success' => false], 500);
    }
    
    public function changeStatus(Request $request)
    {
      if(!\Auth::user()->can('user.edit')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }
      
        if($request->id){
            
            $result = $this->repos->find($request->id);
            if($result){
                $result->status = $request->status;
                $result->save();
                return \Response::json([
                                        'success'   => true,
                                        'status'    =>  $result->status
                                    ], 200);
            }
        }
        return 0;
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
