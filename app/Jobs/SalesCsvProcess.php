<?php

namespace App\Jobs;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SalesCsvProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $data;
    public $fillables;
    public function __construct($data, $fillables)
    {
        $this->data = $data;
        $this->fillables = $fillables;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
     
        foreach ($this->data as $sale)
        {
            $sale =  array_combine($this->fillables, $sale);
            Sale::create($sale);
        }
    }
}
