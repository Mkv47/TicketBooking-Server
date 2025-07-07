$projectPath = $PSScriptRoot

Write-Host "Running migrations..."
cd $projectPath
php artisan migrate

Write-Host "Running migrate:fresh --seed..."
php artisan migrate:fresh --seed

Write-Host "Starting Vite dev server..."
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$projectPath'; npm run dev"

Write-Host "Starting Laravel server..."
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$projectPath'; php artisan serve"

Write-Host "All done!"