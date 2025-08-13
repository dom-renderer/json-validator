<form id="form-section-e-1">

    <div class="mb-3">
        <label class="form-label fw-bold"> Type </label>
        <select name="type" id="section-e-1-type">
            <option value=""></option>
            @foreach (['individual', 'trust', 'llc', 'corporation', 'other'] as $document)
                <option value="{{ $document }}" @if($loop->first) selected @endif> {{ ucwords($document) }} </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3 all-cbox" id="container-for-ommit-documents-e1-individual">
        @foreach (\App\Models\Document::where('status', 'individual')->get() as $status)
            <div class="mb-2 row">
                <div class="col-8">
                    <input type="checkbox" name="documents[{{ $status->id }}]" data-type="policy-holder" id="doc-{{ $status->id }}" value="{{ $status->id }}" @if(isset($dArr[$status->id]) && isset($dArr[$status->id]['uploaded']) && $dArr[$status->id]['uploaded']) checked @endif> &nbsp;&nbsp;&nbsp;
                    <label for="doc-{{ $status->id }}">{{ $status->title }}</label> 
                </div>
                <div class="col-4">
                    <input type="file" name="file[{{ $status->id }}]" class="btn btn-primary doc-upl">
                    <a target="_blank" href="{{ asset('storage/kyc-docs/' . ( isset($dArr[$status->id]['document']) ? $dArr[$status->id]['document'] : '' ) ) }}" id="view[{{ $status->id }}]" class="btn btn-primary view-file @if(isset($dArr[$status->id]['document']) && is_file(public_path('storage/kyc-docs/' . $dArr[$status->id]['document'])) ) @else d-none  @endif "> View </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-3 all-cbox d-none" id="container-for-ommit-documents-e1-trust">
        @foreach (\App\Models\Document::where('status', 'trust')->get() as $status)
        <div class="mb-2 row">
            <div class="col-8">
                <input type="checkbox" name="documents[{{ $status->id }}]" data-type="policy-holder" id="doc-{{ $status->id }}" value="{{ $status->id }}" @if(isset($dArr[$status->id]) && isset($dArr[$status->id]['uploaded']) && $dArr[$status->id]['uploaded']) checked @endif> &nbsp;&nbsp;&nbsp;
                <label for="doc-{{ $status->id }}">{{ $status->title }}</label> 
            </div>
            <div class="col-4">
                <input type="file" name="file[{{ $status->id }}]" class="btn btn-primary doc-upl">
                <a target="_blank" href="{{ asset('storage/kyc-docs/' . ( isset($dArr[$status->id]['document']) ? $dArr[$status->id]['document'] : '' ) ) }}" id="view[{{ $status->id }}]" class="btn btn-primary view-file @if(isset($dArr[$status->id]['document']) && is_file(public_path('storage/kyc-docs/' . $dArr[$status->id]['document'])) ) @else d-none  @endif "> View </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mb-3 all-cbox d-none" id="container-for-ommit-documents-e1-llc">
        @foreach (\App\Models\Document::where('status', 'llc')->get() as $status)
        <div class="mb-2 row">
            <div class="col-8">
                <input type="checkbox" name="documents[{{ $status->id }}]" data-type="policy-holder" id="doc-{{ $status->id }}" value="{{ $status->id }}" @if(isset($dArr[$status->id]) && isset($dArr[$status->id]['uploaded']) && $dArr[$status->id]['uploaded']) checked @endif> &nbsp;&nbsp;&nbsp;
                <label for="doc-{{ $status->id }}">{{ $status->title }}</label> 
            </div>
            <div class="col-4">
                <input type="file" name="file[{{ $status->id }}]" class="btn btn-primary doc-upl">
                <a target="_blank" href="{{ asset('storage/kyc-docs/' . ( isset($dArr[$status->id]['document']) ? $dArr[$status->id]['document'] : '' ) ) }}" id="view[{{ $status->id }}]" class="btn btn-primary view-file @if(isset($dArr[$status->id]['document']) && is_file(public_path('storage/kyc-docs/' . $dArr[$status->id]['document'])) ) @else d-none  @endif "> View </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mb-3 all-cbox d-none" id="container-for-ommit-documents-e1-corporation">
        @foreach (\App\Models\Document::where('status', 'corporation')->get() as $status)
        <div class="mb-2 row">
            <div class="col-8">
                <input type="checkbox" name="documents[{{ $status->id }}]" data-type="policy-holder" id="doc-{{ $status->id }}" value="{{ $status->id }}" @if(isset($dArr[$status->id]) && isset($dArr[$status->id]['uploaded']) && $dArr[$status->id]['uploaded']) checked @endif> &nbsp;&nbsp;&nbsp;
                <label for="doc-{{ $status->id }}">{{ $status->title }}</label> 
            </div>
            <div class="col-4">
                <input type="file" name="file[{{ $status->id }}]" class="btn btn-primary doc-upl">
                <a target="_blank" href="{{ asset('storage/kyc-docs/' . ( isset($dArr[$status->id]['document']) ? $dArr[$status->id]['document'] : '' ) ) }}" id="view[{{ $status->id }}]" class="btn btn-primary view-file @if(isset($dArr[$status->id]['document']) && is_file(public_path('storage/kyc-docs/' . $dArr[$status->id]['document'])) ) @else d-none  @endif "> View </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mb-3 all-cbox d-none" id="container-for-ommit-documents-e1-other">
        @foreach (\App\Models\Document::where('status', 'other')->get() as $status)
        <div class="mb-2 row">
            <div class="col-8">
                <input type="checkbox" name="documents[{{ $status->id }}]" data-type="policy-holder" id="doc-{{ $status->id }}" value="{{ $status->id }}" @if(isset($dArr[$status->id]) && isset($dArr[$status->id]['uploaded']) && $dArr[$status->id]['uploaded']) checked @endif> &nbsp;&nbsp;&nbsp;
                <label for="doc-{{ $status->id }}">{{ $status->title }}</label> 
            </div>
            <div class="col-4">
                <input type="file" name="file[{{ $status->id }}]" class="btn btn-primary doc-upl">
                <a target="_blank" href="{{ asset('storage/kyc-docs/' . ( isset($dArr[$status->id]['document']) ? $dArr[$status->id]['document'] : '' ) ) }}" id="view[{{ $status->id }}]" class="btn btn-primary view-file @if(isset($dArr[$status->id]['document']) && is_file(public_path('storage/kyc-docs/' . $dArr[$status->id]['document'])) ) @else d-none  @endif "> View </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mb-3 float-end">
        {{-- <button type="button" data-type="draft" class="btn btn-primary save-draft">Save Draft</button> --}}
        <button type="submit" data-type="next" data-next="section-e-2" class="btn btn-primary save-next">Save & Next</button>
    </div>
</form>