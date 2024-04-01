<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\App;
use App\Models\Category;
use App\Filters\AgeRangeFilter;
use App\Filters\CheckboxFilter;
use App\Filters\DateFilter;
use App\Models\Product;
use App\Filters\RangeFilter;
use App\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class FiltersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(App::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app(App::class)->registerFilters([
            DateFilter::make('Дата', 'created_at'),
            RangeFilter::make('Стоимость', 'price', values: Product::all()->pluck('price','id')->toArray())
                ->attributes(['step' => 100, 'min' => 0, 'max' => Product::query()->max('price')]),
            CheckboxFilter::make('Категории','categories','id',Category::all()->pluck('title','id')->toArray())
                
            // AgeRangeFilter::make('Стаж работы', 'work_start_at')
            //     ->attributes(['step' => 1, 'min' => 0, 'max' => 50]),
            // AgeRangeFilter::make('Возраст', 'birthday')
            //     ->attributes(['step' => 1, 'min' => 0, 'max' => 100]),
    
            // CheckboxFilter::make('Наличие отзывов','reviewSites')
            //     ->customQuery(function (Builder $q){
            //         return $q->whereRaw('json_length(children) > 0');
            // }),
            
            // CheckboxFilter::make('Наличие научной работы/статьи','articles')
            //     ->customQuery(function (Builder $q){
            //         return $q->whereRaw('json_length(articles) > 0');
            // }),
            
            // CheckboxFilter::make('Наличие личного сайта','web_site')
            //     ->customQuery(function (Builder $q){
            //         return $q->whereRaw('web_site', '!=', '');
            // }),
            
            // SelectFilter::make('Страна','country_id' , values: Country::all()->pluck('value', 'id')->toArray()),
            // SelectFilter::make('Город', 'cities', 'id', City::all()->pluck('value', 'id')->toArray())
            //     ->multiple(),
            // CheckboxFilter::make('Пол','sex',values: Person::$SEX)
            //     ->multiple(),
            // CheckboxFilter::make('Тип консультации', 'consulting_type', values: Therapist::$TYPE)
            //     ->multiple(),
            // SelectFilter::make('Язык', 'langs', 'id', Lang::all()->pluck('value', 'id')->toArray()),
            // SelectFilter::make('Тип клиентов', 'clientTypes', 'id', Clients::all()->pluck('value', 'id')->toArray()),
            // CheckboxFilter::make('Виды проблем', 'problems', 'id', Problem::all()->pluck('value', 'id')->toArray())
            //     ->multiple(),
            // CheckboxFilter::make('Инструменты', 'instruments', 'id', Instrument::all()->pluck('value', 'id')->toArray())
            //     ->multiple(),
            // CheckboxFilter::make('Организация','organizations','id', Organization::all()->pluck('value', 'id')->toArray())
            //     ->multiple(),
                
            // CheckboxFilter::make('Социальные сети','socials','id', Social::all()->pluck('value', 'id')->toArray())
            //     ->multiple(),

        ]);
    }
}
