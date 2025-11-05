# One-step Windows setup for SEMS
# - Enables PHP GD extension
# - Installs Composer deps
# - Installs NPM deps (optional: pass -NoNpm to skip)
# - Generates app key if missing

param(
    [switch]$NoNpm
)

Write-Host "[1/4] Enabling PHP GD..."
Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass -Force | Out-Null
& "$PSScriptRoot/enable-gd.ps1"
if ($LASTEXITCODE -gt 1) { Write-Warning "GD may not be enabled yet. Continuing..." }

Write-Host "[2/4] Installing Composer dependencies..."
try {
    composer --version | Out-Null
} catch { Write-Error "Composer is not installed or not on PATH."; exit 1 }
composer install
if ($LASTEXITCODE -ne 0) { Write-Error "Composer install failed."; exit 1 }

Write-Host "[3/4] Generating app key (if needed)..."
if (-not (Test-Path .env)) { Copy-Item .env.example .env -ErrorAction SilentlyContinue }
php artisan key:generate --ansi

if (-not $NoNpm) {
    Write-Host "[4/4] Installing NPM dependencies..."
    try { npm -v | Out-Null } catch { Write-Warning "NPM not found; skipping frontend deps."; exit 0 }
    npm install
    if ($LASTEXITCODE -ne 0) { Write-Warning "npm install failed; you can run it later." }
}

Write-Host "Setup completed. Verify GD with: 'php -m | findstr /I gd'" -ForegroundColor Green


