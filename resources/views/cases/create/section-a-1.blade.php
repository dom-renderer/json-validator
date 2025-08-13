<form id="form-section-a-1">
    <div class="mb-3">
        <label class="form-label fw-bold">Please select type of Introducer @requiredField </label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="section_a_1_entity" id="section-a-1-entity" value="Entity" @if($introducer['type'] == 'entity') checked @endif>
                <label class="form-check-label" for="section-a-1-entity">Entity</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="section_a_1_entity" id="section-a-1-individual" value="Individual" @if($introducer['type'] == 'individual' || $introducer['type'] != 'entity') checked @endif >
                <label class="form-check-label" for="section-a-1-individual">Individual</label>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Introducer Full Name <span id="8b63dr9t"> (Individual) </span> 
        @requiredField
        </label>
        <input type="text" class="form-control" name="section_a_1_name" placeholder="Please enter full name" value="{{ $introducer['name'] }}">
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label fw-bold">Email @requiredField </label>
            <input type="email" class="form-control" name="section_a_1_email" placeholder="Please enter email address" value="{{ $introducer['email'] }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold">Contact Number @requiredField </label>
            <input type="hidden" id="section-a-1-dial_code" name="section_a_1_dial_code" value="{{ $introducer['dial_code'] }}">
            <input type="tel" class="form-control" name="section_a_1_phone" id="section-a-1-phone_number" value="{{ $introducer['contact_number'] }}" required>
        </div>
    </div>

    <div class="mb-3 float-end">
        {{-- <button type="submit" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-a-2" class="btn btn-primary save-next">Save & Next</button>
    </div>
</form>