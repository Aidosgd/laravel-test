<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContactController extends Controller
{
    private const PATH = 'app/data/data.json';

    private const PER_PAGE = 2;

    private $contacts;

    public function __construct()
    {
        $this->contacts = $this->getContacts();
    }

    public function index(Request $request)
    {
        return view('welcome');
    }

    public function api(Request $request)
    {
        $sortBy = $request->get('sortBy', null);
        $orderBy = $request->get('orderBy', "asc");
        $page = $request->get('page', null);

        $descending = strtolower($orderBy) == "desc" ?? true;

        $result = $this->contacts
            ->where('isActive', true)
            ->sortBy($sortBy, 0, $descending)
            ->forPage($page, self::PER_PAGE)
            ->values();

        return response()->json($result);
    }

    private function getContacts()
    {
        $file = storage_path(self::PATH);
        $json = File::get($file);
        $content = json_decode($json);

        $collection = collect();

        foreach ($content as $item => $value) {
            $collection->push($value->item[0]);
        }

        return $collection;
    }

}
