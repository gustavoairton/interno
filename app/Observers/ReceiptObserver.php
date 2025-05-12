<?php

namespace App\Observers;

use App\Http\Services\MailService;
use App\Models\Lead;
use App\Models\Receipt;
use App\Models\Sale;
use Automattic\WooCommerce\Client;
use NumberFormatter;
use PhpParser\Node\Scalar\Float_;

class ReceiptObserver
{
    /**
     * Handle the Receipt "created" event.
     */
    public function created(Receipt $receipt): void
    {

        /*$sale = Sale::find($receipt->sale_id);
        $lead = Lead::find($sale->lead_id);

        if ($receipt->type == 'Cartão de Crédito' && $lead->email) {
            $woocommerce = new Client(
                'https://luna.bexond.com',
                'ck_f5936709157ea9eedb3a24b2c095b9ffae71e0d8',
                'cs_797f74d1f02f252b6e8eeeb042d00d858756ed01',
                [
                    'wp_api' => true,
                    'version' => 'wc/v3'
                ]
            );

            $data = [
                'name' => 'Premium Quality',
                'type' => 'simple',
                'regular_price' => '' . $receipt->value,
            ];

            $product = $woocommerce->post('products', $data);

            $link = 'https://luna.bexond.com/pay?id=' . $product->id;
            $receipt->update(['link' => $link]);

            $fmt = numfmt_create('pt_BR', NumberFormatter::CURRENCY);
            $value = numfmt_format_currency($fmt, $receipt->value, 'BRL');

            $mailService = new MailService();
            $mailService->sendView('(BEXOND) ' . $lead->name . ', seu link para pagamento!', $lead->email, $lead->name, 'mail.payment', ['link' => $link, 'value' => $value, 'name' => $lead->name], '');
        }*/
    }

    /**
     * Handle the Receipt "updated" event.
     */
    public function updated(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "deleted" event.
     */
    public function deleted(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "restored" event.
     */
    public function restored(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "force deleted" event.
     */
    public function forceDeleted(Receipt $receipt): void
    {
        //
    }
}
