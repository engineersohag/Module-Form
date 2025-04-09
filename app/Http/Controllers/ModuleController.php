<?php
namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function module_store(Request $request){
        $moduleTitle = $request->moduleTitle;
        $contentTitle = $request->content ?? [];
        $img1File = $request->file('img1') ?? [];
        $img2File = $request->file('img2') ?? [];

        $contentIndex = 0;

        foreach($moduleTitle as $modTitle){
            $module = Module::create([
                'title' => $modTitle,
            ]);

            while(isset($contentTitle[$contentIndex])){
                $img1 = isset($img1File[$contentIndex]) ? $img1File[$contentIndex]->store('uploads') : null;
                $img2 = isset($img2File[$contentIndex]) ? $img2File[$contentIndex]->store('uploads') : null;

                Content::create([
                    'module_id' => $module->id,
                    'title' => $contentTitle[$contentIndex],
                    'file1' => $img1,
                    'file2' => $img2,
                ]);

                $contentIndex++;
            }
        }

        return redirect()->back()->with('success', 'Module and Content Added Successfully!');
    }
}
