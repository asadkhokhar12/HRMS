<?php

namespace Modules\QrBasedAttendance\Http\Controllers;

use App\Http\Controllers\Controller;

class QrCodeController extends Controller
{
    public function __construct()
    {
        if (!isModuleActive('QrBasedAttendance')) {
            abort('404');
        }
    }

    public function qrCode()
    {
        $data['title'] = _trans('common.QR Code');
        return view('qrbasedattendance::qr-code.index', compact('data'));
    }
}
