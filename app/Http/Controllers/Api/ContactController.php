<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:200',
            'email'   => 'required|email|max:200',
            'phone'   => 'nullable|string|max:50',
            'company' => 'nullable|string|max:200',
            'service' => 'nullable|in:social_media,content_marketing,paid_ads,seo,email_marketing,branding,other',
            'message' => 'required|string|max:5000',
        ]);

        $data['ip_address'] = $request->ip();

        ContactSubmission::create($data);

        return response()->json(['message' => 'Message received. We will get back to you soon!'], 201);
    }
}
