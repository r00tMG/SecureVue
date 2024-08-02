<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $user = Auth::user();
        logger('user'.json_encode($user));
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Non authentifié'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($user->hasRole('admin') || $user->hasRole('super-admin')) {
            return \response()->json([
                'error' => false,
                'message' => "Votre requête a réussie",
                'roles' => Role::all(),
                'permissions' => Permission::all(),
                'users' => UserResource::collection(User::orderBy('created_at', 'DESC')->limit(1000)->get())
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => true,
                'message' => "Vous n'avez pas les rôles requis"
            ], Response::HTTP_FORBIDDEN);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required'],
                'roles' => ['required', 'array'],
                'roles.*' => ['string', 'exists:roles,name'],
                'permissions' => ['required','array'],
                'permissions.*' => ['string', 'exists:permissions,name']
            ]);
            logger('Request data:'. json_encode($validator));
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation des données échouée',
                    'errors' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            logger('Request data:'. json_encode($request->has('roles')));

            // Attribution des rôles
            if ($request->has('roles')) {
                $roles = Role::whereIn('name', $request->roles)->get();
                logger('Role:'. json_encode($roles));
                $user->roles()->sync($roles->pluck('id'));

            }

            // Attribution des permissions
            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('name', $request->permissions)->get();
                logger('Permission:'. json_encode($permissions));
                $user->permissions()->sync($permissions->pluck('id'));
            }

            return response()->json([
                'error' => false,
                'message' => "L'utilisateur est enregistré avec succès",
                'user' => $user
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Exception:', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => true,
                'message' => 'Une erreur est survenue lors de l\'enregistrement de l\'utilisateur.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
