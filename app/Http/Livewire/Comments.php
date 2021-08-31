<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class Comments extends Component
{
    use WithFileUploads;
    public $commentItem;
    public $photo;
    public $newName;
    public $newComment;
    public $newEmail;
    public $editState;
    public $commentId;
    public $comments=[];

    public function resetProperties(){
        $this->reset('newName','newComment','photo');
    }
    public function mount(){
        // $this->comments= \App\Models\Comments::all();
        $this->fill([
                'comments'=>\App\Models\Comments::all(),
                'editState'=>-1,
                'commentId'=>0
            ]
        );
    }
    public function addComment(){
        $this->validate(['newName'=>'required|min:5|max:60','newComment'=>'required|min:5'
            ,'newEmail'=>'email' , 'photo'=>'required']);
        $commentItem= new \App\Models\Comments();

        $commentItem->name=$this->newName;
        $commentItem->text=$this->newComment;

        $commentItem->date=Carbon::now()->diffForHumans();
        $commentItem->email=$this->newEmail;
        $commentItem->img=$this->photo->temporaryUrl();
        $commentItem->save();
        $this->photo->store('photo');
        session()->flash('message', 'comment successfully added');
        $this->comments= \App\Models\Comments::all();
        $this->resetProperties();
    }


    public function updated($field){
        $this->validateOnly($field, ['newName'=>'required|min:5|max:60','newComment'=>'required|min:5'
            ,'newEmail'=>'email' ]);
    }
    public function remove($commentId){
        unset($this->comments[$commentId]);
    }
    public function editComment($current){
        $this->editState=1;
        $currentEdit = $this->comments[$current];
        $this->newComment=$currentEdit['text'];
        $this->commentId=$current;

        return $this->commentId;
    }
    public function updateComment($index){

        $edited= $this->comments[$this->commentId];
        $edited['text']=$this->newComment;
        $edited['name']=$this->newName;
        $edited['img']=$this->photo;
        $this->comments[$this->commentId]->text=$this->newComment;
        $this->comments[$this->commentId]->name=$this->newName;
        $this->comments[$this->commentId]->img=$this->photo->temporaryUrl();
        $this->editState=-1;

    }
    public function increment(){
        $this->stars++;

    }
    public function render()
    {
        return view('livewire.comments');
    }
}
/*[
                    [
                        'name'=>'parastwo'
                        ,'date'=>'2 minutes ago'
                        ,'text'=>
                        ' Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque
                    ipsam provident sint ut voluptatum! Dolorum hic, veniam. Delectus eaque et eveniet fuga,
                    pariatur praesentium quisquam. Cupiditate deleniti in maxime voluptatum?
               '
                        ,'email'=>'klk@gmail.com'
                        ,'img'=>'images/1.jpg'
                    ]
                    , [
                        'name'=>'sarvenaz'
                        ,'date'=>'2 days ago'
                        ,'text'=>
                            ' Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque
                    ipsam provident sint ut voluptatum! Dolorum hic, veniam. Delectus eaque et eveniet fuga,
                    pariatur praesentium quisquam. Cupiditate deleniti in maxime voluptatum?
               '
                        ,'email'=>'parastwo@gmail.com'
                        ,'img'=>'images/2.jpg'
                    ]
                ]*/
/*

array_unshift($this->comments ,
    [
        'name'=>$this->newName
        ,'date'=>Carbon::now()->diffForHumans()
        ,'text'=>
        $this->newComment
        ,'email'=>$this->newEmail
        ,'img'=>$this->photo->temporaryUrl()
    ]);*/
