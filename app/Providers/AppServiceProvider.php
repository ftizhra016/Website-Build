namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Jangan lupa tambahkan baris ini!

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tambahkan logika ini
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}