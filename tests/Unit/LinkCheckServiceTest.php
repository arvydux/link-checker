<?php

namespace Tests\Unit;

use App\Models\Link;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class LinkCheckServiceTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    private mixed $linkCheckService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->linkCheckService = App::make('App\Services\LinkCheckService');
    }

    public function test_the_link_check_service_return_301_status_code_correctly(): void
    {
        $link = Link::create([
            'url' => 'https://www.whatsmydns.net/example-301-redirect',
        ]);

        $this->linkCheckService->checkLink($link);

        $this->assertContains('301', $link->redirects);
        $this->assertNotContains('302', $link->redirects);
    }

    public function test_the_link_check_service_return_302_status_code_correctly(): void
    {
        $link = Link::create([
            'url' => 'https://www.whatsmydns.net/example-302-redirect',
        ]);

        $this->linkCheckService->checkLink($link);

        $this->assertContains('302', $link->redirects);
        $this->assertNotContains('301', $link->redirects);
    }

    public function test_the_link_check_service_return_301_and_302_status_code_correctly(): void
    {
        $link = Link::create([
            'url' => 'https://www.whatsmydns.net/example-multi-redirect',
        ]);

        $this->linkCheckService->checkLink($link);

        $this->assertContains('301', $link->redirects);
        $this->assertContains('302', $link->redirects);
    }

    public function test_the_link_check_service_return_no_redirect_codes_correctly(): void
    {
        $link = Link::create([
            'url' => 'https://www.whatsmydns.net/',
        ]);

        $this->linkCheckService->checkLink($link);

        $this->assertEmpty($link->redirects);
    }

    public function test_the_link_check_service_detect_redirect_amount_correctly(): void
    {
        $link = Link::create([
            'url' => 'https://www.whatsmydns.net/example-301-redirect',
        ]);
        $this->linkCheckService->checkLink($link);
        $this->assertEquals(1, $link->redirect_amount);

        $link = Link::create([
            'url' => 'https://www.whatsmydns.net/example-302-redirect',
        ]);
        $this->linkCheckService->checkLink($link);
        $this->assertEquals(1, $link->redirect_amount);

        $link = Link::create([
            'url' => 'https://www.whatsmydns.net/example-multi-redirect',
        ]);
        $this->linkCheckService->checkLink($link);
        $this->assertEquals(2, $link->redirect_amount);

        $link = Link::create([
            'url' => 'https://www.whatsmydns.net',
        ]);
        $this->linkCheckService->checkLink($link);
        $this->assertEquals(0, $link->redirect_amount);
    }

    public function test_the_link_check_service_return_seo_keywords(): void
    {
        $link = Link::create([
            'url' => 'https://cnn.com',
        ]);

        $this->linkCheckService->checkLink($link);

        $this->assertIsString($link->keywords);
    }
}
