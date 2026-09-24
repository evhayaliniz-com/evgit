<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminEmail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Email listesi ve ekleme formu (tek sayfa)
     */
    public function index()
    {
        $emails = AdminEmail::orderByDesc('created_at')->get();
        return view('admin.emails.index', compact('emails'));
    }

    /**
     * Yeni email ekleme
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admin_emails,email|max:255',
        ], [
            'email.required' => 'Email adresi zorunludur.',
            'email.email'    => 'Geçerli bir email adresi giriniz.',
            'email.unique'   => 'Bu email adresi zaten kayıtlı.',
        ]);

        AdminEmail::create([
            'email' => $request->email,
        ]);

        return redirect()
            ->route('admin.emails.index')
            ->withSuccess('Email başarıyla eklendi.');
    }

    /**
     * Email silme
     */
    public function destroy($id)
    {
        $email = AdminEmail::findOrFail($id);
        $email->delete();

        return redirect()
            ->route('admin.emails.index')
            ->withSuccess('Email başarıyla silindi.');
    }
}
