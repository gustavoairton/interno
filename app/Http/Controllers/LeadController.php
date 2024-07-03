<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request){
        $lead = Lead::create($request->all());
        return response()->json($lead);
    }
}
