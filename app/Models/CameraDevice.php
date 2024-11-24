<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraDevice extends Model
{
    use HasFactory;

    protected $table = 'camera';

    protected $fillable = [
        'name',
        'device'
    ];

    public static function refreshDevices()
    {
        $devices = self::getFunctionalVideoDevice();
        CameraDevice::truncate();
        CameraDevice::insert($devices);
    }

    public static function getFunctionalVideoDevice(): array
    {
        $output = [];
        exec('v4l2-ctl --list-devices', $output);

        $devices = [];
        $currentDevice = null;
        $order = 0;
        // Parse the output of the command
        foreach ($output as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue; // Skip empty lines
            }

            // Detect device name (ends with a colon)
            if (str_ends_with($line, ':')) {
                $currentDevice = [
                    'name' => rtrim($line, ':'),
                    'device' => null
                ];
            } elseif ($currentDevice) {
                // Test if the device can capture a frame
                $testImagePath = public_path('test_image.jpg');
                $ffmpegCmd = "ffmpeg -f v4l2 -i $line -frames:v 1 -vframes 1 $testImagePath -y";
                exec($ffmpegCmd, $ffmpegOutput, $resultCode);

                // If the command succeeds and image is saved, return the device path
                if ($resultCode === 0 && file_exists($testImagePath) && filesize($testImagePath) > 0) {
                    unlink($testImagePath); // Clean up test image
                    $currentDevice['device'] = $line;
                    $devices[] = $currentDevice;
                }
            }
        }

        return $devices;
    }
}
