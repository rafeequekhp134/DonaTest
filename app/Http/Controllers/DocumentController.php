<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Validator,Redirect,Response,File,Storage;
use App\Document;
class DocumentController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function index () {
        try {

            $documents = Document::all();
            return response()->json(['success' => true, 'data' => $documents], 200);
            
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    
    public function read () {
        try {
            
            $files = Storage::allfiles('public/documents');

            return response()->json(['success' => true, 'data' => $files], 200);
            
        } catch (\Exception $e) {

            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
 
    public function store(Request $request)
    {
 
       $validator = Validator::make($request->all(), 
              [ 
              'user_id' => 'required',
              'file' => 'required|mimes:txt,doc,docx,pdf,png,jpeg,jpg,gif|max:2048',
             ]);
 
        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);
         }  
 
  
        if ($files = $request->file('file')) {
             
            // store file into document folder
            $file = $request->file->store('public/documents');
 
            // store your file into database
            $document = new Document();
            $document->title = $file;
            $document->user_id = $request->user_id;
            $document->save();
              
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file
            ]);
  
        }
 
  
    }

    public function delete (Request $request) {
        try {
            
            if ($request->path && Storage::delete($request->path)) {
                if (Document::where('title', $request->path)->update(['deleted' => true])) {
                    return response()->json(['success' => true], 200);
                }
            }
            return response()->json(['error' => true], 500);
            
        } catch (\Exception $e) {

            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}