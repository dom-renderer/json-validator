<?php

namespace App\Helpers;

use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Customer;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;

class Helper {

    public static $defaulDialCode = 'ch';

    public static $individualStates = ['single' => 'Single', 'married' => 'Married', 'divorced' => 'Divorced', 'separated' => 'Separated', 'other' => 'Other'];
    public static $entityStatuses = [ 'corporation' => 'Corporation', 'llc' => 'LLC', 'trust' => 'Trust', 'partnership' => 'Partnership', 'foundation' => 'Foundation', 'other' => 'Other'];

    public static function title ($title = '') {
        if (!empty($title)) {
            return $title;
        } else if ($name = DB::table('settings')->first()?->name) {
            return $name;
        } else {
            return env('APP_NAME', '');
        }
    }

    public static function logo () {
        if ($name = DB::table('settings')->first()?->logo) {
            return url("settings-media/{$name}");
        } else {
            return url('assets/images/logo.png');
        }
    }

    public static function favicon () {
        if ($name = DB::table('settings')->first()?->favicon) {
            return url("settings-media/{$name}");
        } else {
            return url('assets/images/favicon.ico');
        }
    }

    public static function bgcolor ($bg = null) {
        if (!empty($bg)) {
            return $bg;
        } else if ($color = DB::table('settings')->first()?->theme_color) {
            return $color;
        } else {
            return '#3a082f';
        }
    }

    public function getCountries(Request $request)
    {
        $queryString = trim($request->searchQuery);
        $page = $request->input('page', 1);
        $limit = 10;
    
        $query = Country::query();
    
        if (!empty($queryString)) {
            $query->where('name', 'LIKE', "%{$queryString}%");
        }
    
        $data = $query->paginate($limit, ['*'], 'page', $page);
        $response = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        });

        return response()->json([
            'items' => $response->reverse()->values(),
            'pagination' => [
                'more' => $data->hasMorePages()
            ]
        ]);
    }

    public function getStatesByCountry(Request $request)
    {
        $queryString = trim($request->searchQuery);
        $page = $request->input('page', 1);
        $limit = 10;
    
        $query = State::query()
        ->where('country_id', request('country_id'));
    
        if (!empty($queryString)) {
            $query->where('name', 'LIKE', "%{$queryString}%");
        }
    
        $data = $query->paginate($limit, ['*'], 'page', $page);
        $response = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        });

        return response()->json([
            'items' => $response->reverse()->values(),
            'pagination' => [
                'more' => $data->hasMorePages()
            ]
        ]);
    }

    public function getCitiesByState(Request $request)
    {
        $queryString = trim($request->searchQuery);
        $page = $request->input('page', 1);
        $limit = 10;
    
        $query = City::query()
        ->when(is_numeric($request->state_id) && $request->state_id > 0, function ($innerBuilder) {
            $innerBuilder->where('state_id', request('state_id'));
        })
        ->when(is_numeric($request->country_id) && $request->country_id > 0, function ($innerBuilder) {
            $innerBuilder->where('country_id', request('country_id'));
        });
    
        if (!empty($queryString)) {
            $query->where('name', 'LIKE', "%{$queryString}%");
        }
    
        $data = $query->paginate($limit, ['*'], 'page', $page);
        $response = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        });

        return response()->json([
            'items' => $response->reverse()->values(),
            'pagination' => [
                'more' => $data->hasMorePages()
            ]
        ]);
    }

    public function getDocuments(Request $request)
    {
        $queryString = trim($request->searchQuery);
        $page = $request->input('page', 1);
        $limit = 10;
    
        $query = Document::query()
        ->where('status', $request->status);
    
        if (!empty($queryString)) {
            $query->where('title', 'LIKE', "%{$queryString}%");
        }
    
        $data = $query->paginate($limit, ['*'], 'page', $page);
        $response = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->title
            ];
        });

        return response()->json([
            'items' => $response->reverse()->values(),
            'pagination' => [
                'more' => $data->hasMorePages()
            ]
        ]);
    }
    
    public function getUsers(Request $request)
    {
        $queryString = trim($request->searchQuery);
        $roles = $request->input('roles', null);
        $page = $request->input('page', 1);
        $includeUserData = $request->input('includeUserData', false);
        $limit = 10;
    
        $query = User::query();
    
        if (!empty($queryString)) {
            $query->where('name', 'LIKE', "%{$queryString}%");
        }

        if (!empty($roles)) {
            if (is_string($roles) && $roles == '*') {
                $query->whereHas('roles');
            } else {
                $roles = is_string($roles) ? explode(',', $roles) : (is_array($roles) ? $roles : []);
                $query->whereHas('roles', fn  ($builder) => $builder->whereIn('name', $roles));
            }
        }

        $data = $query->orderBy('name', 'ASC')->paginate($limit, ['*'], 'page', $page);
        $response = $data->map(function ($item) use ($includeUserData) {
            $result = [
                'id' => $item->id,
                'text' => $item->name
            ];
            
            if ($includeUserData) {
                $result['user'] = $item;
            }
            
            return $result;
        });

        return response()->json([
            'items' => $response->values(),
            'pagination' => [
                'more' => $data->hasMorePages()
            ]
        ]);
    }

    public function getHolders(Request $request)
    {
        $queryString = trim($request->searchQuery);
        $roles = $request->input('roles', null);
        $page = $request->input('page', 1);
        $addNewOption = $request->input('addNewOption', 0);
        $includeUserData = $request->input('includeUserData', false);
        $limit = 10;
    
        $query = Customer::query();
    
        if (!empty($queryString)) {
            $query->where('name', 'LIKE', "%{$queryString}%");
        }

        if (!empty($roles)) {
            if (is_string($roles) && $roles == '*') {
                $query->whereHas('roles');
            } else {
                $roles = is_string($roles) ? explode(',', $roles) : (is_array($roles) ? $roles : []);
                $query->whereHas('roles', fn  ($builder) => $builder->whereIn('name', $roles));
            }
        }

        $data = $query->orderBy('name', 'ASC')->paginate($limit, ['*'], 'page', $page);
        $response = $data->map(function ($item) use ($includeUserData) {
            $result = [
                'id' => $item->id,
                'text' => $item->name
            ];
            
            if ($includeUserData) {
                $result['user'] = $item;
                $result['alternate_dial_code_iso'] = Helper::getIso2ByDialCode($item->alternate_dial_code);
            }
            
            return $result;
        });

        if ($addNewOption === '1' && $page == 1) {
            if ($response->count() > 0) {
                $response->push([
                    'id' => 'ADD_NEW_USER',
                    'text' => 'Add New Policy Holder'
                ])->unique();
            } else {
                $response->push([
                    'id' => 'ADD_NEW_USER',
                    'text' => 'Add New Policy Holder'
                ]);
            }
        }

        return response()->json([
            'items' => $response->values(),
            'pagination' => [
                'more' => $data->hasMorePages()
            ]
        ]);
    }

    public static function getIso2ByDialCode($dialCode = null) {
        if (empty(trim($dialCode))) {
            $dialCode = '41';
        }

        $dialCode = trim(str_replace('+', '', $dialCode));
        return strtolower(Country::select('iso2')->where('phonecode', "+{$dialCode}")->orWhere('phonecode', $dialCode)->first()->iso2 ?? 'ch');
    }

    private static function formatTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $remainingSeconds = $seconds % 60;

        return sprintf('%02dh %02dm %02ds', $hours, $minutes, $remainingSeconds);
    }

    public static function number_format($number)
    {
        return '$' . number_format($number, 2);
    }

    public static function generateCaseNumber() {
        $nextId = DB::table('policies')->max('id') + 1;
        return 'CASE-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
}