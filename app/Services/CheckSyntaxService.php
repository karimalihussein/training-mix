<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Finder\Finder;

class CheckSyntaxService
{
    public function handle()
    {
        $rootDir = realpath(__DIR__.'/../..');
        $phpExecutable = 'php';
        $finder = new Finder();
        $finder->files()
            ->in($rootDir)
            ->exclude(['storage', 'vendor'])
            ->name('*.php');
        if (!$finder->hasResults()) {
            echo "No files found\n";
            exit(1);
        }
        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
            $relativeFilePath = $file->getRelativePathname();

            if (!is_string($absoluteFilePath)) {
                echo "Invalid file path for: $relativeFilePath\n";

                continue;
            }

            $process = proc_open([$phpExecutable, '-l', $absoluteFilePath], [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ], $pipes);

            if (!is_resource($process)) {
                echo "Failed to start PHP syntax check process for: $relativeFilePath\n";

                continue;
            }

            $output = stream_get_contents($pipes[1]);
            $errors = stream_get_contents($pipes[2]);

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            $returnCode = proc_close($process);

            if ($returnCode !== 0) {
                echo "Syntax error found in file: $relativeFilePath\n";
                echo $errors;

                continue;
            }

            echo "No syntax errors found in file: $relativeFilePath\n";
        }
    }
}
