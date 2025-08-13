<form id="form-section-a-2">

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Controlling Person Full Legal Name @requiredField </label>
        <div class="col-sm-8">
            <input type="text" name="full_legal_name" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Place Of Birth @requiredField </label>
        <div class="col-sm-4">
            <input type="text" name="place_of_birth" class="form-control" required>
        </div>
        <label class="col-sm-2 col-form-label">Date Of Birth @requiredField </label>
        <div class="col-sm-2">
            <input type="date" name="dob" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Residential Address @requiredField </label>
        <div class="col-sm-8">
            <input type="text" name="residential_address" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Country @requiredField </label>
        <div class="col-sm-4">
            <select id="section-b-2-country_id" name="country_id" class="form-select" required></select>
        </div>
        <label class="col-sm-1 col-form-label">State @requiredField </label>
        <div class="col-sm-3">
            <select id="section-b-2-state_id" name="state_id" class="form-select" required></select>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">City @requiredField </label>
        <div class="col-sm-4">
            <select id="section-b-2-city_id" name="city_id" class="form-select" required></select>
        </div>
        <label class="col-sm-1 col-form-label">Postcode/ZIP @requiredField </label>
        <div class="col-sm-3">
            <input type="text" name="zip" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Status @requiredField </label>
        <div class="col-sm-8">
            <div class="form-check form-check-inline"><input type="radio" name="status" value="Single" class="form-check-input" id="sb2single" checked><label for="sb2single" class="form-check-label">Single</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="status" value="Married" class="form-check-input" id="sb2married"><label for="sb2married" class="form-check-label">Married</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="status" value="Divorced" class="form-check-input" id="sb2divorced"><label for="sb2divorced" class="form-check-label">Divorced</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="status" value="Separated" class="form-check-input" id="sb2separated"><label for="sb2separated" class="form-check-label">Separated</label></div>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Smoker Status @requiredField </label>
        <div class="col-sm-8">
            <div class="form-check form-check-inline"><input type="radio" name="smoker_status" value="Smoker" class="form-check-input" id="sba2smoker" checked><label for="sba2smoker" class="form-check-label">Smoker</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="smoker_status" value="Non-Smoker" class="form-check-input" id="sba2nonesmoker"><label for="sba2nonesmoker" class="form-check-label">Non-Smoker</label></div>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Nationality @requiredField </label>
        <div class="col-sm-4">
            <input type="text" name="nationality" class="form-control" required>
        </div>
        <label class="col-sm-2 col-form-label">Gender @requiredField </label>
        <div class="col-sm-2">
            <div class="form-check form-check-inline"><input type="radio" name="gender" value="Male" class="form-check-input" checked id="sba2male"><label for="sba2male" class="form-check-label">Male</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="gender" value="Female" class="form-check-input" id="sba2female"><label for="sba2female" class="form-check-label">Female</label></div>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Country of Legal Residence @requiredField </label>
        <div class="col-sm-8">
            <select id="section-b-2-country_legal_residence" name="country_legal_residence" class="form-select" required></select>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Countries of Tax Residence @requiredField </label>
        <div class="col-sm-8" id="section-b-2-tax-residence-wrapper">
            <div class="input-group mb-2 section-b-2-tax-residence-row">
                <select name="countries_tax_residence[]" class="form-select section-b-2-countries-tax" required></select>
                <button type="button" class="btn btn-success section-b-2-add-tax">+</button>
                <button type="button" class="btn btn-danger section-b-2-remove-tax">-</button>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Passport Number </label>
        <div class="col-sm-4">
            <input type="text" name="passport_number" class="form-control" required>
        </div>
        <label class="col-sm-2 col-form-label">Country of Issuance </label>
        <div class="col-sm-2">
            <select id="section-b-2-country_issuance" name="country_issuance" class="form-select" required></select>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Relationship to Policyholder @requiredField </label>
        <div class="col-sm-8">
            <input type="text" name="relationship" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-4 col-form-label">E-Mail @requiredField </label>
        <div class="col-sm-8">
            <input type="email" name="email" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 float-end">
        {{-- <button type="submit" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-c-1" class="btn btn-primary save-next">Save & Next</button>
    </div>    
</form>