<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalFunction;
use App\Models\ItemInstalled;
use App\Models\ReportImage;
use App\Models\ReportProblem;
use App\Models\User;
use App\Notifications\ReportCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CustomerReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($unique_code)
    {
        $data['item'] = ItemInstalled::where('unique_code', $unique_code)->first();
        if(!$data['item']){
            return abort(404);
        }
        $data['title'] = 'Laporan Masalah';
        return view('report-page', $data);

    }

    public function showMessage($unique_code,$status){
        $data['title'] = 'Laporan Masalah';
        if($status == 'success'){
            $data['message']= '
            <div class="text-center"><h4>Pelaporan Masalah Berhasil</h4>
            Terima kasih telah melaporkan masalah yang terjadi pada alat kami. Kami akan segera menghubungi anda untuk menyelesaikan masalah ini.<div>';
        }else{
            $data['message']= '
            <div class="text-center"><h4>Pelaporan Masalah Gagal</h4>
            Maaf, masa garansi alat ini sudah habis. Silahkan hubungi kami untuk mendapatkan bantuan lebih lanjut.<div>';
        }
        return view('message-page',$data);

    }

    public function store(Request $request,$unique_code)
    {
        $data['item'] = ItemInstalled::where('unique_code', $unique_code)->first();
        $data['item']->status = 3;
        $data['item']->save();
        if(!$data['item']){
            return abort(404);
        }
        $report = new ReportProblem();
        $report->item_id = $data['item']->id;
        $report->description = $request->description;


        $report->save();
        if($request->image){
            foreach ($request->image as $key => $value) {
                $image = new ReportImage();
                $image->report_problem_id = $report->id;
                $image->image = GlobalFunction::storeSingleImage($value,'reports');
                $image->save();
            }
        }

        Notification::send(User::all(), new ReportCreated($report->id));
        $data['title'] = 'Laporan Masalah';

       return redirect()->route('show-message',[$unique_code,'success']);
    }
}
