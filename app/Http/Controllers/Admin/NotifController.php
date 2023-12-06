<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Helpers\GlobalHelper;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\CategoryQuestion;
use App\Models\ItemInstalled;
use App\Models\ReportProblem;
use App\Models\User;
use App\Notifications\MaintenanceWarning;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class NotifController extends Controller
{
    public function __construct()
    {
        // $this->newModel = new Slider();
        // $this->model = Slider::query();
    }


    public function notifMaintenance()
    {
        $dateNow = date('Y-m-d');
        //where date maintenance 1 month again from now
        $items = ItemInstalled::where(function($query) use ($dateNow){
            $query->where('maintenance_date_first', '<=', date('Y-m-d', strtotime($dateNow . ' +1 month')))
            ->where('maintenance_description_first',null);
        })->orWhere(function($query) use ($dateNow){
            $query->where('maintenance_date_second', '<=', date('Y-m-d', strtotime($dateNow . ' +1 month')))
            ->where('maintenance_description_second',null);
        })->orWhere(function($query) use ($dateNow){
            $query->where('maintenance_date_third', '<=', date('Y-m-d', strtotime($dateNow . ' +1 month')))
            ->where('maintenance_description_third',null);
        })->get();
        foreach ($items as $item) {
            $days = Carbon::parse($item->maintenance_date_first)->diffInDays($dateNow);
            $ke = 1;
            if($days < 0){
                $days = Carbon::parse($item->maintenance_date_second)->diffInDays($dateNow);
                $ke = 2;
            }
            if($days < 0){
                $days = Carbon::parse($item->maintenance_date_third)->diffInDays($dateNow);
                $ke = 3;
            }
            Notification::send(User::all(), new MaintenanceWarning($item,$days,$ke));
        }
    }

    public function datatable (Request $request){

        $items = ItemInstalled::selectRaw('hospital, count(*) as total'
        )->groupBy('hospital')->get();
        return DataTables::of($items)
        ->addColumn('total', function ($item) {
            return $item->total;
        })
        ->addColumn('address', function ($item) {
            return ItemInstalled::where('hospital',$item->hospital)->first()->address;
        })
        ->addColumn('contact_person', function ($item) {
            return ItemInstalled::where('hospital',$item->hospital)->first()->contact_person;
        })
        ->removeColumn('id')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

}
