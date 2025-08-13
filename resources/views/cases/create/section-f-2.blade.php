<form id="form-section-f-2">

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Policy Type</label>
            <div class="col-sm-4">
                <select class="form-select" name="type" required>
                    <option @if(isset($f2Data->policy_type) && $f2Data->policy_type == 'deferred_annuity') selected @endif value="deferred_annuity">Deferred Annuity</option>
                    <option @if(isset($f2Data->policy_type) && $f2Data->policy_type == 'whole_life') selected @endif value="whole_life">Whole Life</option>
                    <option @if(isset($f2Data->policy_type) && $f2Data->policy_type == 'term_life') selected @endif value="term_life">Term Life</option>
                    <option @if(isset($f2Data->policy_type) && $f2Data->policy_type == 'universal_life') selected @endif value="universal_life">Universal Life</option>
                </select>
            </div>
        </div>

        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Description</th>
                    <th>Amount (USD or relevant currency)</th>
                    <th>Notes<br><small>(based on initial illustration basis, confirmed transfer)</small></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Proposed Premium</td>
                    <td><input type="number" min="0" step="0.01" class="form-control" name="proposed_premium" value="{{ $f2Data->proposed_premium_amount ?? 0 }}"></td>
                    <td><textarea class="form-control" rows="2" name="proposed_premium_note" required>{{ $f2Data->proposed_premium_note ?? '' }}</textarea></td>
                </tr>
                <tr>
                    <td>Final Premium</td>
                    <td><input type="number" min="0" step="0.01" class="form-control" name="final_premium" value="{{ $f2Data->final_premium_amount ?? 0 }}"></td>
                    <td><textarea class="form-control" rows="2" name="final_premium_note" required>{{ $f2Data->final_premium_note ?? '' }}</textarea></td>
                </tr>
                <tr>
                    <td>Premium Frequency</td>
                    <td colspan="2">
                        <select class="form-select" name="premium_frequency">
                            <option @if(isset($f2Data->premium_frequency) && $f2Data->premium_frequency == 'annual') selected @endif value="annual">Annual</option>
                            <option @if(isset($f2Data->premium_frequency) && $f2Data->premium_frequency == 'semi-annual') selected @endif value="semi-annual">Semi-Annual</option>
                            <option @if(isset($f2Data->premium_frequency) && $f2Data->premium_frequency == 'quarterly') selected @endif value="quarterly">Quarterly</option>
                            <option @if(isset($f2Data->premium_frequency) && $f2Data->premium_frequency == 'monthly') selected @endif value="monthly">Monthly</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Premium Years (No. of Years of Expected Premium)</td>
                    <td colspan="2"><input type="number" min="0" name="premium_years" class="form-control" value="{{ $f2Data->premium_years ?? 0 }}"></td>
                </tr>
            </tbody>
        </table>

<div class="mb-3 float-end">
    {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
    <button type="submit" data-type="next" data-next="section-f-3" class="btn btn-primary save-next">Save & Next</button>
</div>
</form>