<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload a file to the specified directory
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string|null $oldFile
     * @return string
     */
    public function upload(UploadedFile $file, string $path, ?string $oldFile = null): string
    {
        // Delete old file if exists
        if ($oldFile) {
            $this->delete($path . '/' . $oldFile);
        }

        // Generate unique filename
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Store the file
        $file->move(public_path($path), $filename);

        return $filename;
    }

    /**
     * Delete a file from storage
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (file_exists(public_path($path))) {
            unlink(public_path($path));

            // Check if directory is empty and delete it
            $directory = dirname(public_path($path));
            if (is_dir($directory) && count(scandir($directory)) <= 2) {
                rmdir($directory);
            }

            return true;
        }

        return false;
    }
}
