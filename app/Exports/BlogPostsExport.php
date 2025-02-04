<?php

namespace App\Exports;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BlogPostsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $user;


    public function __construct($user)
    {
        $this->user = $user;
    }

    
    public function collection()
    {
        if ($this->user->hasRole('admin')) {
            return BlogPost::with('user')->get();
        } else {
            return BlogPost::with('user')
                ->where('user_id', $this->user->id)
                ->get();
        }
    }

    public function map($blogPost): array
    {
        return [
            $blogPost->title,
            $blogPost->content,
            $blogPost->user->name,
            $blogPost->created_at->format('Y-m-d'),
        ];
    }

 
    public function headings(): array
    {
        return [
            'Title',
            'Content',
            'Author Name',
            'Created At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'fill' => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF0000FF'], 
                ],
            ],
        ];
    }

    /**
     * 
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 50,  
            'C' => 30,  
            'D' => 20,  
        ];
    }
}
