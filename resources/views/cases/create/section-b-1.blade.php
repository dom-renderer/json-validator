<div class="mt-4">
    <form id="form-section-b-1">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Select Policy Holder: @requiredField </label>
            <div class="col-sm-9">
                <select name="policy_holder_id" id="policy_holder_id" required>
                    @if(isset($polhol['holder']['id']))
                        <option value="{{  $polhol['holder']['id']  }}"> {{  $polhol['holder']['name']  }} </option>
                    @endif
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Policyholder Type: @requiredField </label>
            <div class="col-sm-9">
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-type" name="type" type="radio" value="entity" id="stts-entity" checked required> <label for="stts-entity"> Entity </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-type" name="type" type="radio" value="individual" id="stts-individual" @if(isset($polhol['holder']['id']) && $polhol['holder']['type'] == 'individual') checked @endif required> <label for="stts-individual"> Individual </label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Policyholder Full Legal Name: @requiredField </label>
            <div class="col-sm-9">
                <input type="text" class="form-control section-b-1-policyholder-name" id="name" name="name" value="{{  isset($polhol['holder']['id']) ? ($polhol['holder']['name']) : ''  }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name of Controlling Person(s): @requiredField </label>
            <div class="col-sm-9">
                <input type="text" class="form-control section-b-1-controlling-person" id="controlling_person_name" name="controlling_person_name" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['controlling_person_name']) : '' }}" readonly required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Place Of Birth/ Establishment: @requiredField </label>
            <div class="col-sm-5">
                <input type="text" class="form-control section-b-1-place-birth" name="place_of_birth" id="place_of_birth" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['place_of_birth']) : '' }}" required>
            </div>
            <label class="col-sm-2 col-form-label">Date Of Birth/ Establishment: @requiredField </label>
            <div class="col-sm-2">
                <input type="text" class="form-control section-b-1-date-birth" readonly  name="dob" id="dob" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['dob']) : '' }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Country: @requiredField </label>
            <div class="col-sm-9">
                <input type="text" name="country" id="country" class="form-control section-b-1-country" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['country']) : '' }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-1 col-form-label">City: @requiredField </label>
            <div class="col-sm-5">
                <input type="text" name="city" id="city" class="form-control section-b-1-city" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['city']) : '' }}" required>
            </div>
            <label class="col-sm-3 col-form-label">Postcode/ ZIP: @requiredField </label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-zip" name="zipcode" id="zipcode" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['zipcode']) : '' }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Residential/ Registered Address: @requiredField </label>
            <div class="col-sm-9">
                <input type="text" class="form-control section-b-1-address" name="address_line_1" id="address_line_1" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['address_line_1']) : '' }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Status: @requiredField </label>
            <div class="col-sm-9">
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="single" id="stts-single" checked> <label for="stts-single"> Single </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="married" id="stts-married" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'married') checked @endif> <label for="stts-married"> Married </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="divorced" id="stts-divorced" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'divorced') checked @endif> <label for="stts-divorced"> Divorced </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="separated" id="stts-separated"> <label for="stts-separated" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'separated') checked @endif> Separated </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="corporation" id="stts-corp"> <label for="stts-corp" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'corporation') checked @endif> Corporation </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="llc" id="stts-llc"> <label for="stts-llc" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'llc') checked @endif> LLC </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="trust" id="stts-trust"> <label for="stts-trust" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'trust') checked @endif> Trust </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="partnership" id="stts-prtnr"> <label for="stts-prtnr" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'partnership') checked @endif> Partnership </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="foundation" id="stts-fndtion"> <label for="stts-fndtion" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'foundation') checked @endif> Foundation </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="other" id="stts-other"> <label for="stts-other" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'other') checked @endif> Other </label>
                </div>
                <div class="form-group mt-2">
                    <input type="text" class="form-control section-b-1-status-other @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] != 'other') d-none @endif" @if(isset($polhol['holder']['id']) && $polhol['holder']['status'] == 'other') value="{{ $polhol['holder']['status_name'] }}" @endif placeholder="Other (specify)">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Nationality/ Country of Registration: @requiredField </label>
            <div class="col-sm-5">
                <input type="text" class="form-control section-b-1-nationality" name="national_country_of_registration" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['national_country_of_registration']) : '' }}" required>
            </div>
            <label class="col-sm-1 col-form-label">Gender: @requiredField </label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-gender" id="stts-male" type="radio" name="gender" value="male" checked> Male
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-gender" id="stts-female" type="radio" name="gender" value="female" @if(isset($polhol['holder']['id']) && $polhol['holder']['gender'] == 'female') checked @endif> Female
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Country of Legal Residence/ Domicile: @requiredField </label>
            <div class="col-sm-9">
                <input type="text" class="form-control section-b-1-legal-residence" name="country_of_legal_residence" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['country_of_legal_residence']) : '' }}" required>
            </div>
        </div>
        <div class="row mb-3 section-b-1-country-tax-residence-row">
            <label class="col-sm-3 col-form-label">Countries of Tax Residence: @requiredField </label>
            <div class="col-sm-7">
                <input type="text" class="form-control section-b-1-country-tax-residence" name="all_countries[]" required>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-success section-b-1-add">+</button>
                <button type="button" class="btn btn-danger section-b-1-remove">-</button>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Passport Number: @requiredField </label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-passport" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['passport_number']) : '' }}" name="passport_number" required>
            </div>
            <label class="col-sm-3 col-form-label">Country of Issuance: @requiredField </label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-passport-issue-country" name="country_of_issuance" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['country_of_issuance']) : '' }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Tax Identification Number (TIN): @requiredField </label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-tin" name="tin" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['tin']) : '' }}" required>
            </div>
            <label class="col-sm-3 col-form-label">Legal Entity Identifier (LEI) or Other: @requiredField </label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-lei" name="lei" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['lei']) : '' }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">E-Mail: @requiredField </label>
            <div class="col-sm-9">
                <input type="email" class="form-control section-b-1-email" name="email" value="{{ isset($polhol['holder']['id']) ? ($polhol['holder']['email']) : '' }}" required>
            </div>
        </div>

        <div class="mb-3 float-end">
            {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
            <button type="submit" data-type="next" data-next="section-b-2" class="btn btn-primary save-next">Save & Next</button>
        </div>
    </form>
</div>