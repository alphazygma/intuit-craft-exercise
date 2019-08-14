<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider {

    // Triggered automatically by Laravel
    public function register() {
        $this->app->bind(
            "Intuit\\Storage\\Database\\Database",
            "Intuit\\Storage\\Database\\EloquentDatabase"
        );
        $this->eloquentBinder('Database');

        $this->eloquentBinder('Project');
        $this->eloquentBinder('Bid');
    }

    private function eloquentBinder($repositoryName) {
        $this->app->bind(
            "Intuit\\Storage\\{$repositoryName}\\{$repositoryName}Repository",
            "Intuit\\Storage\\{$repositoryName}\\Eloquent{$repositoryName}Repository"
        );
    }
}

