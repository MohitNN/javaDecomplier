<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
class linuxController extends Controller
{
    public function index (Request $request) {

        try {
            $request->validate([
                'file' => 'required',
            ]);
            $file = $request->file('file')->getClientOriginalName();
    
            $fileName = $file;
            $request->file->move(public_path(), $fileName);
            exec("jadx ".$file, $output);
            $output['decode'] = implode( PHP_EOL, $output );
            
            
            $zipName = substr($fileName, 0, strrpos($fileName, '.'));
            // exec("zip -r ".$zipName.".zip ".$zipName."/ ", $zipOutput);;
            $output['folderName'] = $zipName;
            $output['files'] = Storage::disk('public')->listContents($zipName);
            return response()->json($output);
        } catch (\Exception $e) {
            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }
    public function loadFiles (Request $request) {
        $files = Storage::disk('public')->listContents($request->path);

        usort($files, function ($a, $b) { return strnatcmp($a['type'], $b['type']); });

        return response()->json(['status' => 200, 'data' => $files]);
    }
    public function loadZip  (Request $request) {

        $zipName = $request->name;
        exec("zip -r ".$zipName.".zip ".$zipName."/ ", $zipOutput);
        $resp['output'] = $zipOutput;
        $resp['downloadLink'] = url('/')."/".$zipName.".zip";
        return response()->json(['status' => 200, 'data' => $resp]);
    }
}
