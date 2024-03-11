<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\GlobalFunction;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemInstalled;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class ItemInstalledController extends Controller
{
    protected $name = 'Daftar Alat Terinstall';
    protected $breadcrumb = '<strong>Data</strong> Daftar Alat Terinstall';
    protected $modul = 'item-installed';
    protected $route = 'item-installeds';
    protected $view = 'admin.item-installed';
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
        $this->newModel = new ItemInstalled();
        $this->model = ItemInstalled::query();
        $this->rows = [
            'name' => ['Rumah Sakit', 'Alat',"Nomor PO",'Nomor Seri', "Kondisi Alat", 'Maintenance Terakhir', 'Status Garansi'],
            'column' => ['hospital', 'item', 'po_number','serial_number','item_status', 'latest_maintenance', 'warranty_status'],
        ];
        $this->createLink = route('admin.item-installeds.create');
        $this->storeLink = route('admin.item-installeds.store');
        $this->indexLink = route('admin.item-installeds.index');
        $this->updateLink = 'admin.item-installeds.update';
        $this->editLink = 'admin.item-installeds.edit';
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
        if ($request->ajax()) {
            $items = $this->model;
            if ($request->hospital && $request->hospital != 'all') {
                $items = $items->where('hospital', $request->hospital);
            }
            if ($request->item && $request->item != 'all') {
                $items = $items->where('item_id', $request->item);
            }
            if($request->condition != 'all'){
                if($request->condition == 1){
                    $items = $items->where('status', 1);
                }else if($request->condition == 2){
                    $items = $items->where('status', 2);
                }else if($request->condition == 3){
                    $items = $items->where('status', 3);
                }else if($request->condition == 4){
                    $items = $items->where('status', 4);
                }else {
                    $items = $items->where('status', 0);
                }
            }
            // if ($request->status && $request->status != 'all') {
            //     $items = $items->where('status', $request->status);
            // }

            if($request->maintenance != 'all'){
                if($request->maintenance == 3){
                    $items = $items->where('maintenance_created_at_third', '!=', null);
                }else if($request->maintenance == 2){
                    $items = $items->where('maintenance_created_at_second', '!=', null)->where('maintenance_created_at_third', null);
                }else if($request->maintenance == 1){
                    $items = $items->where('maintenance_created_at_first', '!=', null)->where('maintenance_created_at_second', null)->where('maintenance_created_at_third', null);
                }else{
                    $items = $items->where('maintenance_created_at_first', null)->where('maintenance_created_at_second', null)->where('maintenance_created_at_third', null);
                }
            }
            if ($request->warranty && $request->warranty != 'all') {
                if($request->warranty == 1){
                    $date = date('Y-m-d');
                    $items = $items->where('warranty_date', '>', $date);
                }else{
                    $date = date('Y-m-d');
                    $items = $items->where('warranty_date', '<', $date);
                }
            }
            $items = $items->latest();
            return DataTables::of($items)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="btn btn-primary btn-sm" target="blank" href="'.url('/report-problem/'.$item->unique_code).'">Form</a>
                    <a class="btn btn-primary btn-sm" target="blank" href="'.route('admin.item-installeds.pdf', $item->id).'">QR Code</a>

                           <a class="btn btn-danger btn-sm"  onclick="deleteItem(' . $item->id . ')"><i class="fas fa-trash text-white"></i></span></a> <a class="btn btn-warning btn-sm" href="' . route($this->editLink, $item->id) . '" ><i class="fas fa-eye text-white    "></i></span></a>';
                })
                ->addColumn('item', function ($item) {
                    return "<b>" . $item->item->name . "</b><br>Tipe : " . $item->item->type . "<br>Merek : " . $item->item->brand;
                })
                ->editColumn('item_status', function ($item) {
                    if ($item->status == 0) {
                        $name = 'Normal';
                        $class = 'success';
                    } else if ($item->status == 1) {
                        $name = 'Rusak';
                        $class = 'danger';
                    } else if ($item->status == 3) {
                        $name = 'Berkendala';
                        $class = 'warning';
                    }else{
                        $name = 'Perbaikan';
                        $class = 'primary';
                    }
                    return '<div class="badge bg-' . $class . '">' . $name . '</div>';
                })
                ->addColumn('latest_maintenance', function ($item) {
                    if ($item->maintenance_description_third) {
                        return "maintenance ke 3 : " . Carbon::parse($item->maintenance_created_at_third)->format('d-m-Y')
                        . "<br><a href='" . route('admin.item-installeds.show', $item->id) . "' class='btn btn-sm text-white bg-primary detail-maintenance'>Detail</a>";
                    } else if ($item->maintenance_description_second) {
                        return "maintenance ke 2 : " . Carbon::parse($item->maintenance_created_at_second)->format('d-m-Y')
                        . "<br><a href='" . route('admin.item-installeds.show', $item->id) . "' class='btn btn-sm text-white bg-primary detail-maintenance'>Detail</a>";
                    } else if ($item->maintenance_description_first) {
                        return "maintenance ke 1 : " . Carbon::parse($item->maintenance_created_at_first)->format('d-m-Y')
                        . "<br><a href='" . route('admin.item-installeds.show', $item->id) . "' class='btn btn-sm text-white bg-primary detail-maintenance'>Detail</a>";
                    } else {
                        return "Belum ada maintenance" . "<br><a href='" . route('admin.item-installeds.show', $item->id) . "' class='btn btn-sm text-white bg-primary detail-maintenance'>Detail</a>";
                    }
                })
                ->addColumn('warranty_status', function ($item) {
                    if ($item->warranty_date) {
                        $warranty = date('Y-m-d', strtotime($item->warranty_date));
                        $now = date('Y-m-d');
                        if ($warranty > $now) {
                            return "<div class='badge bg-success'>Masih Berlaku (" . date('d-m-Y', strtotime($item->warranty_date)) . ")</div>";
                        } else {
                            return "<div class='badge bg-danger'>Tidak Berlaku</div>";
                        }
                    } else {
                        return "<div class='badge bg-danger'>Tidak Berlaku</div>";
                    }
                })
                ->removeColumn('id')
                ->addIndexColumn()
                ->rawColumns(['action', 'item', 'item_status', 'latest_maintenance', 'warranty_status'])
                ->make(true);
        }
        $data['title'] = $this->name;
        $data['breadcrumb'] = $this->breadcrumb;
        $data['rows'] = $this->rows;
        $data['createLink'] = $this->createLink;
        $data['hospitals'] = ItemInstalled::orderBy('hospital', 'asc')->select('hospital')->groupBy('hospital')->get();
        $data['items'] = Item::orderBy('name', 'asc')->get();
        return view($this->view . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.i
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->name . ' - Tambah Data';
        $data['breadcrumb'] = $this->breadcrumb . ' - Tambah Data';
        $data['storeLink'] = $this->storeLink;
        $data['indexLink'] = $this->indexLink;
        $data['items'] = Item::orderBy('name', 'asc')->get();
        $data['hospitals'] = ItemInstalled::orderBy('hospital', 'asc')->select('hospital')->groupBy('hospital')->get();
        return view($this->view . '.create', $data);
    }

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
            $item = $this->newModel;
            $check = ItemInstalled::where('serial_number', $request->serial_number)->exists();
            if ($check) {
                return redirect()->back()->withInput()->with('error', 'Serial Number telah digunakan');
            }
            $item->hospital = $request->hospital;
            $item->address = $request->address;
            $item->contact_person = $request->contact_person;
            $item->item_id = $request->item_id;
            $item->serial_number = $request->serial_number;
            $item->po_number = $request->po_number;
            $item->date_installed = $request->date_installed;
            $item->warranty_date = $request->warranty_date;
            $item->maintenance_date_first = $request->maintenance_date_first;
            $item->maintenance_date_second = $request->maintenance_date_second;
            $item->maintenance_date_third = $request->maintenance_date_third;
            $item->status = 0;
            //random unique code 8 char
            $item->unique_code = GlobalFunction::generateRandomString(8);
            $item->save();
            DB::commit();
            return redirect()->route($this->editLink, $item->id)->with('success', 'Data berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        } catch (CustomException $e) {
            DB::rollback();
            return redirect()->back()->with('errors', $e->getOptions());
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = $this->name . ' - Detail Maintenance';
        $data['breadcrumb'] = $this->breadcrumb . ' - Detail Maintenance';
        $data['indexLink'] = $this->indexLink;
        $data['item'] = ItemInstalled::find($id);
        return view('admin.item-installed.maintenance', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data['title'] = $this->name . ' - Detail';
            $data['breadcrumb'] = $this->name . ' - Detail';
            $data['itemInstalled'] = $this->findById($id);
            if (!$data['itemInstalled']) {
                abort(404);
            }

            $data['updateLink'] = route($this->updateLink, $id);
            $data['indexLink'] = $this->indexLink;
            $data['items'] = Item::orderBy('name', 'asc')->get();
            $data['hospitals'] = ItemInstalled::orderBy('hospital', 'asc')->select('hospital')->groupBy('hospital')->get();
            return view($this->view . '.edit', $data);
        } catch (\Throwable $th) {
            abort(404);
        }
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
            $check = ItemInstalled::where('serial_number', $request->serial_number)->where('id', '!=', $id)->exists();
            if ($check) {
                return redirect()->back()->withInput()->with('error', 'Serial Number telah digunakan');
            }
            $item->hospital = $request->hospital;
            $item->address = $request->address;
            $item->contact_person = $request->contact_person;
            $item->item_id = $request->item_id;
            $item->serial_number = $request->serial_number;
            $item->po_number = $request->po_number;
            $item->date_installed = $request->date_installed;
            $item->warranty_date = $request->warranty_date;
            $item->maintenance_date_first = $request->maintenance_date_first;
            $item->maintenance_date_second = $request->maintenance_date_second;
            $item->maintenance_date_third = $request->maintenance_date_third;
            $item->status = $request->status;
            $item->save();
            DB::commit();
            return redirect()->route($this->editLink, $item->id)->with('success', 'Data di perbaharui');
        } catch (Exception $e) {
            dd($e);
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        } catch (CustomException $e) {
            DB::rollback();
            return redirect()->back()->with('errors', $e->getOptions());
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
            if (!$item) {
                throw new CustomException("error", 404, null, ["Data not found"]);
            }
            $item->delete();
            return response()->json(['message' => "$this->name berhasil di hapus !"], 200);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        } catch (CustomException $e) {
            DB::rollback();
            return redirect()->back()->with('errors', $e->getOptions());
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeMaintenance(Request $request, $id)
    {
        $item = ItemInstalled::find($id);
        if ($request->maintenance_description_first) {

            $item->maintenance_description_first = $request->maintenance_description_first;
            if ($item->maintenance_created_at_first == null) {
                $item->maintenance_created_at_first = date('Y-m-d');
            }
            $item->maintenance_updated_at_first = date('Y-m-d');
            $item->save();
        } else if ($request->maintenance_description_second) {
            $item->maintenance_description_second = $request->maintenance_description_second;
            if ($item->maintenance_created_at_second == null) {
                $item->maintenance_created_at_second = date('Y-m-d');
            }
            $item->maintenance_updated_at_second = date('Y-m-d');
            $item->save();
        } else if ($request->maintenance_description_third) {
            $item->maintenance_description_third = $request->maintenance_description_third;
            if ($item->maintenance_created_at_third == null) {
                $item->maintenance_created_at_third = date('Y-m-d');
            }
            $item->maintenance_updated_at_third = date('Y-m-d');
            $item->save();
        }
        return redirect()->back()->with('success', 'Laporan Maintenance Berhasil Disimpan');
    }

    public function downloadPdf($id){
        $item = ItemInstalled::find($id);
        $pdf = Pdf::loadView('pdf', compact('item'));
        $customPaper = array(0,0,260,260);
        $pdf->setPaper($customPaper);
        return $pdf->download('qr-code-'.$item->item->name."-".$item->serial_number.'.pdf');
    }

}
