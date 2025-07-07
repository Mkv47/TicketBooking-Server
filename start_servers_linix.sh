gnome-terminal -- bash -c "php -S 127.0.0.1:8000 -t public; exec bash"

gnome-terminal -- bash -c "php artisan serve --host=127.0.0.1 --port=8080; exec bash"

sleep 5

php artisan migrate:fresh --seed

echo "Servers started and migrations run."