<form id="form-section-g-1">
    
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Communication Date</label>
        <div class="col-sm-4 d-flex">
            <input type="text" class="form-control" name="date" id="sg1date" readonly>
        </div>
        <label class="col-sm-2 col-form-label">Communication Type</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="type" id="sg1type">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Contact Person(s) Involved</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="contact_person" id="sg1involved">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Summary of Discussion</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="discussion" id="sg1discussion"></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Action Taken/ Next Steps</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="5" name="action_taken" id="sg1actiontaken"></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Internal Owner(s)</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="internal_owners">
        </div>
    </div>

    <div class="mb-3 float-end">
        {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-g-2" class="btn btn-primary save-next">Save & Next</button>
    </div>

</form>