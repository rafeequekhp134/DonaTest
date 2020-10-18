<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Validator,Redirect,Response,File,Storage;
use Illuminate\Support\Facades\Auth;
use App\Tree;
class TreeController extends Controller
{

    /**
     * Create a new TreeController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function index () {
        try {

            if (Auth::guard()->user()) {
                $tree = Tree::where('user_id', Auth::guard()->user()->id)->first();
                return response()->json(['success' => true, 'data' => $tree], 200);                
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Something went wrong' , 'message' => $e->getMessage()], 500);
        }
    }
 
    public function save(Request $request)
    {
             
        try {
 
            $success = false;
            $data = null;
            // Check if the user already has a tree saved
            if (Tree::where('user_id', $request->user_id)->exists()) {
                $success = Tree::where('user_id', $request->user_id)->update(['tree' => $request->tree]);
                $data = Tree::where('user_id', $request->user_id)->first();
            } else {

                $tree = new Tree();
                $tree->tree = $request->tree;
                $tree->user_id = $request->user_id;
                $success = $tree->save();
                $data = $tree;
            }

            if ($success) {
                return response()->json([
                    "success" => true,
                    "message" => "Tree updated successfully",
                    "data" => $data
                ]);
            } else {
                return response()->json(['error'=> 'Failed to update the tree'], 401);  
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong' , 'message' => $e->getMessage()], 500);
        }
  
    }
}