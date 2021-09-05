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

    public function store(PdfFileRequest $request){

        $fileName = uniqid().'_'.$request->pdf_file->getClientOriginalName();
        $filePath = $request->file('pdf_file')->storeAs('uploads', $fileName, 'public');

        $pathToPdf = 'storage/'.$filePath;

        $forder_existed = mkdir(public_path("/uploads/pdf/$fileName"), 0777);
        $output_path = public_path("/uploads/pdf/".$fileName);
        // $imgExt = new Imagick();
        // $imgExt->readImage(public_path($pathToPdf));
        // dd($imgExt);
        $imgExt = new Imagick();
        $imgExt->setResolution(120,120);
        $imgExt->readImage(public_path($pathToPdf));
        // $imgExt->setCompressionQuality(200);
        // $imgExt->resizeImage( 2000, 2000, imagick::FILTER_LANCZOS, 0);
        $imgExt->writeImages($output_path."/page-%0004d.jpg",true);

        // return response()->json('ok');
        return back()->with('message', 'Convert thành công !')->with('alert-class', 'alert-success');
    }
}
