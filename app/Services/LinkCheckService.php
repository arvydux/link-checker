<?php

namespace App\Services;

use App\Models\Link;
use Carbon\Carbon;
use GuzzleHttp\Client;

class LinkCheckService
{
    public function checkLink(Link $link): void
    {
        $link->redirects = $this->getRedirectHeaders($link->url);
        if (! is_null($link->redirects)) {
            $link->redirect_amount = $this->getRedirectAmount($link->redirects);
            $link->keywords = $this->getGetKeywords($link->url);
        }
        $link->checked_at = Carbon::now();
        $link->update();
    }

    protected function getRedirectHeaders($url = ''): array|null
    {
        $this->client = new Client(['allow_redirects' => ['track_redirects' => true], 'verify' => false]);
        try {
            $response = $this->client->get($url);
        } catch (\Exception) {

            return null;
        }
        $headersRedirect = $response->getHeader(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER);
        $statusHeadersRedirect = $response->getHeader(\GuzzleHttp\RedirectMiddleware::STATUS_HISTORY_HEADER);
        $redirects = array_combine($headersRedirect, $statusHeadersRedirect);

        return $redirects;

    }

    protected function getRedirectAmount(array $redirects): int
    {
        return $this->redirectAmount = count($redirects);
    }

    protected function getGetKeywords($url): string
    {
        $ab = get_meta_tags($url);

        return array_key_exists('keywords', $ab) ? $ab['keywords'] : '';
    }
}
