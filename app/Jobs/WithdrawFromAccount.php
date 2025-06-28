<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

final class WithdrawFromAccount implements ShouldQueue
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
            usleep(500_000); // 0.5 second

            // Step 3: Check if balance is enough
            if ($balanceBefore < $this->amount) {
                logger()->warning("Insufficient funds for user {$user->id}: Requested {$this->amount}, Available {$balanceBefore}");
                // throw new \Exception("Insufficient funds for withdrawal.");
                return;
            }

            // Step 4: Withdraw safely
            $user->balance = $balanceBefore - $this->amount;
            $user->save();

            logger()->info("Withdrawn {$this->amount} => Final balance: {$user->balance}");
        });
    }
}