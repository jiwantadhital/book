<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\chapters;
use App\Models\semesters;
use App\Models\subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends BackendBaseController
{
    protected $route ='admin.chapter.';
    protected $panel ='Chapter';
    protected $view ='backend.chapter.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new chapters();
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



        return view($this->__loadDataToView($this->view . 'create'),compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $file = $request->file('image_file');
        // if ($request->hasFile("image_file")) {
        //     $fileName = time() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('uploads/images/lab/'), $fileName);
        //     $request->request->add(['image' => $fileName]);
        // }

        $data['row']=$request->all();
        if ($data['row']){
            $attribute_value = $request->input('chapter_title');
            $attribute_id = $request->input('chapter_number');
            $attributeArray['sem_id'] = $request->sem_id;
            $attributeArray['sub_id'] = $request->sub_id;
            $attributeArray['status'] = 1;

            for ($i = 0; $i < count($attribute_id); $i++) {
                $attributeArray['number'] = $attribute_id[$i];
                $attributeArray['name'] = $attribute_value[$i];
                chapters::create($attributeArray);
            }
            request()->session()->flash('success',$this->panel . 'Created Successfully');
        }else{
            request()->session()->flash('error',$this->panel . 'Creation Failed');
        }
//        return redirect()->route('category.index',compact('data'));
        return redirect()->route($this->__loadDataToView($this->route . 'index'));

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
    public function showAll(Request $request, $id){
        $data = chapters::where('sub_id', $id)->get();
        return $data;
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
    public function getSubCategoriesedt(Request $request, $ids,$id){

        echo     json_encode(DB::table('subjects')->where('sem_id', $id)->get());
//        dd($id);
    }
}
