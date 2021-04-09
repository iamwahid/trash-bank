<?php

namespace App\Http\Controllers\Backend\Auth\Permission;

use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\Permission\PermissionDeleted;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\Permission\StorePermissionRequest;
use App\Http\Requests\Backend\Auth\Permission\ManagePermissionRequest;
use App\Http\Requests\Backend\Auth\Permission\UpdatePermissionRequest;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionController.
 */
class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function index(ManagePermissionRequest $request)
    {
        return view('backend.auth.permission.index')
            ->withPermissions($this->permissionRepository
            ->with('users', 'permissions')
            ->orderBy('id')
            ->paginate());
    }

    public function indexJson(ManagePermissionRequest $request)
    {
        $resp = $this->permissionRepository
                // ->with('users', 'permissions')
                ->orderBy('id')->get();
        return response()->json($resp);
    }

    /**
     * @param ManagePermissionRequest $request
     *
     * @return mixed
     */
    public function create(ManagePermissionRequest $request)
    {
        return view('backend.auth.permission.create')
            ->withPermissions($this->permissionRepository->get());
    }

    /**
     * @param StorePermissionRequest $request
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = $this->permissionRepository->create($request->only('name', 'guard_name'));

        return $request->wantsJson() ? response()->json(['message'=> 'created', 'data' => $permission]) : redirect()->route('admin.auth.permission.index')->withFlashSuccess(__('alerts.backend.permissions.created'));
    }

    /**
     * @param ManagePermissionRequest $request
     * @param Permission              $permission
     *
     * @return mixed
     */
    public function edit(ManagePermissionRequest $request, Permission $permission)
    {
        if ($permission->id == 1) {
            return redirect()->route('admin.auth.permission.index')->withFlashDanger('You can not edit the administrator permission.');
        }

        return view('backend.auth.permission.edit')
            ->withPermission($permission)
            ->withPermissionPermissions($permission->permissions->pluck('name')->all())
            ->withPermissions($this->permissionRepository->get());
    }

    /**
     * @param UpdatePermissionRequest $request
     * @param Permission              $permission
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $this->permissionRepository->update($permission, $request->only('name', 'guard_name'));

        return $request->wantsJson() ? response()->json(['message'=> 'updated']) : redirect()->route('admin.auth.permission.index')->withFlashSuccess(__('alerts.backend.permissions.updated'));
    }

    /**
     * @param ManagePermissionRequest $request
     * @param Permission              $permission
     *
     * @throws \Exception
     * @return mixed
     */
    public function destroy(ManagePermissionRequest $request, Permission $permission)
    {
        if ($permission->id == 1) {
            return $request->wantsJson() ? response()->json(['message'=> 'forbidden']) : redirect()->route('admin.auth.permission.index')->withFlashDanger('You can not edit the administrator permission.');
        }

        $this->permissionRepository->deleteById($permission->id);

        return $request->wantsJson() ? response()->json(['message'=> 'deleted']) : redirect()->route('admin.auth.permission.index')->withFlashSuccess(__('alerts.backend.permissions.deleted'));
    }
}
