<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class LienHeController extends Controller
{
    public function hien_thi_lien_he()
    {
        return view('store.lien_he');
    }
    public function gui_lien_he(Request $request)
    {
        $request->validate([
            'ten' => 'required',
            'email' => 'required|email',
            'noi_dung' => 'required',
        ]);
        Contact::create($request->only('ten', 'email', 'so_dien_thoai', 'noi_dung'));
        return back()->with('success', 'Gửi liên hệ thành công');
    }
}
