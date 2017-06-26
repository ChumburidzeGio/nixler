<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\UserRepository;
use App\Repositories\BlogRepository;
use App\Repositories\ProductRepository;
use App\Repositories\MessengerRepository;
use App\Notifications\SystemUpdated;
use App\Entities\User;
use App\Upgrade\AIA;
use App\Upgrade\AIB;
use App\Upgrade\AIC;
use App\Upgrade\AID;
use Notification;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nx:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Nixler';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->legal();

        $this->searchIndex();

        $this->categories();

        $this->upgradeToLatest();
    }

    /**
     * Update legal documents on service
     *
     * @return void
     */
    public function legal()
    {
        $privacy_en = file_get_contents(resource_path('docs/privacy.en.md'));

        app(BlogRepository::class)->updateOrCreateBySlug('privacy', [
            'title:en' => 'Welcome to the Nixler Privacy Policy',
            'body:en' => $privacy_en
        ]);

        $terms_en = file_get_contents(resource_path('docs/terms.en.md'));

        app(BlogRepository::class)->updateOrCreateBySlug('terms', [
            'title:en' => 'Nixler Terms of Service',
            'body:en' => $terms_en
        ]);

    }

    /**
     * Update search indexes
     *
     * @return void
     */
    public function searchIndex()
    {
        $this->call('scout:import', ['model' => 'App\\Entities\\Product']);
        $this->call('scout:import', ['model' => 'App\\Entities\\User']);
    }

    /**
     * Update categories list in database
     *
     * @return void
     */
    public function categories()
    {
        app(ProductRepository::class)->syncCategories();
    }


    /**
     * Update categories list in database
     *
     * @return void
     */
    public function availableVersions()
    {
        return collect([
            '1.91' => AIA::class,
            '1.92' => AIB::class,
            '1.93' => AIC::class,
            '1.94' => AID::class,
        ]);
    }


    /**
     * Update categories list in database
     *
     * @return void
     */
    public function upgradeToLatest()
    {
        $this->availableVersions()->map(function($version, $key){

            if(floatval($key) <= floatval(config('app.version'))) {
                return false;
            }

            $this->comment("Upgrading to version $key");

            app($version)->upgrade();

            $this->sendSystemUpdatedNotification(app($version));

            $this->call('env', [
                'key' => 'APP_VERSION',
                'value' => $key
            ]);

            $this->info("Upgraded to version $key");

        });
    }


    /**
     * Update categories list in database
     *
     * @return void
     */
    public function sendSystemUpdatedNotification($updater)
    {
        if(!method_exists($updater, 'messages')) {
            return false;
        }

        foreach ($updater->messages() as $locale => $message) {

            $users = User::where('locale', $locale)->get();

            Notification::send($users, new SystemUpdated($message));
            
        }
        
    }

}