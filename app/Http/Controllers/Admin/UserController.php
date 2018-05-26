<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
	 * display user page
	 * @return [type] [description]
	 */
    public function getIndex()
    {
    	return view('admin.users.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
    	return Datatables::of(User::query())
    	->addColumn('action', function ($user) {
    		return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$user["id"].'" id="row-'.$user["id"].'"></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$user["id"].'></a>';
    	})
    	->setRowId('id')
    	->make(true);
    }

    /**
     * save new user to db
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
    	$data = $request->all();

    	// $date = date('YmdHis', time());

    	// if ($request->hasFile('thumbnail')) {

    	// 	$extension = '.'.$data['thumbnail']->getClientOriginalExtension();

    	// 	$file_name = md5($request->name).'_'. $date . $extension;

    	// 	$data['thumbnail']->storeAs('public/user_profile',$file_name);

    	// 	$data['avatar'] = 'storage/user_profile/'.$file_name;

    	// }else {
    	// 	$data['avatar']='storage/user_profile/userDefault.png';
    	// }

    	$data['avatar']='storage/user_profile/userDefault.png';
    	
    	$user_name = explode('@', $data['email'])[0];

    	$data['password'] = Hash::make($user_name);

    	return User::create($data);
    }


    /**
     * delete user by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    	$res = User::find($id)->delete();
    	if ($res==true) {
    		return response(['success'], 200);
    	} else {
    		return response([],400);
    	}    	
    }
}
