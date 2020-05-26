<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RoleRepository;
use PermissionRepository;
use Auth;

class RoleController extends Controller
{
    protected $role;

    protected $permission;

    function __construct(RoleRepository $role, PermissionRepository $permission) {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!\Auth::user()->can('role.view'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $limit = $request->get('limit', 10);
        $search = $request->get('search', '');

        $roles = $this->role->model();
        if($search != '') {
            $roles = $roles->where('name', 'LIKE', '%'. $search .'%');
        }
        $roles = $roles->orderBy('title')->paginate($limit)->appends(['limit' => $limit, 'search' => $search]);
        return view('backend.role.index', compact('roles', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!\Auth::user()->can('role.add'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $data["list_permission"] = $this->permission->listPermissions();
        $data["selected_permission"] = [];
        $data['disabled'] = '';
        return view('backend.role.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!\Auth::user()->can('role.add'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $request->validate([
            'name' => 'required|max:255|unique:roles,name',
        ]);

        $role = $this->role->create(['name' => str_slug($request->name, '-'), 'title' => $request->name, 'role_type' => $request->role_type]);
        $permissions = $request->get('permission', []);
        
        if($role) {
            $role->syncPermissions($permissions);
            return redirect('/administrator/role')->with('successful', 'Save Successfully.');
        }
        return redirect('/administrator/role')->with('error','Save Fails.');
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
    public function edit($id)
    {
        if(!\Auth::user()->can('role.edit'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $item = $this->role->find($id);
        if(!$item) {
            return redirect('administrator/role')->with('error','No matching records found');
        }
        $list_permission = $this->permission->listPermissions(); 
        $selected_permission = $item->permissions()->pluck('name','id')->toArray();

        $title = 'Role - Edit';
        $action = 'Edit New Role';
        $breadcrumb = [''=>'User Management', 'active'=>'Role'];
        $disabled = '';

        $data = compact('breadcrumb','list_permission','item','selected_permission','title','action', 'disabled');
        return view('backend.role.form', $data);
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
        if(!\Auth::user()->can('role.edit'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $request->validate([
            'name' => 'required|max:255|unique:roles,name,'.$id,
        ]);

        $item = $this->role->find($id);
        if(!$item) {
            return redirect('administrator/role')->with('error', 'No matching records found');
        }
        $role = $item->update(['title' => $request->name, 'name' => str_slug($request->name, '-'), 'role_type' => $request->role_type]);
        $permissions = $request->get('permission', []);
        if($role) {
            $item->syncPermissions($permissions);
            return redirect('/administrator/role')->with('successful', 'Update Successfully.');
        }
        return redirect('/administrator/role')->with('error','Update Fails.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!\Auth::user()->can('role.delete')) {
            return \Response::json([
                                    'success'   => false,
                                    'message' => 'You have not permission!'
                                ], 500);
            // return view('backend.partial.no-permission', ['title' => 'No-permission']);
        }

        $item = $this->role->find($id);
        if(!$item) {
            return \Response::json([
                                    'success'   => false,
                                    
                                ], 500);
        }
        if($item->delete()){
            return \Response::json([
                                    'success'   => true,
                                    
                                ], 200);
        }
        return \Response::json([
                                    'success'   => false,
                                    
                                ], 500);
    }
}
