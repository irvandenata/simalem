<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Helpers\GlobalFunction;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemInstalled;
use App\Models\ReportProblem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ReportProblemController extends Controller
{
    protected $name = 'Laporan Kendala Alat';
    protected $breadcrumb = '<strong>Data</strong> Laporan Kendala Alat';
    protected $modul = 'report-problem';
    protected $route = 'report-problems';
    protected $view = 'admin.report-problem';
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
        $this->newModel = new ReportProblem();
        $this->model = ReportProblem::query();
        $this->rows = [
            'name'=>['Pelapor','Detail Alat','Nomor Seri','Status','Tanggal Pelaporan','Tanggal Tanggapan','Tanggal Selesai'],
            'column' => ['hospital','item','serial_number','status','created_at','response_at','finished_at']
        ];
        $this->createLink = route('admin.report-problems.create');
        $this->storeLink = route('admin.report-problems.store');
        $this->indexLink = route('admin.report-problems.index');
        $this->updateLink = 'admin.report-problems.update';
        $this->editLink = 'admin.report-problems.edit';
    }

    protected static function validateRequest($request, $type)
    {
        if ($type == 'create') {
            $result = Validator::make($request->all(), [
                'name' => 'required',
            ]);
        } else {
            $result = Validator::make($request->all(), [
                'name' => 'required',
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
        if ($request->ajax()) {
            $items = $this->model->orderBy('status','asc')->orderBy('created_at','desc');
            if($request->search['value']){
                $items = $items->whereHas('item',function($query) use ($request){
                    $query->where('serial_number','like','%'.$request->search['value'].'%');
                })->orWhereHas('item',function($query) use ($request){
                    $query->where('hospital','like','%'.$request->search['value'].'%');
                })->orWhereHas('item',function($query) use ($request){
                    $query->whereHas('item',function($query) use ($request){
                        $query->where('name','like','%'.$request->search['value'].'%');
                    });
                });
            }
            if($request->status != 'all'){
                $items = $items->where('status',$request->status);
            }
            if($request->hospital != 'all'){
                $items = $items->whereHas('item',function($query) use ($request){
                    $query->where('hospital',$request->hospital);
                });
            }
            if($request->item != 'all'){
                $items = $items->whereHas('item',function($query) use ($request){
                    $query->where('item_id',$request->item);
                });
            }

            return DataTables::of($items)
                ->addColumn('action', function ($item) {
                    return '
                           <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $item->id . ')"><i class="fas fa-trash text-white"></i></span></a> <a class="btn btn-warning btn-sm" href="'.route('admin.report-problems.show',$item->id).'"><i class="fas fa-eye text-white    "></i></span></a>';
                })
                ->editColumn('status', function ($item) {
                    if ($item->status == 0) {
                        $name = 'Perlu Tanggapan';
                        $class = 'danger';
                    } else if ($item->status == 1) {
                        $name = 'Ditanggapi';
                        $class = 'primary';
                    } else if ($item->status == 2) {
                        $name = 'Selesai';
                        $class = 'success';
                    }
                    return '<div onclick="changeStatus()" class="badge bg-' . $class . '" style="cursor:pointer">' . $name . '</div>';
                })
                ->addColumn('serial_number', function ($item) {
                    return $item->item->serial_number;
                })
                ->addColumn('hospital', function ($item) {
                    return $item->item->hospital;
                })
                ->addColumn('item', function ($item) {
                    return "<a href='".route('admin.item-installeds.edit',$item->item->id)."'><b>" . $item->item->item->name . "</b></a><br>Tipe : " . $item->item->item->type . "<br>Merek : " . $item->item->item->brand;
                })
                ->editColumn('created_at', function ($item) {
                    return date('d-m-Y', strtotime($item->created_at));
                })
                ->editColumn('response_at', function ($item) {
                    if($item->response_at == null){
                        return '-';
                    }
                    return date('d-m-Y', strtotime($item->response_at));
                })
                ->editColumn('finished_at', function ($item) {
                    if($item->finished_at == null){
                        return '-';
                    }
                    return date('d-m-Y', strtotime($item->finished_at));
                })
                ->removeColumn('id')
                ->addIndexColumn()
                ->rawColumns(['action','status','item'])
                ->make(true);
        }
        $data['title'] = $this->name;
        $data['breadcrumb'] = $this->breadcrumb;
        $data['rows'] = $this->rows;
        $data['createLink'] = $this->createLink;
        $data['view'] = $this->view;
        $data['hospitals'] = ItemInstalled::select('hospital')->groupBy('hospital')->get();
        $data['items'] = Item::all();
        return view($this->view.'.index', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $v = $this->validateRequest($request, 'create');
            if ($v->fails()) {
                throw new CustomException("error", 401, null, $v->errors()->all());
            }
            $findType = ReportProblemType::where('name',$request->type)->first();
            if(!$findType){
                $type = new ReportProblemType();
                $type->name = $request->type;
                $type->save();
            }
            $findBrand = ReportProblemBrand::where('name',$request->brand)->first();
            if(!$findBrand){
                $brand = new ReportProblemBrand();
                $brand->name = $request->brand;
                $brand->save();
            }
            $item = $this->newModel;
            $item->name = $request->name;
            $item->type = $request->type;
            $item->brand = $request->brand;
            $item->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getOptions(), 500);
        } catch (CustomException $e) {
            DB::rollback();
            return response()->json($e->getOptions(),$e->getCode());
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json(['message' => "$this->name has been created !", "data" => $item], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = $this->name . ' - Detail Laporan Kendala';
        $data['breadcrumb'] = $this->breadcrumb . ' - Detail Laporan Kendala';
        $data['indexLink'] = $this->indexLink;
        $data['report'] = ReportProblem::find($id);

        $data['item'] = $data['report']->item;
        return view('admin.report-problem.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoryQuestion = $this->findById($id);
        return $categoryQuestion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $v = $this->validateRequest($request, 'edit');
            if ($v->fails()) {
                throw new CustomException('error', 401, null, $v->errors()->all());
            }
            $item = $this->findById($id);
            $findType = ReportProblemType::where('name',$request->type)->first();
            if(!$findType){
                $type = new ReportProblemType();
                $type->name = $request->type;
                $type->save();
            }
            $findBrand = ReportProblemBrand::where('name',$request->brand)->first();
            if(!$findBrand){
                $brand = new ReportProblemBrand();
                $brand->name = $request->brand;
                $brand->save();
            }
            $item->name = $request->name;
            $item->type = $request->type;
            $item->brand = $request->brand;
            $item->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getOptions(), 500);
        } catch (CustomException $e) {
            DB::rollback();
            return response()->json($e->getOptions(),$e->getCode());
        }
        return response()->json(['message' => "$this->name has been updated !", "data" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->findById($id);
            $item->delete();
            return response()->json(['message' => "$this->name has been deleted !"], 200);
        }catch (Exception $e) {
            return response()->json($e->getOptions(), 500);
        } catch (CustomException $e) {
            return response()->json($e->getOptions(), 500);
        }
    }


    public function change($id){
        $item = $this->findById($id);
        $item->status = request()->status;
        if(request()->status == 1){
            $item->response_at = date('Y-m-d');
        }else if(request()->status == 2){
            $item->response_at = date('Y-m-d');
            $item->finished_at = date('Y-m-d');
            $item->item->status = 0;
            $item->item->save();
        }
        if(request()->status == 0){
            $item->response_at = null;
            $item->finished_at = null;
        }
        $item->save();
        return redirect()->back()->with('success','Status Laporan berhasil diubah !');
    }
}
