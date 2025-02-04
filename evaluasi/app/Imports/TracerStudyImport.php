<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\TracerStudy;
use App\Models\TracerStudyQuestion;
use App\Models\TracerStudyResponse;

class TracerStudyImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
       // Skip header row (adjust as needed)
       $rows->shift();

       foreach ($rows as $row) {
           // Map User-type question responses to LayananAlumni columns
           $layananAlumniData = [
                'name' => $row[0],        // Column B (Index 1)
                'prodi' => $row[1],      // Column C (Index 2)
                'divisi' => $row[6],       // Column D (Index 3)
                'tahun_lulus' => $row[2], // Column E (Index 4)
                'department' => $row[5], // Column E (Index 4)
                'tempat'=> $row[3], // Column E (Index 4)
                'plant'=> $row[4], // Column E (Index 4)
            ];

           // Insert into layanan_alumnis table
           $alumni = TracerStudy::create($layananAlumniData);

           // Map other responses to LayananAlumniResponse
           $otherResponses = [];
           foreach ($row->slice(7) as $questionIndex => $responseValue) {
               $otherResponses[] = [
                   'alumni_id' => $alumni->id,                // Link to layanan_alumnis
                   'question_id' => $questionIndex + 1,       // Adjust question ID (offset for question order)
                   'response_value' => $responseValue,        // Response value
                   'created_at' => now(),
                   'updated_at' => now(),
               ];
           }

           // Insert into layanan_alumni_responses table
           TracerStudyResponse::insert($otherResponses);
       }
    }
}
