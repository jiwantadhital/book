<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\chapters;
use App\Models\notes;
use App\Models\semesters;
use App\Models\subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotesController extends BackendBaseController
{
    protected $route ='admin.notes.';
    protected $panel ='Notes';
    protected $view ='backend.notes.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new notes();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->title = 'List';
        $data['row'] = $this->model->get();

        return view($this->__loadDataToView($this->view . 'index'),compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->title = 'Create';
        $data['sem'] = semesters::pluck('name','id');
        $data['sub'] = subjects::pluck('title','id');
        $data['cha'] = chapters::pluck('name','id');



        return view($this->__loadDataToView($this->view . 'create'),compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadimage(Request $request)
    {
        $image = $request->file('upload');
        $imageData = base64_encode(file_get_contents($image->getRealPath()));
        $url = 'data:'.$image->getClientMimeType().';base64,'.$imageData;
        return response()->json(['fileName' => $image->getClientOriginalName(), 'uploaded' => 1, 'url' => $url]);
    }
    public function store(Request $request)
    {

        // $file = $request->file('image_file');
        // if ($request->hasFile("image_file")) {
        //     $fileName = time() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('uploads/images/lab/'), $fileName);
        //     $request->request->add(['image' => $fileName]);
        // }
    //    dd($request->all());
        $data['row']=$this->model->create($request->all());
        if ($data['row']){
            request()->session()->flash('success',$this->panel . 'Created Successfully');
        }else{
            request()->session()->flash('error',$this->panel . 'Creation Failed');
        }
//        return redirect()->route('category.index',compact('data'));
        return redirect()->route($this->__loadDataToView($this->route . 'index'));

    }
    public function showAll(Request $request, $id){
        $data = notes::where('chapter_id', $id)->with('Chapter')->with('Semester')->with('Subject')->get();
        if (count($data) > 0) {
            return response()->json($data[0]);
        } else {
            return response()->json([]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $this->title= 'View';
        $data['row']=$this->model->findOrFail($id);
//        dd($data['row']);
        return view($this->__loadDataToView($this->view . 'view'),compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   $this->title= 'Edit';
        $data['row']=$this->model->findOrFail($id);
        $data['sem'] = semesters::pluck('name','id');
        $data['sub'] = subjects::pluck('title','id');
        $data['cha'] = chapters::pluck('name','id');

        return view($this->__loadDataToView($this->view . 'edit'),compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/lab/'), $fileName);
            $request->request->add(['image' => $fileName]);
        }
        $data['row'] =$this->model->findOrFail($id);
        if(!$data ['row']){
            request()->session()->flash('error','Invalid Request');
            return redirect()->route($this->__loadDataToView($this->route . 'index'));
        }
        if ($data['row']->update($request->all())) {
            $request->session()->flash('success', $this->panel .' Update Successfully');
        } else {
            $request->session()->flash('error', $this->panel .' Update failed');

        }
        return redirect()->route($this->__loadDataToView($this->route . 'index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->model->findorfail($id)->delete();
//        unlink(public_path('uploads/images/syllabus/'.$data->image));
//        $this->model->where('id',$data->id)->delete();
        return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');
    }
    public function getSubCategories(Request $request, $id){

        echo json_encode(DB::table('subjects')->where('sem_id', $id)->get());
    }
    public function getchapter(Request $request, $id){

        echo json_encode(DB::table('chapters')->where('sub_id', $id)->get());
    }
    public function getchapteredt(Request $request,$idss, $id){
//        dd('ji');

        echo json_encode(DB::table('chapters')->where('sub_id', $id)->get());
//        dd($data);
    }

    public function getSubCategoriesedt(Request $request, $ids,$id){

        echo     json_encode(DB::table('subjects')->where('sem_id', $id)->get());
//        dd($id);
    }
}
