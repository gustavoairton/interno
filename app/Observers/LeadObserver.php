<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\Sale;

class LeadObserver
{

    public function updated(Lead $lead): void
    {
        if($lead->status == 'Negócio Fechado' && $lead->value){
            Sale::create([
                'lead_id' => $lead->id,
                'user_id' => $lead->user_id,
                'value' => $lead->value
            ]);
        }
    }

}
