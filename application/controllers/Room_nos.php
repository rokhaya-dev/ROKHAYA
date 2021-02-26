<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Room_nos extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        if (!$this->rbac->hasPrivilege('room_no', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'room_nos/index');
        $data['title'] = 'Room_no List';

        $room_no_result = $this->room_no_model->get();
        $data['room_nolist'] = $room_no_result;
        $this->form_validation->set_rules('room_no', $this->lang->line('room_no'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('room_no/room_noList', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'room_no' => $this->input->post('room_no'),
            );
            $this->room_no_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">'.$this->lang->line('success_message').'</div>');
            redirect('room_nos/index');
        }
    }

    function view($id) {
        if (!$this->rbac->hasPrivilege('room_no', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Room_no List';
        $room_no = $this->room_no_model->get($id);
        $data['room_no'] = $room_no;
        $this->load->view('layout/header', $data);
        $this->load->view('room_no/room_noShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('room_no', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Room_no List';
        $this->room_no_model->remove($id);
        redirect('room_nos/index');
    }
 
    function getByClass() {
            $class_id = $this->input->get('class_id');
        
            $data = $this->room_no_model->getClassByRoom_no($class_id);
        

        
        
        echo json_encode($data);
    }

   

    function getClassTeacherRoom_no() {
        $class_id = $this->input->get('class_id');
        $data = array();
        $userdata = $this->customlib->getUserData();
        if (($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
            $id = $userdata["id"];
            $query = $this->db->where("staff_id", $id)->where("class_id", $class_id)->get("class_teacher");

            if ($query->num_rows() > 0) {

 
                $data = $this->room_no_model->getClassTeacherRoom_no($class_id);
            } else {

                $data = $this->room_no_model->getSubjectTeacherRoom_no($class_id, $id);
            }
        } else {
            $data = $this->room_no_model->getClassByRoom_no($class_id);
        }
        echo json_encode($data);
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('room_no', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Room_no List';
        $room_no_result = $this->room_no_model->get();
        $data['room_nolist'] = $room_no_result;
        $data['title'] = 'Edit Room_no';
        $data['id'] = $id;
        $room_no = $this->room_no_model->get($id);
        $data['room_no'] = $room_no;
        $this->form_validation->set_rules('room_no', $this->lang->line('room_no'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('room_no/room_noEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'room_no' => $this->input->post('room_no'),
            );
            $this->room_no_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">'.$this->lang->line('update_message').'</div>');
            redirect('room_nos/index');
        }
    }

}

?>