<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\questionbanks;
use App\Models\questionyears;
use App\Models\semesters;
use App\Models\subjects;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QuestionbankController extends BackendBaseController
{
    protected $route ='admin.questionbank.';
    protected $panel ='Question Bank';
    protected $view ='backend.questionbank.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new questionbanks();
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
        $data['que'] = questionyears::pluck('name','id');



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
        //     $file->move(public_path('uploads/images/syllabus/'), $fileName);
        //     $request->request->add(['image' => $fileName]);
        // }

        $data['row']=$request->all();
        if ($data['row']){
             //for multiple image upload
             $imageFiles = $request->file('product_image');
             $imageArray['sem_id'] = $request->sem_id;
             $imageArray['sub_id'] = $request->sub_id;
             $imageArray['year_id'] = $request->year_id;

 
             for ($i = 0; $i < count($imageFiles); $i++){
                 $image      = $imageFiles[$i];
                 $image_name = rand(6785, 9814).'_'.$image->getClientOriginalName();
                  $image->move(public_path('uploads/images/questionBank/'), $image_name);
                 // $image->move($this->image_path, $image_name);
                 $imageArray['image'] = $image_name;
                 $imageArray['status'] = 1;
                 questionbanks::create($imageArray);
             }
            request()->session()->flash('success',$this->panel . 'Created Successfully');
        }else{
            request()->session()->flash('error',$this->panel . 'Creation Failed');
        }
//        return redirect()->route('category.index',compact('data'));
        return redirect()->route($this->__loadDataToView($this->route . 'index'));

    }
    public function showAll(Request $request, $id, $year_id){
        $data = questionbanks::where('sub_id', $id,)->where('year_id', $year_id)->with('Qyear')->get();
        return $data;
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
        $data['que'] = questionyears::pluck('name','id');

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
            $file->move(public_path('uploads/images/syllabus/'), $fileName);
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
