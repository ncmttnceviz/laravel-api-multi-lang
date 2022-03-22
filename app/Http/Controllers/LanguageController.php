<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class LanguageController extends Controller
{
    public function create() : JsonResponse
    {
        $params = request(['short_code','title','is_main']);

        $validate = Validator::make($params,[
            'short_code' => 'required|string|max:5|unique:languages,short_code',
            'title' => 'required|string|max:30',
            'is_main' => 'nullable|int'
        ]);

        if($validate->fails()){
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ],422);
        }

        try {
            $language = new Language();
            $language->short_code = $params['short_code'];
            $language->title = $params['title'];
            $language->is_main = isset($params['is_main']) ?? $params['is_main'];
            $language->save();
        }catch (Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ],400);
        }

        return response()->json([
            'message' => 'Language Created',
            'id' => $language->id
        ],201);
    }

}
