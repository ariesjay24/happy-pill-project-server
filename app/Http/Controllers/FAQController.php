<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::all();
        return response([
            "faqs" => $faqs,
        ], 200);
    }

    public function show($id)
    {
        $faq = FAQ::find($id);
        if (!$faq) {
            return response([
                "message" => "FAQ not found"
            ], 404);
        }
        return response([
            "faq" => $faq,
        ], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            "Question" => "required|string",
            "Answer" => "required|string",
        ]);

        $faq = FAQ::create($fields);

        return response([
            "faq" => $faq,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $faq = FAQ::findOrFail($id);

        $fields = $request->validate([
            "Question" => "string",
            "Answer" => "string",
        ]);

        $faq->update($fields);

        return response([
            "faq" => $faq,
        ], 200);
    }

    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();

        return response([
            "message" => "FAQ deleted",
        ], 200);
    }
}
