# Google OAuth Setup Guide

## Step 1: Create Google OAuth Credentials

1. **Go to Google Cloud Console**
   - Visit: https://console.cloud.google.com/
   - Sign in with your Google account

2. **Create a New Project (or select existing)**
   - Click on the project dropdown at the top
   - Click "New Project"
   - Enter project name: "Bijli Wala Bhai" (or any name)
   - Click "Create"

3. **Enable Google+ API**
   - Go to "APIs & Services" > "Library"
   - Search for "Google+ API" or "Google Identity"
   - Click on it and click "Enable"

4. **Create OAuth 2.0 Credentials**
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "OAuth client ID"
   - If prompted, configure OAuth consent screen first:
     - User Type: External (for testing) or Internal (for Google Workspace)
     - App name: "Bijli Wala Bhai"
     - User support email: Your email
     - Developer contact: Your email
     - Click "Save and Continue"
     - Scopes: Click "Save and Continue" (default scopes are fine)
     - Test users: Add your email if using External type
     - Click "Save and Continue" then "Back to Dashboard"

5. **Create OAuth Client ID**
   - Application type: "Web application"
   - Name: "Bijli Wala Bhai Web Client"
   - Authorized JavaScript origins:
     - `http://localhost:8000` (for local development)
     - `http://127.0.0.1:8000` (alternative local)
     - Your production URL (e.g., `https://yourdomain.com`)
   - Authorized redirect URIs:
     - `http://localhost:8000/auth/google/callback`
     - `http://127.0.0.1:8000/auth/google/callback`
     - Your production callback URL (e.g., `https://yourdomain.com/auth/google/callback`)
   - Click "Create"

6. **Copy Your Credentials**
   - You'll see a popup with:
     - **Client ID** (looks like: `123456789-abcdefghijklmnop.apps.googleusercontent.com`)
     - **Client Secret** (looks like: `GOCSPX-abcdefghijklmnopqrstuvwxyz`)
   - Copy both of these values

## Step 2: Add Credentials to .env File

Open your `.env` file in the project root and add these lines:

```env
GOOGLE_CLIENT_ID=your-client-id-here
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**Important Notes:**
- Replace `your-client-id-here` with your actual Client ID
- Replace `your-client-secret-here` with your actual Client Secret
- For production, update `GOOGLE_REDIRECT_URI` to your production URL
- Make sure `APP_URL` in `.env` matches your application URL

## Step 3: Clear Config Cache

After adding the credentials, run:

```bash
php artisan config:clear
php artisan config:cache
```

## Step 4: Test Google Sign-In

1. Start your Laravel server: `php artisan serve`
2. Go to login page
3. Click "Sign in with Google"
4. You should be redirected to Google login page
5. After login, you'll be redirected back to your app

## Troubleshooting

### Error: "Missing required parameter: client_id"
- Make sure you added `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` to `.env`
- Run `php artisan config:clear` after adding credentials

### Error: "redirect_uri_mismatch"
- Check that the redirect URI in Google Console matches exactly with `GOOGLE_REDIRECT_URI` in `.env`
- Make sure `APP_URL` in `.env` is correct
- The redirect URI should be: `{APP_URL}/auth/google/callback`

### Error: "Access blocked: This app's request is invalid"
- Make sure you've enabled the Google+ API or Google Identity API
- Check that your OAuth consent screen is configured
- If using "External" user type, add your email to test users

## Production Setup

For production:
1. Update `APP_URL` in `.env` to your production domain
2. Update `GOOGLE_REDIRECT_URI` to your production callback URL
3. Add your production URLs to Google Console (Authorized JavaScript origins and Redirect URIs)
4. If using "External" user type, publish your app (requires verification for public use)

