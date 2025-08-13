<form id="form-section-f-3">

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Fee Provided by</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="fee_provided_by" value="{{ $f3Data->fee_provided_by ?? '' }}">
        </div>
        <label class="col-sm-2 col-form-label">Date Fee Provided</label>
        <div class="col-sm-4">
            <input type="text" id="f3d1" name="fee_provided_by_date" class="form-control" value="{{ isset($f3Data->date_fee_provided) ? date('Y-m-d', strtotime($f3Data->date_fee_provided)) : '' }}" readonly required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Controlling Person Fee Approved by</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="fee_approved_by" value="{{ $f3Data->controlling_person_fee_approved_by ?? '' }}">
        </div>
        <label class="col-sm-2 col-form-label">Date Fee Approved</label>
        <div class="col-sm-4">
            <input type="text" id="f3d2" name="fee_approved_by_date" class="form-control" value="{{ isset($f3Data->date_fee_approved) ? date('Y-m-d', strtotime($f3Data->date_fee_approved)) : '' }}" readonly required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">GII Fee Approved by</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="gii_fee_approved_by" value="{{ $f3Data->gii_fee_approved_by ?? '' }}">
        </div>
        <label class="col-sm-2 col-form-label">Date Fee Approved</label>
        <div class="col-sm-4">
            <input type="text" id="f3d3" name="gii_fee_approved_by_date" class="form-control" value="{{ isset($f3Data->gii_date_fee_approved) ? date('Y-m-d', strtotime($f3Data->gii_date_fee_approved)) : '' }}" readonly required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Fee Approval Notes</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="2" name="approval_notes">{{ $f3Data->fee_approval_notes ?? '' }}</textarea>
            <small class="text-muted">
                Notes including communication channel (email, Teams/Zoom/Remote call, telephone call), date, time and any other details.
            </small>
        </div>
    </div>

    <table class="table table-bordered align-middle mt-3">
        <thead class="table-light text-center">
            <tr>
                <th>Fee Type</th>
                <th>Frequency</th>
                <th>Amount/Rate</th>
                <th>Commission Split</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @php
                    $a = $f3Data?->items()?->where('type', 'setup_fee')->count() > 0 ? $f3Data?->items()?->where('type', 'setup_fee')->first()->toArray() : [];
                @endphp
                <td>Set-up Fee</td>
                <td>
                    <input type="hidden" name="a[type]" value="setup_fee">
                    <select class="form-select" name="a[frequency]">
                        <option @if(isset($a['frequency']) && $a['frequency'] == 'monthly') selected @endif value="monthly">Monthly</option>
                        <option @if(isset($a['frequency']) && $a['frequency'] == 'bi-monthly') selected @endif value="bi-monthly">Bi-Monthly</option>
                        <option @if(isset($a['frequency']) && $a['frequency'] == 'quarterly') selected @endif value="quarterly">Quarterly</option>
                        <option @if(isset($a['frequency']) && $a['frequency'] == 'semi-annually') selected @endif value="semi-annually">Semi-Annually</option>
                        <option @if(isset($a['frequency']) && $a['frequency'] == 'anually') selected @endif value="anually">Annually</option>
                    </select>
                </td>
                <td><input type="number" min="0" name="a[amount]" step="0.01" class="form-control" value="{{ isset($a['amount']) ? $a['amount'] : null }}"></td>
                <td><input type="number" min="0" name="a[commission_split]" step="0.01" max="100" class="form-control" value="{{ isset($a['commission_split']) ? $a['commission_split'] : null }}"></td>
                <td><textarea class="form-control" name="a[note]" rows="1">{{ isset($a['notes']) ? $a['notes'] : null }}</textarea></td>
            </tr>

            <tr>
                @php
                    $b = $f3Data?->items()?->where('type', 'me_fee')->count() > 0 ? $f3Data?->items()?->where('type', 'me_fee')->first()->toArray() : [];
                @endphp
                <td>Administration or M&E Fee</td>
                <td>
                    <input type="hidden" name="b[type]" value="me_fee">
                    <select class="form-select" name="b[frequency]">
                        <option @if(isset($b['frequency']) && $b['frequency'] == 'monthly') selected @endif value="monthly">Monthly</option>
                        <option @if(isset($b['frequency']) && $b['frequency'] == 'bi-monthly') selected @endif value="bi-monthly">Bi-Monthly</option>
                        <option @if(isset($b['frequency']) && $b['frequency'] == 'quarterly') selected @endif value="quarterly">Quarterly</option>
                        <option @if(isset($b['frequency']) && $b['frequency'] == 'semi-annually') selected @endif value="semi-annually">Semi-Annually</option>
                        <option @if(isset($b['frequency']) && $b['frequency'] == 'anually') selected @endif value="anually">Annually</option>
                    </select>
                </td>
                <td><input type="number" min="0" name="b[amount]" step="0.01" class="form-control" value="{{ isset($b['amount']) ? $b['amount'] : null }}"></td>
                <td><input type="number" min="0" name="b[commission_split]" step="0.01" max="100" class="form-control" value="{{ isset($b['commission_split']) ? $b['commission_split'] : null }}"></td>
                <td><textarea class="form-control" name="b[note]" rows="1">{{ isset($b['notes']) ? $b['notes'] : null }}</textarea></td>
            </tr>

            <tr>
                @php
                    $c = $f3Data?->items()?->where('type', 'coi')->count() > 0 ? $f3Data?->items()?->where('type', 'coi')->first()->toArray() : [];
                @endphp
                <td>COI</td>
                <td>
                    <input type="hidden" name="c[type]" value="coi">
                    <select class="form-select" name="c[frequency]">
                        <option @if(isset($c['frequency']) && $c['frequency'] == 'monthly') selected @endif value="monthly">Monthly</option>
                        <option @if(isset($c['frequency']) && $c['frequency'] == 'bi-monthly') selected @endif value="bi-monthly">Bi-Monthly</option>
                        <option @if(isset($c['frequency']) && $c['frequency'] == 'quarterly') selected @endif value="quarterly">Quarterly</option>
                        <option @if(isset($c['frequency']) && $c['frequency'] == 'semi-annually') selected @endif value="semi-annually">Semi-Annually</option>
                        <option @if(isset($c['frequency']) && $c['frequency'] == 'anually') selected @endif value="anually">Annually</option>
                    </select>
                </td>
                <td><input type="number" min="0" name="c[amount]" step="0.01" class="form-control" value="{{ isset($c['amount']) ? $c['amount'] : null }}"></td>
                <td><input type="number" min="0" name="c[commission_split]" step="0.01" max="100" class="form-control" value="{{ isset($c['commission_split']) ? $c['commission_split'] : null }}"></td>
                <td><textarea class="form-control" name="c[note]" rows="1">{{ isset($c['notes']) ? $c['notes'] : null }}</textarea></td>
            </tr>

            <tr>
                @php
                    $d = $f3Data?->items()?->where('type', 'dac_fee')->count() > 0 ? $f3Data?->items()?->where('type', 'dac_fee')->first()->toArray() : [];
                @endphp
                <td>DAC Fee</td>
                <td>
                    <input type="hidden" name="d[type]" value="dac_fee">
                    <select class="form-select" name="d[frequency]">
                        <option @if(isset($d['frequency']) && $d['frequency'] == 'monthly') selected @endif value="monthly">Monthly</option>
                        <option @if(isset($d['frequency']) && $d['frequency'] == 'bi-monthly') selected @endif value="bi-monthly">Bi-Monthly</option>
                        <option @if(isset($d['frequency']) && $d['frequency'] == 'quarterly') selected @endif value="quarterly">Quarterly</option>
                        <option @if(isset($d['frequency']) && $d['frequency'] == 'semi-annually') selected @endif value="semi-annually">Semi-Annually</option>
                        <option @if(isset($d['frequency']) && $d['frequency'] == 'anually') selected @endif value="anually">Annually</option>
                    </select>
                </td>
                <td><input type="number" min="0" name="d[amount]" step="0.01" class="form-control" value="{{ isset($d['amount']) ? $d['amount'] : null }}"></td>
                <td><input type="number" min="0" name="d[commission_split]" step="0.01" max="100" class="form-control" value="{{ isset($d['commission_split']) ? $d['commission_split'] : null }}"></td>
                <td><textarea class="form-control" name="d[note]" rows="1">{{ isset($d['notes']) ? $d['notes'] : null }}</textarea></td>
            </tr>

            <tr>
                @php
                    $e = $f3Data?->items()?->where('type', 'crs_fee')->count() > 0 ? $f3Data?->items()?->where('type', 'crs_fee')->first()->toArray() : [];
                @endphp
                <td>FATCA/CRS Fee</td>
                <td>
                    <input type="hidden" name="e[type]" value="crs_fee">
                    <select class="form-select" name="e[frequency]">
                        <option @if(isset($e['frequency']) && $e['frequency'] == 'monthly') selected @endif value="monthly">Monthly</option>
                        <option @if(isset($e['frequency']) && $e['frequency'] == 'bi-monthly') selected @endif value="bi-monthly">Bi-Monthly</option>
                        <option @if(isset($e['frequency']) && $e['frequency'] == 'quarterly') selected @endif value="quarterly">Quarterly</option>
                        <option @if(isset($e['frequency']) && $e['frequency'] == 'semi-annually') selected @endif value="semi-annually">Semi-Annually</option>
                        <option @if(isset($e['frequency']) && $e['frequency'] == 'anually') selected @endif value="anually">Annually</option>
                    </select>
                </td>
                <td><input type="number" min="0" name="e[amount]" step="0.01" class="form-control" value="{{ isset($e['amount']) ? $e['amount'] : null }}"></td>
                <td><input type="number" min="0" name="e[commission_split]" step="0.01" max="100" class="form-control" value="{{ isset($e['commission_split']) ? $e['commission_split'] : null }}"></td>
                <td><textarea class="form-control" name="e[note]" rows="1">{{ isset($e['notes']) ? $e['notes'] : null }}</textarea></td>
            </tr>

            <tr>
                @php
                    $f = $f3Data?->items()?->where('type', 'surrender_fee')->count() > 0 ? $f3Data?->items()?->where('type', 'surrender_fee')->first()->toArray() : [];
                @endphp
                <td>Surrender Fee</td>
                <td>
                    <input type="hidden" name="f[type]" value="surrender_fee">
                    <select class="form-select" name="f[frequency]">
                        <option @if(isset($f['frequency']) && $f['frequency'] == 'monthly') selected @endif value="monthly">Monthly</option>
                        <option @if(isset($f['frequency']) && $f['frequency'] == 'bi-monthly') selected @endif value="bi-monthly">Bi-Monthly</option>
                        <option @if(isset($f['frequency']) && $f['frequency'] == 'quarterly') selected @endif value="quarterly">Quarterly</option>
                        <option @if(isset($f['frequency']) && $f['frequency'] == 'semi-annually') selected @endif value="semi-annually">Semi-Annually</option>
                        <option @if(isset($f['frequency']) && $f['frequency'] == 'anually') selected @endif value="anually">Annually</option>
                    </select>
                </td>
                <td><input type="number" min="0" name="f[amount]" step="0.01" class="form-control" value="{{ isset($f['amount']) ? $f['amount'] : null }}"></td>
                <td><input type="number" min="0" name="f[commission_split]" step="0.01" max="100" class="form-control" value="{{ isset($f['commission_split']) ? $f['commission_split'] : null }}"></td>
                <td><textarea class="form-control" name="f[note]" rows="1">{{ isset($f['notes']) ? $f['notes'] : null }}</textarea></td>
            </tr>

            <tr>
                @php
                    $g = $f3Data?->items()?->where('type', 'loan_interest_rate')->count() > 0 ? $f3Data?->items()?->where('type', 'loan_interest_rate')->first()->toArray() : [];
                @endphp
                <td>Loan Interest Rate</td>
                <td>
                    <input type="hidden" name="g[type]" value="loan_interest_rate">
                    <select class="form-select" name="g[frequency]">
                        <option @if(isset($g['frequency']) && $g['frequency'] == 'monthly') selected @endif value="monthly">Monthly</option>
                        <option @if(isset($g['frequency']) && $g['frequency'] == 'bi-monthly') selected @endif value="bi-monthly">Bi-Monthly</option>
                        <option @if(isset($g['frequency']) && $g['frequency'] == 'quarterly') selected @endif value="quarterly">Quarterly</option>
                        <option @if(isset($g['frequency']) && $g['frequency'] == 'semi-annually') selected @endif value="semi-annually">Semi-Annually</option>
                        <option @if(isset($g['frequency']) && $g['frequency'] == 'anually') selected @endif value="anually">Annually</option>
                    </select>
                </td>
                <td><input type="number" min="0" name="g[amount]" step="0.01" class="form-control" value="{{ isset($g['amount']) ? $g['amount'] : null }}"></td>
                <td><input type="number" min="0" name="g[commission_split]" step="0.01" max="100" class="form-control" value="{{ isset($g['commission_split']) ? $g['commission_split'] : null }}"></td>
                <td><textarea class="form-control" name="g[note]" rows="1">{{ isset($g['notes']) ? $g['notes'] : null }}</textarea></td>
            </tr>

        </tbody>
    </table>

    <div class="mb-3 float-end">
        {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-f-4" class="btn btn-primary save-next">Save & Next</button>
    </div>

</form>