<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\ShortLink;

class ShortLinkController extends Controller
{
    public function index()
    {
        $links = ShortLink::where('user_id', Auth::id())
                        ->select('id', 'original_url', 'code', 'clicks', 'created_at')
                        ->get();

        return response()->json($links, 200);
    }

    private function generateUniqueCode(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
        $code = substr(str_shuffle($characters), 0, 8);
        
        
        if (ShortLink::where('code', $code)->exists()) {
            return $this->generateUniqueCode();
        }

        return $code;
    }

    public function shorten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
            'custom_code' => [
                'nullable',
                'max:10',
                'unique:short_links,code',
                'regex:/^[a-zA-Z0-9_-]+$/', 
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        
        $code = $request->custom_code ?? $this->generateUniqueCode();

       
        $link = ShortLink::create([
            'user_id' => $user->id,
            'original_url' => $request->original_url,
            'code' => $code,
            'clicks' => 0,
        ]);

       
        return response()->json($link, 201);
    }

    public function redirect($code)
    {
        $link = ShortLink::where('code', $code)->first();

        if (!$link) {
            return response()->json(['message' => 'Code de lien introuvable'], 404);
        }

       
        $link->increment('clicks');

       
        return redirect()->to($link->original_url, 302);
    }

    public function destroy($id)
    {
        $link = ShortLink::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->first();

        if (!$link) {
            return response()->json(['message' => 'Lien introuvable ou vous n\'avez pas la permission de le supprimer.'], 404);
        }

        $link->delete();

        return response()->json(['message' => 'Link deleted successfully'], 200);
    }
}
