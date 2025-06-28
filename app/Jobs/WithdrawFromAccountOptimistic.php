<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\QueryException;

final class WithdrawFromAccountOptimistic implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public readonly int $userId,
        public readonly float $amount,
        public readonly int $maxRetries = 3
    ) {}

    public function handle(): void
    {
        $attempts = 0;

        while ($attempts < $this->maxRetries) {
            try {
                DB::transaction(function () {
                    // Step 1: Get user without locking (optimistic approach)
                    $user = User::where('id', $this->userId)->firstOrFail();
                    $balanceBefore = $user->balance;

                    // Step 2: Simulate delay to test concurrency
                    usleep(400_000); // 0.4 second

                    // Step 3: Check if balance is enough
                    if ($balanceBefore < $this->amount) {
                        logger()->warning("Insufficient funds for user {$user->id}: Requested {$this->amount}, Available {$balanceBefore}");
                        return;
                    }

                    // Step 4: Try to update with version check (optimistic locking)
                    $updated = User::where('id', $this->userId)
                        ->where('balance', $balanceBefore) // Version check using balance
                        ->update(['balance' => $balanceBefore - $this->amount]);

                    if ($updated === 0) {
                        // Another transaction modified the balance, throw exception to retry
                        throw new \Exception("Concurrent modification detected, retrying...");
                    }

                    logger()->info("Withdrawn {$this->amount} => Final balance: " . ($balanceBefore - $this->amount));
                });

                // Success, exit the retry loop
                break;
            } catch (\Exception $e) {
                $attempts++;
                logger()->warning("Withdrawal attempt {$attempts} failed: " . $e->getMessage());

                if ($attempts >= $this->maxRetries) {
                    logger()->error("Withdrawal failed after {$this->maxRetries} attempts for user {$this->userId}");
                    throw $e;
                }

                // Wait before retry with exponential backoff
                usleep(100_000 * $attempts); // 0.1s, 0.2s, 0.3s
            }
        }
    }
}