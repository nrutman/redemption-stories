<?php
declare(strict_types=1);

namespace App\Infrastructure\FileSystem;

class FileReader
{
    /**
     * Lists the files within a directory.
     *
     * @param string $path
     *
     * @return array|null
     */
    public function listFiles(string $path): ?array
    {
        $files = glob($path);

        if (!is_array($files)) {
            return null;
        }

        return $files;
    }
}
