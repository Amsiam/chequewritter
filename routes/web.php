<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\Facades\Pdf;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/cheque-write/pdf/{id}', function ($id) {

    $settings = Cache::rememberForever('setting_' . Auth::id(), function () {
        $settings = Setting::where('user_id', Auth::id())->select('key', 'value')->get();

        $keyValue = new stdClass();

        foreach ($settings as $setting) {


            $keyValue->{$setting->key} = $setting->value;
        }

        return $keyValue;
    });



    return Pdf::view('cheque-write.pdf', [
        'chequeWrite' => \App\Models\ChequeWrite::findOrFail($id),
        'settings' => $settings,
    ])
        ->format(Format::A4)
        ->margins(0, 0, 0, 0)
        ->orientation(Orientation::Landscape);

    $pdf = LaravelMpdf::loadView('cheque-write.pdf', [
        'chequeWrite' => \App\Models\ChequeWrite::findOrFail($id),
    ]);

    return $pdf->stream('cheque-write.pdf');
})->name('cheque-write.pdf');
