<?php

namespace App\Http\Controllers;

use App\Models\PolicyDocument;
use Illuminate\Http\Request;
use App\Models\Policy;

class CaseController extends Controller
{
    public function create(Request $request, $id = null)
    {
        $user = auth()->id();
        $policy = null;

        if (!empty($id)) {
            try {
                $id = decrypt($id);
                $id = explode('***', $id);

                if (count($id) == 3 && $id[2] == 'sha-2') {
                    if (!empty($id[1]) && Policy::find($id[1])) {
                        $policy = Policy::find($id[1]);
                    } else {
                        $policy = new Policy();
                        $policy->opening_date = now();
                        $policy->added_by = $user;
                        $policy->save();

                        session()->put(['new_policy' => [
                            'user_id' => $user,
                            'policy_id' => $policy->id
                        ]]);

                        return redirect()->route('cases.create', encrypt($user . '***' . $policy->id . '***sha-2'));
                    }
                }

            } catch (\Exception $e) {
                return redirect()->route('cases.index');
            }
        } else {
            return redirect()->route('cases.index');
        }

        $title = 'Case Management';
        $subTitle = 'Add New Case';

        return view('cases.create.index', compact('title', 'subTitle', 'policy'));
    }

    public function edit(Request $request, $id) {

        if (!empty($id)) {
            try {
                $id = decrypt($id);
                $policy = Policy::find($id);
            } catch (\Exception $e) {
                return redirect()->route('cases.index');
            }
        } else {
            return redirect()->route('cases.index');
        }

        $title = 'Case Management';
        $subTitle = 'Edit Case';

        return view('cases.create.index', compact('title', 'subTitle', 'policy'));
    }

    public function index(Request $request) 
    {
        if ($request->ajax()) {
            return $this->ajax();
        }

        $title = 'Case Management';
        $subTitle = 'Cases';

        return view('cases.index', compact('title', 'subTitle'));
    }

    public function ajax() {
        $policy = Policy::query();

        if (request()->filled('filter_case')) {
            $policy->where('policy_number', 'LIKE', "%" . request('filter_case') . "%");
        }

        if (request()->filled('filter_opened')) {
            $policy->where('opening_date', date('Y-m-d', strtotime(request('filter_opened'))));
        }

        if (request()->filled('filter_holder')) {
            $policy->whereHas('holders', fn ($builder) => $builder->where('name', 'LIKE', '%' . request('filter_holder') . '%'));
        }

        if (request()->filled('filter_introducer')) {
            $policy->whereHas('introducers', fn ($builder) => $builder->where('name', 'LIKE', '%' . request('filter_introducer') . '%'));
        }
        
        if (request()->filled('filter_status')) {
            $policy->where('status', request('filter_status'));
        }

        return datatables()
        ->eloquent($policy)
        ->editColumn('opening_date', fn ($row) => date('Y-m-d', strtotime($row)))
        ->addColumn('theholder', fn ($row) => isset($row->holders[0]->name) ? $row->holders[0]->name : 'N/A')
        ->addColumn('introducer', fn ($row) => isset($row->introducers[0]->name) ? $row->introducers[0]->name : 'N/A')
        ->editColumn('status', function ($row) {
            if ($row->status == 0) {
                return '<span class="btn draft"> Draft </span>';
            } else if ($row->status == 1) {
                return '<span class="btn pending"> Pending </span>';
            } else if ($row->status == 2) {
                return '<span class="btn follow-up"> Follow Up </span>';
            } else if ($row->status == 3) {
                return '<span class="btn active"> Active </span>';
            } else if ($row->status == 4) {
                return '<span class="btn inactive"> In Active </span>';
            }
        })
        ->editColumn('action', function ($row) {
            $html = '';

            if (auth()->user()->can('cases.edit')) {
                $html .= '<ul>
                    <li><a href="' . route('cases.edit', encrypt($row->id)) . '"> View </a></li>
                    <li><a href="' . route('cases.edit', encrypt($row->id)) . '"> Edit</a></li>
                </ul>';
            }

            return $html;
        })
        ->addIndexColumn()
        ->rawColumns(['status', 'action'])
        ->toJson();
    }

    public function submission(\App\Services\PolicyService $service) 
    {
        $submission = $service->submit(request());

        if (isset($submission['errors'])) {
            return response()->json($submission, 422);
        }

        return response()->json($submission);
    }

    public function getDocs(Request $request) {
        $html = '<input type="hidden" name="adding" value="1" />';

        foreach (\App\Models\Document::where('status', $request->status)->get() as $status) {
            $html .= '
            <div class="mb-2 row">
                <div class="col-8">
                    <input type="checkbox" name="documents[]" id="doc-' . $status->id . '" value="' . $status->id . '"> &nbsp;&nbsp;&nbsp;
                    <label for="doc-' . $status->id . '">' . $status->title . '</label> 
                </div>
                <div class="col-4">

                </div>
            </div>
            ';
        }

        return response()->json([
            'html' => $html
        ]);
    }

    public function autoSave(\App\Services\PolicyService $service) 
    {
        $request = request();
        
        $request->merge(['silent_save' => 1]);
        
        $request->merge(['save' => 'draft']);
        
        $submission = $service->submit($request);

        if (isset($submission['errors'])) {
            return response()->json($submission, 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Auto-saved successfully',
            'timestamp' => now()->format('H:i:s')
        ]);
    }

    public function uploadDoc(Request $request) {
        $request->validate([
            'file' => 'required|file|max:10240',
            'policy_id' => 'required|integer',
            'doc_id' => 'required|integer'
        ]);

        $folder = 'kyc-docs';

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($folder)) {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($folder);
        }

        $filename = time().'_'.$request->file->getClientOriginalName();
        $path = \Illuminate\Support\Facades\Storage::disk('public')->putFileAs($folder, $request->file, $filename);
        $shouldCheck = false;

        if (PolicyDocument::where('policy_id', $request->policy_id)
        ->where('document_id', $request->doc_id)->exists()) {
            PolicyDocument::where('policy_id', $request->policy_id)
            ->where('document_id', $request->doc_id)->update([
                'document' => $filename
            ]);
        } else {
            PolicyDocument::create([
                'document_id' => $request->doc_id,
                'policy_id' => $request->policy_id,
                'document_type' => $request->dt_type,
                'document' => $filename,
                'uploaded' => 1
            ]);

            $shouldCheck = true;
        }


        return response()->json([
            'status' => 'success',
            'url' => asset('storage/' . $path),
            'check' => $shouldCheck
        ]);
    }
}
