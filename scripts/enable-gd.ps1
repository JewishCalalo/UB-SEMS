# Auto-enable PHP GD extension on Windows
# Usage (PowerShell as Administrator recommended if using Apache):
#   Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
#   ./scripts/enable-gd.ps1

function Get-PHPIniPath {
    $phpExe = (Get-Command php -ErrorAction SilentlyContinue).Source
    if (-not $phpExe) {
        Write-Error "php.exe not found on PATH. Open a new terminal where PHP is available or add it to PATH."
        return $null
    }
    $phpInfo = & php -i 2>$null
    if (-not $phpInfo) {
        Write-Error "Unable to run 'php -i'. Ensure PHP is installed correctly."
        return $null
    }
    $loadedLine = $phpInfo | Select-String -Pattern '^Loaded Configuration File => ' | ForEach-Object { $_.ToString() }
    if ($loadedLine) {
        $iniPath = $loadedLine -replace '^Loaded Configuration File =>\s*',''
        if ($iniPath -and (Test-Path $iniPath)) { return $iniPath }
    }
    # Fallback: look for php.ini in php.exe directory
    $phpDir = Split-Path $phpExe -Parent
    $candidate = Join-Path $phpDir 'php.ini'
    if (Test-Path $candidate) { return $candidate }
    Write-Error "Could not determine php.ini path."
    return $null
}

function Enable-GDInIni([string]$iniPath) {
    $content = Get-Content -Path $iniPath -Raw
    $original = $content

    # Normalize line endings to `\n` for easier replace
    $normalized = $content -replace "\r\n","\n" -replace "\r","\n"

    # Patterns to uncomment/ensure
    $patterns = @(
        '^\s*;\s*extension\s*=\s*gd\s*$',
        '^\s*;\s*extension\s*=\s*gd2\s*$'
    )

    $updated = $normalized
    foreach ($pat in $patterns) {
        $updated = [System.Text.RegularExpressions.Regex]::Replace(
            $updated,
            $pat,
            'extension=gd',
            [System.Text.RegularExpressions.RegexOptions]::Multiline
        )
    }

    # If no extension=gd exists at all, append it near other extensions
    if ($updated -notmatch '(?m)^\s*extension\s*=\s*gd\s*$') {
        if ($updated -match '(?m)^\s*;?\s*extension\s*=') {
            # Insert after the last extension line
            $lines = $updated -split "\n"
            $lastExtIndex = ($lines | Select-String -Pattern '^(\s*;?\s*extension\s*=)' -AllMatches).LineNumber | Sort-Object -Descending | Select-Object -First 1
            if ($lastExtIndex) {
                $idx = [int]$lastExtIndex
                $before = $lines[0..($idx-1)]
                $after = $lines[$idx..($lines.Length-1)]
                $updated = ($before + 'extension=gd' + $after) -join "\n"
            } else {
                $updated = ($updated.TrimEnd() + "\nextension=gd\n")
            }
        } else {
            $updated = ($updated.TrimEnd() + "\nextension=gd\n")
        }
    }

    if ($updated -ne $normalized) {
        # Restore Windows line endings
        $final = $updated -replace "\n","`r`n"
        Set-Content -Path $iniPath -Value $final -Encoding UTF8
        return $true
    }
    return $false
}

Write-Host "Detecting php.ini..."
$ini = Get-PHPIniPath
if (-not $ini) { exit 1 }
Write-Host "Using php.ini at: $ini"

$changed = Enable-GDInIni -iniPath $ini
if ($changed) {
    Write-Host "PHP GD extension enabled in php.ini."
} else {
    Write-Host "PHP GD extension already enabled."
}

Write-Host "Verifying GD availability..."
$mods = & php -m 2>$null
if ($mods -and ($mods -match '(?im)^gd$')) {
    Write-Host "GD is available in CLI. If using Apache/Nginx, restart your web server (or PHP-FPM)." -ForegroundColor Green
    exit 0
} else {
    Write-Warning "GD still not detected in CLI. Ensure you edited the correct php.ini and restart services."
    exit 2
}


