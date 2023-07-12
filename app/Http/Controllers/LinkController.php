<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEditLinkRequest;
use App\Models\Link;
use App\Services\LinkCheckService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function __construct(
        protected LinkCheckService $linksCheckService,
    ) {
    }

    public function index(): View
    {
        $links = Link::all();

        return view('index', compact('links'));
    }

    public function store(StoreEditLinkRequest $request): RedirectResponse
    {
        $link = Link::create(['url' => $request->input('url')]);
        $this->linksCheckService->checkLink($link);

        return redirect('links');
    }

    public function edit($id): View
    {
        $link = Link::where('id', $id)->firstOrFail();
        $links = Link::all();

        return view('edit', compact('link', 'links'));
    }

    public function update(StoreEditLinkRequest $request, $id): RedirectResponse
    {
        $link = Link::where('id', $id)->firstOrFail();
        $link->url = $request->input('url');
        $link->save();
        $this->linksCheckService->checkLink($link);

        return redirect('links');
    }

    public function show($id): View
    {
        $link = Link::where('id', $id)->firstOrFail();

        return view('view', compact('link'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $link = Link::where('id', $id)->firstOrFail();
        $link->delete();

        return redirect('links');
    }
}
