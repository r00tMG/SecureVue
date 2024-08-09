<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use http\Env\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * @return Permission[]|Collection
     */
    public function index()
    {
        return Permission::orderBy('id', 'DESC')->get();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'name' => ['required','string']
        ]);
        //dd($validator->fails());
        if ($validator->fails() === true)
        {
            return response()->json([
                'error' => true,
                'message' => "Votre requête a une erreur",
                'permission' => $validator->errors()
            ]);
        }
        $permission = Permission::create([
            'name' => $request->name
        ]);
        return response()->json([
            'error' => false,
            'message' => "Votre permission a été bien ajouté",
            'permission' => $permission
        ]);
    }

    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function show(Permission $permission)
    {
        return response()->json([
            'error' => false,
            'message' => "Votre requête a été bien réussie",
            'permission' => $permission
        ]);
    }
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','string']
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'error' => true,
                'message' => "Votre requête a une erreur",
                'permissions' => $validator->errors()
            ]);
        }
        $permission->update([
            'name' => $request->name
        ]);
        return response()->json([
            'error' => true,
            'message' => "Votre permission a été bien modifiée",
            'permissions' => $permission
        ]);
    }

    public function destroy($id): JsonResponse
    {
        //dd($id);
        $permission = Permission::find($id);

        if (!$permission)
        {
            return response()->json([
               'error' => true,
               'message' => "Cette permission n'existe pas",
            ]);
        }
        $permission->delete();
        return response()->json([
            'error' => false,
            'message' => "Votre permission a été bien supprimé"
        ], \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    }

}
