<?php

use Barryvdh\DomPDF\Facade\Pdf as DomPDFPDF;

use Illuminate\Support\Facades\Route;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\Facades\Pdf;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/cheque-write/pdf/{id}', function ($id) {


    // return view('cheque-write.pdf', ['chequeWrite' => \App\Models\ChequeWrite::findOrFail($id),]);


    // return DomPDFPDF::loadView('cheque-write.pdf', [
    //     'chequeWrite' => \App\Models\ChequeWrite::findOrFail($id),
    // ])->stream();
    return Pdf::view('cheque-write.pdf', [
        'chequeWrite' => \App\Models\ChequeWrite::findOrFail($id),
    ])
        ->format(Format::A4)
        ->margins(0, 0, 0, 0)
        ->orientation(Orientation::Landscape);

    $pdf = LaravelMpdf::loadView('cheque-write.pdf', [
        'chequeWrite' => \App\Models\ChequeWrite::findOrFail($id),
    ]);

    return $pdf->stream('cheque-write.pdf');
})->name('cheque-write.pdf');
