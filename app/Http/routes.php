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

/** @var \Dingo\Api\Routing\Router $Router */
$Router = app('Dingo\Api\Routing\Router');

$Router->version('v1', function ($Router) {
    /** @var \Dingo\Api\Routing\Router $Router */

    $Router->group(['prefix' => 'species'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->group([
            'prefix' => '{species_id}',
            'where'  => ['species_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses'        => 'App\Http\Controllers\SpeciesController@oneSpecies',
                'no'          => 'PLANTS_001',
                'description' => '种详细',
            ]);

            $Router->put('/', [
                'uses'        => 'App\Http\Controllers\SpeciesController@editSpecies',
                'middleware'  => 'api.auth',
                'providers'   => ['oauth'],
                'no'          => 'PLANTS_020',
                'description' => '编辑种',
            ]);

        });

    });

    $Router->group(['prefix' => 'genus'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->group([
            'prefix' => '{genus_id}',
            'where'  => ['genus_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses'        => 'App\Http\Controllers\GenusController@oneGenus',
                'no'          => 'PLANTS_002',
                'description' => '属详细',
            ]);

            $Router->get('species', [
                'uses'        => 'App\Http\Controllers\SpeciesController@allSpecies',
                'no'          => 'PLANTS_003',
                'description' => '属下种列表',
            ]);
        });

    });

    $Router->group(['prefix' => 'family'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'App\Http\Controllers\FamilyController@allFamily',
            'no'          => 'PLANTS_004',
            'description' => '科列表',
        ]);

        $Router->group([
            'prefix' => '{family_id}',
            'where'  => ['family_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses'        => 'App\Http\Controllers\FamilyController@oneFamily',
                'no'          => 'PLANTS_005',
                'description' => '科详细',
            ]);

            $Router->get('genus', [
                'uses'        => 'App\Http\Controllers\GenusController@allGenus',
                'no'          => 'PLANTS_006',
                'description' => '科下属列表',
            ]);

        });

    });

    $Router->group(['prefix' => 'businesses'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'App\Http\Controllers\BusinessesController@allBusinesses',
            'no'          => 'PLANTS_007',
            'description' => '商家列表',
        ]);

        $Router->group([
            'prefix' => '{businesses_id}',
            'where'  => ['businesses_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses'        => 'App\Http\Controllers\BusinessesController@oneBusiness',
                'no'          => 'PLANTS_008',
                'description' => '商家详细',
            ]);

            $Router->get('plants', [
                'uses'        => 'App\Http\Controllers\BusinessesPlantsController@allPlants',
                'no'          => 'PLANTS_009',
                'description' => '商家植物列表',
            ]);

        });

    });

    $Router->group(['prefix' => 'plants'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'App\Http\Controllers\PlantsController@allPlants',
            'no'          => 'PLANTS_010',
            'description' => '植物列表',
        ]);

        $Router->post('/', [
            'uses'        => 'App\Http\Controllers\PlantsController@addPlant',
            'middleware'  => 'api.auth',
            'providers'   => ['oauth'],
            'no'          => 'PLANTS_021',
            'description' => '添加植物',
        ]);

        $Router->group([
            'prefix' => '{plants_id}',
            'where'  => ['plants_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses'        => 'App\Http\Controllers\PlantsController@onePlant',
                'no'          => 'PLANTS_011',
                'description' => '植物详细',
            ]);

            $Router->put('/', [
                'uses'        => 'App\Http\Controllers\PlantsController@editPlant',
                'middleware'  => 'api.auth',
                'providers'   => ['oauth'],
                'no'          => 'PLANTS_022',
                'description' => '修改植物',
            ]);

            $Router->delete('/', [
                'uses'        => 'App\Http\Controllers\PlantsController@destroyPlant',
                'middleware'  => 'api.auth',
                'providers'   => ['oauth'],
                'no'          => 'PLANTS_023',
                'description' => '删除植物',
            ]);

            $Router->post('images', [
                'uses'        => 'App\Http\Controllers\ImagesController@addPlantsImages',
                'middleware'  => 'api.auth',
                'providers'   => ['oauth'],
                'no'          => 'PLANTS_014',
                'description' => '添加植物图片',
            ]);

        });

        $Router->group([
            'prefix' => 'images/{images_id}',
            'where'  => ['images_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->delete('/', [
                'uses'        => 'App\Http\Controllers\ImagesController@destroyPlantsImages',
                'middleware'  => 'api.auth',
                'providers'   => ['oauth'],
                'no'          => 'PLANTS_015',
                'description' => '删除植物图片',
            ]);

        });

    });

    $Router->group(['prefix' => 'tags'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'App\Http\Controllers\TagsController@allTags',
            'no'          => 'PLANTS_012',
            'description' => '标签列表',
        ]);

        $Router->group([
            'prefix' => '{tags_id}',
            'where'  => ['tags_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses'        => 'App\Http\Controllers\TagsController@oneTag',
                'no'          => 'PLANTS_013',
                'description' => '标签详细',
            ]);

        });

    });

    $Router->group(['prefix' => 'hybrids'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses'        => 'App\Http\Controllers\HybridsController@allHybrids',
            'no'          => 'PLANTS_016',
            'description' => '杂交植物列表',
        ]);

        $Router->group([
            'prefix' => '{hybrids_id}',
            'where'  => ['hybrids_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses'        => 'App\Http\Controllers\HybridsController@oneHybrids',
                'no'          => 'PLANTS_017',
                'description' => '植物详细',
            ]);

            $Router->post('images', [
                'uses'        => 'App\Http\Controllers\ImagesController@addHybridsImages',
                'middleware'  => 'api.auth',
                'providers'   => ['oauth'],
                'no'          => 'PLANTS_018',
                'description' => '添加植物图片',
            ]);

        });

        $Router->group([
            'prefix' => 'images/{images_id}',
            'where'  => ['images_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->delete('/', [
                'uses'        => 'App\Http\Controllers\ImagesController@destroyHybridsImages',
                'middleware'  => 'api.auth',
                'providers'   => ['oauth'],
                'no'          => 'PLANTS_019',
                'description' => '删除植物图片',
            ]);

        });

    });

});
