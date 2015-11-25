<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/** @var \Illuminate\Routing\Router $Router */
$Router = app('Illuminate\Routing\Router');

$Router->group(['prefix' => 'species'], function ($Router) {
    /** @var \Illuminate\Routing\Router $Router */

    $Router->get('{species_id}', [
        'uses'        => 'SpeciesController@one',
        'no'          => 'PLANTS_001',
        'description' => '种详细',
    ])->where('id', '[0-9]+');

});

$Router->group(['prefix' => 'genus'], function ($Router) {
    /** @var \Illuminate\Routing\Router $Router */

    $Router->group([
        'prefix' => '{genus_id}',
        'where'  => ['genus_id' => '[0-9]+'],
    ], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'GenusController@one',
            'no'          => 'PLANTS_002',
            'description' => '属详细',
        ]);

        $Router->get('species', [
            'uses'        => 'SpeciesController@all',
            'no'          => 'PLANTS_003',
            'description' => '属下种列表',
        ]);
    });

});

$Router->group(['prefix' => 'family'], function ($Router) {
    /** @var \Illuminate\Routing\Router $Router */

    $Router->get('/', [
        'uses'        => 'FamilyController@all',
        'no'          => 'PLANTS_004',
        'description' => '科列表',
    ]);

    $Router->group([
        'prefix' => '{family_id}',
        'where'  => ['family_id' => '[0-9]+'],
    ], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'FamilyController@one',
            'no'          => 'PLANTS_005',
            'description' => '科详细',
        ]);

        $Router->get('genus', [
            'uses'        => 'GenusController@all',
            'no'          => 'PLANTS_006',
            'description' => '科下属列表',
        ]);

    });

});

$Router->group(['prefix' => 'businesses'], function ($Router) {
    /** @var \Illuminate\Routing\Router $Router */

    $Router->get('/', [
        'uses'        => 'BusinessesController@all',
        'no'          => 'PLANTS_007',
        'description' => '商家列表',
    ]);

    $Router->group([
        'prefix' => '{businesses_id}',
        'where'  => ['businesses_id' => '[0-9]+'],
    ], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'BusinessesController@one',
            'no'          => 'PLANTS_008',
            'description' => '商家详细',
        ]);

        $Router->get('plants', [
            'uses'        => 'BusinessesPlantsController@all',
            'no'          => 'PLANTS_009',
            'description' => '商家植物列表',
        ]);

    });

});

$Router->group(['prefix' => 'plants'], function ($Router) {
    /** @var \Illuminate\Routing\Router $Router */

    $Router->get('/', [
        'uses'        => 'PlantsController@all',
        'no'          => 'PLANTS_010',
        'description' => '植物列表',
    ]);

    $Router->group([
        'prefix' => '{plants_id}',
        'where'  => ['plants_id' => '[0-9]+'],
    ], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'PlantsController@one',
            'no'          => 'PLANTS_011',
            'description' => '植物详细',
        ]);

    });

});