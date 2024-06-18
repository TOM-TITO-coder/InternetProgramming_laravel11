<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Audience;
use App\Models\Author;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class EloquentController extends Controller
{
    // 

    public function createAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->get('username'),
        ]);

        Author::create([
            'name' => $request->get('username'),
            'user_id' => $user->id,
        ]);

        return response("Author Created Successfull");
    }


    //create article

    public function createArticle(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string',
        ]);

        $author = Author::where('name', '=', $request->get('author'))->first();

        Article::create([
            'name' => $request->get('name'),
            'author_id' => $author->id,
        ]);

        return response("Article has created successfull for author " . $author->name);
    }

    // create audience

    public function subscribe(Request $request)
    {
        $request->validate([
            'name' => "required|string|max:255",
            'article' => "required|string|max:255",
        ]);

        $audience = Audience::where('name', '=', $request->get('name'))->first();
        $article = Article::where('name', '=', $request->get('article'))->first();

        if ($audience != null || $article != null) {
            if ($audience->article_id == null) {
                $audience->article_id = $article->id;
                $audience->save();
                return response("Audience has subscribed to article " . $article->id);
            } else {
                Audience::create(['name' => $audience->name, 'user_id' => $audience->user_id, 'article_id' => $article->id]);
                return response("Audience has subscribed to article " . $article->id);
            }
        } else {
            return response("Audience or Article does not exist");
        }
    }

    // creae comment api

    public function comment(Request $request)
    {
        $request->validate([
            'name' => 'string|max:255|required',
            'comment' => 'required|max:255|string',
            'comment_type' => 'required|max:255|string',
            'comment_to' => 'nullable|max:255|string'
        ]);

        $author = Author::where('name', '=', $request->get('name'))->first();
        $audience = Audience::where('name', '=', $request->get('name'))->first();

        if (!$audience && !$author) {
            return response("User with " . $request->get('name') . " does not exist");
        }

        $comment = new Comment([
            'name' => $request->get('comment'),
            'user_id' => $author ? $author->user_id : ($audience ? $audience->user_id : null),
        ]);

        switch ($request->get('comment_type')) {
            case 'article':
                $article = Article::where('name', $request->get('comment_to'))->first();
                if ($article) {
                    $article->comment()->save($comment);
                } else {
                    return response("Article with name " . $request->get('name') . " does not exist");
                }
                break;

            case 'audience':
                $a = Audience::where('name', '=', $request->get('comment_to'))->first();
                if ($a) {
                    $a->comment()->save($comment); // Notice the use of `comment()` instead of `comments()`
                } else {
                    return response("Audience with name " . $request->get('comment_to') . " does not exist");
                }
                break;

            case 'author':
                $a = Author::where('name', '=', $request->get('comment_to'))->first();
                if ($a) {
                    $a->comment()->save($comment); // Notice the use of `comment()` instead of `comments()`
                } else {
                    return response("Author with name " . $request->get('comment_to') . " does not exist");
                }
                break;
        }

        return response("Commented Successfully");
    }

    // get all api
    // get article
    public function getArticles($name)
    {
        $article = Author::with('article')->where('name', '=', $name)->first();

        return $article->article;
    }

    // get audience
    public function getAudience($article)
    {
        $audience = Article::with('audiences')->where('name', '=', $article)->first();

        return $audience->audiences;
    }

    //get audience by author
    public function getAudienceByAuthor($author)
    {
        $author = Author::with('audiences')->where('name', '=', $author)->first();
        $audience = collect([]);

        foreach ($author->audiences as $a) {
            if (!$audience->contains($a->name)) {
                $audience->push($a);
            }
        }

        return $audience->unique('name')->values();
    }

    //get comment from another 
    public function getCommentByA($audience)
    {
        $a = Audience::with('comment')->where('name', '=', $audience)->get();

        $comments = [];

        foreach ($a as $b) {
            if (!empty($b->comment)) {
                foreach ($b->comment as $comments) {
                    // $comments .= $comment; // You can customize the separator
                    $comments[] = $b;
                }
            }
        }

        return $comments;
    }

    // get comment
    public function getComment($topic)
    {
        switch ($topic) {
            case 'author':
                $author = Author::with('comment')->get();
                return $author;
            case 'audience':
                $audience = Audience::with('comment')->get();
                return $audience;
            case 'article':
                $article = Article::with('comment')->get();
                return $article;
        }
    }
}
