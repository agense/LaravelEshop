<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use App\Models\Admin;

class AdminManagementService {

    private $pagination = 10;

    /**
     * Returns a paginated list of all administrators
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Admin::paginate($this->pagination);
    }

    /**
     * Creates a new administrator or updates existing one
     * @param App\Models\Admin $admin (optional)
     * @return App\Models\Admin
     */
    public function saveAdmin($admin = null){
        $admin =  $admin instanceof Admin ? $admin : new Admin;

        $admin->fill(request()->only('role','name','email'));

        if(request()->filled('password')){
            $admin->password = bcrypt(request()->password);
        }
        $admin->save();
        return $admin;
    }

    /**
     * Deletes an administrator
     * @param App\Models\Admin $admin
     * @return Void
     */
    public function delete(Admin $admin){
        try{
            $sdmin->delete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }
}