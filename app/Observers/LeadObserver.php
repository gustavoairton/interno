<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\Sale;

class LeadObserver
{

    public function updated(Lead $lead): void
    {
    }
}
