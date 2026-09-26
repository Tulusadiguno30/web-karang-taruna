<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Gallery;
use App\Models\CashTransaction;
use App\Models\Officer;
use App\Models\Program;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MemberContribution;

class AdminController extends Controller
{
    // 1. Dashboard Utama Admin (Mengirimkan semua data)
    public function index()
{
    $settings = SiteSetting::pluck('value', 'key')->toArray();
    $galleries = Gallery::latest()->get();
    $cashTransactions = CashTransaction::latest('transaction_date')->get();
    $officers = Officer::orderBy('order_level', 'asc')->get();
    $programs = Program::latest()->get();
    $messages = Message::latest()->get();

    // Data Iuran Kas Anggota
    $contributions = MemberContribution::with('officer')->get();

    $totalIn = CashTransaction::where('type', 'in')->sum('amount');
    $totalOut = CashTransaction::where('type', 'out')->sum('amount');
    $balance = $totalIn - $totalOut;

    return view('admin.dashboard', compact(
        'settings', 
        'galleries', 
        'cashTransactions', 
        'officers', 
        'programs', 
        'messages', 
        'contributions',
        'totalIn', 
        'totalOut', 
        'balance'
    ));
}

    // 2. Setting Teks Website
    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'Teks website profil berhasil diperbarui!');
    }

    // 3. Management Galeri
    public function storeGallery(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'event_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'title' => $request->title,
            'category' => $request->category,
            'event_date' => $request->event_date,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Foto kegiatan berhasil diunggah!');
    }

    public function destroyGallery($id)
    {
        $gallery = Gallery::findOrFail($id);
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }

    // 4. Management Kas
    public function storeCash(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'transaction_date' => 'required|date',
            'receipt_image' => 'nullable|image|max:2048',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt_image')) {
            $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
        }

        CashTransaction::create([
            'type' => $request->type,
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
            'receipt_image' => $receiptPath,
        ]);

        return redirect()->back()->with('success', 'Transaksi kas berhasil dicatat!');
    }

    public function destroyCash($id)
    {
        $cash = CashTransaction::findOrFail($id);
        if ($cash->receipt_image) {
            Storage::disk('public')->delete($cash->receipt_image);
        }
        $cash->delete();

        return redirect()->back()->with('success', 'Transaksi kas berhasil dihapus!');
    }

    // 5. Cetak Laporan Kas (PDF)
    public function exportCashPdf()
    {
        $cashes = CashTransaction::orderBy('transaction_date', 'asc')->get();
        $totalIn = CashTransaction::where('type', 'in')->sum('amount');
        $totalOut = CashTransaction::where('type', 'out')->sum('amount');
        $balance = $totalIn - $totalOut;
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        $pdf = Pdf::loadView('admin.pdf_cash', compact('cashes', 'totalIn', 'totalOut', 'balance', 'settings'));
        return $pdf->download('Laporan_Kas_Karang_Taruna_' . date('Y-m-d') . '.pdf');
    }

    // 6. Management Pengurus
    public function storeOfficer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'order_level' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('officers', 'public');
        }

        Officer::create([
            'name' => $request->name,
            'position' => $request->position,
            'order_level' => $request->order_level,
            'photo' => $photoPath,
        ]);

        return redirect()->back()->with('success', 'Data pengurus berhasil ditambahkan!');
    }

    public function destroyOfficer($id)
    {
        $officer = Officer::findOrFail($id);
        if ($officer->photo) {
            Storage::disk('public')->delete($officer->photo);
        }
        $officer->delete();

        return redirect()->back()->with('success', 'Data pengurus berhasil dihapus!');
    }

    // 7. Management Program Kerja (Proker)
    public function storeProgram(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'status' => 'required|in:Perencanaan,Berjalan,Selesai',
        ]);

        Program::create($request->only(['title', 'division', 'status', 'description']));

        return redirect()->back()->with('success', 'Program kerja berhasil ditambahkan!');
    }

    public function destroyProgram($id)
    {
        Program::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Program kerja berhasil dihapus!');
    }

    // 8. Hapus Pesan / Aspirasi Warga
    public function destroyMessage($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pesan warga berhasil dihapus!');
    }
    // Method Tambahkan / Update Status Bayar Anggota
public function storeMemberContribution(Request $request)
{
    $request->validate([
        'officer_id' => 'required|exists:officers,id',
        'month_period' => 'required|string',
        'amount' => 'required|numeric',
        'status' => 'required|in:paid,unpaid',
    ]);

    $contribution = MemberContribution::updateOrCreate(
        [
            'officer_id' => $request->officer_id,
            'month_period' => $request->month_period,
        ],
        [
            'amount' => $request->amount,
            'status' => $request->status,
            'payment_date' => $request->status == 'paid' ? now() : null,
        ]
    );

    // Otomatis masukkan ke Kas Pemasukan Utama jika Lunas
    if ($request->status == 'paid') {
        $officer = Officer::find($request->officer_id);
        CashTransaction::create([
            'type' => 'in',
            'title' => 'Iuran Kas ' . $officer->name . ' (' . $request->month_period . ')',
            'amount' => $request->amount,
            'category' => 'Iuran Anggota',
            'transaction_date' => now(),
        ]);
    }

    return redirect()->back()->with('success', 'Status iuran kas anggota berhasil diperbarui!');
}
}