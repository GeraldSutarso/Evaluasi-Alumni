<?php

namespace App\Imports;

use App\Models\LayananAlumni;
use App\Models\LayananAlumniResponse;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class LayananAlumniImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Skip header row (adjust as needed)
        $rows->shift();

        foreach ($rows as $row) {
            // Map User-type question responses to LayananAlumni columns
            $layananAlumniData = [
                'name' => $row[0],        // Column B (Index 1)
                'divisi' => $row[1],      // Column C (Index 2)
                'prodi' => $row[2],       // Column D (Index 3)
                'tahun_lulus' => $row[3], // Column E (Index 4)
            ];

            // Insert into layanan_alumnis table
            $alumni = LayananAlumni::create($layananAlumniData);

            // Map other responses to LayananAlumniResponse
            $otherResponses = [];
            foreach ($row->slice(4) as $questionIndex => $responseValue) {
                $otherResponses[] = [
                    'alumni_id' => $alumni->id,                // Link to layanan_alumnis
                    'question_id' => $questionIndex + 1,       // Adjust question ID (offset for question order)
                    'response_value' => $responseValue,        // Response value
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert into layanan_alumni_responses table
            LayananAlumniResponse::insert($otherResponses);
        }
    }
}

