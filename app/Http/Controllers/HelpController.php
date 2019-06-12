<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class HelpController extends Controller
{
    public function help(Request $request)
    {
        $baseUrl = 'https://fizban05.rz.tu-harburg.de/itbh/portfolio-team/portfolio-hilfe';

        $url = $baseUrl . $request->get('url');
        $html = file_get_contents($url);

        $crawler = new Crawler($html);
        $data = trim($crawler->filter('body > div > div.book-body > div > div.page-wrapper > div')->first()->html());
        $data = str_replace('href="', 'href="https://fizban05.rz.tu-harburg.de/itbh/portfolio-team/portfolio-hilfe/', $data);
        $data = str_replace('src="', 'src="https://fizban05.rz.tu-harburg.de/itbh/portfolio-team/portfolio-hilfe/media/', $data);

        return $data;
    }

    public function imprint()
    {
        if (config('help.imprint_redirect')) {
            return redirect(config('help.imprint_redirect'));
        }
        return view('help.imprint');
    }

    public function privacy()
    {
        if (config('help.privacy_redirect')) {
            return redirect(config('help.privacy_redirect'));
        }
        return view('help.privacy');
    }
}
