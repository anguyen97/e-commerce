<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
	 * display admin page
	 * @return [type] [description]
	 */
    public function getIndex()
    {
      return view('admin.admins.index');
  }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
    	return Datatables::of(Admin::query())
    	->addColumn('action', function ($admin) {
            return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$admin["id"].'" id="row-'.$admin["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$admin["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$admin["id"].'></a>';
        })
        ->setRowId('id')
        ->make(true);
    }

    /**
     * save new admin to db
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
    	$data = $request->all();

        $date = date('YmdHis', time());

        if ($request->hasFile('thumbnail')) {

            $extension = '.'.$data['thumbnail']->getClientOriginalExtension();

            $file_name = md5($request->name).'_'. $date . $extension;

            $data['thumbnail']->storeAs('public/admin_profile',$file_name);

            $data['avatar'] = 'storage/admin_profile/'.$file_name;

        }else {
            $data['avatar']='storage/admin_profile/userDefault.png';
        }

        $user_name = explode('@', $data['email'])[0];

        $data['password'] = Hash::make($user_name);

        return Admin::create($data);
    }

    /**
     * get admin's info and display
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
    	return Admin::findOrFail($id);
    }

    /**
     * get admin's infomation and display to edit
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
    	return Admin::find($id);
    }

    /**
     * update admin by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request,$id)
    {
    	$data = $request->all();
    	$res = Admin::find($id)->update($data);
    	if($res ==true){
    		return Admin::find($id);
    	} else {
    		return response([],400);
    	}
    }

    /**
     * delete admin by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    	$res = Admin::find($id)->delete();
    	if ($res==true) {
    		return response(['success'], 200);
    	} else {
    		return response([],400);
    	}    	
    }
}
