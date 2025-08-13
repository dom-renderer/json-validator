<form id="form-section-f-4">
    
    <div class="mt-4">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Fee Type</th>
                    <th>Frequency</th>
                    <th>Amount/Rate</th>
                    <th>Recipient</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Investment Management Fee</td>
                    <td> <input type="hidden" name="a[type]" value="management_fee"> <input type="text" name="a[frequency]" class="form-control"></td>
                    <td><input type="nummber" min="0" step="0.01" class="form-control" name="a[amount]"></td>
                    <td><input type="text" class="form-control" name="a[recipient]"></td>
                    <td><textarea class="form-control" rows="1" name="a[note]"></textarea></td>
                </tr>
                <tr>
                    <td>IDF Manager Fee</td>
                    <td> <input type="hidden" name="b[type]" value="idf_manager_fee"> <input type="text" name="b[frequency]" class="form-control"></td>
                    <td><input type="nummber" min="0" step="0.01" class="form-control" name="b[amount]"></td>
                    <td><input type="text" class="form-control" name="b[recipient]"></td>
                    <td><textarea class="form-control" rows="1" name="b[note]"></textarea></td>
                </tr>
                <tr>
                    <td>Custody Fee</td>
                    <td> <input type="hidden" name="c[type]" value="custody_fee"> <input type="text" name="c[frequency]" class="form-control"></td>
                    <td><input type="nummber" min="0" step="0.01" class="form-control" name="c[amount]"></td>
                    <td><input type="text" class="form-control" name="c[recipient]"></td>
                    <td><textarea class="form-control" rows="1" name="c[note]"></textarea></td>
                </tr>
                <tr>
                    <td>Legal/Structuring Fee</td>
                    <td> <input type="hidden" name="d[type]" value="legal_sturcturing_fee"> <input type="text" name="d[frequency]" class="form-control"></td>
                    <td><input type="nummber" min="0" step="0.01" class="form-control" name="d[amount]"></td>
                    <td><input type="text" class="form-control" name="d[recipient]"></td>
                    <td><textarea class="form-control" rows="1" name="d[note]"></textarea></td>
                </tr>
                <tr>
                    <td>Trustee Fee</td>
                    <td> <input type="hidden" name="e[type]" value="trustee_fee"> <input type="text" name="e[frequency]" class="form-control"></td>
                    <td><input type="nummber" min="0" step="0.01" class="form-control" name="e[amount]"></td>
                    <td><input type="text" class="form-control" name="e[recipient]"></td>
                    <td><textarea class="form-control" rows="1" name="e[note]"></textarea></td>
                </tr>
                <tr>
                    <td>Other</td>
                    <td> <input type="hidden" name="f[type]" value="other"> <input type="text" name="f[frequency]" class="form-control"></td>
                    <td><input type="nummber" min="0" step="0.01" class="form-control" name="f[amount]"></td>
                    <td><input type="text" class="form-control" name="f[recipient]"></td>
                    <td><textarea class="form-control" rows="1" name="f[note]"></textarea></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mb-3 float-end">
        {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-f-5" class="btn btn-primary save-next">Save & Next</button>
    </div>

</form>