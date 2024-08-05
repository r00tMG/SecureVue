<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return \response()->json([
           'error' => false,
           'message' => "Votre requête a réussie",
           'roles' => RoleResource::collection(
               Role::with('permissions')->get()
           )
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        // Valider les données d'entrée
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        // Vérifier si la validation a échoué
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Validation des données échouée',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Créer le rôle
        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        // Associer les permissions si elles existent
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('name', $request->permissions)->get();
            logger('Permission:' . json_encode($permissions));
            $role->permissions()->sync($permissions->pluck('id'));
        }
        // Retourner une réponse JSON
        return response()->json([
            'error' => false,
            'message' => 'Rôle créé avec succès',
            'role' => $role
        ], Response::HTTP_CREATED);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        //dd($id);
        $role = Role::find($id);
        logger("User".json_encode($role));
        if ($role == null)
        {
            return \response()->json([
                'error' => true,
                'message' => "Aucun role n'a été trouvé",
            ], Response::HTTP_NOT_FOUND);
        }
        return \response()->json([
            'error' => false,
            'message' => "Votre requête a réussie avec succés",
            'role' => new RoleResource($role)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $role = Role::find($id);
            //dd($user);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'permissions' => 'array',
                'permissions.*' => 'string|exists:permissions,name'
            ]);
            //dd($validator->fails());
            logger('Request data:'. json_encode($validator));
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validation des données échouée',
                    'errors' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }

            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description
            ]);
            //dd($user);
            logger('Request data:'. json_encode($request->has('roles')));
            // Attribution des permissions
             if ($request->has('permissions')) {
                 $permissions = Permission::whereIn('name', $request->permissions)->get();
                 logger('Permission:'. json_encode($permissions));
                 $role->permissions()->sync($permissions->pluck('id'));
             }

            return response()->json([
                'error' => false,
                'message' => "L'utilisateur est enregistré avec succès",
                'role' => $role
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        $role = Role::find($id);
        //dd($user);
        if ($role == null)
        {
            return \response()->json([
                'error' => true,
                'message' => "Aucun utilsateur n'a été trouvé",
            ], Response::HTTP_NOT_FOUND);
        }
        $role->delete();
        return \response()->json([
            'error' => false,
            'message' => "l'utilsateur a bien été supprimé",
        ], Response::HTTP_NO_CONTENT);
    }
}
