<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BlogPostsExport;
use App\Imports\BlogPostsImport;

class ExcelController extends Controller
{

    public function export()
    {
        $user = Auth::user();
        $fileName = $user->hasRole('admin') ? 'all_blog_posts.xlsx' : 'my_blog_posts.xlsx';
        return Excel::download(new BlogPostsExport($user), $fileName);
    }

    public function showImportForm()
    {
        return view('excel.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,ods',
        ]);

        $import = new BlogPostsImport;
        Excel::import($import, $request->file('file'));
        $summary = [
            'successes' => $import->successes,
            'failures'  => $import->getFailureReasons(),
        ];

        return redirect()->back()
            ->with('success', 'Import completed.')
            ->with('importSummary', $summary);
    }
}
