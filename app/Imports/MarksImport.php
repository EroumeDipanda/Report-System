<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class MarksImport implements ToArray
{
    public function array(array $rows)
    {
        return $rows; // Process rows as needed
    }
}
