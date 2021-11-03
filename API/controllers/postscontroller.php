<?php


namespace API\CONTROLLERS;
use API\SYSTEM\Controller;
use API\SYSTEM\Helper;
use API\MODELS\postsmodel;
use API\CONTROLLERS\userscontroller;

class postscontroller extends Controller{
    private $post=null;
    public function add(){
        if(userscontroller::isAuth($this->params['token'])){
            $data = Helper::parseAccessToken($this->params['token']);
            $this->post = new postsmodel();
            $this->post->id = 1;
            $this->post->post_body = $this->params['post_body'];
            $this->post->posted_date = date('d/m/Y');
            $this->post->user_id = $data[0];

            $res = $this->post->create();
            if($res){
                echo json_encode(array("Message"=>"Post Added Successfully"));
            }else{
                echo json_encode(array("Error"=>"Failed to Add Post"));
            }
        }else{
            echo json_encode(array("Error"=>"You are not allowed..."));
        }
    }
    public function delete(){
        if(userscontroller::isAuth($this->params['token'])){
            $this->post = new postsmodel();
            $this->post->id = $this->params['id'];
            $res = $this->post->delete();
            if($res){
                echo json_encode(array("Message"=>"Post Deleted Successfully"));
            }else{
                echo json_encode(array("Error"=>"Failed to Delete Post"));
            }
        }else{
            echo json_encode(array("Error"=>"You are not allowed..."));
        }
    }
    public function update(){
        if(userscontroller::isAuth($this->params['token'])){
            $data = Helper::parseAccessToken($this->params['token']);
            $this->post = new postsmodel();
            $this->post->id =          $this->params['id'];
            $this->post->post_body =   $this->params['post_body'];
            $this->post->posted_date = date('d/m/Y');
            $this->post->user_id =     $data[0];
            $res = $this->post->update();
            if($res){
                echo json_encode(array("Message"=>"Post Updated Successfully"));
            }else{
                echo json_encode(array("Error"=>"Failed to Update Post"));
            }
        }else{
            echo json_encode(array("Error"=>"You are not allowed..."));
        }
    }
    public function getById(){
        if(userscontroller::isAuth($this->params['token'])){
            $this->post = postsmodel::where("id","=",$this->params['id']);
            if($this->post){
                echo json_encode($this->post);
            }else{
                echo json_encode(array("Erro"=>"Failed to fetch Post"));
            }
        }else{
            echo json_encode(array("Error"=>"You are not allowed..."));
        }
    }
    public function getAll(){
        if(userscontroller::isAuth($this->params['token'])){
            $this->post = postsmodel::where("user_id","=",$this->params['user_id']);
            if($this->post){
                echo json_encode($this->post);
            }else{
                echo json_encode(array("Error"=>"Failed to fetch Post"));
            }
        }else{
            echo json_encode(array("Error"=>"You are not allowed..."));
        }
    }

}