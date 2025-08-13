<form id="form-section-g-2">

    <div class="row mb-3 align-items-center">
        <div class="col-2">
            <label for="sg2-date" class="fw-bold"> Date of Note : </label>
        </div>
        <div class="col-10">
            <input type="text" name="noted_at" id="sg2-date" class="form-control" readonly required>
        </div>
    </div>

    <div class="row mb-3 align-items-center">
        <div class="col-2">
            <label for="sg2-notedby" class="fw-bold"> Note By : </label>
        </div>
        <div class="col-10">
            <input type="text" name="noted_by" id="sg2-notedby" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3 align-items-center">
        <div class="col-2">
            <label for="sg2-note" class="fw-bold"> Note(s) : </label>
        </div>
        <div class="col-10">
            <textarea name="note" id="sg2-note" class="form-control" rows="10" required></textarea>
        </div>
    </div>

    <div class="mb-3 float-end">
        {{-- <button type="submit" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-g-2" data-final="yes" class="btn btn-primary save-next">Save</button>
    </div>
</form>