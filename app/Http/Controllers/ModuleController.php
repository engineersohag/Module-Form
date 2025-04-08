<?php
namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('contents')->get();
        return view('modules.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'modules' => 'required|array',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.contents' => 'array',
            'modules.*.contents.*.title' => 'required|string|max:255',
            'modules.*.contents.*.files' => 'array',
            'modules.*.contents.*.files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        foreach ($request->modules as $moduleData) {
            $module = Module::create(['title' => $moduleData['title']]);

            if (!empty($moduleData['contents'])) {
                foreach ($moduleData['contents'] as $contentData) {
                    $content = new Content([
                        'title' => $contentData['title'],
                        'module_id' => $module->id
                    ]);

                    if (!empty($contentData['files'])) {
                        $filePaths = [];
                        foreach ($contentData['files'] as $index => $file) {
                            $filePaths[] = $file->store('uploads', 'public');
                        }

                        $content->file1 = $filePaths[0] ?? null;
                        $content->file2 = $filePaths[1] ?? null;
                    }

                    $content->save();
                }
            }
        }

        return response()->json(['message' => 'Modules and Contents saved successfully!']);
    }
}
