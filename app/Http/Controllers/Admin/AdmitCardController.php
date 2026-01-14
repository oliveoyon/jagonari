<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class AdmitCardController extends Controller
{
    public function generate($id)
    {
        $application = JobApplication::with('circular')->findOrFail($id);

        // Only allow admit card for selected candidates
        if ($application->status != 'selected') {
            return redirect()->back()->with('error', 'এই প্রার্থীর জন্য অ্যাডমিট কার্ড তৈরি করা সম্ভব নয়।');
        }

        //  mPDF font configuration for Bangla
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [public_path('assets/fonts')]), // your font path
            'fontdata' => $fontData + [
                'solaimanlipi' => [
                    'R' => 'SolaimanLipi.ttf',
                    // 'B' => 'SolaimanLipi-Bold.ttf', // if you have bold
                ]
            ],
            'default_font' => 'solaimanlipi'
        ]);

        // Admit card HTML
        $html = view('admin.job-applications.admit-card', compact('application'))->render();

        $mpdf->WriteHTML($html);

        // Output PDF to browser
        return $mpdf->Output('admit_card_' . $application->id . '.pdf', 'I');
    }
}
