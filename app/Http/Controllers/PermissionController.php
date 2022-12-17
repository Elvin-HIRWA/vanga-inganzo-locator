<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\Permission;
use App\Services\PermissionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function permissionCreate(Request $request, PermissionService $service)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string",
        ]);

        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $service->CreatePermission($request->name);

        return response()->json(["Permission Created"], Response::HTTP_CREATED);
    }


    public function listPermission(PermissionService $service)
    {
        $results = $service->listPermission();

        return Response()->json($results, 200);
    }


    public function getPermission($id, PermissionService $service)
    {
        $results = $service->getPermission($id);

        return Response()->json($results);
    }


    public function updatePermission(Request $request, PermissionService $service)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|string",
        ]);

        if ($validation->fails()) {
            return response()->json(["errors" => $validation->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $key = Permission::find($request->id);

        if ($key === null) {
            return response()->json(["Id not found"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $service->updatePermission($request->id, $request->name);

        return Response()->json(["Permission Updated"], Response::HTTP_CREATED);
    }


    public function deletePermission($id, PermissionService $service)
    {

        $key = Permission::find($id);

        if ($key === null) {
            return response()->json(["Id not found"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $key = Key::where("permissionID", $id)->first();

        if ($key === null) {
            $service->deletePermission($id);
            return Response()->json(["Permission deleted"], Response::HTTP_OK);
        }
        return Response()->json(["you can't delete permission, is created on key"], Response::HTTP_FORBIDDEN);
    }
}
