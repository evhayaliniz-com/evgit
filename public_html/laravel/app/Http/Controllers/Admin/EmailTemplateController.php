<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = EmailTemplate::orderByDesc('id')->get();
        return view('admin.email_templates.index', compact('emailTemplates'));
    }


    public function create()
    {
        return view('admin.email_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:email_templates,key',
            'subject' => 'required',
            'content' => 'required',
            'roles' => 'required|array|min:1',
            'roles.*' => 'in:user,company',
            'status' => 'nullable|in:0,1',
        ]);

        EmailTemplate::create([
            'key' => $request->key,
            'subject' => $request->subject,
            'content' => $request->content,
            'roles' => json_encode($request->roles),
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.email-templates.index')->withSuccess('Şablon başarıyla oluşturuldu.');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.email_templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $request->validate([
            'key' => 'required|unique:email_templates,key,' . $template->id,
            'subject' => 'required',
            'content' => 'required',
            'roles' => 'required|array|min:1',
            'roles.*' => 'in:user,company',
            'status' => 'nullable|in:0,1',
        ]);

        $template->update([
            'key' => $request->key,
            'subject' => $request->subject,
            'content' => $request->content,
            'roles' => json_encode($request->roles),
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.email-templates.index')->withSuccess('Şablon başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        EmailTemplate::whereId($id)->delete();
        return redirect()->route('admin.email-templates.index')->withSuccess('Şablon silindi.');
    }
}
