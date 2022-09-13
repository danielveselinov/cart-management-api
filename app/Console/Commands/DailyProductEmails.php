<?php

namespace App\Console\Commands;

use App\Jobs\DailyProductEmails as JobsDailyProductEmails;
use App\Mail\NewProductsArrival;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Product\Entities\Product;

class DailyProductEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily scheduled email at 8PM with last 10 products.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::with(['category'])
                    ->where('created_at', '>=', Carbon::today())
                    ->latest()
                    ->limit(10)
                    ->get();
        
        // foreach (User::all() as $user) {
        //     Mail::to($user->email)->send(new NewProductsArrival($products));
        // }

        // $this->info('Successfully sent email with latest products.');
        JobsDailyProductEmails::dispatch($products)->delay(now()->addMinutes(1));
    }
}
