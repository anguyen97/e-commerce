<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Category;

class CategoryController extends Controller
{
    /**
	 * display Category page
	 * @return [type] [description]
	 */
	public function getIndex()
	{
		return view('admin.categories.index');
	}

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
    	return Datatables::of(Category::query())
    	->addColumn('action', function ($category) {
			return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$category["id"].'" id="row-'.$category["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$category["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$category["id"].'></a>';
		})
		->setRowId('id')
    	->make(true);
    }

    /**
     * save new Category to db
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
    	$data = $request->all();
    	$data['slug'] = str_slug($request->name, '-');
    	return Category::create($data);
    }

    /**
     * get Category's info and display
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
    	return Category::find($id);
    }

    /**
     * get Category's infomation and display to edit
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
    	return Category::findOrFail($id);
    }

    /**
     * update Category by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request,$id)
    {
    	$data = $request->all();
    	$res = Category::find($id)->update($data);
    	if($res ==true){
    		return Category::find($id);
    	} else {
    		return response([],400);
    	}
    }

    /**
     * delete Category by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    	$res = Category::find($id)->delete();
    	if ($res==true) {
    		return response(['success'], 200);
    	} else {
    		return response([],400);
    	}    	
    }
}
