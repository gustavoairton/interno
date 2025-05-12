<?php

namespace App\Observers;

use App\Models\Sale;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     */
    public function created(Sale $sale): void
    {
        $lead = $sale->lead;
        if (!$lead->converted_at || $lead->status != 'Negócio Fechado') {
            $lead->update(['converted_at' => now(), 'status' => 'Negócio Fechado']);
        }
    }

    /**
     * Handle the Sale "updated" event.
     */
    public function updated(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "deleted" event.
     */
    public function deleted(Sale $sale): void
    {
        $lead = $sale->lead;
        if ($lead->sales->count() === 0) {
            $lead->update(['converted_at' => null]);
        }
    }

    /**
     * Handle the Sale "restored" event.
     */
    public function restored(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     */
    public function forceDeleted(Sale $sale): void
    {
        //
    }
}
