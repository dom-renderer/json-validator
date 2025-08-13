<div id="communication-entries-container">
    @if($g1Data && $g1Data->count() > 0)
        <div class="mb-4">
            <h5>Previous Communication Entries</h5>
            <div class="accordion" id="communicationAccordion">
                @foreach($g1Data as $index => $communication)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                {{ $communication->type ?: 'Communication' }} - {{ $communication->date ? \Carbon\Carbon::parse($communication->date)->format('M d, Y') : 'No Date' }}
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#communicationAccordion">
                            <div class="accordion-body">
                                <div class="row mb-2">
                                    <div class="col-sm-3"><strong>Communication Date:</strong></div>
                                    <div class="col-sm-9">{{ $communication->date ? \Carbon\Carbon::parse($communication->date)->format('M d, Y H:i') : 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3"><strong>Communication Type:</strong></div>
                                    <div class="col-sm-9">{{ $communication->type ?: 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3"><strong>Contact Person(s):</strong></div>
                                    <div class="col-sm-9">{{ $communication->contact_person_involved ?: 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3"><strong>Summary of Discussion:</strong></div>
                                    <div class="col-sm-9">{{ $communication->summary_of_discussion ?: 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3"><strong>Action Taken/Next Steps:</strong></div>
                                    <div class="col-sm-9">{{ $communication->action_taken_or_next_step ?: 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3"><strong>Internal Owner(s):</strong></div>
                                    <div class="col-sm-9">{{ $communication->internal_owners ?: 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

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
        <button type="submit" data-type="save-and-add" class="btn btn-secondary me-2">Save & Add New</button>
        <button type="submit" data-type="next" data-next="section-g-2" class="btn btn-primary save-next">Save & Next</button>
    </div>

</form>