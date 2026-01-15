# Development Environment Setup

## Cache Configuration for Development

### Automatic Cache Management
The application now automatically manages cache in development mode:

1. **Settings Cache**: Reduces from 1 hour to 60 seconds in development
2. **View Cache**: Automatically cleared when admin updates settings
3. **No manual intervention needed** after changing views or settings

### .env Configuration

Make sure your `.env` file has these settings for development:

```env
APP_ENV=local
APP_DEBUG=true
CACHE_STORE=array
```

### Cache Drivers

- **Development**: Use `array` driver (no persistent cache)
- **Production**: Use `database` or `redis` driver (persistent cache)

### Manual Cache Commands (if needed)

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear everything at once
php artisan optimize:clear
```

### Browser Cache

For frontend changes, always hard refresh in browser:
- **Windows/Linux**: `Ctrl + F5` or `Ctrl + Shift + R`
- **Mac**: `Cmd + Shift + R`

### Features Implemented

✅ Settings cache auto-expires in 60 seconds (development)
✅ View cache auto-clears on settings update
✅ No manual cache clearing needed for admin changes
✅ Production cache remains optimized (1 hour)

### Notes

- View changes (Blade files) still compile on first request
- Database queries are cached based on CACHE_STORE setting
- Static assets (CSS/JS) require browser cache clear

