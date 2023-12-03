<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class SeoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @throws RequestException
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'url' => ['required', 'url'],
        ]);
        $url = $validated['url'];

        $response = Http::get($validated['url'])->throw();
        $crawler = new Crawler($response->body(), $url);

        $icons = $this->getIcons($crawler, $url);
        $seo = [
            'title' => $crawler->filterXPath('//title')->text(''),
            'description' => $crawler->filterXPath('//meta[@name="description"]')->attr('content', ''),
            'keywords' => $crawler->filterXPath('//meta[@name="keywords"]')->attr('content', ''),
            'icon' => $icons[0] ?? '',
        ];

        return response()->json($seo);
    }

    private function getIcons(Crawler $crawler, string $url): array
    {
        return $crawler->filterXPath('//link[@rel="icon" or @rel="shortcut icon"]')->each(function (Crawler $node) use ($url) {
            $href = $node->attr('href');
            if (str_starts_with($href, 'http')) {
                return $href;
            }

            if (str_starts_with($href, '/')) {
                $urlObj = parse_url($url);

                return $urlObj['scheme'].'://'.$urlObj['host'].$href;
            }

            return $url.'/'.ltrim($href, '/');
        });
    }
}
