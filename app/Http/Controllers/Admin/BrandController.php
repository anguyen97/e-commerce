<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Brand;

class BrandController extends Controller
{
    /**
	 * display brand page
	 * @return [type] [description]
	 */
	public function getIndex()
	{
		return view('admin.brands.index');
	}

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
    	return Datatables::of(Brand::query())
    	->addColumn('action', function ($brand) {
			return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$brand["id"].'" id="row-'.$brand["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$brand["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$brand["id"].'></a>';
		})
		->setRowId('id')
    	->make(true);
    }

    /**
     * save new brand to db
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
    	$data = $request->all();
        $data['slug'] = str_slug($data['name'], '-');
    	return Brand::create($data);
    }

    /**
     * get brand's info and display
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
    	return Brand::find($id);
    }

    /**
     * get brand's infomation and display to edit
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
    	return Brand::find($id);
    }

    /**
     * update brand by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request,$id)
    {
    	$data = $request->all();
    	$res = Brand::find($id)->update($data);
    	if($res ==true){
    		return Brand::find($id);
    	} else {
    		return response([],400);
    	}
    }

    /**
     * delete brand by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    	$res = Brand::find($id)->delete();
    	if ($res==true) {
    		return response(['success'], 200);
    	} else {
    		return response([],400);
    	}    	
    }
}
