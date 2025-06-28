<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

final class DepositToAccount implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public readonly int $userId,
        public readonly float $amount
    ) {}

    public function handle(): void
    {
        DB::transaction(function () {
            // Step 1: Lock the row for update
            $user = User::where('id', $this->userId)->lockForUpdate()->firstOrFail();

            $balanceBefore = $user->balance;

            // Step 2: Simulate delay to test concurrency
            usleep(300_000); // 0.3 second

            // Step 3: Deposit safely
            $user->balance = $balanceBefore + $this->amount;
            $user->save();

            logger()->info("Deposited {$this->amount} => Final balance: {$user->balance}");
        });
    }
}
