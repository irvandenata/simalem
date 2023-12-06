<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportProblem extends Model
{
    use HasFactory;
    public function item()
    {
        return $this->belongsTo(ItemInstalled::class, 'item_id');
    }

    public function images (){
    return $this->hasMany(ReportImage::class, 'report_problem_id');
    }
}
