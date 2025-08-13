<div class="mt-4">
    <form id="form-section-b-1">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Select Policy Holder: @requiredField </label>
            <div class="col-sm-9">
                <select name="policy_holder_id" id="policy_holder_id"></select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Policyholder Type: @requiredField </label>
            <div class="col-sm-9">
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-type" name="type" type="radio" value="entity" id="stts-entity" checked> <label for="stts-entity"> Entity </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-type" name="type" type="radio" value="individual" id="stts-individual" checked> <label for="stts-individual"> Individual </label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Policyholder Full Legal Name: @requiredField </label>
            <div class="col-sm-9">
                <input type="text" class="form-control section-b-1-policyholder-name" id="name" name="name" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name of Controlling Person(s): @requiredField </label>
            <div class="col-sm-9">
                <input type="text" class="form-control section-b-1-controlling-person" id="controlling_person_name" name="controlling_person_name" readonly required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Place Of Birth/ Establishment: @requiredField </label>
            <div class="col-sm-5">
                <input type="text" class="form-control section-b-1-place-birth" name="place_of_birth" id="place_of_birth" required>
            </div>
            <label class="col-sm-2 col-form-label">Date Of Birth/ Establishment: @requiredField </label>
            <div class="col-sm-2">
                <input type="text" class="form-control section-b-1-date-birth" readonly  name="dob" id="dob" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Country: @requiredField </label>
            <div class="col-sm-9">
                <select name="country" id="country" class="section-b-1-country" required></select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-1 col-form-label">City: @requiredField </label>
            <div class="col-sm-5">
                <select name="city" id="city" class="section-b-1-city"></select>
            </div>
            <label class="col-sm-3 col-form-label">Postcode/ ZIP: @requiredField </label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-zip" name="zipcode" id="zipcode" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Residential/ Registered Address: @requiredField </label>
            <div class="col-sm-9">
                <input type="text" class="form-control section-b-1-address" name="address_line_1" id="address_line_1" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Status: @requiredField </label>
            <div class="col-sm-9">
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="Single" id="stts-single" checked> <label for="stts-single"> Single </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="Married" id="stts-married"> <label for="stts-married"> Married </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="Divorced" id="stts-divorced"> <label for="stts-divorced"> Divorced </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="Separated" id="stts-separated"> <label for="stts-separated"> Separated </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="Corporation" id="stts-corp"> <label for="stts-corp"> Corporation </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="LLC" id="stts-llc"> <label for="stts-llc"> LLC </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="Trust" id="stts-trust"> <label for="stts-trust"> Trust </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="Partnership" id="stts-prtnr"> <label for="stts-prtnr"> Partnership </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-status" name="status" type="radio" value="Foundation" id="stts-fndtion"> <label for="stts-fndtion"> Foundation </label>
                </div>
                <div class="form-group mt-2">
                    <input type="text" class="form-control section-b-1-status-other" placeholder="Other (specify)">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Nationality/ Country of Registration:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control section-b-1-nationality">
            </div>
            <label class="col-sm-1 col-form-label">Gender:</label>
            <div class="col-sm-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-gender" type="radio" name="gender" value="Male"> Male
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input section-b-1-gender" type="radio" name="gender" value="Female"> Female
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Country of Legal Residence/ Domicile:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control section-b-1-legal-residence">
            </div>
        </div>
        <div class="row mb-3 section-b-1-country-tax-residence-row">
            <label class="col-sm-3 col-form-label">Countries of Tax Residence:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control section-b-1-country-tax-residence">
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-success section-b-1-add">+</button>
                <button type="button" class="btn btn-danger section-b-1-remove">-</button>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Passport Number:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-passport">
            </div>
            <label class="col-sm-3 col-form-label">Country of Issuance:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-passport-issue-country">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Tax Identification Number (TIN):</label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-tin">
            </div>
            <label class="col-sm-3 col-form-label">Legal Entity Identifier (LEI) or Other:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control section-b-1-lei">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">E-Mail:</label>
            <div class="col-sm-9">
                <input type="email" class="form-control section-b-1-email">
            </div>
        </div>

        <div class="mb-3 float-end">
            {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
            <button type="submit" data-type="next" data-next="section-b-2" class="btn btn-primary save-next">Save & Next</button>
        </div>
    </form>
</div>