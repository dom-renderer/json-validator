<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $individual = [
            'Certified or Notarized Passport',
            'Certified or Notarized Driver\'s License',
            'Certified or Notarized National Identification Card',
            'Certified or Notarized Proof of Address (English or Translated)',
            'Professional Reference Letter',
            'Bank Reference Letter',
            'Application Form',
            'Due Diligence Declaration',
            'Personal Information Authorization',
            'Medical Examination Form',
            'FATCA/CRS Self Certification Form',
            'Privacy Notice',
            '1035 Exchange Form',
            'Term Sheet',
            'Structure Chart'
        ];

        foreach ($individual as $i) {
            \App\Models\Document::updateOrCreate([
                'type' => 'policy-holders',
                'title' => $i,
                'status' => 'individual'
            ]);
        }

        $trust = [
            'Certified or Notarized Trust Deed',
            'FATCA/CRS Self Certification Form for the Trust',
            'W-9 or W-8 BEN Form for the Trust',
            'Certified or Notarized Passport for the Trustee',
            'Certified or Notarized National Identification Card for the Trustee',
            'Certified or Notarized Proof of Address for the Trustee (English or Translated)',
            'FATCA/CRS Self Certification Form for the Trustee',
            'W-9 or W-8 BEN Form for the Trustee',
            'Certified or Notarized Passport for the Settlor',
            'Certified or Notarized National Identification for the Settlor',
            'Certified or Notarized Proof of Address for the Settlor (English or Translated)',
            'W-9 or W-8 BEN Form for the Settlor',
            'FATCA/CRS Self Certification Form for the Settlor',
            'Certified or Notarized Passport for the Protector',
            'Certified or Notarized National Identification Card for the Protector',
            'Certified or Notarized Proof of Address for the Protector (English or Translated)',
            'W-9 or W-8 BEN Form for the Trust Protector',
            'FATCA/CRS Self Certification Form for the Trust Protector'
        ];

        foreach ($trust as $t) {
            \App\Models\Document::updateOrCreate([
                'type' => 'policy-holders',
                'title' => $t,
                'status' => 'trust'
            ]);
        }

        $llc = [
            'Certified or Notarized Certificate of Good Standing',
            'Certified or Notarized Certificate of Incorporation',
            'Certified or Notarized Shareholder Register',
            'Certified or Notarized Director Register',
            'Certified or Notarized Memorandum of Articles or By-Laws',
            'Certified or Notarized Copy of Signatory List',
            'Certified or Notarized Passport for Each Signatory, Director and Shareholder',
            'Certified or Notarized Proof of Address for Each Signatory, Director and Shareholder (English or Translated)',
            'Privacy Notice',
            'FATCA/CRS Form for the Entity',
            'W-9 or W-8 BEN Form for the Entity'
        ];


        foreach ($llc as $l) {
            \App\Models\Document::updateOrCreate([
                'type' => 'policy-holders',
                'title' => $l,
                'status' => 'llc'
            ]);
        }



















        $ctrlprsn = [
            '[TESTING CONTROLLING PERSON DOC] Certified or Notarized Certificate of Good Standing',
            '[TESTING CONTROLLING PERSON DOC] Certified or Notarized Certificate of Incorporation',
            '[TESTING CONTROLLING PERSON DOC] Certified or Notarized Shareholder Register',
            '[TESTING CONTROLLING PERSON DOC] Certified or Notarized Director Register',
            '[TESTING CONTROLLING PERSON DOC] Certified or Notarized Memorandum of Articles or By-Laws'
        ];

        foreach ($ctrlprsn as $cp) {
            \App\Models\Document::updateOrCreate([
                'type' => 'controlling-person',
                'title' => $cp,
                'status' => ''
            ]);
        }

        $il = [
            '[TESTING INSURED LIFE DOC] Certified or Notarized Certificate of Good Standing',
            '[TESTING INSURED LIFE DOC] Certified or Notarized Certificate of Incorporation',
            '[TESTING INSURED LIFE DOC] Certified or Notarized Shareholder Register',
            '[TESTING INSURED LIFE DOC] Certified or Notarized Director Register',
            '[TESTING INSURED LIFE DOC] Certified or Notarized Memorandum of Articles or By-Laws'
        ];

        foreach ($il as $i) {
            \App\Models\Document::updateOrCreate([
                'type' => 'insured-life',
                'title' => $i,
                'status' => ''
            ]);
        }
        
        $ben = [
            '[TESTING BENEFICIARY DOC] Certified or Notarized Certificate of Good Standing',
            '[TESTING BENEFICIARY DOC] Certified or Notarized Certificate of Incorporation',
            '[TESTING BENEFICIARY DOC] Certified or Notarized Shareholder Register',
            '[TESTING BENEFICIARY DOC] Certified or Notarized Director Register',
            '[TESTING BENEFICIARY DOC] Certified or Notarized Memorandum of Articles or By-Laws'
        ];

        foreach ($ben as $b) {
            \App\Models\Document::updateOrCreate([
                'type' => 'beneficiary',
                'title' => $b,
                'status' => ''
            ]);
        }        

    }
}
