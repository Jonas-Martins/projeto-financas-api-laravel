<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    function create(Request $r){
        $array = ['message' => ''];
        
        $rules = [
            'name' => 'required'
        ];
        $validator = Validator::make($r->all(), $rules);
        if ($validator->fails()) {
            $array['message'] = $validator->messages();
            return $array;
        }

        $itens = $r->only('name');
        $itens['user_id'] = $r->user()->id;

        $category = Category::create($itens);
        $array['category'] = $category;

        return $array;
    }

    function readAll(Request $r){
        $array = ['message' => 'Categorias consultadas com sucesso!!'];

        $find = User::find($r->user()->id)->categories;

        if($find){
            $array['category'] = $find;
            return $array;
        }
        $array = ['message' => 'Erro ao consultar as Categorias!!'];
        return response($array, 404);;
    }

    function update(Request $r){
        $array = ['message' => ''];

        $name = $r->name;

        $category = Category::find($r->id);
        if($category && $category->user_id == $r->user()->id){
            $name ? $category->name = $name : false;
            $category->save();

            $array['message'] = 'Categoria atualizada com sucesso!';
            return $array;
        }

        $array['message'] = 'Aconteceu algum erro!';
        return $array;
    }

    function delete(Category $category, Request $r){
        $array = ['message' => ''];

        $category = $category->firstWhere('id', $r->id);
        $category->delete() 
        ? $array['message'] = 'Categoria excluída permanente com sucesso!' 
        : $array['message'] = 'Algo deu errado, tente novamente mais tarde!';

        return $array;
    }
}
