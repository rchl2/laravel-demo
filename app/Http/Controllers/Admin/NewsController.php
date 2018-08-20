<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Models\News;
use App\Queries\NewsQueries;
use App\Jobs\Admin\News\CreateNews;
use App\Jobs\Admin\News\DeleteNews;
use App\Jobs\Admin\News\UpdateNews;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\CreateNewsRequest;
use App\Http\Requests\Admin\News\UpdateNewsRequest;

class NewsController extends Controller
{
    /**
     * Display a listing of news.
     */
    public function index()
    {
        return view('admin.news.index', ['news' => NewsQueries::latestPaginated()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNewsRequest $request)
    {
        $this->dispatchNow(CreateNews::CreateNewsRequest($request));

        Alert::success(trans('admin/partials/alerts.informations.news_successfully_created'))->autoclose(2000);

        return redirect()->route('news.index');
    }

    /**
     * Display the news.
     */
    public function show(News $news)
    {
        return view('admin.news.show', ['news' => $news]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $this->dispatchNow(UpdateNews::UpdateNewsRequest($news, $request));

        Alert::success(trans('admin/partials/alerts.informations.news_successfully_edited'))->autoclose(2000);

        return redirect()->route('news.show', [$news]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $this->dispatchNow(new DeleteNews($news));

        Alert::success(trans('admin/partials/alerts.informations.news_successfully_deleted'))->autoclose(2000);

        return redirect()->route('news.index');
    }
}
