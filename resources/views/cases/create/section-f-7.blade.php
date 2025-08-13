<form id="form-section-f-7">
    
     <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Date of Change</label>
        <div class="col-sm-3">
            <input type="date" class="form-control section-b-2-date" name="portfolio_change_date" required>
        </div>
    </div>

     <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Portfolio Change</label>
        <div class="col-sm-9 mt-2">
            <textarea class="form-control section-b-2-portfolio" name="portfolio_change" rows="2" required></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Date of Change</label>
        <div class="col-sm-3">
            <input type="date" class="form-control section-b-2-date" name="idf_change_date" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">IDF or Investment Manager Change</label>
        <div class="col-sm-9 mt-2">
            <textarea class="form-control section-b-2-idf" name="idf_change" rows="2" required></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Date of Change</label>
        <div class="col-sm-3">
            <input type="date" class="form-control section-b-2-date" name="asset_transfer_date" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Asset Transfer or Liquidity Events</label>
        <div class="col-sm-3">
            <textarea class="form-control section-b-2-transfer" name="asset_transfer_note" rows="4" required></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Relevant Policyholder/ Board/ Trustee Decisions</label>
        <div class="col-sm-9">
            <textarea class="form-control section-b-2-decisions" name="trustee_decisions" rows="4" required></textarea>
        </div>
    </div>

    <div class="mb-3 float-end">
        {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-g-1" class="btn btn-primary save-next">Save & Next</button>
    </div>

</form>