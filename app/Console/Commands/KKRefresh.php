<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/24
 * Time: 下午5:13
 */

namespace App\Console\Commands;

use App\Services\Works\KK;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use simplehtmldom_1_5\simple_html_dom_node;
use Sunra\PhpSimple\HtmlDomParser;


/**
 * Class KKRefresh
 *
 * @package App\Console\Commands
 * @author  sueysok
 */
class KKRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '刷新当天kk种子单';
    /**
     * @var KK
     */
    protected $KK;

    /**
     * Create a new command instance.
     *
     * @param KK $KK
     */
    public function __construct(KK $KK)
    {
        parent::__construct();

        $this->KK = $KK;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $t1 = microtime(true);

        $ch = $this->curlInit();

        $urls = [];

        $Index = HtmlDomParser::str_get_html($this->curlExec($ch, 'http://www.koehres-kaktus.de/shop/'));
        $date = $Index->find('.lastmodi', 0)->plaintext;
        preg_match("/\d{2}.\d{2}.\d{4}/", $date, $m);
        $date = date('Y-m-d', strtotime($m[0]));
        $this->info($date);

        $Date = DB::connection('mysql_v1_seeds')->table('log_kk_dates')->where('date', $date)->get();
        if (empty($Date)) {
            $this->error('还未pull最新种子单');
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

            $Dom = HtmlDomParser::str_get_html($this->curlExec($ch, $page['url']));

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

            $Dom = HtmlDomParser::str_get_html($this->curlExec($ch, $url['category_home']));

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

                $Dom = HtmlDomParser::str_get_html($this->curlExec($ch, $pageUrl));

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

        $seeds = $this->KK->manySeeds($date)->toArray();

        foreach ($seeds as $oldKey => $old) {
            foreach ($data as $newKey => $new) {
                if ($old['number'] == $new['number']) {
                    if ($old['spec_pkt'] == $new['spec_pkt']
                        && $old['spec_100'] == $new['spec_100']
                        && $old['spec_1000'] == $new['spec_1000']
                        && $old['spec_10000'] == $new['spec_10000']
                    ) {
                        unset($seeds[$oldKey]);
                        unset($data[$newKey]);
                    }
                }
            }
        }

        if (!empty($seeds)) {
            DB::connection('mysql_v1_seeds')->table('log_kk_seeds')
                ->whereIn('id', array_pluck($seeds, 'id'))->delete();
        }
        if (!empty($data)) {
            DB::connection('mysql_v1_seeds')->table('log_kk_seeds')->insert($data);
        }

        $this->curlClose($ch);

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

    /**
     * @return resource
     */
    private function curlInit()
    {
        return curl_init();
    }

    /**
     * @param $ch
     */
    private function curlClose($ch)
    {
        curl_close($ch);
    }

    /**
     * @param $ch
     * @param $url
     *
     * @return mixed
     */
    private function curlExec($ch, $url)
    {
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $data = curl_exec($ch);

        return $data;
    }

}
