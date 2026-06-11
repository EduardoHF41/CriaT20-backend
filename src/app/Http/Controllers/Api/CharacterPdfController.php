<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CharacterPdfController extends Controller
{
    /**
     * Exporta a ficha do personagem em PDF.
     *
     * Acessível ao dono da ficha ou ao mestre da campanha à qual ela pertence.
     * Se a biblioteca dompdf estiver instalada, retorna um PDF para download;
     * caso contrário, retorna o HTML imprimível (Imprimir → Salvar como PDF).
     *
     * Use ?format=html para forçar a saída em HTML.
     */
    public function export(Request $request, int $id)
    {
        $character = Character::query()
            ->with(['race', 'characterClass', 'origin', 'classes', 'deityRelation'])
            ->findOrFail($id);

        $this->authorizeAccess($character);

        $html = view('pdf.character', ['c' => $character])->render();

        $pdfFacade = \Barryvdh\DomPDF\Facade\Pdf::class;
        $filename = 'ficha-' . Str::slug($character->name) . '.pdf';

        if ($request->query('format') !== 'html' && class_exists($pdfFacade)) {
            $pdf = $pdfFacade::loadHTML($html)->setPaper('a4');

            return $pdf->download($filename);
        }

        // Fallback: HTML imprimível.
        return response($html, 200, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    private function authorizeAccess(Character $character): void
    {
        $userId = auth()->id();

        if ($character->user_id === $userId) {
            return;
        }

        // Mestre da campanha da ficha também pode exportar.
        $campaign = $character->campaign;
        if ($campaign && $campaign->gm_user_id === $userId) {
            return;
        }

        abort(403, 'Você não pode exportar esta ficha.');
    }
}
