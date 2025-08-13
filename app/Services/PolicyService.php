<?php

namespace App\Services;

use App\Models\PolicyCommunication;
use App\Models\PolicyDocument;
use App\Models\PolicyEconomicProfile;
use App\Models\PolicyFeeSummaryExternal;
use App\Models\PolicyFeeSummaryInternalFee;
use App\Models\PolicyInvestmentNote;
use App\Models\PolicyPremium;
use Illuminate\Support\Facades\Validator;
use App\Models\PolicyIntroducer;
use App\Models\PolicyKeyRole;
use App\Models\Policy;
use App\Models\PolicyCaseFileNote;
use App\Models\PolicyFeeSummaryInternal;
use App\Models\PolicyInception;
use App\Models\PolicyOnGoing;

class PolicyService {

    public static $sections = [
        'section-a-1',
        'section-a-2',
        'section-b-1',
        'section-b-2',
        'section-c-1',
        'section-d-1',
        'section-e-1',
        'section-e-2',
        'section-e-3',
        'section-e-4',
        'section-f-1',
        'section-f-2',
        'section-f-3',
        'section-f-4',
        'section-f-5',
        'section-f-6',
        'section-f-7',
        'section-g-1',
        'section-g-2'
    ];

    public function submit($request) : mixed
    {
        // $validator = Validator::make($request->all(), [
        //     'policy_id' => 'required'            
        // ]);

        // if ($validator->fails()) {
        //     return ['errors' => $validator->errors()];
        // }

        if ($request->filled('policy')) {
            $policy = Policy::find($request->policy);
            $savingType = $request->save != 'draft' ? 'save' : 'draft';
            $section = $request->section;
            $currentLoggedInUser = auth()->id();

            $response = [
                'data' => [],
                'type' => $savingType,
                'next_section' => $section
            ];

            if ($policy) {
                switch ($section) {
                case self::$sections[0]:

                    $introducer = PolicyIntroducer::where('policy_id', $policy->id)->first();
                    if ($introducer) {
                        PolicyIntroducer::where('policy_id', $policy->id)->update([
                            'type' => strtolower($request['data']['section_a_1_entity']),
                            'name' => $request['data']['section_a_1_name'],
                            'email' => $request['data']['section_a_1_email'],
                            'dial_code' => $request['data']['section_a_1_dial_code'] ?? '41',
                            'contact_number' => $request['data']['section_a_1_phone'],
                            'updated_by' => $currentLoggedInUser,
                            'silent_save' => $request->get('silent_save', 0),
                            'in_draft' => $savingType == 'draft' ? 1 : 0
                        ]);
                    } else {
                        PolicyIntroducer::create([
                            'policy_id' => $policy->id,
                            'type' => strtolower($request['data']['section_a_1_entity']),
                            'name' => $request['data']['section_a_1_name'],
                            'email' => $request['data']['section_a_1_email'],
                            'dial_code' => $request['data']['section_a_1_dial_code'] ?? '41',
                            'contact_number' => $request['data']['section_a_1_phone'],
                            'added_by' => $currentLoggedInUser,
                            'silent_save' => $request->get('silent_save', 0),
                            'in_draft' => $savingType == 'draft' ? 1 : 0
                        ]);
                    }

                    if ($savingType == 'draft') {
                        $policy->silent_save = $request->get('silent_save', 0);
                        $policy->status = 0;
                        $policy->save();

                        if (!$request->get('silent_save', 0)) {
                            session()->forget('new_policy');
                        }
                    }

                    $response['next_section'] = self::$sections[1];
                    return $response;
                case self::$sections[1]:

                    if ($request->has('data.policy_holder')) {
                        $keyRoles1 = PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'policy-holder')->first();
                        if ($keyRoles1) {
                            PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'policy-holder')->update([
                                'type' => 'policy-holder',
                                'name' => $request['data']['policy_holder']['name'] ?? '',
                                'entity_type' => $request['data']['policy_holder']['entity_type'] ?? '',
                                'notes' => $request['data']['policy_holder']['notes'] ?? '',
                                'silent_save' => $request->get('silent_save', 0),
                                'updated_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        } else {
                            PolicyKeyRole::create([
                                'policy_id' => $policy->id,
                                'type' => 'policy-holder',
                                'name' => $request['data']['policy_holder']['name'] ?? '',
                                'entity_type' => $request['data']['policy_holder']['entity_type'] ?? '',
                                'notes' => $request['data']['policy_holder']['notes'] ?? '',
                                'silent_save' => $request->get('silent_save', 0),
                                'added_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        }
                    }
                    
                    if ($request->has('data.unsured_life')) {
                        $keyRoles1 = PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'insured-life')->first();
                        if ($keyRoles1) {
                        PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'insured-life')->update([
                            'type' => 'insured-life',
                            'name' => $request['data']['unsured_life']['name'] ?? '',
                            'entity_type' => $request['data']['unsured_life']['entity_type'] ?? '',
                            'notes' => $request['data']['unsured_life']['notes'] ?? '',
                            'silent_save' => $request->get('silent_save', 0),
                            'updated_by' => $currentLoggedInUser,
                            'in_draft' => $savingType == 'draft' ? 1 : 0
                        ]);
                        } else {
                            PolicyKeyRole::create([
                                'policy_id' => $policy->id,
                                'type' => 'insured-life',
                                'name' => $request['data']['unsured_life']['name'] ?? '',
                                'entity_type' => $request['data']['unsured_life']['entity_type'] ?? '',
                                'notes' => $request['data']['unsured_life']['notes'] ?? '',
                                'silent_save' => 0,
                                'added_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        }
                    }

                    if ($request->has('data.beneficiaries')) {
                        $keyRoles1 = PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'beneficiary')->first();
                        if ($keyRoles1) {
                            PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'beneficiary')->update([
                                'type' => 'beneficiary',
                                'name' => $request['data']['beneficiaries']['name'] ?? '',
                                'entity_type' => $request['data']['beneficiaries']['entity_type'] ?? '',
                                'notes' => $request['data']['beneficiaries']['notes'] ?? '',
                                'silent_save' => 0,
                                'updated_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        } else {
                            PolicyKeyRole::create([
                                'policy_id' => $policy->id,
                                'type' => 'beneficiary',
                                'name' => $request['data']['beneficiaries']['name'] ?? '',
                                'entity_type' => $request['data']['beneficiaries']['entity_type'] ?? '',
                                'notes' => $request['data']['beneficiaries']['notes'] ?? '',
                                'silent_save' => 0,
                                'added_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        }
                    }
                    
                    if ($request->has('data.advisor')) {
                        $keyRoles1 = PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'investment-advisor')->first();
                        if ($keyRoles1) {
                            PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'investment-advisor')->update([
                                'type' => 'investment-advisor',
                                'name' => $request['data']['advisor']['name'] ?? '',
                                'entity_type' => $request['data']['advisor']['entity_type'] ?? '',
                                'notes' => $request['data']['advisor']['notes'] ?? '',
                                'silent_save' => 0,
                                'updated_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        } else {
                            PolicyKeyRole::create([
                                'policy_id' => $policy->id,
                                'type' => 'investment-advisor',
                                'name' => $request['data']['advisor']['name'] ?? '',
                                'entity_type' => $request['data']['advisor']['entity_type'] ?? '',
                                'notes' => $request['data']['advisor']['notes'] ?? '',
                                'silent_save' => 0,
                                'added_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        }
                    }
                    
                    if ($request->has('data.idf')) {
                        $keyRoles1 = PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'idf-name')->first();
                        if ($keyRoles1) {
                            PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'idf-name')->update([
                                'type' => 'idf-name',
                                'name' => $request['data']['idf']['name'] ?? '',
                                'entity_type' => $request['data']['idf']['entity_type'] ?? '',
                                'notes' => $request['data']['idf']['notes'] ?? '',
                                'silent_save' => 0,
                                'updated_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        } else {
                            PolicyKeyRole::create([
                                'policy_id' => $policy->id,
                                'type' => 'idf-name',
                                'name' => $request['data']['idf']['name'] ?? '',
                                'entity_type' => $request['data']['idf']['entity_type'] ?? '',
                                'notes' => $request['data']['idf']['notes'] ?? '',
                                'silent_save' => 0,
                                'added_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        }
                    }
                    
                    if ($request->has('data.idfm_holder')) {
                        $keyRoles1 = PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'idf-manager')->first();
                        if ($keyRoles1) {
                            PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'idf-manager')->update([
                                'type' => 'idf-manager',
                                'name' => $request['data']['idfm_holder']['name'] ?? '',
                                'entity_type' => $request['data']['idfm_holder']['entity_type'] ?? '',
                                'notes' => $request['data']['idfm_holder']['notes'] ?? '',
                                'silent_save' => 0,
                                'updated_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        } else {
                            PolicyKeyRole::create([
                                'policy_id' => $policy->id,
                                'type' => 'idf-manager',
                                'name' => $request['data']['idfm_holder']['name'] ?? '',
                                'entity_type' => $request['data']['idfm_holder']['entity_type'] ?? '',
                                'notes' => $request['data']['idfm_holder']['notes'] ?? '',
                                'silent_save' => 0,
                                'added_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        }
                    }
                    
                    if ($request->has('data.custodian_holder')) {
                        $keyRoles1 = PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'custodian-bank')->first();
                        if ($keyRoles1) {
                            PolicyKeyRole::where('policy_id', $policy->id)->where('type', 'custodian-bank')->update([
                                'type' => 'custodian-bank',
                                'name' => $request['data']['custodian_holder']['name'] ?? '',
                                'entity_type' => $request['data']['custodian_holder']['entity_type'] ?? '',
                                'notes' => $request['data']['custodian_holder']['notes'] ?? '',
                                'silent_save' => 0,
                                'updated_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        } else {
                            PolicyKeyRole::create([
                                'policy_id' => $policy->id,
                                'type' => 'custodian-bank',
                                'name' => $request['data']['custodian_holder']['name'] ?? '',
                                'entity_type' => $request['data']['custodian_holder']['entity_type'] ?? '',
                                'notes' => $request['data']['custodian_holder']['notes'] ?? '',
                                'silent_save' => 0,
                                'added_by' => $currentLoggedInUser,
                                'in_draft' => $savingType == 'draft' ? 1 : 0
                            ]);
                        }
                    }                    

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }

                    $response['next_section'] = self::$sections[2];
                    return $response;
                case self::$sections[2]:
                    $response['next_section'] = self::$sections[3];
                    return $response;
                case self::$sections[3]:
                    $response['next_section'] = self::$sections[4];
                    return $response;
                case self::$sections[4]:
                    $response['next_section'] = self::$sections[5];
                    return $response;
                case self::$sections[5]:
                    $response['next_section'] = self::$sections[6];
                    return $response;
                case self::$sections[6]:

                    $keepChecked = [];

                    if (isset($request['data']['documents'])) {
                        foreach ($request['data']['documents'] as $document) {
                            $keepChecked[] = PolicyDocument::updateOrCreate([
                                'policy_id' => $policy->id,
                                'document_id' => $document,
                                'document_type' => 'policy-holder',
                                'uploaded' => 1
                            ])->id;
                        }
                    }

                    if (!empty($keepChecked)) {
                        PolicyDocument::where('policy_id', $policy->id)->where('document_type', 'policy-holder')->whereNotIn('id', $keepChecked)->update(['uploaded' => 0]);
                    } else {
                        PolicyDocument::where('policy_id', $policy->id)->where('document_type', 'policy-holder')->update(['uploaded' => 0]);
                    }

                    $response['next_section'] = self::$sections[7];
                    return $response;
                case self::$sections[7]:

                    $keepChecked = [];

                    if (isset($request['data']['documents'])) {
                        foreach ($request['data']['documents'] as $document) {
                            $keepChecked[] = PolicyDocument::updateOrCreate([
                                'policy_id' => $policy->id,
                                'document_id' => $document,
                                'document_type' => 'controlling-person',
                                'uploaded' => 1
                            ])->id;
                        }
                    }

                    if (!empty($keepChecked)) {
                        PolicyDocument::where('policy_id', $policy->id)->where('document_type', 'policy-holder')->whereNotIn('id', $keepChecked)->update(['uploaded' => 0]);
                    } else {
                        PolicyDocument::where('policy_id', $policy->id)->where('document_type', 'policy-holder')->update(['uploaded' => 0]);
                    }

                    $response['next_section'] = self::$sections[8];
                    return $response;
                case self::$sections[8]:

                    $keepChecked = [];

                    if (isset($request['data']['documents'])) {
                        foreach ($request['data']['documents'] as $document) {
                            $keepChecked[] = PolicyDocument::updateOrCreate([
                                'policy_id' => $policy->id,
                                'document_id' => $document,
                                'document_type' => 'insured-life',
                                'uploaded' => 1
                            ])->id;
                        }
                    }

                    if (!empty($keepChecked)) {
                        PolicyDocument::where('policy_id', $policy->id)->where('document_type', 'insured-life')->whereNotIn('id', $keepChecked)->update(['uploaded' => 0]);
                    } else {
                        PolicyDocument::where('policy_id', $policy->id)->where('document_type', 'insured-life')->update(['uploaded' => 0]);
                    }

                    $response['next_section'] = self::$sections[9];
                    return $response;
                case self::$sections[9]:

                    $keepChecked = [];

                    if (isset($request['data']['documents'])) {
                        foreach ($request['data']['documents'] as $document) {
                            $keepChecked[] = PolicyDocument::updateOrCreate([
                                'policy_id' => $policy->id,
                                'document_id' => $document,
                                'document_type' => 'beneficiary',
                                'uploaded' => 1
                            ])->id;
                        }
                    }

                    if (!empty($keepChecked)) {
                        PolicyDocument::where('policy_id', $policy->id)->where('document_type', 'beneficiary')->whereNotIn('id', $keepChecked)->update(['uploaded' => 0]);
                    } else {
                        PolicyDocument::where('policy_id', $policy->id)->where('document_type', 'beneficiary')->update(['uploaded' => 0]);
                    }

                    $response['next_section'] = self::$sections[10];
                    return $response;
                case self::$sections[10]:

                    if (PolicyEconomicProfile::where('policy_id', $policy->id)->exists()) {
                        PolicyEconomicProfile::where('policy_id', $policy->id)->update([
                            'purpose_of_policy_and_structure' => $request['data']['purpose'] ?? '',
                            'additional_details' => $request['data']['additional_details'] ?? '',
                            'estimated_networth' => $request['data']['estimated_networth'] ?? '',
                            'source_of_wealth_for_policy' => $request['data']['source_of_wealth_for_policy'] ?? '',
                            'distribution_strategy_during_policy_lifetime' => $request['data']['distribution_strategy_during_policy_lifetime'] ?? '',
                            'distribution_strategy_post_death_payout' => $request['data']['distribution_strategy_post_death_payout'] ?? '',
                            'known_triggers_for_policy_exit_or_surrender' => $request['data']['known_triggers_for_policy_exit_or_surrender'] ?? '',
                            'updated_by' => $currentLoggedInUser
                        ]);
                    } else {
                        PolicyEconomicProfile::create([
                            'policy_id' => $policy->id,
                            'purpose_of_policy_and_structure' => $request['data']['purpose'] ?? '',
                            'additional_details' => $request['data']['additional_details'] ?? '',
                            'estimated_networth' => $request['data']['estimated_networth'] ?? '',
                            'source_of_wealth_for_policy' => $request['data']['source_of_wealth_for_policy'] ?? '',
                            'distribution_strategy_during_policy_lifetime' => $request['data']['distribution_strategy_during_policy_lifetime'] ?? '',
                            'distribution_strategy_post_death_payout' => $request['data']['distribution_strategy_post_death_payout'] ?? '',
                            'known_triggers_for_policy_exit_or_surrender' => $request['data']['known_triggers_for_policy_exit_or_surrender'] ?? '',
                            'added_by' => $currentLoggedInUser
                        ]);
                    }

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }                    

                    $response['next_section'] = self::$sections[11];
                    return $response;
                case self::$sections[11]:

                    if (PolicyPremium::where('policy_id', $policy->id)->exists()) {
                        PolicyPremium::where('policy_id', $policy->id)->update([
                            'policy_type' => $request['data']['type'] ?? '',
                            'proposed_premium_amount' => $request['data']['proposed_premium'] ?? '',
                            'proposed_premium_note' => $request['data']['proposed_premium_note'] ?? '',
                            'final_premium_amount' => $request['data']['final_premium'] ?? '',
                            'final_premium_note' => $request['data']['final_premium_note'] ?? '',
                            'premium_frequency' => $request['data']['premium_frequency'] ?? '',
                            'premium_years' => $request['data']['premium_years'] ?? '',
                            'updated_by' => $currentLoggedInUser
                        ]);
                    } else {
                        PolicyPremium::create([
                            'policy_id' => $policy->id,
                            'policy_type' => $request['data']['type'] ?? '',
                            'proposed_premium_amount' => $request['data']['proposed_premium'] ?? '',
                            'proposed_premium_note' => $request['data']['proposed_premium_note'] ?? '',
                            'final_premium_amount' => $request['data']['final_premium'] ?? '',
                            'final_premium_note' => $request['data']['final_premium_note'] ?? '',
                            'premium_frequency' => $request['data']['premium_frequency'] ?? '',
                            'premium_years' => $request['data']['premium_years'] ?? '',
                            'added_by' => $currentLoggedInUser
                        ]);
                    }

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }

                    $response['next_section'] = self::$sections[12];
                    return $response;
                case self::$sections[12]:

                    if (PolicyFeeSummaryInternal::where('policy_id', $policy->id)->exists()) {
                        $created = PolicyFeeSummaryInternal::where('policy_id', $policy->id)->update([
                            'fee_provided_by' => $request['data']['fee_provided_by'] ?? '',
                            'date_fee_provided' => isset($request['data']['fee_provided_by_date']) ? date('Y-m-d H:i:s', strtotime($request['data']['fee_provided_by_date'])) : null,
                            'controlling_person_fee_approved_by' => $request['data']['fee_approved_by'] ?? '',
                            'date_fee_approved' => isset($request['data']['fee_approved_by_date']) ? date('Y-m-d H:i:s', strtotime($request['data']['fee_approved_by_date'])) : null,
                            'gii_fee_approved_by' => $request['data']['gii_fee_approved_by'] ?? '',
                            'gii_date_fee_approved' => isset($request['data']['gii_fee_approved_by_date']) ? date('Y-m-d H:i:s', strtotime($request['data']['gii_fee_approved_by_date'])) : null,
                            'fee_approval_notes' => $request['data']['approval_notes'] ?? '',
                            'updated_by' => $currentLoggedInUser
                        ]);
                        $created = PolicyFeeSummaryInternal::where('policy_id', $policy->id)->first();
                    } else {
                        $created = PolicyFeeSummaryInternal::create([
                            'policy_id' => $policy->id,
                            'fee_provided_by' => $request['data']['fee_provided_by'] ?? '',
                            'date_fee_provided' => isset($request['data']['fee_provided_by_date']) ? date('Y-m-d H:i:s', strtotime($request['data']['fee_provided_by_date'])) : null,
                            'controlling_person_fee_approved_by' => $request['data']['fee_approved_by'] ?? '',
                            'date_fee_approved' => isset($request['data']['fee_approved_by_date']) ? date('Y-m-d H:i:s', strtotime($request['data']['fee_approved_by_date'])) : null,
                            'gii_fee_approved_by' => $request['data']['gii_fee_approved_by'] ?? '',
                            'gii_date_fee_approved' => isset($request['data']['gii_fee_approved_by_date']) ? date('Y-m-d H:i:s', strtotime($request['data']['gii_fee_approved_by_date'])) : null,
                            'fee_approval_notes' => $request['data']['approval_notes'] ?? '',
                            'added_by' => $currentLoggedInUser
                        ]);
                    }

                    if ($created) {
                        if ($request->has('data.a')) {
                            $keyRoles1 = PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['a']['type'])->first();
                            if ($keyRoles1) {
                                PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['a']['type'])->update([
                                    'type' => $request['data']['a']['type'],
                                    'frequency' => $request['data']['a']['frequency'] ?? '',
                                    'amount' => $request['data']['a']['amount'] ?? 0,
                                    'commission_split' => $request['data']['a']['commission_split'] ?? '',
                                    'notes' => $request['data']['a']['note'] ?? '',
                                    'updated_by' => $currentLoggedInUser
                                ]);
                            } else {
                                PolicyFeeSummaryInternalFee::create([
                                    'policy_fee_summary_internal_id' => $created->id,
                                    'type' => $request['data']['a']['type'],
                                    'frequency' => $request['data']['a']['frequency'] ?? '',
                                    'amount' => $request['data']['a']['amount'] ?? 0,
                                    'commission_split' => $request['data']['a']['commission_split'] ?? '',
                                    'notes' => $request['data']['a']['note'] ?? '',
                                    'added_by' => $currentLoggedInUser
                                ]);
                            }
                        }

                        if ($request->has('data.b')) {
                            $keyRoles1 = PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['b']['type'])->first();
                            if ($keyRoles1) {
                                PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['b']['type'])->update([
                                    'type' => $request['data']['b']['type'],
                                    'frequency' => $request['data']['b']['frequency'] ?? '',
                                    'amount' => $request['data']['b']['amount'] ?? 0,
                                    'commission_split' => $request['data']['b']['commission_split'] ?? '',
                                    'notes' => $request['data']['b']['note'] ?? '',
                                    'updated_by' => $currentLoggedInUser
                                ]);
                            } else {
                                PolicyFeeSummaryInternalFee::create([
                                    'policy_fee_summary_internal_id' => $created->id,
                                    'type' => $request['data']['b']['type'],
                                    'frequency' => $request['data']['b']['frequency'] ?? '',
                                    'amount' => $request['data']['b']['amount'] ?? 0,
                                    'commission_split' => $request['data']['b']['commission_split'] ?? '',
                                    'notes' => $request['data']['b']['note'] ?? '',
                                    'added_by' => $currentLoggedInUser
                                ]);
                            }
                        }
                        
                        if ($request->has('data.c')) {
                            $keyRoles1 = PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['c']['type'])->first();
                            if ($keyRoles1) {
                                PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['c']['type'])->update([
                                    'type' => $request['data']['c']['type'],
                                    'frequency' => $request['data']['c']['frequency'] ?? '',
                                    'amount' => $request['data']['c']['amount'] ?? 0,
                                    'commission_split' => $request['data']['c']['commission_split'] ?? '',
                                    'notes' => $request['data']['c']['note'] ?? '',
                                    'updated_by' => $currentLoggedInUser
                                ]);
                            } else {
                                PolicyFeeSummaryInternalFee::create([
                                    'policy_fee_summary_internal_id' => $created->id,
                                    'type' => $request['data']['c']['type'],
                                    'frequency' => $request['data']['c']['frequency'] ?? '',
                                    'amount' => $request['data']['c']['amount'] ?? 0,
                                    'commission_split' => $request['data']['c']['commission_split'] ?? '',
                                    'notes' => $request['data']['c']['note'] ?? '',
                                    'added_by' => $currentLoggedInUser
                                ]);
                            }
                        }
                        
                        if ($request->has('data.f')) {
                            $keyRoles1 = PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['d']['type'])->first();
                            if ($keyRoles1) {
                                PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['d']['type'])->update([
                                    'type' => $request['data']['d']['type'],
                                    'frequency' => $request['data']['d']['frequency'] ?? '',
                                    'amount' => $request['data']['d']['amount'] ?? 0,
                                    'commission_split' => $request['data']['d']['commission_split'] ?? '',
                                    'notes' => $request['data']['d']['note'] ?? '',
                                    'updated_by' => $currentLoggedInUser
                                ]);
                            } else {
                                PolicyFeeSummaryInternalFee::create([
                                    'policy_fee_summary_internal_id' => $created->id,
                                    'type' => $request['data']['d']['type'],
                                    'frequency' => $request['data']['d']['frequency'] ?? '',
                                    'amount' => $request['data']['d']['amount'] ?? 0,
                                    'commission_split' => $request['data']['d']['commission_split'] ?? '',
                                    'notes' => $request['data']['d']['note'] ?? '',
                                    'added_by' => $currentLoggedInUser
                                ]);
                            }
                        }
                        
                        if ($request->has('data.e')) {
                            $keyRoles1 = PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['e']['type'])->first();
                            if ($keyRoles1) {
                                PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['e']['type'])->update([
                                    'type' => $request['data']['e']['type'],
                                    'frequency' => $request['data']['e']['frequency'] ?? '',
                                    'amount' => $request['data']['e']['amount'] ?? 0,
                                    'commission_split' => $request['data']['e']['commission_split'] ?? '',
                                    'notes' => $request['data']['e']['note'] ?? '',
                                    'updated_by' => $currentLoggedInUser
                                ]);
                            } else {
                                PolicyFeeSummaryInternalFee::create([
                                    'policy_fee_summary_internal_id' => $created->id,
                                    'type' => $request['data']['e']['type'],
                                    'frequency' => $request['data']['e']['frequency'] ?? '',
                                    'amount' => $request['data']['e']['amount'] ?? 0,
                                    'commission_split' => $request['data']['e']['commission_split'] ?? '',
                                    'notes' => $request['data']['e']['note'] ?? '',
                                    'added_by' => $currentLoggedInUser
                                ]);
                            }
                        }
                        
                        if ($request->has('data.f')) {
                            $keyRoles1 = PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['f']['type'])->first();
                            if ($keyRoles1) {
                                PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['f']['type'])->update([
                                    'type' => $request['data']['f']['type'],
                                    'frequency' => $request['data']['f']['frequency'] ?? '',
                                    'amount' => $request['data']['f']['amount'] ?? 0,
                                    'commission_split' => $request['data']['f']['commission_split'] ?? '',
                                    'notes' => $request['data']['f']['note'] ?? '',
                                    'updated_by' => $currentLoggedInUser
                                ]);
                            } else {
                                PolicyFeeSummaryInternalFee::create([
                                    'policy_fee_summary_internal_id' => $created->id,
                                    'type' => $request['data']['f']['type'],
                                    'frequency' => $request['data']['f']['frequency'] ?? '',
                                    'amount' => $request['data']['f']['amount'] ?? 0,
                                    'commission_split' => $request['data']['f']['commission_split'] ?? '',
                                    'notes' => $request['data']['f']['note'] ?? '',
                                    'added_by' => $currentLoggedInUser
                                ]);
                            }
                        }  

                        if ($request->has('data.g')) {
                            $keyRoles1 = PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['g']['type'])->first();
                            if ($keyRoles1) {
                                PolicyFeeSummaryInternalFee::where('policy_fee_summary_internal_id', $created->id)->where('type', $request['data']['g']['type'])->update([
                                    'type' => $request['data']['g']['type'],
                                    'frequency' => $request['data']['g']['frequency'] ?? '',
                                    'amount' => $request['data']['g']['amount'] ?? 0,
                                    'commission_split' => $request['data']['g']['commission_split'] ?? '',
                                    'notes' => $request['data']['g']['note'] ?? '',
                                    'updated_by' => $currentLoggedInUser
                                ]);
                            } else {
                                PolicyFeeSummaryInternalFee::create([
                                    'policy_fee_summary_internal_id' => $created->id,
                                    'type' => $request['data']['g']['type'],
                                    'frequency' => $request['data']['g']['frequency'] ?? '',
                                    'amount' => $request['data']['g']['amount'] ?? 0,
                                    'commission_split' => $request['data']['g']['commission_split'] ?? '',
                                    'notes' => $request['data']['g']['note'] ?? '',
                                    'added_by' => $currentLoggedInUser
                                ]);
                            }
                        }
                    }                 

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }


                    $response['next_section'] = self::$sections[13];
                    return $response;
                case self::$sections[13]:

                    if ($request->has('data.a')) {
                        $keyRoles1 = PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['a']['type'])->first();
                        if ($keyRoles1) {
                            PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['a']['type'])->update([
                                'type' => $request['data']['a']['type'],
                                'frequency' => $request['data']['a']['frequency'] ?? '',
                                'amount' => $request['data']['a']['amount'] ?? 0,
                                'recipient' => $request['data']['a']['recipient'] ?? '',
                                'notes' => $request['data']['a']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyFeeSummaryExternal::create([
                                'policy_id' => $policy->id,
                                'type' => $request['data']['a']['type'],
                                'frequency' => $request['data']['a']['frequency'] ?? '',
                                'amount' => $request['data']['a']['amount'] ?? 0,
                                'recipient' => $request['data']['a']['recipient'] ?? '',
                                'notes' => $request['data']['a']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.b')) {
                        $keyRoles1 = PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['b']['type'])->first();
                        if ($keyRoles1) {
                            PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['b']['type'])->update([
                                'type' => $request['data']['b']['type'],
                                'frequency' => $request['data']['b']['frequency'] ?? '',
                                'amount' => $request['data']['b']['amount'] ?? 0,
                                'recipient' => $request['data']['b']['recipient'] ?? '',
                                'notes' => $request['data']['b']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyFeeSummaryExternal::create([
                                'policy_id' => $policy->id,
                                'type' => $request['data']['b']['type'],
                                'frequency' => $request['data']['b']['frequency'] ?? '',
                                'amount' => $request['data']['b']['amount'] ?? 0,
                                'recipient' => $request['data']['b']['recipient'] ?? '',
                                'notes' => $request['data']['b']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.c')) {
                        $keyRoles1 = PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['c']['type'])->first();
                        if ($keyRoles1) {
                            PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['c']['type'])->update([
                                'type' => $request['data']['c']['type'],
                                'frequency' => $request['data']['c']['frequency'] ?? '',
                                'amount' => $request['data']['c']['amount'] ?? 0,
                                'recipient' => $request['data']['c']['recipient'] ?? '',
                                'notes' => $request['data']['c']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyFeeSummaryExternal::create([
                                'policy_id' => $policy->id,
                                'type' => $request['data']['c']['type'],
                                'frequency' => $request['data']['c']['frequency'] ?? '',
                                'amount' => $request['data']['c']['amount'] ?? 0,
                                'recipient' => $request['data']['c']['recipient'] ?? '',
                                'notes' => $request['data']['c']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.f')) {
                        $keyRoles1 = PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['d']['type'])->first();
                        if ($keyRoles1) {
                            PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['d']['type'])->update([
                                'type' => $request['data']['d']['type'],
                                'frequency' => $request['data']['d']['frequency'] ?? '',
                                'amount' => $request['data']['d']['amount'] ?? 0,
                                'recipient' => $request['data']['d']['recipient'] ?? '',
                                'notes' => $request['data']['d']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyFeeSummaryExternal::create([
                                'policy_id' => $policy->id,
                                'type' => $request['data']['d']['type'],
                                'frequency' => $request['data']['d']['frequency'] ?? '',
                                'amount' => $request['data']['d']['amount'] ?? 0,
                                'recipient' => $request['data']['d']['recipient'] ?? '',
                                'notes' => $request['data']['d']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.e')) {
                        $keyRoles1 = PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['e']['type'])->first();
                        if ($keyRoles1) {
                            PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['e']['type'])->update([
                                'type' => $request['data']['e']['type'],
                                'frequency' => $request['data']['e']['frequency'] ?? '',
                                'amount' => $request['data']['e']['amount'] ?? 0,
                                'recipient' => $request['data']['e']['recipient'] ?? '',
                                'notes' => $request['data']['e']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyFeeSummaryExternal::create([
                                'policy_id' => $policy->id,
                                'type' => $request['data']['e']['type'],
                                'frequency' => $request['data']['e']['frequency'] ?? '',
                                'amount' => $request['data']['e']['amount'] ?? 0,
                                'recipient' => $request['data']['e']['recipient'] ?? '',
                                'notes' => $request['data']['e']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.f')) {
                        $keyRoles1 = PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['f']['type'])->first();
                        if ($keyRoles1) {
                            PolicyFeeSummaryExternal::where('policy_id', $policy->id)->where('type', $request['data']['f']['type'])->update([
                                'type' => $request['data']['f']['type'],
                                'frequency' => $request['data']['f']['frequency'] ?? '',
                                'amount' => $request['data']['f']['amount'] ?? 0,
                                'recipient' => $request['data']['f']['recipient'] ?? '',
                                'notes' => $request['data']['f']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyFeeSummaryExternal::create([
                                'policy_id' => $policy->id,
                                'type' => $request['data']['f']['type'],
                                'frequency' => $request['data']['f']['frequency'] ?? '',
                                'amount' => $request['data']['f']['amount'] ?? 0,
                                'recipient' => $request['data']['f']['recipient'] ?? '',
                                'notes' => $request['data']['f']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }                    

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }

                    $response['next_section'] = self::$sections[14];
                    return $response;
                case self::$sections[14]:

                    if ($request->has('data.a')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['a']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['a']['asset_class'])->update([
                                'asset_class' => $request['data']['a']['asset_class'],
                                'included' => isset($request['data']['a']['included']) && $request['data']['a']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['a']['est'] ?? '',
                                'valuation_support' => $request['data']['a']['val'] ?? '',
                                'notes' => $request['data']['a']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['a']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['a']['included']) && $request['data']['a']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['a']['est'] ?? '',
                                'valuation_support' => $request['data']['a']['val'] ?? '',
                                'notes' => $request['data']['a']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.b')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['b']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['b']['asset_class'])->update([
                                'asset_class' => $request['data']['b']['asset_class'],
                                'included' => isset($request['data']['b']['included']) && $request['data']['b']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['b']['est'] ?? '',
                                'valuation_support' => $request['data']['b']['val'] ?? '',
                                'notes' => $request['data']['b']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['b']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['b']['included']) && $request['data']['b']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['b']['est'] ?? '',
                                'valuation_support' => $request['data']['b']['val'] ?? '',
                                'notes' => $request['data']['b']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.c')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['c']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['c']['asset_class'])->update([
                                'asset_class' => $request['data']['c']['asset_class'],
                                'included' => isset($request['data']['c']['included']) && $request['data']['c']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['c']['est'] ?? '',
                                'valuation_support' => $request['data']['c']['val'] ?? '',
                                'notes' => $request['data']['c']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['c']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['c']['included']) && $request['data']['c']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['c']['est'] ?? '',
                                'valuation_support' => $request['data']['c']['val'] ?? '',
                                'notes' => $request['data']['c']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.d')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['d']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['d']['asset_class'])->update([
                                'asset_class' => $request['data']['d']['asset_class'],
                                'included' => isset($request['data']['d']['included']) && $request['data']['d']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['d']['est'] ?? '',
                                'valuation_support' => $request['data']['d']['val'] ?? '',
                                'notes' => $request['data']['d']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['d']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['d']['included']) && $request['data']['d']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['d']['est'] ?? '',
                                'valuation_support' => $request['data']['d']['val'] ?? '',
                                'notes' => $request['data']['d']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.e')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['e']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['e']['asset_class'])->update([
                                'asset_class' => $request['data']['e']['asset_class'],
                                'included' => isset($request['data']['e']['included']) && $request['data']['e']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['e']['est'] ?? '',
                                'valuation_support' => $request['data']['e']['val'] ?? '',
                                'notes' => $request['data']['e']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['e']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['e']['included']) && $request['data']['e']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['e']['est'] ?? '',
                                'valuation_support' => $request['data']['e']['val'] ?? '',
                                'notes' => $request['data']['e']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.f')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['f']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['f']['asset_class'])->update([
                                'asset_class' => $request['data']['f']['asset_class'],
                                'included' => isset($request['data']['f']['included']) && $request['data']['f']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['f']['est'] ?? '',
                                'valuation_support' => $request['data']['f']['val'] ?? '',
                                'notes' => $request['data']['f']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['f']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['f']['included']) && $request['data']['f']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['f']['est'] ?? '',
                                'valuation_support' => $request['data']['f']['val'] ?? '',
                                'notes' => $request['data']['f']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.g')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['g']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['g']['asset_class'])->update([
                                'asset_class' => $request['data']['g']['asset_class'],
                                'included' => isset($request['data']['g']['included']) && $request['data']['a']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['g']['est'] ?? '',
                                'valuation_support' => $request['data']['g']['val'] ?? '',
                                'notes' => $request['data']['g']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['g']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['g']['included']) && $request['data']['g']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['g']['est'] ?? '',
                                'valuation_support' => $request['data']['g']['val'] ?? '',
                                'notes' => $request['data']['g']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.h')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['h']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['h']['asset_class'])->update([
                                'asset_class' => $request['data']['h']['asset_class'],
                                'included' => isset($request['data']['h']['included']) && $request['data']['h']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['h']['est'] ?? '',
                                'valuation_support' => $request['data']['h']['val'] ?? '',
                                'notes' => $request['data']['h']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['h']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['h']['included']) && $request['data']['h']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['h']['est'] ?? '',
                                'valuation_support' => $request['data']['h']['val'] ?? '',
                                'notes' => $request['data']['h']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.i')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['i']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['i']['asset_class'])->update([
                                'asset_class' => $request['data']['i']['asset_class'],
                                'included' => isset($request['data']['i']['included']) && $request['data']['i']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['i']['est'] ?? '',
                                'valuation_support' => $request['data']['i']['val'] ?? '',
                                'notes' => $request['data']['i']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['i']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['i']['included']) && $request['data']['i']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['i']['est'] ?? '',
                                'valuation_support' => $request['data']['i']['val'] ?? '',
                                'notes' => $request['data']['i']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.j')) {
                        $keyRoles1 = PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['j']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyInception::where('policy_id', $policy->id)->where('asset_class', $request['data']['j']['asset_class'])->update([
                                'asset_class' => $request['data']['j']['asset_class'],
                                'included' => isset($request['data']['j']['included']) && $request['data']['j']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['j']['est'] ?? '',
                                'valuation_support' => $request['data']['j']['val'] ?? '',
                                'notes' => $request['data']['j']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyInception::create([
                                'asset_class' => $request['data']['j']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['j']['included']) && $request['data']['j']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['j']['est'] ?? '',
                                'valuation_support' => $request['data']['j']['val'] ?? '',
                                'notes' => $request['data']['j']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }
                    
                    $response['next_section'] = self::$sections[15];
                    return $response;
                case self::$sections[15]:

                    if ($request->has('data.a')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['a']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['a']['asset_class'])->update([
                                'asset_class' => $request['data']['a']['asset_class'],
                                'included' => isset($request['data']['a']['included']) && $request['data']['a']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['a']['est'] ?? '',
                                'valuation_support' => $request['data']['a']['val'] ?? '',
                                'notes' => $request['data']['a']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['a']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['a']['included']) && $request['data']['a']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['a']['est'] ?? '',
                                'valuation_support' => $request['data']['a']['val'] ?? '',
                                'notes' => $request['data']['a']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.b')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['b']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['b']['asset_class'])->update([
                                'asset_class' => $request['data']['b']['asset_class'],
                                'included' => isset($request['data']['b']['included']) && $request['data']['b']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['b']['est'] ?? '',
                                'valuation_support' => $request['data']['b']['val'] ?? '',
                                'notes' => $request['data']['b']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['b']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['b']['included']) && $request['data']['b']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['b']['est'] ?? '',
                                'valuation_support' => $request['data']['b']['val'] ?? '',
                                'notes' => $request['data']['b']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.c')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['c']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['c']['asset_class'])->update([
                                'asset_class' => $request['data']['c']['asset_class'],
                                'included' => isset($request['data']['c']['included']) && $request['data']['c']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['c']['est'] ?? '',
                                'valuation_support' => $request['data']['c']['val'] ?? '',
                                'notes' => $request['data']['c']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['c']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['c']['included']) && $request['data']['c']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['c']['est'] ?? '',
                                'valuation_support' => $request['data']['c']['val'] ?? '',
                                'notes' => $request['data']['c']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.d')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['d']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['d']['asset_class'])->update([
                                'asset_class' => $request['data']['d']['asset_class'],
                                'included' => isset($request['data']['d']['included']) && $request['data']['d']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['d']['est'] ?? '',
                                'valuation_support' => $request['data']['d']['val'] ?? '',
                                'notes' => $request['data']['d']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['d']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['d']['included']) && $request['data']['d']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['d']['est'] ?? '',
                                'valuation_support' => $request['data']['d']['val'] ?? '',
                                'notes' => $request['data']['d']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.e')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['e']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['e']['asset_class'])->update([
                                'asset_class' => $request['data']['e']['asset_class'],
                                'included' => isset($request['data']['e']['included']) && $request['data']['e']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['e']['est'] ?? '',
                                'valuation_support' => $request['data']['e']['val'] ?? '',
                                'notes' => $request['data']['e']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['e']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['e']['included']) && $request['data']['e']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['e']['est'] ?? '',
                                'valuation_support' => $request['data']['e']['val'] ?? '',
                                'notes' => $request['data']['e']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.f')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['f']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['f']['asset_class'])->update([
                                'asset_class' => $request['data']['f']['asset_class'],
                                'included' => isset($request['data']['f']['included']) && $request['data']['f']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['f']['est'] ?? '',
                                'valuation_support' => $request['data']['f']['val'] ?? '',
                                'notes' => $request['data']['f']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['f']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['f']['included']) && $request['data']['f']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['f']['est'] ?? '',
                                'valuation_support' => $request['data']['f']['val'] ?? '',
                                'notes' => $request['data']['f']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }
                    
                    if ($request->has('data.g')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['g']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['g']['asset_class'])->update([
                                'asset_class' => $request['data']['g']['asset_class'],
                                'included' => isset($request['data']['g']['included']) && $request['data']['a']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['g']['est'] ?? '',
                                'valuation_support' => $request['data']['g']['val'] ?? '',
                                'notes' => $request['data']['g']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['g']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['g']['included']) && $request['data']['g']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['g']['est'] ?? '',
                                'valuation_support' => $request['data']['g']['val'] ?? '',
                                'notes' => $request['data']['g']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.h')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['h']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['h']['asset_class'])->update([
                                'asset_class' => $request['data']['h']['asset_class'],
                                'included' => isset($request['data']['h']['included']) && $request['data']['h']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['h']['est'] ?? '',
                                'valuation_support' => $request['data']['h']['val'] ?? '',
                                'notes' => $request['data']['h']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['h']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['h']['included']) && $request['data']['h']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['h']['est'] ?? '',
                                'valuation_support' => $request['data']['h']['val'] ?? '',
                                'notes' => $request['data']['h']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.i')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['i']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['i']['asset_class'])->update([
                                'asset_class' => $request['data']['i']['asset_class'],
                                'included' => isset($request['data']['i']['included']) && $request['data']['i']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['i']['est'] ?? '',
                                'valuation_support' => $request['data']['i']['val'] ?? '',
                                'notes' => $request['data']['i']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['i']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['i']['included']) && $request['data']['i']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['i']['est'] ?? '',
                                'valuation_support' => $request['data']['i']['val'] ?? '',
                                'notes' => $request['data']['i']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($request->has('data.j')) {
                        $keyRoles1 = PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['j']['asset_class'])->first();
                        if ($keyRoles1) {
                            PolicyOnGoing::where('policy_id', $policy->id)->where('asset_class', $request['data']['j']['asset_class'])->update([
                                'asset_class' => $request['data']['j']['asset_class'],
                                'included' => isset($request['data']['j']['included']) && $request['data']['j']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['j']['est'] ?? '',
                                'valuation_support' => $request['data']['j']['val'] ?? '',
                                'notes' => $request['data']['j']['note'] ?? '',
                                'updated_by' => $currentLoggedInUser
                            ]);
                        } else {
                            PolicyOnGoing::create([
                                'asset_class' => $request['data']['j']['asset_class'],
                                'policy_id' => $policy->id,
                                'included' => isset($request['data']['j']['included']) && $request['data']['j']['included'] == 'yes' ? 'yes' : 'no',
                                'est_of_portfolio' => $request['data']['j']['est'] ?? '',
                                'valuation_support' => $request['data']['j']['val'] ?? '',
                                'notes' => $request['data']['j']['note'] ?? '',
                                'added_by' => $currentLoggedInUser
                            ]);
                        }
                    }

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }

                    $response['next_section'] = self::$sections[16];
                    return $response;
                case self::$sections[16]:

                    if (PolicyInvestmentNote::where('policy_id', $policy->id)->exists()) {
                        PolicyInvestmentNote::where('policy_id', $policy->id)->update([
                            'date_of_change_portfolio' => date('Y-m-d H:i:s', strtotime($request['data']['portfolio_change_date'] ?? '')),
                            'portfolio_change' => $request['data']['portfolio_change'] ?? '',
                            'date_of_change_idf' => date('Y-m-d H:i:s', strtotime($request['data']['idf_change_date'] ?? '')),
                            'idf_change' => $request['data']['idf_change'] ?? '',
                            'date_of_change_transfer' => date('Y-m-d H:i:s', strtotime($request['data']['asset_transfer_date'] ?? '')),
                            'transfer_change' => $request['data']['asset_transfer_note'] ?? '',
                            'decision' => $request['data']['trustee_decisions'] ?? '',
                            'added_by' => $currentLoggedInUser
                        ]);
                    } else {
                        PolicyInvestmentNote::create([
                            'policy_id' => $policy->id,
                            'date_of_change_portfolio' => date('Y-m-d H:i:s', strtotime($request['data']['portfolio_change_date'] ?? '')),
                            'portfolio_change' => $request['data']['portfolio_change'] ?? '',
                            'date_of_change_idf' => date('Y-m-d H:i:s', strtotime($request['data']['idf_change_date'] ?? '')),
                            'idf_change' => $request['data']['idf_change'] ?? '',
                            'date_of_change_transfer' => date('Y-m-d H:i:s', strtotime($request['data']['asset_transfer_date'] ?? '')),
                            'transfer_change' => $request['data']['asset_transfer_note'] ?? '',
                            'decision' => $request['data']['trustee_decisions'] ?? '',
                            'added_by' => $currentLoggedInUser
                        ]);
                    }

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }

                    $response['next_section'] = self::$sections[17];
                    return $response;
                case self::$sections[17]:

                    if (PolicyCommunication::where('policy_id', $policy->id)->exists()) {
                        PolicyCommunication::where('policy_id', $policy->id)->update([
                            'type' => $request['data']['type'] ?? '',
                            'date' => date('Y-m-d H:i:s', strtotime($request['data']['date'] ?? '')),
                            'contact_person_involved' => $request['data']['contact_person'] ?? '',
                            'summary_of_discussion' => $request['data']['discussion'] ?? '',
                            'action_taken_or_next_step' => $request['data']['action_taken'] ?? '',
                            'internal_owners' => $request['data']['internal_owners'] ?? '',
                            'updated_by' => $currentLoggedInUser
                        ]);
                    } else {
                        PolicyCommunication::create([
                            'policy_id' => $policy->id,
                            'type' => $request['data']['type'] ?? '',
                            'date' => date('Y-m-d H:i:s', strtotime($request['data']['date'] ?? '')),
                            'contact_person_involved' => $request['data']['contact_person'] ?? '',
                            'summary_of_discussion' => $request['data']['discussion'] ?? '',
                            'action_taken_or_next_step' => $request['data']['action_taken'] ?? '',
                            'internal_owners' => $request['data']['internal_owners'] ?? '',
                            'added_by' => $currentLoggedInUser
                        ]);
                    }

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }

                    $response['next_section'] = self::$sections[18];
                    return $response;
                case self::$sections[18]:

                    if (PolicyCaseFileNote::where('policy_id', $policy->id)->exists()) {
                        PolicyCaseFileNote::where('policy_id', $policy->id)->update([
                            'policy_id' => $policy->id,
                            'date' => date('Y-m-d H:i:s', strtotime($request['data']['noted_at'] ?? '')),
                            'noted_by' => $request['data']['noted_by'] ?? '',
                            'notes' => $request['data']['note'] ?? '',
                            'updated_by' => $currentLoggedInUser
                        ]);
                    } else {
                        PolicyCaseFileNote::create([
                            'policy_id' => $policy->id,
                            'date' => date('Y-m-d H:i:s', strtotime($request['data']['noted_at'] ?? '')),
                            'noted_by' => $request['data']['noted_by'] ?? '',
                            'notes' => $request['data']['note'] ?? '',
                            'added_by' => $currentLoggedInUser
                        ]);
                    }

                    if ($savingType == 'draft') {
                        $policy->silent_save = 0;
                        $policy->status = 0;
                        $policy->save();

                        session()->forget('new_policy');
                    }

                    $response['next_section'] = null;
                    return $response;
                default:
                }
            }
        }

        return [
            'errors' => [
                'policy' => [
                    'Curreny policy session is expired! Please try again!'
                ]
            ]
        ];
    }

}