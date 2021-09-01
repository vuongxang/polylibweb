<?php

namespace App\Http\Controllers;

use App\Http\Requests\PdfFileRequest;
use Illuminate\Http\Request;
use Spatie\PdfToImage\Pdf;
use Imagick;

class FileController extends Controller
{
    public function convertForm(){
        return view('admin.files.convert-form');
    }

    public function store(Request $request){

        $fileName = uniqid().'_'.$request->pdf_file->getClientOriginalName();
        $filePath = $request->file('pdf_file')->storeAs('uploads', $fileName, 'public');

        $pathToPdf = 'storage/'.$filePath;

        $forder_existed = mkdir(public_path("/uploads/pdf/$fileName"), 0777);
        $output_path = public_path("/uploads/pdf/".$fileName);
        $pdf = new Pdf($pathToPdf);
        $number_page = $pdf->getNumberOfPages();
        dd($pdf);
        for($i=1;$i<=$number_page;$i++){
            $pdf->saveImage($output_path);
        }
        // return response()->json('ok');
        return back()->with('message', 'Convert thành công !')->with('alert-class', 'alert-success');
    }
}
