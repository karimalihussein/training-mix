<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Person;
use GenderApi\Client as GenderApiClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PeopleXlJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apiClient = new GenderApiClient('8PQXe8d5LEVwaFwLXB5JcUKKmfP32CnlVFSW');
        foreach ($this->data as $person) {
            $lookup = $apiClient->getByFirstNameAndLastNameAndCountry($person, 'egypt');
            $all[] = [
                'name' => $person,
                'gender' => $lookup->getGender(),
            ];
        }

        Person::insert($all);
    }
}
