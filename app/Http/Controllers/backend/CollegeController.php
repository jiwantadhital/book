<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\colleges;
use App\Models\college_images;
use Illuminate\Http\Request;

class CollegeController extends BackendBaseController
{
    protected $route ='admin.college.';
    protected $panel ='Intuition';
    protected $view ='backend.college.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new colleges();
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
        return view($this->__loadDataToView($this->view . 'create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $file = $request->file('image_file');
       if ($request->hasFile("image_file")) {
           $fileName = time() . '_' . $file->getClientOriginalName();
           $file->move(public_path('uploads/images/colleges/'), $fileName);
           $request->request->add(['logo' => $fileName]);
       }

        $data['row']=$this->model->create($request->all());
        //for multiple image upload
        $imageFiles = $request->file('product_image');
        $imageArray['college_id'] = $data['row']->id;

        for ($i = 0; $i < count($imageFiles); $i++){
            $image      = $imageFiles[$i];
            $image_name = rand(6785, 9814).'_'.$image->getClientOriginalName();
             $image->move(public_path('uploads/images/colleges/images/'), $image_name);
            $imageArray['image'] = $image_name;
            $imageArray['status'] = 1;
            college_images::create($imageArray);
        }
        if ($data['row']){
            request()->session()->flash('success',$this->panel . 'Created Successfully');
        }else{
            request()->session()->flash('error',$this->panel . 'Creation Failed');
        }
//        return redirect()->route('category.index',compact('data'));
        return redirect()->route($this->__loadDataToView($this->route . 'index'));

    }
    public function showAll(){
        $data = colleges::all();
        return $data;
    }
    public function imageShowAll($id){
        $data = college_images::where('college_id',$id)->get();
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
            $file->move(public_path('uploads/images/collegequestion/'), $fileName);
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

        return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');
    }

}
