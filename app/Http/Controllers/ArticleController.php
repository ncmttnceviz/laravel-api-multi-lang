<?php

namespace App\Http\Controllers;

use App\Http\Traits\HandleLanguage;
use App\Models\Article;
use App\Models\ArticleTranslate;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mockery\Exception;

class ArticleController extends Controller
{
    use HandleLanguage;

    public function create() : JsonResponse
    {
        $params = request(['title','content','category_id','image']);
        $params['slug'] = isset($params['title']) ? Str::slug($params['title'])  : '';

        $validate = Validator::make($params,[
            'slug' => 'unique:article_translates,slug',
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|int',
            'image' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ],422);
        }

        try {
            $article = new Article();
            $article->category_id =  $params['category_id'];
            $article->image = $params['image'];
            $article->save();

            $translate = new ArticleTranslate();
            $translate->slug = $params['slug'];
            $translate->title = $params['title'];
            $translate->content = $params['content'];
            $translate->article_id = $article->id;
            $translate->language_id = $this->getMainLang();
            $translate->save();
        }catch (Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ],400);
        }

        return response()->json([
            'message' => 'Article Created',
            'article_id' => $article->id
        ],201);
    }

    public function update() : JsonResponse
    {
        $getContent = request()->getContent();
        $params = (array) json_decode($getContent);
        $params['slug'] = isset($params['title']) ? Str::slug($params['title'])  : '';

        $validate = Validator::make($params,[
            'id' => 'required|int',
            'slug' => Rule::unique(ArticleTranslate::class,'slug')->where(function (Builder $query) use ($params){
                    return $query->where('article_id','!=',$params['id']);
                }),
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|int',
            'image' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ],422);
        }

        try {
            $article = (new Article())->find($params['id']);
            $article->category_id =  $params['category_id'];
            $article->image = $params['image'];
            $article->save();

            $translate = (new ArticleTranslate())
                ->where('article_id',$params['id'])
                ->where('language_id',$this->getCurrentLang())
                ->first();

            if(!$translate){
                $translate = new ArticleTranslate();
            }

            $translate->slug = $params['slug'];
            $translate->title = $params['title'];
            $translate->content = $params['content'];
            $translate->article_id = $params['id'];
            $translate->language_id = $this->getCurrentLang();
            $translate->save();
        }catch (Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ],400);
        }

        return response()->json([
            'message' => 'Article Updated',
            'article_id' => $article->id
        ]);
    }

    public function readAll() : JsonResponse
    {
        $data = Article::all();
        $response = [];

        foreach ($data as $item){
            if($item->translate){
                $article = [
                    'id' => $item->id,
                    'category_id' => $item->category_id,
                    'image' => $item->image,
                    'slug' => $item->translate->slug,
                    'title' => $item->translate->title,
                    'content' => $item->translate->content
                ];
                array_push($response,$article);
            }
        }
        return response()->json($response);
    }
}
