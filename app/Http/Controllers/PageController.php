<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notebook;
use App\Models\Page;

class PageController extends Controller
{
    // Salvar ou atualizar os traços de uma página
    public function store(Request $request, $notebook_id)
    {
        // 1. Validar se o caderno existe (futuramente validamos se pertence ao user)
        $notebook = Notebook::findOrFail($notebook_id);

        // 2. Validar os dados do Flutter
        $request->validate([
            'page_number' => 'required|integer',
            'stroke_data' => 'required|array' // Garante que vem um array/json válido
        ]);

        // 3. Usar updateOrCreate: Se a página 1 já existir, atualiza os traços. 
        // Se não existir, cria uma nova! Isto é perfeito para sincronização em tempo real.
        $page = $notebook->pages()->updateOrCreate(
            ['page_number' => $request->page_number],
            ['stroke_data' => $request->stroke_data]
        );

        return response()->json($page, 201);
    }
}