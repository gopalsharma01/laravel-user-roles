<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Exception;

class UserController extends Controller
{
    // Create user with roles
    public function store(Request $request)
    {
        try{

            // Validation
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'email'     => 'required|email|unique:users,email',
                'roles'     => 'required|array',
                'roles.*'   => 'exists:roles,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()
                ], 422);
            }

            // Create user
            $user = User::create([
                'name'  => $request->full_name,
                'email' => $request->email,
            ]);

            // Attach roles
            $user->roles()->attach($request->roles);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data'    => $user->load('roles')
            ], 201);

        }catch(Exception $e){
            // Catch any exception
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(), // you can hide this in production
            ], 500);
        }
    }

    // Get users
    public function index(Request $request)
    {
        try {
            $role = $request->query('role');

            $users = User::with('roles')
                ->when($role, function ($query, $role) {
                    $query->whereHas('roles', function ($q) use ($role) {
                        $q->where('roles.id', $role);
                    });
                })->orderBy('created_at', 'desc') // descending
                ->get();
            $roles = Role::get();

            return response()->json([
                'success' => true,
                'data'    => $users,
                'roles'   => $roles
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'There is a problem in your request',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    
    //Get User Detail
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'success' => true,
                'data'    => $user->load('roles')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    //Update user
    public function update(Request $request, $id)
    {
        try{
            $user = User::findOrFail($id);
            // Validation
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'email'     => 'required|email|unique:users,email,' . $user->id,
                'roles'     => 'required|array',
                'roles.*'   => 'exists:roles,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()
                ], 422);
            }

            // Create user
            $user->update([
                'name'  => $request->full_name,
                'email' => $request->email,
            ]);
            // Update pivot table
            $user->roles()->sync($request->roles);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data'    => $user->load('roles')
            ], 201);

        }catch(Exception $e){
            // Catch any exception
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(), // you can hide this in production
            ], 500);
        }
    }
    //delete user
    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ], 201);

        }catch(Exception $e){
            // Catch any exception
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(), // you can hide this in production
            ], 500);
        }
    }

    // Get roles
    public function roles(Request $request)
    {
        try {
            $roles = Role::get();

            return response()->json([
                'success' => true,
                'data'   => $roles
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'There is a problem in your request',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
