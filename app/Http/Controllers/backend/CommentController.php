<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\colleges;
use App\Models\comments;
use App\Models\coolleges_comments;
use Illuminate\Http\Request;

class CommentController extends BackendBaseController
{
    protected $route ='admin.comments.';
    protected $panel ='Comments';
    protected $view ='backend.comments.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new comments();
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
        $data['college']=colleges::pluck('name','id');
        return view($this->__loadDataToView($this->view . 'create'),compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getComment(Request $request){
        try{
        $comments = comments::create([
            'comments_ratting' => $request->rating,
            'description' => $request->desc,
            'user_id' => $request->id,
            'student_id' => $request->student_id,
            'college_id' => $request->college_id
        ]);
        return response()->json([
            'messgae' => true
            ]);
    }catch(e){
        return response()->json([
            'messgae' => false
            ]);
    }

    }

    public function showAll($id){
        $data = comments::where('college_id',$id)->with('Student')->sortByDesc(function ($data) {
            return Carbon::parse($data['Timestamp'])->timestamp;
        })->get();
        return $data;
    }
    public function store(Request $request)
    {
        $request->request->add(['user_id' => auth()->user()->id]);
        //dd($request->all());
        $data['row']=$this->model->create($request->all());
        $collegecomment['comment_id']=$data['row']->id;
        $collegecomment['college_id']=$data['row']->college_id;
       // dd($collegecomment);

        coolleges_comments::create($collegecomment);
        if ($data['row']){
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
