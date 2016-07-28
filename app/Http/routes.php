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
                'uses' => 'App\Http\Controllers\SpeciesController@oneSpecies',
                'no'   => 'PLANTS_001',
                'as'   => '种详细',
            ]);

            $Router->put('/', [
                'uses'       => 'App\Http\Controllers\SpeciesController@editSpecies',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_020',
                'as'         => '编辑种',
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
                'uses' => 'App\Http\Controllers\GenusController@oneGenus',
                'no'   => 'PLANTS_002',
                'as'   => '属详细',
            ]);

            $Router->get('species', [
                'uses' => 'App\Http\Controllers\SpeciesController@allSpecies',
                'no'   => 'PLANTS_003',
                'as'   => '属下种列表',
            ]);
        });

    });

    $Router->group(['prefix' => 'family'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses' => 'App\Http\Controllers\FamilyController@allFamily',
            'no'   => 'PLANTS_004',
            'as'   => '科列表',
        ]);

        $Router->group([
            'prefix' => '{family_id}',
            'where'  => ['family_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses' => 'App\Http\Controllers\FamilyController@oneFamily',
                'no'   => 'PLANTS_005',
                'as'   => '科详细',
            ]);

            $Router->get('genus', [
                'uses' => 'App\Http\Controllers\GenusController@allGenus',
                'no'   => 'PLANTS_006',
                'as'   => '科下属列表',
            ]);

        });

    });

    $Router->group(['prefix' => 'businesses'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses' => 'App\Http\Controllers\BusinessesController@allBusinesses',
            'no'   => 'PLANTS_007',
            'as'   => '商家列表',
        ]);

        $Router->group([
            'prefix' => '{businesses_id}',
            'where'  => ['businesses_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses' => 'App\Http\Controllers\BusinessesController@oneBusiness',
                'no'   => 'PLANTS_008',
                'as'   => '商家详细',
            ]);

            $Router->get('plants', [
                'uses' => 'App\Http\Controllers\BusinessesPlantsController@allPlants',
                'no'   => 'PLANTS_009',
                'as'   => '商家植物列表',
            ]);

        });

    });

    $Router->group(['prefix' => 'plants'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses' => 'App\Http\Controllers\PlantsController@allPlants',
            'no'   => 'PLANTS_010',
            'as'   => '植物列表',
        ]);

        $Router->post('/', [
            'uses'       => 'App\Http\Controllers\PlantsController@addPlant',
            'middleware' => 'api.auth',
            'providers'  => ['oauth'],
            'no'         => 'PLANTS_021',
            'as'         => '添加植物',
        ]);

        $Router->group([
            'prefix' => '{plants_id}',
            'where'  => ['plants_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses' => 'App\Http\Controllers\PlantsController@onePlant',
                'no'   => 'PLANTS_011',
                'as'   => '植物详细',
            ]);

            $Router->put('/', [
                'uses'       => 'App\Http\Controllers\PlantsController@editPlant',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_022',
                'as'         => '修改植物',
            ]);

            $Router->delete('/', [
                'uses'       => 'App\Http\Controllers\PlantsController@destroyPlant',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_023',
                'as'         => '删除植物',
            ]);

            $Router->post('images', [
                'uses'       => 'App\Http\Controllers\ImagesController@addPlantImage',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_014',
                'as'         => '添加植物图片',
            ]);

            $Router->post('covers', [
                'uses'       => 'App\Http\Controllers\ImagesController@addPlantCover',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_030',
                'as'         => '添加植物封面',
            ]);

        });

        $Router->group([
            'prefix' => 'images/{images_id}',
            'where'  => ['images_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->delete('/', [
                'uses'       => 'App\Http\Controllers\ImagesController@destroyPlantImage',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_015',
                'as'         => '删除植物图片',
            ]);

        });

        $Router->group([
            'prefix' => 'covers/{covers_id}',
            'where'  => ['covers_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            //$Router->delete('/', [
            //    'uses'       => 'App\Http\Controllers\ImagesController@destroyPlantCover',
            //    'middleware' => 'api.auth',
            //    'providers'  => ['oauth'],
            //    'no'         => 'PLANTS_032',
            //    'as'         => '删除植物封面',
            //]);
            //
            //$Router->get('/', [
            //    'uses'        => 'App\Http\Controllers\PlantsController@allCovers',
            //    'no'          => 'PLANTS_033',
            //    'as' => '植物封面列表',
            //]);

        });

    });

    $Router->group(['prefix' => 'tags'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses' => 'App\Http\Controllers\TagsController@allTags',
            'no'   => 'PLANTS_012',
            'as'   => '标签列表',
        ]);

        $Router->group([
            'prefix' => '{tags_id}',
            'where'  => ['tags_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses' => 'App\Http\Controllers\TagsController@oneTag',
                'no'   => 'PLANTS_013',
                'as'   => '标签详细',
            ]);

        });

    });

    $Router->group(['prefix' => 'hybrids'], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('/', [
            'uses' => 'App\Http\Controllers\HybridsController@allHybrids',
            'no'   => 'PLANTS_016',
            'as'   => '杂交植物列表',
        ]);

        $Router->post('/', [
            'uses'       => 'App\Http\Controllers\HybridsController@addHybrid',
            'middleware' => 'api.auth',
            'providers'  => ['oauth'],
            'no'         => 'PLANTS_024',
            'as'         => '添加杂交植物',
        ]);

        $Router->group([
            'prefix' => '{hybrids_id}',
            'where'  => ['hybrids_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses' => 'App\Http\Controllers\HybridsController@oneHybrid',
                'no'   => 'PLANTS_017',
                'as'   => '杂交植物详细',
            ]);

            $Router->put('/', [
                'uses'       => 'App\Http\Controllers\HybridsController@editHybrid',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_025',
                'as'         => '修改植物',
            ]);

            $Router->delete('/', [
                'uses'       => 'App\Http\Controllers\HybridsController@destroyHybrid',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_026',
                'as'         => '删除植物',
            ]);

            $Router->post('images', [
                'uses'       => 'App\Http\Controllers\ImagesController@addHybridImage',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_018',
                'as'         => '添加杂交植物图片',
            ]);

            $Router->post('covers', [
                'uses'       => 'App\Http\Controllers\ImagesController@addHybridCover',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_031',
                'as'         => '添加杂交植物封面',
            ]);

        });

        $Router->group([
            'prefix' => 'images/{images_id}',
            'where'  => ['images_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->delete('/', [
                'uses'       => 'App\Http\Controllers\ImagesController@destroyHybridImage',
                'middleware' => 'api.auth',
                'providers'  => ['oauth'],
                'no'         => 'PLANTS_019',
                'as'         => '删除杂交植物图片',
            ]);

        });

        $Router->group([
            'prefix' => 'covers/{covers_id}',
            'where'  => ['covers_id' => '[0-9]+'],
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            //$Router->delete('/', [
            //    'uses'       => 'App\Http\Controllers\ImagesController@destroyHybridCover',
            //    'middleware' => 'api.auth',
            //    'providers'  => ['oauth'],
            //    'no'         => 'PLANTS_034',
            //    'as'         => '删除杂交植物封面',
            //]);
            //
            //$Router->get('/', [
            //    'uses'        => 'App\Http\Controllers\HybridsController@allCovers',
            //    'no'          => 'PLANTS_035',
            //    'as' => '杂交植物封面列表',
            //]);

        });

    });

    $Router->group([
        'prefix' => 'kk',
    ], function ($Router) {
        /** @var \Illuminate\Routing\Router $Router */

        $Router->get('news', [
            'uses' => 'App\Http\Controllers\KKController@news',
            //'middleware'  => 'api.auth',
            //'providers'   => ['oauth'],
            'no'   => 'PLANTS_027',
            'as'   => 'KK最新更新列表',
        ]);

        $Router->group([
            'prefix' => 'dates',
        ], function ($Router) {
            /** @var \Illuminate\Routing\Router $Router */

            $Router->get('/', [
                'uses' => 'App\Http\Controllers\KKController@dates',
                //'middleware'  => 'api.auth',
                //'providers'   => ['oauth'],
                'no'   => 'PLANTS_028',
                'as'   => 'KK更新日期列表',
            ]);

            $Router->get('{date}/seeds', [
                'uses' => 'App\Http\Controllers\KKController@dateSeeds',
                //'middleware'  => 'api.auth',
                //'providers'   => ['oauth'],
                'no'   => 'PLANTS_029',
                'as'   => 'KK种子列表',
            ]);

        });

    });

});
