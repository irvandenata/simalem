<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\GlobalFunction;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $name = 'About Me';
    protected $breadcrumb = '<strong>Setting</strong>';
    protected $modul = 'user';
    protected $route = 'users';
    protected $view = 'admin.user';
    protected $newModel;
    protected $model;
    protected $rows;
    protected $createLink;
    protected $storeLink;
    protected $indexLink;
    protected $updateLink;
    protected $editLink;

    public function __construct()
    {
        $this->newModel = new User();
        $this->model = User::query();
        $this->createLink = route('admin.users.create');
        $this->storeLink = route('admin.users.store');
        $this->indexLink = route('admin.users.index');
        $this->updateLink = 'admin.users.update';
        $this->editLink = 'admin.users.edit';
    }

    protected static function validateRequest($request, $type)
    {
        if ($type == 'create') {
            $result = Validator::make($request->all(), [
                // 'equipment_id' => 'required',
                // 'serial_number' => 'required',
                // 'installation_date'=> 'required',
                // 'photo' => 'mimes:jpeg,jpg,png,gif|max:10000',
                // 'price'=> 'required',
            ]);
        } else {
            $result = Validator::make($request->all(), [
                // 'equipment_id' => 'required',
                // 'serial_number' => 'required',
                // 'installation_date'=> 'required',
                // 'photo' => 'mimes:jpeg,jpg,png,gif|max:10000',

                // 'price'=> 'required',
            ]);
        }

        return $result;
    }
    protected function findById($id)
    {
        $model = clone $this->model;
        return $model->where('id', $id)->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = $this->name;
        $data['breadcrumb'] = $this->breadcrumb;
        $data['rows'] = $this->rows;
        $data['createLink'] = $this->createLink;
        return view($this->view . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.i
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->name . ' - Create';
        $data['breadcrumb'] = $this->breadcrumb . ' - Create';
        $data['storeLink'] = $this->storeLink;
        $data['indexLink'] = $this->indexLink;
        return view($this->view . '.create', $data);
    }

    public function edit (){
    return ;
    }

    public function update(Request $request, $id)
    {
        $model = User::find($id);
        $model->password = Hash::make($request->password);
        $model->save();
        return response()->json(['status' => 'success', 'message' => 'Data has been updated']);
    }
}
