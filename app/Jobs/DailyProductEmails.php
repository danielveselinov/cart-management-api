<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\NewProductsArrival;
use Illuminate\Support\Facades\Mail;
use Modules\Product\Entities\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DailyProductEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $products = [])
    {
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = Product::with(['category'])
                    ->where('created_at', '>=', Carbon::today())
                    ->latest()
                    ->limit(10)
                    ->get();
        
        foreach (User::all() as $user) {
            Mail::to($user->email)->send(new NewProductsArrival($products));
        }
    }
}
