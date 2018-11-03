<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ArticleRequest;
use App\Article;
use App\User;
use App\Tag;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = Article::paginate(5);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tags = Tag::all();

        return view('articles.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        //
        if ($article = Auth::user()->articles()->create($request->all())) {
            
            $article->tags()->attach($request->tag_id);

            Session::flash('created_article', 'The article ' . $article->title . ' has been created');
        }

        return redirect('/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $article = Article::findOrFail($id);

        if($article->is_published == 1){

            $comments = $article->comments()->get();

            return view('articles.show', compact('article', 'comments'));
        }else{

            return redirect('/articles');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $article = Article::findOrFail($id);

        $tags = Tag::all();

        return view('articles.edit', compact('article', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        //
        $data = [
            'title' => $request->title,
            'summary' => $request->summary,
            'content' => $request->content,   
        ];
        //->except(['_token', '_method', 'submit', 'tag_id']);

        if (Auth::user()->articles()->whereId($id)->update($data)) {
            
            $article = Article::findOrFail($id);

            $article->tags()->sync($request->tag_id);

            Session::flash('updated_article', 'The article ' . $article->title . ' has been updated');
        }

        return redirect('/articles');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $article = Article::findOrFail($id);

        if (count($article->comments) > 0) {

            if ($article->delete()) {
            
                Session::flash('deleted_article', 'The article ' . $article->title . ' and associated comments have been deleted');
            }
        }else{

            if ($article->delete()) {
            
                Session::flash('deleted_article', 'The article ' . $article->title . ' has been deleted');
            }
        }

        return redirect('/articles');
    }

    public function approve(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $article->update(['is_published' => $request->is_published]);

        return redirect()->back();
    }
}
