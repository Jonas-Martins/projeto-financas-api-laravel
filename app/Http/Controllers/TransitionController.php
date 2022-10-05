<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transition;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TransitionController extends Controller
{
    function create(Transition $task, Request $r)
    {
        $array = ['message' => ''];

        $rules = [
            'amount' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'finish' => 'required | Boolean'
        ];

        $validator = Validator::make($r->all(), $rules);
        if ($validator->fails()) {
            $array['message'] = $validator->messages();
            return $array;
        }

        $category = Category::find($r->category_id);
        if ($category && $category->user_id == $r->user()->id) {
            $task->amount = $r->amount;
            $task->description = $r->description;
            $task->user_id = $r->user()->id;
            $task->category_id = $r->category_id;
            $task->finish = $r->finish;

            $task->save();

            $array['message'] = 'Cadastro com sucesso!';
            return $array;
        }

        $array['message'] = 'Aconteceu algum erro!';
        return $array;
    }

    function readAllCategory(Request $r)
    {
        $array = ['message' => ''];

        $category = Category::find($r->id);

        if ($category && $category->user_id == $r->user()->id) {
            $array['category'] = $category;
            $category->transitions;

            $array['message'] = 'Transitions pegas com sucesso!';
            return $array;
        }

        $array['message'] = 'Erro ao consultar as Transitions!!';
        return $array;
    }

    function readAll(Request $r)
    {
        $array = ['message' => ''];

        $find = User::find($r->user()->id)->transitions;

        if ($find) {
            $array['transitions'] = $find;
            return $array;
        }
        $array = ['message' => 'Erro ao consultar as Transitions!!'];
        return response($array, 404);;
    }

    function update(Request $r)
    {
        $array = ['message' => ''];

        try {

            $rules = [
                'finish' => 'Boolean'
            ];

            $validator = Validator::make($r->all(), $rules);
            if ($validator->fails()) {
                $array['message'] = $validator->messages();
                return $array;
            }

            $amount = $r->amount;
            $description = $r->description;
            $category_id = $r->category_id;
            $finish = $r->finish;

            $transition = Transition::find($r->id);
            if ($transition && $transition->user_id == $r->user()->id) {
                $amount ? $transition->amount = $amount : false;
                $description  ? $transition->description  = $description  : false;
                $finish != null ? $transition->finish = $finish : false;


                if ($category_id) {
                    if (Category::find($category_id)->user_id == $r->user()->id) {
                        $transition->category_id = $category_id;
                    }
                }

                $transition->save();
                $array['message'] = 'Transition atualizada com sucesso!';
                return $array;
            }
            $array['message'] = 'Algo deu errado, tente novamente mais tarde!';
            return $array;
        } catch (\Exception $e) {
            $array['message'] = 'Algo deu errado, tente novamente mais tarde!';
            return $array;
        }
    }

    function delete(Request $r)
    {
        $array = ['message' => ''];

        $transition = Transition::find($r->id);
        if ($transition && $transition->user_id == $r->user()->id) {
            $task = Transition::firstWhere('id', $r->id);
            $task->delete() ? $array['message'] = 'Transition excluída com sucesso!' : $array['message'] = 'Transition não encontrado!';
            return $array;
        }

        $array['message'] = 'Transition não encontrado!';
        return $array;
    }
}
