<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\MassDestroyUserRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = User::where('id', '!=', 1)->with(['roles'])->get();

        return view('admin.users.index', compact('data'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $role = Role::where('id', 2)->firstOrFail();

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->roles()->sync([$role->id]);

        return redirect('admin/users')->with('success', 'User Created Successfully');
    }


    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $userRole = $user->roles->first()->title ?? null;

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user', 'userRole'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $role = Role::where('id', 2)->firstOrFail();

        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->roles()->sync([$role->id]);

        return redirect()->route('admin.users.index')->with('success', 'User Updated Successfully');;
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->forceDelete();

        return back()->with('success', 'User Deleted Successfully');
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = User::find(request('ids'));

        foreach ($users as $user) {
            $user->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function toggleBlock($id)
    {
        $user = User::find($id);
    
        if ($user) {
            $user->is_block = !$user->is_block;
            $user->save();
            
            return redirect()->back()->with('success', $user->is_block ? 'User Blocked Successfully' : 'User Unblocked Successfully');
        }

        return redirect()->back()->with('error', 'User Not Found.');
        }
}
