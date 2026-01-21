<?php

namespace App\Imports;

use App\Models\Guest;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuestsImport implements ToModel, WithHeadingRow
{
    private $invitationId;

    public function __construct($invitationId)
    {
        $this->invitationId = $invitationId;
    }

    public function model(array $row)
    {
        // 1. Validation (Skip if Name is empty)
        if (empty($row['name'])) {
            return null;
        }

        // 2. Formatting
        // Category Default
        $validCategories = ['family', 'friend', 'colleague', 'vip'];
        $category = isset($row['category']) ? strtolower(trim($row['category'])) : 'friend';

        // Normalize common user inputs if needed or just valid match
        if (!in_array($category, $validCategories)) {
            $category = 'friend';
        }

        // Phone Sanitize
        $phone = $row['phone'] ?? null;
        if ($phone) {
            // Remove non-numeric
            $phone = preg_replace('/[^0-9]/', '', $phone);
            // Replace leading 08 with 628
            if (Str::startsWith($phone, '08')) {
                $phone = '62' . substr($phone, 1);
            }
        }

        // 3. Insert
        return new Guest([
            'invitation_id' => $this->invitationId,
            'name' => trim($row['name']),
            'category' => $category,
            'phone_number' => $phone,
            'slug' => Str::random(10),
            'status' => 'pending',
        ]);
    }
}
