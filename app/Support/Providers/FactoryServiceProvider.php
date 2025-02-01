<?php

declare(strict_types=1);

namespace Support\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class FactoryServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing($this->guessFactoryName(...));
        Factory::guessModelNamesUsing($this->guessModelName(...));
    }

    /**
     * Transforms Domain\TheDomain\Models\TheModel to Database\Factories\TheDomain\TheModelFactory.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TModel>  $modelFqcn
     * @return class-string<\Illuminate\Database\Eloquent\Factories\Factory<TModel>>
     */
    public function guessFactoryName(string $modelFqcn): string
    {
        return str_replace(['Domain', 'Models\\'], ['Database\\Factories', ''], $modelFqcn).'Factory';
    }

    /**
     * Transforms Database\Factories\TheDomain\TheModelFactory to Domain\TheDomain\Models\TheModel.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Factory<TModel>  $factory
     * @return class-string<TModel>
     */
    public function guessModelName(Factory $factory): string
    {
        [$domain, $model] = str($factory::class)
            ->after('Database\\Factories\\')
            ->beforeLast('Factory')
            ->explode('\\');

        return "Domain\\{$domain}\\Models\\{$model}";
    }
}
