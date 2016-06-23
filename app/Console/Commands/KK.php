<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use simplehtmldom_1_5\simple_html_dom_node;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Class KK
 *
 * @package App\Console\Commands
 * @author  sueysok
 */
class KK extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拉kk最新种子单';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $t1 = microtime(true);
        $urls = [];

        $Index = HtmlDomParser::str_get_html(file_get_contents('http://www.koehres-kaktus.de/shop/'));
        $date = $Index->find('.lastmodi', 0)->plaintext;
        preg_match("/\d{2}.\d{2}.\d{4}/", $date, $m);
        $date = date('Y-m-d', strtotime($m[0]));
        $this->info($date);

        $Date = DB::connection('mysql_v1_seeds')->table('log_kk_dates')->where('date', $date)->get();
        if (!empty($Date)) {
            $this->error('已存在');
            exit;
        }

        $pages = [
            [
                'title' => 'Cactus',
                'url'   => 'http://www.koehres-kaktus.de/shop/Cactus-seeds---1.html?language=en',
            ],
            [
                'title' => 'Succulent',
                'url'   => 'http://www.koehres-kaktus.de/shop/Succulent-seeds---2.html?language=en',
            ],
            [
                'title' => 'Indoor plants',
                'url'   => 'http://www.koehres-kaktus.de/shop/Indoor-plants-seeds---3.html?language=en',
            ],
            [
                'title' => 'Mesembryanthemum',
                'url'   => 'http://www.koehres-kaktus.de/shop/Mesembryanthemum-seeds---4.html?language=en',
            ],
        ];

        $this->comment('加载目录');
        foreach ($pages as $page) {
            $this->info($page['url']);

            $Dom = HtmlDomParser::str_get_html(file_get_contents($page['url']));

            foreach ($Dom->find('table', 2)->find('.submoduleRow') as $key => $Element) {
                $A = $Element->find('a', 0);
                array_push($urls, [
                    'date'          => $date,
                    'class_1'       => $page['title'],
                    'class_2'       => $A->plaintext,
                    'category_home' => $A->href,
                    'pages'         => [],
                    'seeds'         => [],
                ]);
            }
        }

        $this->comment('加载分类首页');
        foreach ($urls as $key => $url) {
            $this->info($url['category_home']);

            $Dom = HtmlDomParser::str_get_html(file_get_contents($url['category_home']));

            $Point = $Dom->find('#productliste', 0)->find('tr', 0);
            $as = $Point->find('tr', 1)->find('a');
            array_pop($as);
            foreach ($as as $A) {
                array_push($urls[$key]['pages'], $A->href);
            }

            $urls[$key]['seeds'] = array_merge($urls[$key]['seeds'], $this->seeds($Point));
        }

        $this->comment('加载页码页');
        foreach ($urls as $key => $url) {
            foreach ($url['pages'] as $pageUrl) {
                $this->info($pageUrl);

                $Dom = HtmlDomParser::str_get_html(file_get_contents($pageUrl));

                $Point = $Dom->find('#productliste', 0)->find('tr', 0);
                $urls[$key]['seeds'] = array_merge($urls[$key]['seeds'], $this->seeds($Point));
            }
        }

        $t2 = microtime(true);

        $data = [];
        $createdAt = date('Y-m-d H:i:s', time());
        foreach ($urls as $cate) {
            foreach ($cate['seeds'] as $seed) {
                array_push($data, [
                    'class_1'    => $cate['class_1'],
                    'class_2'    => $cate['class_2'],
                    'title'      => $seed['title'],
                    'number'     => $seed['number'],
                    'spec_pkt'   => $seed['spec_pkt'],
                    'spec_100'   => $seed['spec_100'],
                    'spec_1000'  => $seed['spec_1000'],
                    'spec_10000' => $seed['spec_10000'],
                    'date'       => $cate['date'],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }

        DB::connection('mysql_v1_seeds')->table('log_kk_seeds')->insert($data);
        DB::connection('mysql_v1_seeds')->table('log_kk_dates')->insert([
            'date'       => $date,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);
        $this->comment('耗时' . round($t2 - $t1, 3) . '秒');

        $this->comment('done!');
    }

    /**
     * @param simple_html_dom_node $Dom
     *
     * @return array
     */
    private function seeds(simple_html_dom_node $Dom)
    {
        $temp = [];
        $forms = $Dom->next_sibling()->find('form');
        foreach ($forms as $Form) {
            array_push($temp, [
                'title'      => trim($Form->find('strong', 0)->plaintext),
                'number'     => $Form->find('tr', 1)->find('td', 0)->children(1)->value,
                'spec_pkt'   => $Form->find('tr', 1)->find('td', 0)->children(0)->find('table', 0)->find('td',
                    0)->find('input', 0) ? 1 : 0,
                'spec_100'   => $Form->find('tr', 1)->find('td', 0)->children(0)->find('table', 0)->find('td',
                    1)->find('input', 0) ? 1 : 0,
                'spec_1000'  => $Form->find('tr', 1)->find('td', 0)->children(0)->find('table', 0)->find('td',
                    2)->find('input', 0) ? 1 : 0,
                'spec_10000' => $Form->find('tr', 1)->find('td', 0)->children(0)->find('table', 0)->find('td',
                    3)->find('input', 0) ? 1 : 0,
            ]);
        }

        return $temp;
    }
}
