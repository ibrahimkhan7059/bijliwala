<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Display admin settings page
     */
    public function index()
    {
        $settings = $this->getSettings();
        $systemInfo = $this->getSystemInfo();
        $cacheInfo = $this->getCacheInfo();
        
        return view('admin.settings.index', compact('settings', 'systemInfo', 'cacheInfo'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:500',
            'site_logo' => 'nullable|file|mimes:jpeg,jpg,png,webp,avif|mimetypes:image/jpeg,image/jpg,image/png,image/webp,image/avif|max:2048',
            'currency' => 'required|string|max:3',
            'currency_symbol' => 'required|string|max:5',
            'timezone' => 'required|string|max:50',
            'date_format' => 'required|string|max:20',
            'items_per_page' => 'required|integer|min:5|max:100',
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_tiktok' => 'nullable|url|max:255',
            'delivery_charges' => 'required|numeric|min:0|max:99999',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255'
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $logoPath = storage_path('app/public/settings');
            if (!file_exists($logoPath)) {
                mkdir($logoPath, 0755, true);
            }
            
            $logo = $request->file('site_logo');
            $filename = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move($logoPath, $filename);
            
            // Delete old logo if exists
            $oldLogo = $this->getSetting('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
                // Also delete from public/storage if exists (Windows workaround)
                $publicPath = public_path('storage/' . $oldLogo);
                if (file_exists($publicPath)) {
                    @unlink($publicPath);
                }
            }
            
            $this->updateSetting('site_logo', 'settings/' . $filename);
            
            // Copy to public/storage for Windows compatibility
            $publicSettingsPath = public_path('storage/settings');
            if (!file_exists($publicSettingsPath)) {
                mkdir($publicSettingsPath, 0755, true);
            }
            copy($logoPath . '/' . $filename, $publicSettingsPath . '/' . $filename);
        }

        $this->updateSetting('site_name', $request->site_name);
        $this->updateSetting('site_email', $request->site_email);
        $this->updateSetting('site_phone', $request->site_phone);
        $this->updateSetting('site_address', $request->site_address);
        $this->updateSetting('currency', $request->currency);
        $this->updateSetting('currency_symbol', $request->currency_symbol);
        $this->updateSetting('timezone', $request->timezone);
        $this->updateSetting('date_format', $request->date_format);
        $this->updateSetting('items_per_page', $request->items_per_page);
        $this->updateSetting('delivery_charges', $request->delivery_charges);
        $this->updateSetting('bank_name', $request->bank_name);
        $this->updateSetting('account_number', $request->account_number);
        $this->updateSetting('social_facebook', $request->social_facebook);
        $this->updateSetting('social_instagram', $request->social_instagram);
        $this->updateSetting('social_tiktok', $request->social_tiktok);
        $this->updateSetting('delivery_charges', $request->delivery_charges);

        return redirect()->route('admin.settings.index')
                        ->with('success', 'General settings updated successfully!');
    }

    /**
     * Update email settings
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_driver' => 'required|string',
            'mail_host' => 'required_if:mail_driver,smtp|string',
            'mail_port' => 'required_if:mail_driver,smtp|integer',
            'mail_username' => 'required_if:mail_driver,smtp|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string'
        ]);

        $this->updateSetting('mail_driver', $request->mail_driver);
        $this->updateSetting('mail_host', $request->mail_host);
        $this->updateSetting('mail_port', $request->mail_port);
        $this->updateSetting('mail_username', $request->mail_username);
        
        if ($request->filled('mail_password')) {
            $this->updateSetting('mail_password', encrypt($request->mail_password));
        }
        
        $this->updateSetting('mail_encryption', $request->mail_encryption);
        $this->updateSetting('mail_from_address', $request->mail_from_address);
        $this->updateSetting('mail_from_name', $request->mail_from_name);

        return redirect()->route('admin.settings.index')
                        ->with('success', 'Email settings updated successfully!');
    }

    /**
     * Update privacy and terms settings
     */
    public function updatePrivacyTerms(Request $request)
    {
        $request->validate([
            'privacy_policy' => 'nullable|string',
            'terms_of_service' => 'nullable|string'
        ]);

        $this->updateSetting('privacy_policy', $request->privacy_policy ?? '');
        $this->updateSetting('terms_of_service', $request->terms_of_service ?? '');

        return redirect()->route('admin.settings.index')
                        ->with('success', 'Privacy Policy and Terms of Service updated successfully!');
    }

    /**
     * Update security settings
     */
    public function updateSecurity(Request $request)
    {
        $request->validate([
            'session_lifetime' => 'required|integer|min:60|max:10080',
            'password_min_length' => 'required|integer|min:6|max:50',
            'login_attempts' => 'required|integer|min:3|max:10',
            'lockout_duration' => 'required|integer|min:1|max:60',
            'require_email_verification' => 'boolean',
            'enable_2fa' => 'boolean',
            'maintenance_mode' => 'boolean'
        ]);

        $this->updateSetting('session_lifetime', $request->session_lifetime);
        $this->updateSetting('password_min_length', $request->password_min_length);
        $this->updateSetting('login_attempts', $request->login_attempts);
        $this->updateSetting('lockout_duration', $request->lockout_duration);
        $this->updateSetting('require_email_verification', $request->require_email_verification ?? false);
        $this->updateSetting('enable_2fa', $request->enable_2fa ?? false);
        
        // Handle maintenance mode
        if ($request->maintenance_mode) {
            Artisan::call('down');
        } else {
            Artisan::call('up');
        }
        $this->updateSetting('maintenance_mode', $request->maintenance_mode ?? false);

        return redirect()->route('admin.settings.index')
                        ->with('success', 'Security settings updated successfully!');
    }

    /**
     * Clear application cache
     */
    public function clearCache(Request $request)
    {
        $type = $request->get('type', 'all');
        
        try {
            switch ($type) {
                case 'config':
                    Artisan::call('config:clear');
                    $message = 'Configuration cache cleared successfully!';
                    break;
                case 'route':
                    Artisan::call('route:clear');
                    $message = 'Route cache cleared successfully!';
                    break;
                case 'view':
                    Artisan::call('view:clear');
                    $message = 'View cache cleared successfully!';
                    break;
                case 'application':
                    Cache::flush();
                    $message = 'Application cache cleared successfully!';
                    break;
                default:
                    Artisan::call('cache:clear');
                    Artisan::call('config:clear');
                    Artisan::call('route:clear');
                    Artisan::call('view:clear');
                    Cache::flush();
                    $message = 'All caches cleared successfully!';
            }

            return redirect()->route('admin.settings.index')
                           ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                           ->with('error', 'Error clearing cache: ' . $e->getMessage());
        }
    }

    /**
     * Backup database
     */
    public function backupDatabase()
    {
        try {
            $filename = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            // Create backups directory if it doesn't exist
            if (!Storage::disk('local')->exists('backups')) {
                Storage::disk('local')->makeDirectory('backups');
            }

            // Simple database backup (you may want to use more sophisticated backup)
            $tables = DB::select('SHOW TABLES');
            $backup = '';
            
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                $backup .= "-- Table: {$tableName}\n";
                $backup .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
                $backup .= array_values((array) $createTable)[1] . ";\n\n";
                
                $rows = DB::select("SELECT * FROM `{$tableName}`");
                foreach ($rows as $row) {
                    $values = array_map(function($value) {
                        return is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                    }, (array) $row);
                    $backup .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
                }
                $backup .= "\n";
            }

            Storage::disk('local')->put('backups/' . $filename, $backup);

            return redirect()->route('admin.settings.index')
                           ->with('success', 'Database backup created successfully! File: ' . $filename);
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                           ->with('error', 'Error creating backup: ' . $e->getMessage());
        }
    }

    /**
     * Get all settings
     */
    private function getSettings()
    {
        return [
            // General Settings
            'site_name' => $this->getSetting('site_name', 'AJ Electric'),
            'site_email' => $this->getSetting('site_email', 'admin@ajelectric.com'),
            'site_phone' => $this->getSetting('site_phone', '+92-300-1234567'),
            'site_address' => $this->getSetting('site_address', 'Karachi, Pakistan'),
            'site_logo' => $this->getSetting('site_logo', null),
            'currency' => $this->getSetting('currency', 'PKR'),
            'currency_symbol' => $this->getSetting('currency_symbol', 'Rs.'),
            'timezone' => $this->getSetting('timezone', 'Asia/Karachi'),
            'date_format' => $this->getSetting('date_format', 'Y-m-d'),
            'items_per_page' => $this->getSetting('items_per_page', 25),
            'delivery_charges' => $this->getSetting('delivery_charges', 250),
            'bank_name' => $this->getSetting('bank_name', null),
            'account_number' => $this->getSetting('account_number', null),
            'social_facebook' => $this->getSetting('social_facebook', null),
            'social_instagram' => $this->getSetting('social_instagram', null),
            'social_tiktok' => $this->getSetting('social_tiktok', null),
            'delivery_charges' => $this->getSetting('delivery_charges', 250),
            
            // Email Settings
            'mail_driver' => $this->getSetting('mail_driver', 'smtp'),
            'mail_host' => $this->getSetting('mail_host', 'smtp.gmail.com'),
            'mail_port' => $this->getSetting('mail_port', 587),
            'mail_username' => $this->getSetting('mail_username', ''),
            'mail_encryption' => $this->getSetting('mail_encryption', 'tls'),
            'mail_from_address' => $this->getSetting('mail_from_address', 'noreply@ajelectric.com'),
            'mail_from_name' => $this->getSetting('mail_from_name', 'AJ Electric'),
            
            // Security Settings
            'session_lifetime' => $this->getSetting('session_lifetime', 120),
            'password_min_length' => $this->getSetting('password_min_length', 8),
            'login_attempts' => $this->getSetting('login_attempts', 5),
            'lockout_duration' => $this->getSetting('lockout_duration', 15),
            'require_email_verification' => $this->getSetting('require_email_verification', true),
            'enable_2fa' => $this->getSetting('enable_2fa', false),
            'maintenance_mode' => app()->isDownForMaintenance(),
            
            // Privacy & Terms
            'privacy_policy' => $this->getSetting('privacy_policy', null),
            'terms_of_service' => $this->getSetting('terms_of_service', null)
        ];
    }

    /**
     * Get system information
     */
    private function getSystemInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_version' => DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown',
            'storage_used' => $this->formatBytes($this->getDirectorySize(storage_path())),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize')
        ];
    }

    /**
     * Get cache information
     */
    private function getCacheInfo()
    {
        return [
            'config_cached' => file_exists(base_path('bootstrap/cache/config.php')),
            'routes_cached' => file_exists(base_path('bootstrap/cache/routes-v7.php')),
            'views_cached' => count(glob(storage_path('framework/views/*.php'))) > 0,
            'cache_driver' => config('cache.default')
        ];
    }

    /**
     * Get setting value
     */
    private function getSetting($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function() use ($key, $default) {
            $setting = DB::table('settings')->where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Update setting value
     */
    private function updateSetting($key, $value)
    {
        DB::table('settings')->updateOrInsert(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );
        
        Cache::forget("setting_{$key}");
        Cache::forget('site_settings'); // Clear global settings cache
        Cache::forget('delivery_charges'); // Clear delivery charges cache
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Get directory size
     */
    private function getDirectorySize($directory)
    {
        $size = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
}
