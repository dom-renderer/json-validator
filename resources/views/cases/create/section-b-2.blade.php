<form id="form-section-b-2">

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Controlling Person Full Legal Name: @requiredField </label>
        <div class="col-sm-9">
            <input type="text" class="form-control secction-b-2-policyholder-name" id="name" name="name" value="{{  isset($polhol['id']) ? ($polhol['name']) : ''  }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Place Of Birth: @requiredField </label>
        <div class="col-sm-5">
            <input type="text" class="form-control secction-b-2-place-birth" name="place_of_birth" id="place_of_birth" value="{{ isset($polhol['id']) ? ($polhol['place_of_birth']) : '' }}" required>
        </div>
        <label class="col-sm-2 col-form-label">Date Of Birth: @requiredField </label>
        <div class="col-sm-2">
            <input type="text" class="form-control secction-b-2-date-birth" readonly  name="dob" id="dob-b-2" value="{{ isset($polhol['id']) ? ($polhol['dob']) : '' }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Residential Address: @requiredField </label>
        <div class="col-sm-9">
            <input type="text" class="form-control secction-b-2-address" name="address_line_1" id="address_line_1" value="{{ isset($polhol['id']) ? ($polhol['address_line_1']) : '' }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Country: @requiredField </label>
        <div class="col-sm-9">
            <input type="text" name="country" id="country" class="form-control secction-b-2-country" value="{{ isset($polhol['id']) ? ($polhol['country']) : '' }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-1 col-form-label">City: @requiredField </label>
        <div class="col-sm-5">
            <input type="text" name="city" id="city" class="form-control secction-b-2-city" value="{{ isset($polhol['id']) ? ($polhol['city']) : '' }}" required>
        </div>
        <label class="col-sm-3 col-form-label">Postcode/ ZIP: @requiredField </label>
        <div class="col-sm-3">
            <input type="text" class="form-control secction-b-2-zip" name="zipcode" id="zipcode" value="{{ isset($polhol['id']) ? ($polhol['zipcode']) : '' }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Status: @requiredField </label>
        <div class="col-sm-9">
            <div class="form-check form-check-inline">
                <input class="form-check-input secction-b-2-status" name="status" type="radio" value="single" id="stts-single-b-2" checked> <label for="stts-single-b-2"> Single </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input secction-b-2-status" name="status" type="radio" value="married" id="stts-married-b-2" @if(isset($polhol['id']) && $polhol['status'] == 'married') checked @endif> <label for="stts-married-b-2"> Married </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input secction-b-2-status" name="status" type="radio" value="divorced" id="stts-divorced-b-2" @if(isset($polhol['id']) && $polhol['status'] == 'divorced') checked @endif> <label for="stts-divorced-b-2"> Divorced </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input secction-b-2-status" name="status" type="radio" value="separated" id="stts-separated-b-2"> <label for="stts-separated-b-2" @if(isset($polhol['id']) && $polhol['status'] == 'separated') checked @endif> Separated </label>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Smoker Status: @requiredField </label>
        <div class="col-sm-9">
            <div class="form-check form-check-inline">
                <input class="form-check-input secction-b-2-smoker-status" name="smoker_status" type="radio" value="smoker" id="stts-smoker" checked> <label for="stts-smoker"> Smoker </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input secction-b-2-smoker-status" name="smoker_status" type="radio" value="non-smoker" id="stts-non-smoker" @if(isset($polhol['id']) && $polhol['smoker_status'] == 'non-smoker') checked @endif> <label for="stts-non-smoker"> Non-Smoker </label>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Nationality: @requiredField </label>
        <div class="col-sm-5">
            <input type="text" class="form-control secction-b-2-nationality" name="national_country_of_registration" value="{{ isset($polhol['id']) ? ($polhol['national_country_of_registration']) : '' }}" required>
        </div>
        <label class="col-sm-1 col-form-label">Gender: @requiredField </label>
        <div class="col-sm-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input secction-b-2-gender" id="stts-male" type="radio" name="gender" value="male" checked> Male
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input secction-b-2-gender" id="stts-female" type="radio" name="gender" value="female" @if(isset($polhol['id']) && $polhol['gender'] == 'female') checked @endif> Female
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Country of Legal Residence: @requiredField </label>
        <div class="col-sm-9">
            <input type="text" class="form-control secction-b-2-legal-residence" name="country_of_legal_residence" value="{{ isset($polhol['id']) ? ($polhol['country_of_legal_residence']) : '' }}" required>
        </div>
    </div>
    <div class="row mb-3 secction-b-2-country-tax-residence-row">
        <label class="col-sm-3 col-form-label">Countries of Tax Residence: @requiredField </label>
        <div class="col-sm-7">
            <input type="text" class="form-control secction-b-2-country-tax-residence" name="all_countries[]" required>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-success secction-b-2-add">+</button>
            <button type="button" class="btn btn-danger secction-b-2-remove">-</button>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Passport Number: @requiredField </label>
        <div class="col-sm-3">
            <input type="text" class="form-control secction-b-2-passport" value="{{ isset($polhol['id']) ? ($polhol['passport_number']) : '' }}" name="passport_number" required>
        </div>
        <label class="col-sm-3 col-form-label">Country of Issuance: @requiredField </label>
        <div class="col-sm-3">
            <input type="text" class="form-control secction-b-2-passport-issue-country" name="country_of_issuance" value="{{ isset($polhol['id']) ? ($polhol['country_of_issuance']) : '' }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Relationship to Policyholder @requiredField </label>
        <div class="col-sm-8">
            <input type="text" name="relationship_to_policyholder" class="form-control" value="{{ isset($polhol['id']) ? ($polhol['relationship_to_policyholder']) : '' }}" required>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">E-Mail: @requiredField </label>
        <div class="col-sm-9">
            <input type="email" class="form-control secction-b-2-email" name="email" value="{{ isset($polhol['id']) ? ($polhol['email']) : '' }}" required>
        </div>
    </div>

    <div class="mb-3 float-end">
        {{-- <button type="submit" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-c-1" class="btn btn-primary save-next">Save & Next</button>
    </div>    
</form>