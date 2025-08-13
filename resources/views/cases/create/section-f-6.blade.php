<form id="form-section-f-6">
    
        <div class="mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Asset Class</th>
                        <th>Included</th>
                        <th>Est. % of Portfolio</th>
                        <th>Valuation Support</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Listed Equities (Stocks)</td>
                        <td class="text-center"> <input type="hidden" name="a[asset_class]" value="stocks"> <input type="checkbox" name="a[included]" class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="a[est]"></td>
                        <td><input type="text" class="form-control"    name="a[val]"></td>
                        <td><textarea class="form-control" rows="1"    name="a[note]"></textarea></td>
                    </tr>
                    <tr>
                        <td>Listed Equities (Bonds)</td>
                        <td class="text-center"> <input type="hidden" name="b[asset_class]" value="bonds"> <input type="checkbox" name="b[included]" class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="b[est]"  ></td>
                        <td><input type="text" class="form-control"    name="b[val]"  ></td>
                        <td><textarea class="form-control" rows="1"    name="b[note]"  ></textarea></td>
                    </tr>
                    <tr>
                        <td>ETFs/Mutual Funds</td>
                        <td class="text-center"> <input type="hidden" name="c[asset_class]" value="etfs"> <input type="checkbox" name="c[included]" class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="c[est]" ></td>
                        <td><input type="text" class="form-control"    name="c[val]" ></td>
                        <td><textarea class="form-control" rows="1"    name="c[note]" ></textarea></td>
                    </tr>
                    <tr>
                        <td>Private Equity</td>
                        <td class="text-center"> <input type="hidden" name="d[asset_class]" value="private_equity"> <input type="checkbox" name="d[included]" class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="d[est]" ></td>
                        <td><input type="text" class="form-control"    name="d[val]" ></td>
                        <td><textarea class="form-control" rows="1"    name="d[note]" ></textarea></td>
                    </tr>
                    <tr>
                        <td>Promissory Note (internal)</td>
                        <td class="text-center"> <input type="hidden" name="e[asset_class]" value="internal_prom_note"> <input type="checkbox" name="e[included]" class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="e[est]" ></td>
                        <td><input type="text" class="form-control"    name="e[val]" ></td>
                        <td><textarea class="form-control" rows="1"    name="e[note]" ></textarea></td>
                    </tr>
                    <tr>
                        <td>Promissory Note (external)</td>
                        <td class="text-center"> <input type="hidden" name="f[asset_class]" value="external_prom_note"> <input type="checkbox" name="f[included]" class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="f[est]" ></td>
                        <td><input type="text" class="form-control"    name="f[val]" ></td>
                        <td><textarea class="form-control" rows="1"    name="f[note]" ></textarea></td>
                    </tr>
                    <tr>
                        <td>Loans Receivable</td>
                        <td class="text-center"> <input type="hidden" name="g[asset_class]" value="loan_receivable"> <input type="checkbox" name="g[included]" class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="g[est]" ></td>
                        <td><input type="text" class="form-control"    name="g[val]" ></td>
                        <td><textarea class="form-control" rows="1"    name="g[note]" ></textarea></td>
                    </tr>
                    <tr>
                        <td>Real Estate</td>
                        <td class="text-center"> <input type="hidden" name="h[asset_class]" value="real_estate"> <input type="checkbox" name="h[included]"  class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="h[est]" ></td>
                        <td><input type="text" class="form-control"    name="h[val]" ></td>
                        <td><textarea class="form-control" rows="1"    name="h[note]" ></textarea></td>
                    </tr>
                    <tr>
                        <td>Digital Assets</td>
                        <td class="text-center"> <input type="hidden" name="i[asset_class]" value="digital_assets"> <input type="checkbox" name="i[included]"  class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"    name="i[est]" ></td>
                        <td><input type="text" class="form-control"    name="i[val]" ></td>
                        <td><textarea class="form-control" rows="1"    name="i[note]" ></textarea></td>
                    </tr>
                    <tr>
                        <td>Other:</td>
                        <td class="text-center"> <input type="hidden" name="j[asset_class]" value="other"> <input type="checkbox"name="j[included]" class="form-check-input" value="yes"></td>
                        <td><input type="text" class="form-control"   name="j[est]" ></td>
                        <td><input type="text" class="form-control"   name="j[val]" ></td>
                        <td><textarea class="form-control" rows="1"   name="j[note]" ></textarea></td>
                    </tr>
                </tbody>
            </table>
        </div>

    <div class="mb-3 float-end">
        {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-f-7" class="btn btn-primary save-next">Save & Next</button>
    </div>

</form>