<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index', ['messages' => ContactMessage::latest()->paginate(15)]);
    }

    public function show(ContactMessage $message)
    {
        if (! $message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['read_at' => now()]);

        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
